<?php

namespace App\Controller;

use App\Factory\ParticipantFactory;
use App\Repository\CategoryRepository;
use App\Repository\ParticipantRepository;
use App\Repository\ProfileRepository;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ParticipantController extends AbstractController
{
    
    public function participantPage(): void
    {
        echo $this->twig->render('participantView.html.twig');
    }

    public function participantList(): void
    {
        $participantRepository = new ParticipantRepository($this->pdo);
        $participantList = $participantRepository->findAll();
        echo $this->twig->render('participantList.html.twig', ['participants' => $participantList]);
    }

    public function participantImg(Request $request, Response $response)
    {
        $params = explode('/', $request->getPathInfo());
        $participantRepository = new ParticipantRepository($this->pdo);
        $participant = $participantRepository->find($params[3]);
        $file = $participant['participant']->getImgLink();
        $theImage = 'C:/wamp64/www/tp15_championnat_ski/data/img/' . $file;
        $response->headers->set('content-type', 'image/jpg');
        $response->setContent(file_get_contents($theImage));
        $response->send();
        return $response;
    }

    public function participantForm(): void
    {
        $categoryRepository = new CategoryRepository($this->pdo);
        $allCategory = $categoryRepository->findAll();
        $profileRepository = new ProfileRepository($this->pdo);
        $allProfile = $profileRepository->findAll();

        echo $this->twig->render(
            'participantForm.html.twig',
            ['participant' => null,
            'categories' => $allCategory,
            'profiles' => $allProfile
            ]
        );
    }

    public function participantAdd(Request $request): void
    {
        $participantRepository = new ParticipantRepository($this->pdo);
        $file = $request->files->get('img');
        if ($file === null) {
            $request->request->add(['imgLink' => 'unknown.jpg']);
        } else {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = uniqid() . '.' . $file->guessExtension();
            $request->request->add(['imgLink' => $fileName]);
        }

        $newParticipant = ParticipantFactory::fromRequestAdd($request);

        $checkParticipant = $participantRepository->findbyName($newParticipant);
        if (! empty($checkParticipant)) {
            throw new Exception('Participant déjà éxistant');
        }

        $addParticipant = $participantRepository->add($newParticipant);

        
        if (! $addParticipant) {
            throw new Exception('Echec création participant');
        }
        if ($file !== null) {
            $file->move('C:/wamp64/www/tp15_championnat_ski/data/img', $fileName);
        }
        $response = new RedirectResponse('http://127.1.2.3/participant/list');
        $response->send();
    }

    public function participantFormUpdate(Request $request): void
    {
        $categoryRepository = new CategoryRepository($this->pdo);
        $allCategory = $categoryRepository->findAll();

        $profileRepository = new ProfileRepository($this->pdo);
        $allProfile = $profileRepository->findAll();

        $params = explode('/', $request->getPathInfo());
        $participantRepository = new ParticipantRepository($this->pdo);
        $participant = $participantRepository->find($params[2]);

        echo $this->twig->render(
            'participantForm.html.twig',
            ['participant' => $participant,
            'categories' => $allCategory,
            'profiles' => $allProfile
            ]
        );
    }

    public function participantUpdate(Request $request): void
    {
        $participantRepository = new ParticipantRepository($this->pdo);

        $params = explode('/', $request->getPathInfo());
        $file = $request->files->get('img');
        $request->request->add(['id' => $params[2]]);

        if ($file !== null) {
            $oldImage = $request->request->get('imgLink');
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = uniqid() . '.' . $file->guessExtension();
            $request->request->add(['imgLink' => $fileName]);
        }

        $newParticipant = ParticipantFactory::fromRequestUpdate($request);
        $checkParticipant = $participantRepository->findbyName($newParticipant);
        if (! empty($checkParticipant)) {
            throw new Exception('Participant déjà éxistant');
        }

        $updateParticipant = $participantRepository->update($newParticipant);

        if (! $updateParticipant) {
            throw new Exception('Echec création participant');
        }
        if ($file !== null) {
            $file->move('C:/wamp64/www/tp15_championnat_ski/data/img', $fileName);
            unlink('C:/wamp64/www/tp15_championnat_ski/data/img/' . $oldImage);
        }

        $response = new RedirectResponse('http://127.1.2.3/participant/list');
        $response->send();
    }
}
