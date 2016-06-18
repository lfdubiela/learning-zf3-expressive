<?php

namespace App\Action\Beer;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class Delete
{
    private $tableGateway;

    public function __construct($tableGateway)
    {
        $this->tableGateway   = $tableGateway;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');
        $beer = $this->tableGateway->select(['id' => $id]);
        if (count($beer) == 0) {
            return $response->withStatus(404);
        }

        $this->tableGateway->delete(['id' => $id]);

        $response->getBody()->write(serialize('Deleted'));

        return $response;
    }
}
