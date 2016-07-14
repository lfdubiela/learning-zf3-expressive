<?php
namespace App\Middleware;

use Lcobucci\JWT\ValidationData;
use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Lcobucci\JWT\Token;

/**
 * Class Auth
 * @package App\Middleware
 */
class Auth implements MiddlewareInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param callable|null $out
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        if ($this->isRouteOnWhiteList($request->getUri())) {
            return $out($request, $response);
        }

        if (!$request->hasHeader('authorization')) {
            return $response->withStatus(401);
        }

        if (!$this->isValid($request)) {
            return $response->withStatus(403);
        }

        return $out($request, $response);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isValid(Request $request)
    {
        $token = $request->getHeader('authorization');
        $token = (is_array($token) ? $token[0] : $token);
        $tokenData = new ValidationData(time());
        $tokenData->setSubject($token);
        $tokenJWT = new Token();
        return $tokenJWT->validate($tokenData);
    }

    /**
     * @param $route
     * @return mixed
     */
    private function isRouteOnWhiteList($route)
    {
        $route = explode('/', $route);
        if (isset($route[3]) &&
            $route[3]) {
            return array_search($route[3], $this->getWhiteList()) !== false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getWhiteList()
    {
        return ['login'];
    }

}
