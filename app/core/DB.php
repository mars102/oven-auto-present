<?php 
namespace app\core;
class DB{
	protected static $db = NULL;

	public function __construct()
	{
		
	}

	public static function getInstant()
	{
		if(self::$db!=NULL){
			return self::$db;
		}

		self::$db = new \PDO("mysql:host=".BASE_HOST.";dbname=".BASE_NAME, BASE_USER,BASE_PASS);
		self::$db->query('SET CHARSET UTF8');
		return self::$db;
	}

	
}