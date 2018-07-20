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
}