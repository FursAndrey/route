<?
class Another_controller
{
	public static function Function1($param)
	{
		echo "Hello, i`m Function1 from Another_controller<br/>I have next param '$param'";
	}
	
	public static function Function2($params)
	{
		echo "Hello, i`m Function2 from Another_controller<br/>I have next params:<br/>";
		foreach ($params as $key => $value) {
			echo "$key => $value<br/>";
		}
	}
}
