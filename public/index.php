<?php

require_once '../conf/config.php';
spl_autoload_register(function ($class_name) {
    require_once "../core/" . $class_name . '.php';
});

Session::startSessionAction();
$controller = isset($_GET['page']) ? ucfirst($_GET['page']) . "Controller" : "IndexController";
$controller = file_exists("controllers/" . $controller . ".php") ? $controller : "IndexController";
$model = isset($_GET['page']) ? ucfirst($_GET['page']) . "Model" : "IndexModel";
$model = file_exists("models/" . $model . ".php") ? $model : "IndexModel";
$action = isset($_GET['action']) ? $_GET['action'] . "Action" : "defaultAction";
include "controllers/" . ucfirst($controller) . ".php";
if (!method_exists($controller, $action)) {
	$action = "defaultAction";
}
include "models/" . ucfirst($model) . ".php";
$controller::$action();
// Session::destroySessionAction();