<?php
declare(strict_types=1);

namespace Nerd\Middleware;

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GuestMiddleware
{

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        $response = $handler->handle($request);
        //if (Sentinel::check()) {
            //return $response->withHeader('Location', '/jobs');
        //}
        return $response;
    }
}
