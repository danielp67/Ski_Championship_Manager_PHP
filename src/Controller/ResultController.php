<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Factory\ResultFactory;
use App\Repository\CategoryRepository;
use App\Repository\ParticipantRepository;
use App\Repository\RaceRepository;
use App\Repository\ResultRepository;
use App\Repository\StageRepository;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class ResultController extends AbstractController
{

    public function resultPage($request): void
    {
        $params = explode('/', $request->getPathInfo());

        $resultRepository = new ResultRepository($this->pdo);
        $raceRepository = new RaceRepository($this->pdo);
        $participantRepository = new ParticipantRepository($this->pdo);
        $categoryRepository = new CategoryRepository($this->pdo);

        $allCategories = $categoryRepository->findAll();

        $race = $raceRepository->find($params[2]);
        $results = $resultRepository->findResultsByRaceId($params[2]);
        var_dump($results);
        /*
        $result2 = $this->serializer->denormalize($results ,'App\Entity\Participant[]');
        $result3 = $this->serializer->denormalize($results ,'App\Entity\Result[]');
        var_dump($result2);
        var_dump($result3);
*/
        $results = array_map("self::test", $results);

        var_dump($results);
        var_dump($results[0][1]->getId());

        $categoryResults = $this->rankingByCategory($allCategories, $params[2]);

        var_dump($categoryResults[0]);
        echo $this->twig->render('resultView.html.twig', ['results' => $results,  'categoryResults' =>  $categoryResults, 'categories' => $allCategories, 'race' => $race]);
    }

    public function generalRanking(){


    }

    public function rankingByCategory($allCategories, $raceId){
        $resultRepository = new ResultRepository($this->pdo);
        

        $resultsByCategories = [];
        foreach($allCategories as $allCategory){
            $categoryId = $allCategory->getId();
            $resultByCategory = $resultRepository->findResultsByRaceIdAndCategory($raceId, $categoryId);
            $resultByCategory = array_map("self::test", $resultByCategory);
            
            array_push($resultsByCategories, $resultByCategory );
        }
       // var_dump($resultsByCategories);

        return $resultsByCategories;
    }
    

    public function rankingByAge(){


        
    }

    public function test($result){
            $resultRepository = new ResultRepository($this->pdo);
     
            $result4 = $this->serializer->denormalize($result ,'App\Entity\Participant');
            $result5 = $this->serializer->denormalize($result ,'App\Entity\Result');
            $result = [$result4 , $result5];
        
        return $result;
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


    public function resultParticipantList($request)
    {
        $participantRepository = new ParticipantRepository($this->pdo);
        $resultRepository = new ResultRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());

        $result = $resultRepository->findParticipantByRace($params[2]);

        $result2 = $resultRepository->findParticipantByNotRace($params[2]);

       // var_dump($result);

      //  var_dump($result2);

        return $result;
    }

    public function resultExport($request)
    {
        $participantList = $this->resultParticipantList($request);
       // var_dump($participantList);

        $participantList = array_map('self::serializeToCsv', $participantList);
        
       //var_dump($participantList);
       $list =  $participantList;
       $csvHeader = array('id,Nom,Prenom,Temps de passage 1, Temps de passage 2');
       array_unshift($list, $csvHeader);
       /*
        $list = array(
            //these are the columns
            array('Firstname', 'Lastname',),
            //these are the rows
            $participantList,
        );*/
       //var_dump($list);
        $filename = 'users.csv';
        $fp = fopen('php://output', 'w','w');
    
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }
    
        fclose($fp);
        $response = new Response();
        
        $response->headers->set('Content-Type', 'text/csv');
        //it's gonna output in a testing.csv file
        $response->headers->set('Content-Disposition', 'attachment; filename='. $filename);
       
        $response->sendHeaders();

       // var_dump($response);
        return $response;
    }

    public function serializeToCsv($dataToCsv)
    {

        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $dataToNormalizer = [$serializer->normalize($dataToCsv, null, [AbstractNormalizer::ATTRIBUTES => ['id','lastName', 'firstName']])];
        $context = ['no_headers' => true , 'output_utf8_bom' => false];
        $dataToCsv = $serializer->serialize($dataToNormalizer, 'csv',$context);
        return  [$dataToCsv];
         
      
    }

    
    public function resultImport($request)
    {
        $stages = $this->deserializeFromCsv($request);
        $stageRepository = new StageRepository($this->pdo);
        
        foreach($stages as $stage){
            $addStage = $this->insertResultIntoStageTable($stage, $stageRepository);
        }

        if($addStage){
           $addResult = $this->insertResultIntoResultTable($request);
        }
        $params = explode('/', $request->getPathInfo());
        $response = new RedirectResponse('http://127.1.2.3/race/detail/'.$params[2]);
        $response->send();
    }

    public function deserializeFromCsv($request)
    {
        $data = $request->files->get('file');
        /*   $encoders = [new CsvEncoder(), new JsonEncoder()];
           $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
           $serializer = new Serializer($normalizers, $encoders);
        */
           var_dump(file_get_contents($data));
   
           $result2 = $this->serializer->deserialize(file_get_contents($data) ,'App\Entity\Stage[]', 'csv');
          
           var_dump($result2);

           return $result2;
    }

    public function insertResultIntoStageTable($stage, $stageRepository)
    {
        $checkStage = $stageRepository->findByResultIdAndStageNb($stage);
            if(! empty($checkStage))
            {
                $updateStage = $stageRepository->updateTime($stage);
                if(! $updateStage){
                    throw new Exception('Import incorrect');
                }
            }
            else{
                $addStage = $stageRepository->add($stage);
                if(! $addStage){
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
        $allResults = $resultRepository->findAllParticipantsByRaceId($params[2]);
        var_dump($allResults);
        
        foreach($allResults as $allResult)
        {
            $getStages = $stageRepository->findByResultId($allResult->getId());
            $minutes = 0;
            $seconds = 0;
            $milliseconds = 0;
            foreach($getStages as $getStage)
            {
                $minutes = $minutes + (int) $getStage->getTime()->format('i');
                $seconds = $seconds + (int) $getStage->getTime()->format('s');
                $milliseconds = $milliseconds +((int) $getStage->getTime()->format('u'))/1000;

                if($milliseconds > 999){
                    $seconds = $seconds + 1;
                    $milliseconds = $milliseconds - 1000;
                }
                if($seconds >59){
                    $minutes = $minutes + 1;
                    $seconds = $seconds - 60;
                }
                $minutes = ($minutes<10) ? strval('0'.$minutes) : strval($minutes);
                $seconds = ($seconds<10) ? strval('0'.$seconds) : strval($seconds);
                $timeToString = strval($minutes.':'. $seconds.'.'.$milliseconds);

            }

            $allResult->setAverageTime($timeToString);
            var_dump($allResult);
            $updateResult = $resultRepository->update($allResult);

        }

    }


/*
    public function resultImport2($request)
    {
      //  var_dump($request->files);
        var_dump($request->files->get('file'));

        $data = $request->files->get('file');
        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        var_dump(file_get_contents($data));
       // $result =  $serializer->decode(file_get_contents($data), 'csv',[AbstractNormalizer::IGNORED_ATTRIBUTES => ['nom']] );
      //  var_dump($result);
        //var_dump(array_splice($result[0],3,2));
       // unset($result[0]['nom'], $result['prenom']);
      //  var_dump(  $result );

        $result2 = $serializer->deserialize(file_get_contents($data) ,'App\Entity\Stage[]', 'csv');
      //  $result3 = $serializer->denormalize($result,'App\Entity\Stage[]', null, [AbstractNormalizer::IGNORED_ATTRIBUTES => ['nom']]);
        
       // $result3 = array_map('self::deserialize', $result);
       
        var_dump($result2);
       // var_dump($result3);
    }



    public function deserialize($result)
    {
        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $normalizers = [new GetSetMethodNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $result = $serializer->denormalize($result,'App\Entity\Stage');

        return $result;
    }
    */
}
