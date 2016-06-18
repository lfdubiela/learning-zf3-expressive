<?php

namespace App\Action\Beer;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class Create
{
    private $tableGateway;

    public function __construct($tableGateway)
    {
        $this->tableGateway   = $tableGateway;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $data = $request->getParsedBody();

        $this->tableGateway->insert($data);

        $response->getBody()->write(serialize($this->tableGateway->getLastInsertValue()));

        return $next($request, $response);
    }
}
