<?php

namespace App\Controller;

use App\Factory\ProfileFactory;
use App\Repository\ProfileRepository;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class ProfileController extends AbstractController
{

    public function profilePage(): void
    {
        $profileRepository = new ProfileRepository();
        $allProfile = $profileRepository->findAll();
        echo $this->twig->render('profileView.html.twig', ['profiles' => $allProfile]);
    }

    public function profileAdd($request): void
    {
        $profileRepository = new ProfileRepository();

        $newProfile = ProfileFactory::fromRequestAdd($request);
        $checkProfile = $profileRepository->findbyName($newProfile);
        if (! empty($checkProfile)) {
            throw new Exception('Nom déjà existant');
        }
        $addProfile = $profileRepository->add($newProfile);
        $response = new RedirectResponse('http://127.1.2.3/profile');
        $response->send();
    }

    public function profileUpdate($request): void
    {
        $profileRepository = new ProfileRepository();

        $updateProfile = ProfileFactory::fromRequestUdpate($request);
        $checkProfile = $profileRepository->findbyName($updateProfile);
        if (! empty($checkProfile)) {
            throw new Exception('Nom déjà existant');
        }
        $addProfile = $profileRepository->update($updateProfile);
        $response = new RedirectResponse('http://127.1.2.3/profile');
        $response->send();
    }

    public function profileDelete($request): void
    {
        $profileRepository = new ProfileRepository();

        $deleteProfile = $profileRepository->delete($request->get('nameId'));
        $response = new RedirectResponse('http://127.1.2.3/profile');
        $response->send();
    }
}
