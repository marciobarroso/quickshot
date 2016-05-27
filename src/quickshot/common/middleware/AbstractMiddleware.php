<?php

namespace QuickShot\Common\Middleware;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface as Container;
use QuickShot\Common\AbstractComponent;

abstract class AbstractMiddleware extends AbstractComponent {
	public abstract function __invoke(Request $request, Response $response, callable $next);
}