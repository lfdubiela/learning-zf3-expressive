<?php

namespace App\Factory\Db\Adapter;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;

class Adapter
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        return new Adapter($config['db']);
    }
}
