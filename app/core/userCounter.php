<?php 
namespace app\core;
Class userCounter extends \app\core\Model
{
	public $user = NULL;
	public $ip = NULL;
	public $visit = NULL;
	public $table = '';

	public function start()
	{
		$this->ip = new \app\models\ips();
		$this->visit = new \app\models\ips_visit();

		$date = strtotime(date('d.m.Y'));
		$this->visit->getVisitByDate($date);

		if(!isset($_SESSION['userId']))
		{
			$_SESSION['userId'] = session_id().date('d.m.y.h');
			$this->user = $_SESSION['userId'];

			
			$this->ip_addres = $this->user;
			$this->ip->ip_ad = $_SERVER['REMOTE_ADDR'];
			$this->ip->info = $_SERVER['HTTP_USER_AGENT'];
			$this->ip->insertData();

			$stack = mb_strtolower($_SERVER['HTTP_USER_AGENT']);
			$find = "bot";
			$res = mb_strpos($stack, $find);
			if($res===false)
			{
				$this->visit->host = $this->visit->host+1;
				$this->visit->updateData();
			}
				
		}
		
		
	}
}