<?php

namespace App\Kernel;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

final class Kernel
{
    public function handleRequest($request)
    {
        // Init RequestContext object
        $context = new RequestContext();
        $context->fromRequest($request);
        $localDirectory =  $request->server->get('DOCUMENT_ROOT');

        $fileLocator = new FileLocator(array($localDirectory . '/config'));
        $loader = new YamlFileLoader($fileLocator);
        $routes = $loader->load('routes.yaml');

        // Init UrlMatcher object
        $matcher = new UrlMatcher($routes, $context);
    
        // Find the current route
        $parameters = $matcher->match($context->getPathInfo());
        
        $params = explode('::', $parameters['_controller']);
        return $params;
    }
}
