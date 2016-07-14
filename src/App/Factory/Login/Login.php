<?php

namespace App\Factory\Login;

use App\Action\Login\Login as Action;
use App\Factory\Db\Adapter\Adapter;
use Interop\Container\ContainerInterface;
use Zend\Db\TableGateway\TableGateway;

class Login
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get(Adapter::class);

        $tableGateway = new TableGateway('user', $adapter);

        return new Action($tableGateway);
    }
}
