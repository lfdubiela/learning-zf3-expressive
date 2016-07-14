<?php

namespace App\Action\Login;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Lcobucci\JWT\Builder;
use Zend\Db\TableGateway\TableGateway;

class Login
{
    /** @var  $tableGateway TableGateway */
    private $tableGateway;

    public function __construct($tableGateway)
    {
        $this->tableGateway = $tableGateway;
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

        return $next($request, $response
            ->withHeader('authorization', $this->createNewToken()->__toString())
        );
    }

    public function createNewToken()
    {
        $builder = new Builder();
            return $builder->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
            ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
            ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
            ->set('uid', 1) // Configures a new claim, called "uid"
            ->getToken(); // Retrieves the generated token
    }
}
