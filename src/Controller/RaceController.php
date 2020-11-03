<?php

namespace App\Controller;

use App\Factory\RaceFactory;
use App\Repository\RaceRepository;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RaceController extends AbstractController
{
    public function raceList(Request $request, Response $response): Response
    {
        $raceRepository = new RaceRepository($this->pdo);
        $params = explode('/', $request->getPathInfo());
        $allRaces = $raceRepository->findAllPaginated($params[3]);
        $content = $this->twig->render('raceList.html.twig', ['races' => $allRaces]);
        $response->setContent($content);

        return $response;
    }

    public function raceForm(Request $request, Response $response): Response
    {
        $content = $this->twig->render('raceForm.html.twig', ['race' => null]);
        $response->setContent($content);

        return $response;
    }

    public function raceAdd(Request $request): Response
    {
        $raceRepository = new RaceRepository($this->pdo);

        $newRace = RaceFactory::fromRequestAdd($request);
        $checkRace = $raceRepository->findbyName($newRace);
        if (! empty($checkRace)) {
            throw new Exception('Epreuve déjà éxistante');
        }
        $addRace = $raceRepository->add($newRace);
        $serverHost = $request->server->get('HTTP_HOST');

        return new RedirectResponse('http://' . $serverHost . '/race/list');
    }

    public function raceFormUpdate(Request $request, Response $response): Response
    {
        $raceRepository = new RaceRepository($this->pdo);
        $params = explode('/', $request->getPathInfo());
        $race = $raceRepository->find($params[2]);
        $content = $this->twig->render('raceForm.html.twig', ['race' => $race]);
        $response->setContent($content);

        return $response;
    }

    public function raceUpdate(Request $request): Response
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
        $serverHost = $request->server->get('HTTP_HOST');

        return new RedirectResponse('http://' . $serverHost . '/race/list');
    }

    public function raceDelete(Request $request): Response
    {
        $raceRepository = new RaceRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());
        $deleteRace = $raceRepository->delete($params[2]);
        $serverHost = $request->server->get('HTTP_HOST');

        return new RedirectResponse('http://' . $serverHost . '/race/list');
    }

    public function raceDetail(Request $request, Response $response): Response
    {
        $raceRepository = new RaceRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());
        $race = $raceRepository->find($params[2]);

        $content = $this->twig->render('raceDetail.html.twig', ['race' => $race]);
        $response->setContent($content);

        return $response;
    }

    public function raceStart(Request $request): Response
    {
        return $this->raceStatus($request, 1);
    }

    public function raceFinish(Request $request): Response
    {
        return $this->raceStatus($request, 2);
    }

    public function raceCancel(Request $request): Response
    {
        return $this->raceStatus($request, 3);
    }

    private function raceStatus(Request $request, $status): Response
    {
        $raceRepository = new RaceRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());
        $race = $raceRepository->find($params[2]);
        $race->setStatus($status);
        $updateRace = $raceRepository->update($race);
        $serverHost = $request->server->get('HTTP_HOST');

        return new RedirectResponse('http://' . $serverHost . '/race/' . $params[2] . '/detail');
    }
}
