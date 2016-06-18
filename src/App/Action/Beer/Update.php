<?php

namespace App\Action\Beer;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class Update
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

        // não encontrei outra forma na documentação :/
        parse_str(file_get_contents("php://input"),$data);
        $this->tableGateway->update($data, ['id' => $id]);

        $response->getBody()->write(serialize($id));

        return $response;
    }
}
