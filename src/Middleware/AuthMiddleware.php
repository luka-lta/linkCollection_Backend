<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Middleware;

use Firebase\JWT\JWT;
use LinkCollectionBackend\Exception\AuthException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use UnexpectedValueException;

class AuthMiddleware implements MiddlewareInterface
{

    /**
     * @throws AuthException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $jwtHeader = $request->getHeaderLine('Authorization');
        if (!$jwtHeader) {
            throw new AuthException('No Authorization header found');
        }

        $jwt = explode('Bearer ', $jwtHeader);
        if (!isset($jwt[1])) {
            throw new AuthException('No valid Authorization header found');
        }
        $decoded = $this->checkToken($jwt[1]);
        $object  = (array)$request->getParsedBody();
        $object['decoded'] = $decoded;

        return $handler->handle($request->withParsedBody($object));
    }

    /**
     * @throws AuthException
     */
    private function checkToken(string $token): object
    {
        try {
            return JWT::decode($token, '93Z3j68stLE{Wh§m', ['HS256']);
        } catch (UnexpectedValueException) {
            throw new AuthException('Forbidden: you are not authorized');
        }
    }
}