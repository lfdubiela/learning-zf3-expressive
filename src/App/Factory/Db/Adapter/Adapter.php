<?php

namespace App\Factory\Db\Adapter;

use Interop\Container\ContainerInterface;

class Adapter
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return new \Zend\Db\Adapter\Adapter($config['db']);
    }
}
