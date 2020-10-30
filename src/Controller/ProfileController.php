<?php

namespace App\Controller;

use App\Factory\ProfileFactory;
use App\Repository\ProfileRepository;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ProfileController extends AbstractController
{

    public function profilePage(Request $request, Response $response): Response
    {
        $profileRepository = new ProfileRepository($this->pdo);
        $allProfile = $profileRepository->findAll();
        $content =  $this->twig->render('profileView.html.twig', ['profiles' => $allProfile]);
        $response->setContent($content);

        return $response;
    }

    public function profileAdd(Request $request): Response
    {
        $profileRepository = new ProfileRepository($this->pdo);

        $newProfile = ProfileFactory::fromRequestAdd($request);
        $checkProfile = $profileRepository->findbyName($newProfile);
        if (! empty($checkProfile)) {
            throw new Exception('Nom déjà existant');
        }
        $addProfile = $profileRepository->add($newProfile);
        
        $serverHost = $request->server->get('HTTP_HOST');

        return new RedirectResponse('http://' . $serverHost . '/profile');
    }

    public function profileUpdate(Request $request): Response
    {
        $profileRepository = new ProfileRepository($this->pdo);

        $updateProfile = ProfileFactory::fromRequestUdpate($request);
        $checkProfile = $profileRepository->findbyName($updateProfile);
        if (! empty($checkProfile)) {
            throw new Exception('Nom déjà existant');
        }
        $addProfile = $profileRepository->update($updateProfile);
        $serverHost = $request->server->get('HTTP_HOST');

        return new RedirectResponse('http://' . $serverHost . '/profile');
    }

    public function profileDelete(Request $request): Response
    {
        $profileRepository = new ProfileRepository($this->pdo);
        $deleteProfile = $profileRepository->delete($request->get('nameId'));
        $serverHost = $request->server->get('HTTP_HOST');

        return new RedirectResponse('http://' . $serverHost . '/profile');
    }
}
