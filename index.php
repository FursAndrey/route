<?php
$url = $_SERVER['REQUEST_URI'];
require_once('controllers/route.php');

if (!isset($url) || !preg_match('/^[a-zA-Z0-9_\/]{1,20}$/',$url)) {
	exit('Invalid URL '.$url);
}

//получаем адрес контроллера и имя метода из массива роутов
foreach ($routings as $key => $route) {
	$pattern = str_replace('/','\/',$route['route']);
	if (preg_match("/^$pattern$/",$url)) {
		$address = $route['address'];
		$controller_name = $route['class_name'];
		$function_name = $route['func_name'];
		break;
	}

	$address = './controllers/pages/';
	$controller_name = 'Error_controller';
	$function_name = 'Er_404';
}

//проверяем существование файла
if (!is_file($address.$controller_name.'.php')) {
	exit('File '.$address.$controller_name.' not found');
}
require_once($address.$controller_name.'.php');
//проверяем наличие класса в файле
if (!class_exists($controller_name)) {
	exit('Class '.$controller_name.' not found');
}
//проверяем наличие метода в классе
if (!method_exists($controller_name, $function_name)) {
	exit('Method '.$function_name.' not found');
}

define('NO_PARAMS', 1);
define('ONE_PARAM', 2);
//определяем количество переданных параметров
if (substr_count($url,'/') == NO_PARAMS) {
	//без параметров
	$params = '';
} elseif (substr_count($url,'/') == ONE_PARAM) {
	//если передан 1 параметр
	//оставляем только его
	$params = preg_replace('/^\/[a-zA-Z]+[0-9]+\//', '', $url);
} else {
	//если параметров много	
	//оставляем только список переданных параметров
	$params = preg_replace('/^\/[a-zA-Z]+[0-9]+\//', '', $url);
	//преобразуем его в массив
	$params = explode('/', $params);
}

//вызов искомой функции
$controller_name::$function_name($params);