<?php
include_once("../dispatcher.php");
include_once("../Src/router.php");
include_once("../Controllers/UsersController.php");
include_once("../Controllers/ArticlesController.php");
include_once("../Controllers/CommentsController.php");

$router = new Router;
$path = $router->parse_url();


$dispatcher = new Dispatcher;
$dispatcher-> dispatch($path);


?>