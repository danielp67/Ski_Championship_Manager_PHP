<?php

namespace App\Controller;

use App\Container\DeserializerContainer;
use App\Container\SerializerContainer;
use App\Factory\ResultFactory;
use App\Repository\CategoryRepository;
use App\Repository\ParticipantRepository;
use App\Repository\RaceRepository;
use App\Repository\ResultRepository;
use App\Repository\StageRepository;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ResultController extends AbstractController
{
    public function resultPage(Request $request, Response $response): Response
    {
        $params = explode('/', $request->getPathInfo());

        $resultRepository = new ResultRepository($this->pdo);
        $raceRepository = new RaceRepository($this->pdo);
        $categoryRepository = new CategoryRepository($this->pdo);

        $allCategories = $categoryRepository->findAll();

        $race = $raceRepository->find($params[2]);
        $results = $resultRepository->findResultsByRaceId($params[2]);

        $categoryResults = $this->rankingByCategory($allCategories, $params[2]);

        $content =  $this->twig->render(
            'resultView.html.twig',
            ['results' => $results,
            'categoryResults' =>  $categoryResults,
            'categories' => $allCategories,
            'race' => $race]
        );
        $response->setContent($content);

        return $response;
    }

    public function rankingByCategory(array $allCategories, int $raceId): array
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

    public function resultPodium(Request $request, Response $response): Response
    {
        $localDirectory =  $request->server->get('DOCUMENT_ROOT');

        $theImage = $localDirectory . '/data/img/podium.png';
        $response->headers->set('content-type', 'image/jpeg');
        $response->setContent(file_get_contents($theImage));
        
        return $response;
    }

    public function resultFormParticipantList(Request $request, Response $response): Response
    {
        $resultRepository = new ResultRepository($this->pdo);
        $params = explode('/', $request->getPathInfo());

        $participants = $resultRepository->findResultsByRaceId($params[2]);
        $notParticipants = $resultRepository->findParticipantByNotRace($params[2]);
        
        $content = $this->twig->render(
            'addParticipantListToRaceView.html.twig',
            [
                'notParticipants' => $notParticipants,
                'participants' =>  $participants,
                'raceId' => $params[2]
                ]
        );
        $response->setContent($content);

        return $response;
    }

    public function resultAddParticipantList($request)
    {
        $resultRepository = new ResultRepository($this->pdo);
        $params = explode('/', $request->getPathInfo());

        $participantList = $request->request->get('participantId');
        $participantList = explode(',', $participantList);

        $participantList = array_map(function ($participant) {
            return (int) $participant;
        }, $participantList);

        $participantListWithRaceId = [];
        foreach ($participantList as $participant) {
            $participantWithRaceId = ['raceId' => $params[2], 'participantId' => $participant];
            array_push($participantListWithRaceId, $participantWithRaceId);
        }

        $resultList = ResultFactory::arrayfromRequestAdd($participantListWithRaceId);

       // var_dump( $resultList);

        foreach ($resultList as $result) {
            $checkResult = $resultRepository->findByName($result);
            if (! $checkResult) {
                var_dump($result);
                 $addResult = $resultRepository->add($result);
            }
        }

        $checkResultList = $resultRepository->findResultsByRaceId($params[2]);
       // var_dump( $checkResultList);

        var_dump($participantList);

        foreach ($checkResultList as $checkResult) {
            var_dump(array_search($checkResult['result']->getParticipantId(), $participantList));
            var_dump($checkResult['result']->getParticipantId());

            if (array_search($checkResult['result']->getParticipantId(), $participantList) === false) {
                var_dump('remove');
                $deleteResult = $resultRepository->delete($checkResult['result']->getParticipantId());
            }
        }

        return true;
    }

      //Export to CSV
    public function resultExport(Request $request, Response $response): Response
    {
        $params = explode('/', $request->getPathInfo());
        $resultRepository = new ResultRepository($this->pdo);
        $results = $resultRepository->findResultsByRaceId($params[2]);

        $participantList = array_map('self::serializeResultToCsv', $results);

        $chronometerSheet = $this->addStageNb($participantList);

        $csvHeader = array('result_id,Nom,Prenom,Date de naissance,Categorie,Profile,stage_nb,time');

        array_unshift($chronometerSheet, $csvHeader);

        $filename = 'users.csv';
        $fp = fopen('php://output', 'w', 'w');
    
        foreach ($chronometerSheet as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $filename);
        $response->sendHeaders();

        return $response;
    }

    public function serializeResultToCsv($dataToCsv)
    {
        return SerializerContainer::serializeResultToCsv($dataToCsv);
    }

    public function addStageNb($participantList)
    {
        $dataWithNbStage = [];
        foreach ($participantList as $participant) {
            array_push($dataWithNbStage, [substr($participant, 0, -1) . ',1'], [substr($participant, 0, -1) . ',2']);
        }
        return $dataWithNbStage;
    }

    // Import CSV
    public function resultImport($request)
    {
        $resultFromCsv = $request->files->get('file');

        if ($resultFromCsv === null) {
            throw new Exception('Pas de fichier trouvé !');
        }
        if ($resultFromCsv->getMimeType() !== 'text/plain') {
            throw new Exception('Format de fichier incorrect, csv seulement !');
        }

        $fileContent = file_get_contents($resultFromCsv);
        $pattern = '/^result_id;Nom;Prenom;Date de naissance;Categorie;Profile;stage_nb;time/';

        if (! preg_match($pattern, $fileContent)) {
            throw new Exception('Format de données incorrectes !');
        }

        $stages = DeserializerContainer::deserializeStagesFromCsv($fileContent);
        $stageRepository = new StageRepository($this->pdo);
        
        foreach ($stages as $stage) {
            $insertedStage = $this->insertResultIntoStageTable($stage, $stageRepository);
        }
        if ($insertedStage) {
            $insertedResult = $this->insertResultIntoResultTable($request);
        }
        $params = explode('/', $request->getPathInfo());
        $serverHost = $request->server->get('HTTP_HOST');

       // return new RedirectResponse('http://' . $serverHost . '/race/' . $params[2] . '/detail');
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
            $stages = $stageRepository->findByResultId($allResult['result']->getId());
            $minutes = 0;
            $seconds = 0;
            $milliseconds = 0;
            foreach ($stages as $stage) {
                $minutes = $minutes + (int) $stage->getTime()->format('i');
                $seconds = $seconds + (int) $stage->getTime()->format('s');
                $milliseconds = $milliseconds + ((int) $stage->getTime()->format('u')) / 1000;

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
