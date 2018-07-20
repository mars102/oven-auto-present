<?php 
namespace app\controllers;
use \app\models as models;
Class AdminController extends \app\core\Controller
{
	public function actionIndex($value='')
	{
        header("Location:http://admin.oven-auto.ru");
    }
}