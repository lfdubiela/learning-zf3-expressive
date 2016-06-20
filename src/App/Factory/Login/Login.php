<?php

namespace App\Factory\Login;

use Interop\Container\ContainerInterface;
use Zend\Db\TableGateway\TableGateway;
use App\Action\Login\Login as Action;

class Login
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get('App\Factory\Db\Adapter\Adapter');
        $tableGateway = new TableGateway('user', $adapter);

        return new Action($tableGateway);
    }
}
