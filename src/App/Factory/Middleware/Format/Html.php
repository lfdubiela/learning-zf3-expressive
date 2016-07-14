<?php

namespace App\Factory\Middleware\Format;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Middleware\Format\Html as AHtml;

class Html
{
    public function __invoke(ContainerInterface $container)
    {
        return new AHtml($container->get(TemplateRendererInterface::class));
    }
}
