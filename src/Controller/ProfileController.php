<?php

namespace App\Controller;

use App\Model\Profile;
use App\Repository\ProfileRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class ProfileController
{
    private ProfileRepository $profileRepository;
    public object $loader;
    public object $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader('src/View');
        $this->twig = new Environment($this->loader, []);
        $this->profileRepository = new ProfileRepository();
    }

    public function profilePage(): void
    {
        $allProfile = $this->profileRepository->findAll();
        echo $this->twig->render('profileView.html.twig', ['profiles' => $allProfile]);
    }

    public function profileAdd(): void
    {
        $request = Request::createFromGlobals();
        $name = $request->get('name');
        $newProfile = new Profile();
        $newProfile->setName($name);
        $checkProfile = $this->profileRepository->findbyName($newProfile);
        if (empty($checkProfile)) {
            $addProfile = $this->profileRepository->add($newProfile);
        }
        $response = new RedirectResponse('http://127.1.2.3/profile');
        $response->send();
    }

    public function profileUpdate(): void
    {
        $request = Request::createFromGlobals();
        $updateProfile = new Profile();
        $updateProfile->setName($request->get('name'));
        $updateProfile->setId($request->get('nameId'));
        $checkProfile = $this->profileRepository->findbyName($updateProfile);
        if (empty($checkProfile)) {
            $addProfile = $this->profileRepository->update($updateProfile);
        }
        $response = new RedirectResponse('http://127.1.2.3/profile');
        $response->send();
    }

    public function profileDelete(): void
    {
        $request = Request::createFromGlobals();
        $id = (int) $request->get('nameId');
        $deleteProfile = $this->profileRepository->delete($id);
        $response = new RedirectResponse('http://127.1.2.3/profile');
        $response->send();
    }
}
