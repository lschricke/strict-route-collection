<?php

namespace StrictRouteCollection;

use StrictRouteCollection\Exception\RouteNameAlreadyUsedException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * {@inheritdoc}
 *
 * This only difference with symfony's RouteCollection is that this does not let you add a Route with a name
 * that is already used in the collection.
 */
class StrictRouteCollection extends RouteCollection
{
    public function addCollection(RouteCollection $collection)
    {
        foreach ($collection->all() as $name => $route) {
            $this->add($name, $route);
        }

        // remove all the routes so that we have an empty collection when calling parent method
        // and we are not re-adding the routes again
        $collection->remove($collection->all());

        // call parent method with empty collection to merge the collection's resources
        parent::addCollection($collection);
    }

    public function add($name, Route $route)
    {
        if (null !== $this->get($name)) {
            throw new RouteNameAlreadyUsedException(sprintf("You are trying to register a route with the name '%s' (path '%s'), which is already used by another route (path '%s')",
                $name, $route->getPath(), $this->get($name)->getPath()));
        }

        parent::add($name, $route);
    }
}