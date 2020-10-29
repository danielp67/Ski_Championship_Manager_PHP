<?php

namespace App\Controller;

use App\Factory\ResultFactory;
use App\Repository\CategoryRepository;
use App\Repository\ParticipantRepository;
use App\Repository\RaceRepository;
use App\Repository\ResultRepository;
use App\Repository\StageRepository;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class ResultController extends AbstractController
{

    public function resultPage($request): void
    {
        $params = explode('/', $request->getPathInfo());

        $resultRepository = new ResultRepository($this->pdo);
        $raceRepository = new RaceRepository($this->pdo);
        $categoryRepository = new CategoryRepository($this->pdo);

        $allCategories = $categoryRepository->findAll();

        $race = $raceRepository->find($params[2]);
        $results = $resultRepository->findResultsByRaceId($params[2]);
        var_dump($results);

        $categoryResults = $this->rankingByCategory($allCategories, $params[2]);

        var_dump($categoryResults);
        echo $this->twig->render('resultView.html.twig', ['results' => $results,
                                                        'categoryResults' =>  $categoryResults,
                                                        'categories' => $allCategories,
                                                        'race' => $race]);
        
    }

    public function rankingByCategory($allCategories, $raceId)
    {
        $resultRepository = new ResultRepository($this->pdo);
        
        $resultsByCategories = [];
        foreach ($allCategories as $allCategory) {
            $categoryId = $allCategory->getId();
            $resultByCategory = $resultRepository->findResultsByRaceIdAndCategory($raceId, $categoryId);
            array_push($resultsByCategories, $resultByCategory);
        }

        return $resultsByCategories;
    }
    

    public function rankingByAge()
    {
    }

    public function resultPodium()
    {
        $theImage = 'C:/wamp64/www/tp15_championnat_ski/data/img/podium.png';
        $response = new Response();

        $response->headers->set('content-type', 'image/jpeg');
        $response->setContent(file_get_contents($theImage));
        
        return $response->send();
    }

    public function resultAdd($request): void
    {
        $resultRepository = new ResultRepository($this->pdo);

        $newResult = ResultFactory::fromRequestAdd($request);
        $checkResult = $resultRepository->findbyName($newResult);
        if (! empty($checkResult)) {
            throw new Exception('Nom déjà existant');
        }
        $addResult = $resultRepository->add($newResult);
        $response = new RedirectResponse('http://127.1.2.3/result');
        $response->send();
    }

    public function resultUpdate($request): void
    {
        $resultRepository = new ResultRepository($this->pdo);

        $updateResult = ResultFactory::fromRequestUdpate($request);
        $checkResult = $resultRepository->findbyName($updateResult);
        if (! empty($checkResult)) {
            throw new Exception('Nom déjà existant');
        }
        $addResult = $resultRepository->update($updateResult);
        $response = new RedirectResponse('http://127.1.2.3/result');
        $response->send();
    }

    public function resultDelete($request): void
    {
        $resultRepository = new ResultRepository($this->pdo);

        $deleteResult = $resultRepository->delete($request->get('nameId'));
        $response = new RedirectResponse('http://127.1.2.3/result');
        $response->send();
    }


    public function resultFormParticipantList($request)
    {
        $participantRepository = new ParticipantRepository($this->pdo);
        $resultRepository = new ResultRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());

        $participants = $resultRepository->findResultsByRaceId($params[2]);

        $notParticipants = $resultRepository->findParticipantByNotRace($params[2]);

      //  var_dump($participants);

      //  var_dump($notParticipants);
        
        echo $this->twig->render('addParticipantListToRaceView.html.twig', ['notParticipants' => $notParticipants,
                                                                            'participants' =>  $participants,
                                                                            'raceId' => $params[2]]);



        //return $result;
    }

    public function resultAddParticipantList($request)
    {
        $resultRepository = new ResultRepository($this->pdo);
        $params = explode('/', $request->getPathInfo());

        $participantList = $request->request->get('participantId');
        var_dump($request->request->get('participantId'));

        $resultList = ResultFactory::arrayFromDbCollection([$participantList]);

        var_dump( $resultList);

        foreach($participantList as $participant){
           
            // $checkResult = $resultRepository->findByName()
        }
        

        
        return $params;
    }

      //Export to CSV
    public function resultExport($request)
    {
        $params = explode('/', $request->getPathInfo());
        $resultRepository = new ResultRepository($this->pdo);
        $results = $resultRepository->findResultsByRaceId($params[2]);

        $participantList = array_map('self::serializeToCsv', $results);
        
        $chronometerSheet = $this->addStageNb($participantList);

        $csvHeader = array('result_id,Nom,Prenom,Date de naissance,Categorie,Profile,stage_nb,time');
        array_unshift($chronometerSheet, $csvHeader );
       // var_dump($chronometerSheet);

        $filename = 'users.csv';
        $fp = fopen('php://output', 'w', 'w');
    
        foreach ($chronometerSheet as $fields) {
            fputcsv($fp, $fields);
        }
    
        fclose($fp);
        $response = new Response();
        
        $response->headers->set('Content-Type', 'text/csv');
        //it's gonna output in a testing.csv file
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $filename);
       
        $response->sendHeaders();

        return $response;
    }

    public function serializeToCsv($dataToCsv)
    {
        $dateContext = array(DateTimeNormalizer::FORMAT_KEY => 'd/m/Y');
        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer($dateContext), new ObjectNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $dataResult = $serializer->normalize(
            $dataToCsv['result'],
            null,
            [AbstractNormalizer::ATTRIBUTES => ['id'] ]
        );

        $dataParticipant = $serializer->normalize(
            $dataToCsv['participant'],
            null,
            [AbstractNormalizer::ATTRIBUTES => ['lastName', 'firstName', 'birthDate'] ]
        );

        $dataCategory = $serializer->normalize(
            $dataToCsv['category'],
            null,
            [AbstractNormalizer::ATTRIBUTES => ['name'] ]
        );

        $dataProfile = $serializer->normalize(
            $dataToCsv['profile'],
            null,
            [AbstractNormalizer::ATTRIBUTES => ['name'] ]
        );
       
        $dataNormalized = ['result' => $dataResult,
                            'pparticipant' => $dataParticipant,
                            'category' => $dataCategory,
                            'profile' =>  $dataProfile];

        $context = ['no_headers' => true, 'csv_escape_char' => false, 'as_collection' => true];

      //  var_dump( $dataNormalized);
       $dataToCsv = $serializer->serialize($dataNormalized, 'csv', $context);
       // var_dump( $dataToCsv);
       return $dataToCsv;
    }

    public function addStageNb($participantList)
    {
        $dataWithNbStage = [];
        foreach($participantList as $participant){
            array_push($dataWithNbStage, [substr($participant, 0, -1).',1'],[substr($participant, 0, -1).',2']);
        }
        return $dataWithNbStage;
    }

    // Import CSV
    public function resultImport($request)
    {
        $stages = $this->deserializeFromCsv($request);
        $stageRepository = new StageRepository($this->pdo);
        
        foreach ($stages as $stage) {
            $addStage = $this->insertResultIntoStageTable($stage, $stageRepository);
        }
        if ($addStage) {
            $addResult = $this->insertResultIntoResultTable($request);
        }
        $params = explode('/', $request->getPathInfo());/*
        $response = new RedirectResponse('http://127.1.2.3/race/' . $params[2] . '/detail');
        $response->send();*/
    }

    public function deserializeFromCsv($request)
    {
        $data = $request->files->get('file');
        $dateContext = array(DateTimeNormalizer::FORMAT_KEY => 'd/m/Y');
        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer($dateContext), new ObjectNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
           var_dump(file_get_contents($data));
           $context = ['csv_delimiter' => ';'];

           $result2 = $serializer->deserialize(file_get_contents($data), 'App\Entity\Stage[]', 'csv', $context);
          
           var_dump($result2);

           return $result2;
    }

    public function insertResultIntoStageTable($stage, $stageRepository)
    {
        $checkStage = $stageRepository->findByResultIdAndStageNb($stage);
        if (! empty($checkStage)) {
            $updateStage = $stageRepository->updateTime($stage);
            if (! $updateStage) {
                throw new Exception('Import incorrect');
            }
        } else {
            $addStage = $stageRepository->add($stage);
            if (! $addStage) {
                throw new Exception('Import incorrect');
            }
        }
            return true;
    }

    public function insertResultIntoResultTable($request)
    {
        $resultRepository = new ResultRepository($this->pdo);
        $stageRepository = new StageRepository($this->pdo);
        $params = explode('/', $request->getPathInfo());
        $allResults = $resultRepository->findResultsByRaceId($params[2]);
        
        foreach ($allResults as $allResult) {
            $getStages = $stageRepository->findByResultId($allResult['result']->getId());
            $minutes = 0;
            $seconds = 0;
            $milliseconds = 0;
            foreach ($getStages as $getStage) {
                $minutes = $minutes + (int) $getStage->getTime()->format('i');
                $seconds = $seconds + (int) $getStage->getTime()->format('s');
                $milliseconds = $milliseconds + ((int) $getStage->getTime()->format('u')) / 1000;

                if ($milliseconds > 999) {
                    $seconds = $seconds + 1;
                    $milliseconds = $milliseconds - 1000;
                }
                if ($seconds > 59) {
                    $minutes = $minutes + 1;
                    $seconds = $seconds - 60;
                }
                $minutes = ($minutes < 10) ? strval('0' . $minutes) : strval($minutes);
                $seconds = ($seconds < 10) ? strval('0' . $seconds) : strval($seconds);
                $timeToString = strval($minutes . ':' . $seconds . '.' . $milliseconds);
            }

            $allResult['result']->setAverageTime($timeToString);
            $updateResult = $resultRepository->update($allResult['result']);
        }
    }



}
