<?php

namespace App\Action\Beer;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Index implements MiddlewareInterface
{
    private $tableGateway;

    public function __construct($tableGateway)
    {
        $this->tableGateway   = $tableGateway;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $beers = $this->tableGateway->select()->toArray();

        $response->getBody()->write(serialize($beers));

        return $next($request, $response);
    }
}
