<?php

namespace App\Controller;

use App\Container\FactoryContainer;


abstract class AbstractController
{
    protected object $twig;

    public function __construct()
    {
        $this->twig = FactoryContainer::twigInitializer();
        
    }
}
