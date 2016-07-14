<?php

namespace App\Middleware\Format;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Stratigility\MiddlewareInterface;

class Html implements MiddlewareInterface
{
    private $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $content = unserialize($response->getBody());

        $response = new HtmlResponse($this->template->render('beer::index', ['content' => $content]));

        return $next($request, $response);
    }
}
