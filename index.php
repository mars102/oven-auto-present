<?php 
namespace app;
session_start();
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = array();//если сессия не существовала то создаём её
if(!isset($_SESSION['sortcars'])) $_SESSION['sortcars'] = null;
if(!isset($_SESSION['install_pack'])) $_SESSION['install_pack'] = null;
if(!isset($_SESSION['selectedcars'])) $_SESSION['selectedcars'] = null;

require 'app/autoloader.php';

define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('TEMPLATE',ROOT.'/app/views');
define ('DEFAULT_CLASS','Content');
define ('DEFAULT_METHOD','Index');

define('BASE_HOST', 'localhost');
define('BASE_NAME', 'oa_renault');
define('BASE_USER', 'admin');
define('BASE_PASS', 'admin');

/*
DEFINE('BASE_HOST', 'localhost');
DEFINE('BASE_NAME', 'myrenault');
DEFINE('BASE_USER', 'myrenault');
DEFINE('BASE_PASS', 'h7dBzZyCBPxWbntx');
*/
  
define('BRAND',1);
$autoloader = 'autoloader\\' . "autoloader";
$autoloader = new $autoloader;



$app = new \app\core\Router();
$app->run();


$counter = new \app\core\userCounter();
$counter->start();


