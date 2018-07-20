<?php
namespace app\controllers;
use \app\models as models;
use \app\core as core;
Class GuidController extends \app\core\Controller
{
    public function actionIndex()
    {
        $models = new models\car_2_model();
        $models = $models->getAllModels(BRAND);
        $this->view->render('index.php','guid.php',array(
            'title'=>'Гид Renault',
            'models'=>$models
        ));
    }
}