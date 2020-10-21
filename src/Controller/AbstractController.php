<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    public object $loader;
    public object $twig;


    public function __construct()
    {
        $this->loader = new FilesystemLoader('src/View');
        $this->twig = new Environment($this->loader, []);

        return $this->twig;
    }


    
}
