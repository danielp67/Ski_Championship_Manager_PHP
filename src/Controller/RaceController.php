<?php

namespace App\Controller;

use App\Factory\RaceFactory;
use App\Repository\RaceRepository;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

final class RaceController extends AbstractController
{
 
    public function racePage(): void
    {
        echo $this->twig->render('raceView.html.twig');
    }

    public function raceForm(): void
    {
        echo $this->twig->render('raceForm.html.twig', ['race' => null]);
    }

    public function raceAdd(Request $request): void
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

    public function raceFormUpdate(Request $request): void
    {
        $raceRepository = new RaceRepository($this->pdo);
        $params = explode('/', $request->getPathInfo());
        $race = $raceRepository->find($params[2]);
        echo $this->twig->render('raceForm.html.twig', ['race' => $race]);
    }

    public function raceUpdate(Request $request): void
    {
        $params = explode('/', $request->getPathInfo());

        $raceRepository = new RaceRepository($this->pdo);
        $race = $raceRepository->find($params[2]);
        $request->request->add(['status' => $race->getStatus()]);
        $request->request->add(['id' => $params[2]]);

        $newRace = RaceFactory::fromRequestUdpate($request);

        $checkRace = $raceRepository->findbyName($newRace);

        if (! empty($checkRace)) {
            throw new Exception('Epreuve déjà éxistante');
        }
        $updateRace = $raceRepository->update($newRace);
        
        $response = new RedirectResponse('http://127.1.2.3/race/list');
        $response->send();
    }

    public function raceDelete(Request $request): void
    {
        $raceRepository = new RaceRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());
        $deleteRace = $raceRepository->delete($params[2]);
        $response = new RedirectResponse('http://127.1.2.3/race/list');
        $response->send();
    }

    public function raceList(): void
    {
        $raceRepository = new RaceRepository($this->pdo);

        $allRaces = $raceRepository->findAll();
        echo $this->twig->render('raceList.html.twig', ['races' => $allRaces]);
    }

    public function raceDetail(Request $request): void
    {
        $raceRepository = new RaceRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());
        $race = $raceRepository->find($params[2]);
        
        echo $this->twig->render('raceDetail.html.twig', ['race' => $race]);
    }

    public function raceStart(Request $request): void
    {
        $this->raceStatus($request, 1);
    }

    public function raceFinish(Request $request): void
    {
        $this->raceStatus($request, 2);
    }

    public function raceCancel(Request $request): void
    {
        $this->raceStatus($request, 3);
    }

    private function raceStatus(Request $request, $status): void
    {
        $raceRepository = new RaceRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());
        $race = $raceRepository->find($params[2]);
        $race->setStatus($status);
        $updateRace = $raceRepository->update($race);
        
        $response = new RedirectResponse('http://127.1.2.3/race/' . $params[2] . '/detail');
        $response->send();
    }
}
