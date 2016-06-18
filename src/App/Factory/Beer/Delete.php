<?php

namespace App\Factory\Beer;

use Interop\Container\ContainerInterface;
use Zend\Db\TableGateway\TableGateway;
use App\Action\Beer\Delete as Action;

class Delete
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('App\Factory\Db\Adapter\Adapter');
        $tableGateway = new TableGateway('beer', $adapter);

        return new Action($tableGateway);
    }
}
