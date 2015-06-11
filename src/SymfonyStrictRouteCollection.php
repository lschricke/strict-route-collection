<?php

namespace Lschricke\SymfonyStrictRouteCollection;

use Lschricke\SymfonyStrictRouteCollection\Exception\RouteNameAlreadyUsedException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * {@inheritdoc}
 *
 * This only difference with Symfony's RouteCollection is that this does not let you add a Route with a name
 * that is already used in the collection.
 */
class SymfonyStrictRouteCollection extends RouteCollection
{
    public function addCollection(RouteCollection $collection)
    {
        foreach ($collection->all() as $name => $route) {
            $this->add($name, $route);
        }

        // remove all the routes so that we have an empty collection when calling parent method
        // and we are not re-adding the routes again
        $collection->remove(array_keys($collection->all()));

        // call parent method with empty collection to merge the collection's resources
        parent::addCollection($collection);
    }

    public function add($name, Route $route)
    {
        if (null !== $routeWithSameName = $this->get($name)) {
            throw new RouteNameAlreadyUsedException($route, $name, $routeWithSameName);
        }

        parent::add($name, $route);
    }
}
