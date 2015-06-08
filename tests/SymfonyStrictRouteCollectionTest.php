<?php

namespace StrictRouteCollection\Tests;

use Lschricke\SymfonyStrictRouteCollection\SymfonyStrictRouteCollection;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Routing\Route;

class SymfonyStrictRouteCollectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Lschricke\SymfonyStrictRouteCollection\Exception\RouteNameAlreadyUsedException
     */
    public function testException()
    {
        $routeCollection = new SymfonyStrictRouteCollection();
        $route = new Route('/');

        $routeCollection->add('same_route_name', $route);
        $routeCollection->add('same_route_name', $route);
    }

    public function testNormalBehavior()
    {
        $routeCollection = new SymfonyStrictRouteCollection();
        $route = new Route('/');

        $routeCollection->add('one_route_name', $route);
        $routeCollection->add('another_route_name', $route);

        $this->assertEquals(2, $routeCollection->count());
    }
}
