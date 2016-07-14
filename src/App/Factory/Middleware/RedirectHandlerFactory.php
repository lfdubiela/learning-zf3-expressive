<?php

namespace App\Factory\Middleware;

use App\Middleware\RedirectHandler;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;

class RedirectHanderFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new RedirectHandler($container->get(UrlHelper::class));
    }
}