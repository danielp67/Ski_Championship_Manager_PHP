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

    public function participantList(Request $request, Response $response): Response
    {
        $participantRepository = new ParticipantRepository($this->pdo);
        $participantList = $participantRepository->findAll();
        $content =  $this->twig->render('participantList.html.twig', ['participants' => $participantList]);
        $response->setContent($content);

        return $response;
    }

    public function participantImg(Request $request, Response $response): Response
    {
        $params = explode('/', $request->getPathInfo());
        $participantRepository = new ParticipantRepository($this->pdo);
        $participant = $participantRepository->find($params[3]);
        $file = $participant['participant']->getImgLink();
        $theImage = 'C:/wamp64/www/tp15_championnat_ski/data/img/' . $file;
        $response->headers->set('content-type', 'image/jpg');
        $response->setContent(file_get_contents($theImage));

        return $response;
    }

    public function participantForm(Request $request, Response $response): Response
    {
        $categoryRepository = new CategoryRepository($this->pdo);
        $allCategory = $categoryRepository->findAll();
        $profileRepository = new ProfileRepository($this->pdo);
        $allProfile = $profileRepository->findAll();

        $content =  $this->twig->render(
            'participantForm.html.twig',
            ['participant' => null,
            'categories' => $allCategory,
            'profiles' => $allProfile
            ]
        );
        $response->setContent($content);

        return $response;
    }

    public function participantAdd(Request $request, Response $response): Response
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

        return new RedirectResponse('http://127.1.2.3/participant/list');
    }

    public function participantFormUpdate(Request $request, Response $response): Response
    {
        $categoryRepository = new CategoryRepository($this->pdo);
        $allCategory = $categoryRepository->findAll();

        $profileRepository = new ProfileRepository($this->pdo);
        $allProfile = $profileRepository->findAll();

        $params = explode('/', $request->getPathInfo());
        $participantRepository = new ParticipantRepository($this->pdo);
        $participant = $participantRepository->find($params[2]);

        $content = $this->twig->render(
            'participantForm.html.twig',
            ['participant' => $participant,
            'categories' => $allCategory,
            'profiles' => $allProfile
            ]
        );
        $response->setContent($content);

        return $response;
    }

    public function participantUpdate(Request $request, Response $response): Response
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

        return new RedirectResponse('http://127.1.2.3/participant/list');
    }
}
