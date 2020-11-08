<?php
class Route_controller
{
	private $url;
	private $routings;

	private $address;
	private $controller_name;
	private $function_name;
	private $params;

	public function __construct($url, $routings)
	{
		$this->url = $url;
		$this->routings = $routings;
	}

	/**	собственно обработка роута
	 */
	public function go_to_route()
	{
		//проверка урл
		if (!$this->url_validate()) {
			exit('Invalid URL '.$this->url);
		}
		//получить имя класса и функции
		$this->get_classname_funname();
		//проверить существование файла
		if (!$this->file_found()) {
			exit('File '.$this->address.$this->controller_name.' not found');
		} else {
			require_once($this->address.$this->controller_name.'.php');
		}
		//проверить существование класса
		if (!$this->class_found()) {
			exit('Class '.$this->controller_name.' not found');
		}
		//проверить существование функции
		if (!$this->function_found()) {
			exit('Method '.$this->function_name.' not found');
		}
		//получение параметров
		$this->work_with_params();
		//собственно вызов функции
		$function_name = $this->function_name;
		$this->controller_name::$function_name($this->params);
	}

	/**	валидция УРЛ
	 * 	@return bool true - адрес верный или false - адрес не верный
	 */
	private function url_validate()
	{
		if (isset($this->url) && preg_match('/^[a-zA-Z0-9_\/]{1,20}$/',$this->url)) {
			return true;
		} else {
			return false;
		}
	}

	/**	по УРЛ получить имена вызываемых класса и метода
	 */
	private function get_classname_funname()
	{
		//получаем адрес контроллера и имя метода из массива роутов
		foreach ($this->routings as $key => $route) {
			$pattern = str_replace('/','\/',$route['route']);
			if (preg_match("/^$pattern$/",$this->url)) {
				$this->address = $route['address'];
				$this->controller_name = $route['class_name'];
				$this->function_name = $route['func_name'];
				break;
			}

			$this->address = './controllers/pages/';
			$this->controller_name = 'Error_controller';
			$this->function_name = 'Er_404';
		}
	}

	/**	поиск файла
	 * 	@return bool true - файл существует или false - файл не существует
	 */
	private function file_found()
	{
		if (is_file($this->address.$this->controller_name.'.php')) {
			return true;
		} else {
			return false;
		}
	}

	/**	поиск класса
	 * 	@return bool true - класс существует или false - класс не существует
	 */
	private function class_found()
	{
		if (class_exists($this->controller_name)) {
			return true;
		} else {
			return false;
		}
	}

	/**	поиск функции
	 * 	@return bool true - функция существует или false - функция не существует
	 */
	private function function_found()
	{
		//проверяем наличие метода в классе
		if (method_exists($this->controller_name, $this->function_name)) {
			return true;
		} else {
			return false;
		}
	}

	/**	получение параметров, если они были переданы
	 */
	private function work_with_params()
	{		
		define('NO_PARAMS', 1);
		define('ONE_PARAM', 2);
		//определяем количество переданных параметров
		if (substr_count($this->url,'/') == NO_PARAMS) {
			//без параметров
			$this->params = '';
		} elseif (substr_count($this->url,'/') == ONE_PARAM) {
			//если передан 1 параметр
			//оставляем только его
			$this->params = preg_replace('/^\/[a-zA-Z]+[0-9]+\//', '', $this->url);
		} else {
			//если параметров много	
			//оставляем только список переданных параметров
			$params = preg_replace('/^\/[a-zA-Z]+[0-9]+\//', '', $this->url);
			//преобразуем его в массив
			$this->params = explode('/', $params);
		}
	}
}
