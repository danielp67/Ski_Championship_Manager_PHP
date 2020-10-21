<?php

namespace App\Controller;

use App\Model\Race;
use App\Repository\RaceRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class RaceController extends AbstractController
{
    private RaceRepository $raceRepository;
    public object $loader;
    public object $twig;
 
    public function __construct()
    {
        $this->loader = new FilesystemLoader('src/View');
        $this->twig = new Environment($this->loader, []);
        $this->raceRepository = new RaceRepository();
    }
 
    public function racePage(): void
    {
        echo $this->twig->render('raceView.html.twig');
    }

    public function raceForm(): void
    {
        echo $this->twig->render('raceAdd.html.twig');
    }

    public function raceAdd(): void
    {
        $request = Request::createFromGlobals();
        $newRace = new Race();
        $newRace->setLocation($request->get('location'));
        $newRace->setDate($request->get('date'));
        $newRace->setStatus(0);
        var_dump($newRace);
       // $checkCategory = $this->categoryRepository->findbyName($newCategory);
       // if(empty($checkCategory)){
        $addRace = $this->raceRepository->add($newRace);
       // }
       // $response = new RedirectResponse('http://127.1.2.3/race');
       // $response->send();
    }

    public function raceCheck(): void
    {
        $request = Request::createFromGlobals();
        var_dump($request->request);
        $race = new Race();
    }

    public function raceList(): void
    {
        $allRaces = $this->raceRepository->findAll();
        echo $this->twig->render('raceList.html.twig', ['races' => $allRaces]);
    }

    public function raceDetail(): void
    {
        $params = explode('/', $_GET['url']);
        $race = $this->raceRepository->find($params[2]);
        echo $this->twig->render('raceDetail.html.twig', ['races' => $race]);
    }

    public function raceStart(): void
    {
        $params = explode('/', $_GET['url']);
        $race = $this->raceRepository->find($params[2]);
        $newRace = new Race();
        $newRace->setId($race[0]['id']);
        $newRace->setLocation($race[0]['location']);
        $newRace->setDate($race[0]['date']);
        $newRace->setStatus(1);
        $race = $this->raceRepository->update($newRace);

        $response = new RedirectResponse('http://127.1.2.3/race/detail/'.$params[2]);
        $response->send();

    }

    public function raceFinish(): void
    {
        $params = explode('/', $_GET['url']);
        $race = $this->raceRepository->find($params[2]);
        $newRace = new Race();
        $newRace->setId($race[0]['id']);
        $newRace->setLocation($race[0]['location']);
        $newRace->setDate($race[0]['date']);
        $newRace->setStatus(2);
        $race = $this->raceRepository->update($newRace);
        
        $response = new RedirectResponse('http://127.1.2.3/race/detail/'.$params[2]);
        $response->send();

    }

    public function raceCancel(): void
    {
        $params = explode('/', $_GET['url']);
        $race = $this->raceRepository->find($params[2]);
        $newRace = new Race();
        $newRace->setId($race[0]['id']);
        $newRace->setLocation($race[0]['location']);
        $newRace->setDate($race[0]['date']);
        $newRace->setStatus(3);
        $race = $this->raceRepository->update($newRace);
        
        $response = new RedirectResponse('http://127.1.2.3/race/detail/'.$params[2]);
        $response->send();

    }


}
