<?php 
namespace app\controllers;
use \app\models as models;
Class ApiController extends \app\core\Controller
{
    public function actionSetgrouper()
    {
        $option = new models\car_5_option_list();
        $option = $option->getAll();
    }

    public function actionPagecounter()
    {
    	$stack = mb_strtolower($_SERVER['HTTP_USER_AGENT']);
		$find = "bot";
		$res = mb_strpos($stack, $find);
		if($res===false)
		{
	    	$page_counter = new \app\models\page_counter();
			$url = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
			$page_counter->title = $_POST['param'];
			$page_counter->url = $_POST['url'];
			$page_counter->checkURL();
			echo json_encode($_POST);	
		}
    }
}