<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('authenticate', new Route('/authenticate', array(
    '_controller' => 'HamzaBundle:Login:authenticate',
)));

return $collection;