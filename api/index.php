<?php

require_once "configs/Route.php";
require_once "configs/Router.php";
require_once "controller/UserController.php";
require_once "controller/CronController.php";
require_once "controller/StatsController.php";

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];

$router = new Router();
$router->addController(new UserController());
match (true) {
    preg_match("/user/", $path) == true => $router->addController(new UserController()),
    preg_match("/cron/", $path) == true => $router->addController(new CronController()),
    preg_match("/stat/", $path) == true  => $router->addController(new StatsController()),
    // default => {echo "<h1>no match<\>"}
};

header('Content-Type: application/json');
echo json_encode($router->handleRequest($method, $path));
