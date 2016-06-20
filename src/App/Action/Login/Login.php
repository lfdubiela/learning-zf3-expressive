<?php

namespace App\Action\Login;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Login
{
    private $tableGateway;

    public function __construct($tableGateway)
    {
        $this->tableGateway   = $tableGateway;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $body = $request->getParsedBody();

        $login = $body['login'];
        $password = $body['password'];

        $users = $this->tableGateway->select(array('login' => $login, 'password' => $password));    

        if (count($users) == false) {
           return $response->withStatus(404);    

        }

        return $next($request, $response->getBody()->write('success'));
    }
}
