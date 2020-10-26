<?php

namespace App\Controller;

use App\Factory\RaceFactory;
use App\Repository\RaceRepository;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class RaceController extends AbstractController
{
 
    public function racePage(): void
    {
        echo $this->twig->render('raceView.html.twig');
    }

    public function raceForm(): void
    {
        echo $this->twig->render('raceForm.html.twig');
    }

    public function raceAdd($request): void
    {
        $raceRepository = new RaceRepository($this->pdo);

        $newRace = RaceFactory::fromRequestAdd($request);
        $checkRace = $raceRepository->findbyName($newRace);
        if (! empty($checkRace)) {
            throw new Exception('Epreuve déjà éxistante');
        }
        $addRace = $raceRepository->add($newRace);
        $response = new RedirectResponse('http://127.1.2.3/race/list');
        $response->send();
    }

    public function raceUpdate($request): void
    {
        $raceRepository = new RaceRepository($this->pdo);

        $newRace = RaceFactory::fromRequestUdpate($request);
        $checkRace = $raceRepository->findbyName($newRace);
        if (! empty($checkRace)) {
            throw new Exception('Epreuve déjà éxistante');
        }
        $updateRace = $raceRepository->update($newRace);
        $response = new RedirectResponse('http://127.1.2.3/race/list');
        $response->send();
    }

    public function raceDelete($request): void
    {
        $raceRepository = new RaceRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());
        $deleteRace = $raceRepository->delete($params[3]);
        $response = new RedirectResponse('http://127.1.2.3/race/list');
        $response->send();
    }

    public function raceCheck($request): void
    {
        var_dump($request);
    }

    public function raceList(): void
    {
        $raceRepository = new RaceRepository($this->pdo);

        $allRaces = $raceRepository->findAll();
        echo $this->twig->render('raceList.html.twig', ['races' => $allRaces]);
    }

    public function raceDetail($request): void
    {
        $raceRepository = new RaceRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());
        $race = $raceRepository->find($params[3]);
        
        echo $this->twig->render('raceDetail.html.twig', ['race' => $race]);
    }

    public function raceStart($request): void
    {
        $this->raceStatus($request, 1);
    }

    public function raceFinish($request): void
    {
        $this->raceStatus($request, 2);
    }

    public function raceCancel($request): void
    {
        $this->raceStatus($request, 3);
    }

    private function raceStatus($request, $status): void
    {
        $raceRepository = new RaceRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());
        $race = $raceRepository->find($params[3]);
        $race->setStatus($status);
        $updateRace = $raceRepository->update($race);
        
        $response = new RedirectResponse('http://127.1.2.3/race/detail/' . $params[3]);
        $response->send();
    }
}
