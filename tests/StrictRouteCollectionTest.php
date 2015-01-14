<?php

namespace StrictRouteCollection\Tests;

use PHPUnit_Framework_TestCase;
use StrictRouteCollection\StrictRouteCollection;
use Symfony\Component\Routing\Route;

class StrictRouteCollectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \StrictRouteCollection\Exception\RouteNameAlreadyUsedException
     */
    public function testException()
    {
        $routeCollection = new StrictRouteCollection();
        $route = new Route('/');

        $routeCollection->add('same_route_name', $route);
        $routeCollection->add('same_route_name', $route);
    }

    public function testNormalBehavior()
    {
        $routeCollection = new StrictRouteCollection();
        $route = new Route('/');

        $routeCollection->add('one_route_name', $route);
        $routeCollection->add('another_route_name', $route);

        $this->assertEquals(2, $routeCollection->count());
    }
}
