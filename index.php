<?php
$url = $_SERVER['REQUEST_URI'];
//файл с роутами
require_once('controllers/routings.php');
require_once('controllers/Route_controller.php');

$route = new Route_controller($_SERVER['REQUEST_URI'], $routings);
$route->go_to_route();