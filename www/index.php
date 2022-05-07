<?php
session_start();
require_once('vendor/autoload.php');

$list_no_param = array('XemDon', 'TaoDon', 'XemNhiemVu');

if (!empty($_GET['controller'])) {
	$controller = $_GET['controller'];
	if (!empty($_GET['action'])) {
		$action = $_GET['action'];
		if (!empty($_GET['param'])) {
			if (!in_array($action, $list_no_param)) {
				$param = $_GET['param'];
			} else {
				$controller = 'error';
			}
		} else {
			$param = "";
		}
	} else {
		$action = 'index';
	}
} else {
	$controller = 'Home';
	$action = 'index';
	$param = "";
}

$controller = ucfirst($controller) . 'Controller';
if (!class_exists($controller)) {
	$controller = 'ErrorController';
	$action = 'error';
}
$obj = new $controller();
if (!method_exists($obj, $action)) {
	$obj = new ErrorController();
	$action = 'error';
}
if (empty($param)) {
	$obj->$action();
} else {
	$obj->$action($param);
}
