<?php

namespace Lschricke\SymfonyStrictRouteCollection\Exception;

use Symfony\Component\Routing\Route;

class RouteNameAlreadyUsedException extends \LogicException
{
    /**
     * @param Route $route the route we're tried to add
     * @param int $name the name given to the route we tried to add
     * @param Route $routeWithSameName the existing route with the same name
     */
    public function __construct(Route $route, $name, Route $routeWithSameName)
    {
        // host to string
        if (!$host = $route->getHost()) {
            $host = 'any';
        }

        if (!$hostRouteWithSameName = $routeWithSameName->getHost()) {
            $hostRouteWithSameName = 'any';
        }

        // methods to string
        if ($methods = $route->getMethods()) {
            $methods = implode($methods, ', ');
        } else {
            $methods = 'any';
        }

        if ($methodsRouteWithSameName = $routeWithSameName->getMethods()) {
            $methodsRouteWithSameName = implode($methodsRouteWithSameName, ', ');
        } else {
            $methodsRouteWithSameName = 'any';
        }

        $message = sprintf("Cannot add the route [path: %s, host: %s, methods: %s] with the name '%s'
                as it is already used by the route [path: %s, host: %s, methods: %s].",
            $route->getPath(), $host, $methods,
            $name,
            $routeWithSameName->getPath(), $hostRouteWithSameName, $methodsRouteWithSameName
        );

        parent::__construct($message);
    }
}