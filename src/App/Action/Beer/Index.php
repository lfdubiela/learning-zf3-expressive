<?php

namespace App\Action\Beer;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
// use Zend\Diactoros\Response\HtmlResponse;

class Index
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

        return $response;
    }
}
