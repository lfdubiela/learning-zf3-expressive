<?php

namespace App\Middleware;

use Zend\Expressive\ZendView\UrlHelper;
use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RedirectHandler implements MiddlewareInterface
{

    protected $urlHelper;

    public function __construct(UrlHelper $urlHelper)
    {
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        if ($response->getStatusCode() == 401 &&
            !$this->isXmlHttpRequest($request)) {

            $response = $response->withHeader(
                'Login',
                $this->urlHelper->generate('login')
            );
        }

        return $out($request, $response);
    }

    private function isValid(Request $request)
    {
        $token = $request->getHeader('authorization');
        return true;
    }

    private function isXmlHttpRequest(Request $request)
    {
        $header = $request->getHeader('accept');
        $accept = null;
        if (isset($header[0])) {
            $accept = $header[0];
        }
        if (!$accept || $accept != 'application/json') {
            return true;
        }
        return false;
    }
}

