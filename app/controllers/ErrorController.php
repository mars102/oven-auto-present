<?php 
namespace app\controllers;
use \app\models as models;
Class ErrorController extends \app\core\Controller
{
    public function actionIndex()
    {
        header('HTTP/1.0 404 not found');
        $message="Страница не найдена";
        $this->view->render('error.php','head.php',array(
            'title'=>"Ошибка",
            'message' => $message
        ));
    }
}