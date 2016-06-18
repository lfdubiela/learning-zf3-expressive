<?php

namespace App\Middleware;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Validate implements MiddlewareInterface
{
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        // if ($request->getMethod() != 'POST' && $request->getMethod() != 'PUT') {
        //     return $next($request, $response);
        // }
        // $parsedUri = $this->parseUri($request);
        // if ($parsedUri != '/beer') {
        //     return $next($request, $response);
        // }
        $beer = new \App\Model\Beer;
        $inputFilter = $beer->getInputFilter();
        $inputFilter->setData($this->parseBody($request));
        if (!$inputFilter->isValid()) {
            $errors = [];
            foreach ($inputFilter->getMessages() as $key => $values) {
                $messages = [];
                foreach ($values as $message) {
                    $messages[] = $message;
                }
                $errors[] = [
                    'input' => $key,
                    'messages' => $messages,
                ];
            }
            // throw new \Exception(json_encode($errors), 422);
            $response->getBody()->write(json_encode($errors));
            return $response->withStatus(422);
        }

        return $next($request, $response);
    }

    private function parseUri($request)
    {
        return substr($request->getUri()->getPath(), 0, 5);
    }

    private function parseBody($request)
    {
        switch ($request->getMethod()) {
            case 'POST':
                return $request->getParsedBody();
                break;
            case 'PUT':
                parse_str(file_get_contents("php://input"),$data);
                return $data;
                break;
        }

        return [];
    }
}
