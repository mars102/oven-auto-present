<?php 
namespace app\controllers;
use \app\models as models;
Class ContentController extends \app\core\Controller
{
	public function actionIndex($value='')
	{
		$models = new models\car_2_model();
		$models = $models->getAllModels(BRAND);
		$new = new models\news();
		$news = $new->getActualNews(1,5);
		$actions = $new->getActualNews(2);
		$banner = new models\banner();
		$this->view->render('index.php','head.php',array(
			'title'=>'Главная',
			'models'=>$models,
			'news'=>$news,
			'actions'=>$actions,
			'banner'=>$banner
		));
	}

	public function actionViewcar($link)
	{	
		$models = new models\car_2_model();
		$models = $models->getModelByLink($link);

		$image = new \app\core\Image();
		$maspic = explode('/',ROOT.'../admin'.$models->alpha);
		array_pop($maspic);
		$maspic[] = 'photo';
		$models->pictures = $image->getImgList(implode('/',$maspic));
		
		foreach($models->pictures as $key=>$img)
		{
			$start = mb_strpos($img,'/../')+4;
			$end = \mb_strlen($img);
			$img = \str_replace('admin','http://admin.oven-auto.ru',$img);
			$models->pictures[$key] = \mb_substr($img,$start,$end);
		}
		
		$models->getDocuments();
		$models->getComplect();
		$kredit = new \app\models\kredit();
		$kredit = $kredit->getKreditByIdCar($models->id);
		$test = \app\models\testdrive::getTestCar($models->id);
		$kredit_banner = array();
		if(is_array($kredit)) :
			foreach ($kredit as $key => $value) {
				$krbanner[] = $value->name;
			}
			$kredit_banner = $krbanner;
		endif;
		$form = new \app\models\forms();
		$form = $form->getFormsData(array(1));
		$this->view->render('viewcar.php','head.php',array(
			'title'=>$models->name,
			'models'=>$models,
			'kredit'=>$kredit,
			'test'=>$test,
			'kredit_banner'=>$kredit_banner,
			'form'=>$form
		));
	}

	public function actionViewavacar($id="")
	{
		$install_pack = array();
		$car = new \app\models\car_available();
		$car = $car->getAvaCar($id);
		$_SESSION['install_pack'] = array();
		if(\is_array($car->packs)) :
			foreach($car->packs as $pack)
			{
				$_SESSION['install_pack'][] = $pack->id;
			}
		endif;
		$kredit = new \app\models\kredit();
		$kredit = $kredit->getKreditByIdCar($car->model->id);
		$test = \app\models\testdrive::getTestCar($car->model->id);
		$form = new \app\models\forms();
		$form = $form->getFormsData(array(1));
		$mas = trim($car->install,',');
		$mas1 = explode(',',$mas);
		if(is_numeric($mas1[0]))
			$car->install = (\app\models\dop_ob::getDop($car->install));

		$company = new \app\models\company();
		$companyList = $company->getCompanyByCar($car);
		
		//\app\core\Html::prA($companyList);

		$company_sale=0;
		$company_gift=0;
		$company_service=0;
		$company_action=0;
		foreach ($companyList as $key => $value) {
			if($value->razdel==1) $company_sale++;
			if($value->razdel==2) $company_gift++;
			if($value->razdel==3) $company_service++;
			if($value->razdel==4) $company_action++;
		}
		$actionCount = array(
			'company_sale'=>$company_sale,
			'company_gift'=>$company_gift,
			'company_service'=>$company_service,
			'company_action'=>$company_action
		);

		$this->view->render('viewavacar.php','head.php',array(
			'title'=>$car->model->name,
			'car'=>$car,
			'kredit'=>$kredit,
			'test'=>$test,
			'form'=>$form,
			'company'=>$companyList,
			'countCompany'=>$actionCount
		));
	}

	public function actionConfigure($model="",$id_complect="",$complect="")
	{	
		$install_pack = array();
		if(is_array($_SESSION['install_pack']))
			$install_pack = $_SESSION['install_pack'];
		$_SESSION['install_pack'] = "";
		$model = new \app\models\car_2_model();
		$complect = new \app\models\car_6_complect();
		$character = new \app\models\car_8_character_list();
		$palette = new \app\models\car_color();
		$complect = $complect->getComplectById($id_complect);
		$model->getRowById($complect->id_model);
		$model->getBrand();
		$model->complect = $complect;
		$model->character = $character->getCharacterByIdModel($model->id);
		$model->palette = $palette->getColorListByModelColorId($model->color);
		$kredit = new \app\models\kredit();
		$kredit = $kredit->getKreditByIdCar($model->id);
		$test = \app\models\testdrive::getTestCar($model->id);
		$form = new \app\models\forms();
		$form = $form->getFormsData(array(1));
		$this->view->render('configure.php','head.php',array(
			'title'=>$model->name,
			'model'=>$model,
			'test'=>$test,
			'kredit'=>$kredit,
			'form'=>$form,
			'install_pack'=>$install_pack
		));
	}

	public function actionAvailablelist(
		$page=1,
		$amount=20,
		$checkedFilter=array(
			'model'=>'',
			'transmission'=>'',
			'privod'=>'',
			'location'=>'',
			'option'=>array(),
			'vin'=>'',
			'pricefrom'=>'',
			'priceto'=>'',
			'selected'=>'',
			'sort'=>''
		)
	)
	{	
		$i=0;
		
		$url = explode('/',$_SERVER["HTTP_REFERER"]);
		array_shift($url);
		array_shift($url);
		array_shift($url);
		$control = array_shift($url);
		$method = array_shift($url);
		if($control.'/'.$method != 'content/availablelist')
		{
			$_SESSION['cartcolor'] = null;
			$_SESSION['selectedcars'] = null;
		}

		if(isset($_POST['model'])) 
		{
			$checkedFilter['model'] = $_POST['model'];
			if(!empty($_POST['model'])) $i++;
		}
		if(isset($_POST['transmission'])) {
			$checkedFilter['transmission'] = $_POST['transmission'];
			if(!empty($_POST['transmission'])) $i++;
		}
		if(isset($_POST['privod'])) 
		{
			$checkedFilter['privod'] = $_POST['privod'];
			if(!empty($_POST['privod'])) $i++;
		}
		if(isset($_POST['location'])) 
		{
			$checkedFilter['location'] = $_POST['location'];
			if(!empty($_POST['location'])) $i++;
		}
		if(isset($_POST['option'])) 
		{
			$checkedFilter['option'] = $_POST['option'];
			if(!empty($_POST['option'])) $i+=count($_POST['option']);
		}
		if(isset($_POST['vin'])) 
		{
			$checkedFilter['vin'] = $_POST['vin'];
			if(!empty($_POST['vin'])) $i++;
		}
		if(isset($_POST['pricefrom'])) 
		{
			$checkedFilter['pricefrom'] = str_replace(" ","",$_POST['pricefrom']);
			if(!empty($_POST['pricefrom'])) $i++;
		}
		if(isset($_POST['priceto'])) 
		{
			$checkedFilter['priceto'] = str_replace(" ","",$_POST['priceto']);
			if(!empty($_POST['priceto'])) $i++;
		}
		if(isset($_POST['submit']))
		{
			$_SESSION['sortcars'] = null;
			$_SESSION['sortmincolor'] = null;
			$_SESSION['sortmaxcolor'] = null;
			$_SESSION['cartcolor'] = null;
			$_SESSION['selectedcars'] = null;
		}
		/*ОЧИСТКА*/
		if(isset($_POST['clear']))
		{
			$_SESSION['sortcars'] = null;
			$_SESSION['sortmincolor'] = null;
			$_SESSION['sortmaxcolor'] = null;
			$_SESSION['cartcolor'] = null;
			$_SESSION['selectedcars'] = null;
			foreach($checkedFilter as $key => $check)
			{
				$checkedFilter[$key] = null;
			}
		}
		/*СОРТИРОВКА*/
		if(isset($_POST['sortmintomax']))
		{
			$_SESSION['sortcars'] = 'mintomax';
			$_SESSION['sortmincolor'] = "color:#a00";
			$_SESSION['sortmaxcolor'] = null;
			//$_SESSION['cartcolor'] = null;
		}
		if(isset($_POST['sortmaxtomin']))
		{
			$_SESSION['sortcars'] = 'maxtomin';
			$_SESSION['sortmaxcolor'] = "color:#a00";
			$_SESSION['sortmincolor'] = null;
			//$_SESSION['cartcolor'] = null;
		}
		$checkedFilter['sort'] = $_SESSION['sortcars'];

		/*ПОКАЗАТЬ ТОЛЬКО МАШИНЫ ИЗ КОРЗИНЫ*/
		if(isset($_POST['selectedcars']))
		{
			$carsId = implode(',',$_SESSION['cart']);
			$carsId = \str_replace(",,",",",$carsId);
			foreach($checkedFilter as $key => $check)
			{
				$checkedFilter[$key] = null;
			}
			if(!empty($carsId)) :
				$_SESSION['selectedcars'] = $carsId;
				$_SESSION['cartcolor'] = "color:#a00";
			endif;
			$_SESSION['sortmincolor'] = null;
			$_SESSION['sortmaxcolor'] = null;
		}
		$checkedFilter['selected'] = $_SESSION['selectedcars'];

		if($page<1) $page=1;
		$cars = new \app\models\car_available();
		$availableCars = $cars->getCountCar();
		$totalCars = $cars->getTotalCars($checkedFilter);
		$cars = $cars->getAvaListCar($page,$amount,$checkedFilter);
		$form = new \app\models\forms();
		$form = $form->getFormsData(array(1));
		$pagination = new \app\core\Pagination($totalCars,$amount,$page);
		$filter = \app\models\car_5_option_list::getFilterOption();
		$this->view->render('carlist.php','head.php',array(
			'title'=>"Автомобили в продаже",
			'totalCars'=>$totalCars,
			'cars'=>$cars,
			'pagination'=>$pagination,
			'filter'=>$filter,
			'form'=>$form,
			'checkfilter'=>$checkedFilter,
			'countFilter'=>$i,
			'availableCars'=>$availableCars
		));
	}

	public function actionTestdrivecar($id="")
	{
		$car = new \app\models\car_available();
		$car = $car->getAvaCar($id);
		$kredit = new \app\models\kredit();
		$kredit = $kredit->getKreditByIdCar($car->model->id);
		$form = new \app\models\forms();
		$form = $form->getFormsData(array(1));
		$this->view->render('testdrivecar.php','head.php',array(
			'title'=>"Тест-драйв".$car->model->name,
			'car'=>$car,
			'kredit'=>$kredit,
			'form'=>$form
		));
	}

	public function actionCompare($list=array())
	{
		$car = new models\car_available();
		if(empty($_SESSION['cart'])) header("Location:/content/availablelist");//если корзина пуста уходим
		$carList = $_SESSION['cart'];
		$carData = array();
		foreach ($carList as $value) {
			if(!empty($value))
				$itemCar = $car->getAvaCar($value);
				$mas = trim($itemCar->install,',');
				$mas1 = explode(',',$mas);
				if(is_numeric($mas1[0]))
					$itemCar->install = (\app\models\dop_ob::getDop($itemCar->install));
				$carData[] = $itemCar;//получаем машины из id хранящихся в корзине
		};
		$optionArray = array();
		foreach ($carData as $key => $value) {
			$data = $value->getCustomSQLNonClass("
				SELECT co.id,co.name FROM caroption as co 
				JOIN car_5_option_list as ol 
					ON ol.id = co.id 
				WHERE co.car_id = {$value->id} 
				order BY ol.parent,ol.name"
			);//собираем оборудование на каждой машине
			foreach($data as $row)
			{
				$optionArray[$row['id']] = $row['name'];
				$carData[$key]->usedOption[]=$row['id'];
			}
		}

		asort($optionArray);
		//\app\core\Html::prA($optionArray);

		foreach($optionArray as $id => $option)
		{
			foreach($carData as $key => $car)
			{
				if(in_array($id,$car->usedOption))
					$carData[$key]->compare[$id] = "<i class='fa fa-plus'></i>";
				else
					$carData[$key]->compare[$id] = "<i class='fa fa-minus'></i>
					";
			}
		}
		$this->view->render('compare.php','head.php',array(
			'title'=>"Сравнение автомобилей",
			'cars'=>$carData,
			'option'=>$optionArray,
			'countCart'=> count($_SESSION['cart'])
		));
	}

	public function actionNewslist($page=1,$amount=10)
	{
		if($page<1) $page=1;
		$news = new \app\models\news();
		$totalNews = $news->getTotalNews(1);
		$news = $news->getNewsList($page,$amount,1);
		$form = new \app\models\forms();
		$form = $form->getFormsData(array(1));
		$pagination = new \app\core\Pagination($totalNews,$amount,$page);
		
		$this->view->render('newslist.php','head.php',array(
			'title'=>"Новости Овен-Авто",
			'totalNews'=>$totalNews,
			'news'=>$news,
			'pagination'=>$pagination,
			'form'=>$form
		));
	}

	public function actionViewnew($id="")
	{
		$new = new models\news();
		$new->getRowById($id);
		$form = new \app\models\forms();
		if($new->form)
			$form = $form->getFormsData(array($new->form));
		else
			$form = $form->getFormsData(array(1));
		$this->view->render('viewnew.php','head.php',array(
			'title'=>$new->title,
			'new'=>$new,
			'form'=>$form
		));
	}

	public function actionActionlist($page=1,$amount=10)
	{
		$action = new \app\models\news();
		$totalNews = $action->getTotalNews(2);
		$action = $action->getNewsList($page,$amount,2);
		$form = new \app\models\forms();
		$form = $form->getFormsData(array(1));
		$pagination = new \app\core\Pagination($totalNews,$amount,$page);
		$this->view->render('newslist.php','head.php',array(
			'title'=>"Акции Овен-Авто",
			'totalNews'=>$totalNews,
			'news'=>$action,
			'pagination'=>$pagination,
			'form'=>$form
		));
	}

	public function actionViewpage($id='')
	{
		$pages = new \app\models\page();
		$pages->getRowById($id);
		$form = new \app\models\forms();
		if($pages->form)
			$form = $form->getFormsData(array($pages->form));
		else
			$form = $form->getFormsData(array(1));
		$this->view->render('viewpage.php','head.php',array(
			'title'=>$pages->title,
			'pages'=>$pages,
			'form'=>$form
		));
	}

	public function actionKreditList()
	{
		$kredit = new \app\models\kredit();
		$kreditList = $kredit->getActualKreditList();
		$form = new \app\models\forms();
		$form = $form->getFormsData(array(7));
		$this->view->render('viewkredit.php','head.php',array(
			'title'=>'Кредитные программы',
			'kreditlist'=>$kreditList,
			'form'=>$form
		));
	}

	public function actionTestform()
	{

		$form = new models\forms();
		$form = $form->getFormsData(array(4),'pic')[0];
		$this->view->render('viewform.php','head.php',array(
			'title'=>$form->header,
			'form'=>$form
		));
	}

	public function actionService()
	{
		$form = new models\forms();
		$form = $form->getFormsData(array(3),'pic')[0];
		$this->view->render('viewform.php','head.php',array(
			'title'=>$form->header,
			'form'=>$form
		));
	}

	public function actionParts()
	{
		$form = new models\forms();
		$form = $form->getFormsData(array(2),'pic')[0];
		$this->view->render('viewform.php','head.php',array(
			'title'=>$form->header,
			'form'=>$form
		));
	}

	public function actionKredit()
	{
		$form = new models\forms();
		$form = $form->getFormsData(array(8),'pic')[0];
		$this->view->render('viewform.php','head.php',array(
			'title'=>$form->header,
			'form'=>$form
		));
	}

	public function actionQuestion()
	{
		$form = new models\forms();
		$form = $form->getFormsData(array(1),'pic')[0];
		$this->view->render('viewform.php','head.php',array(
			'title'=>$form->header,
			'form'=>$form
		));
	}

	public function actionContact()
	{
		$contacts = new models\contacts();
		$brand = BRAND;
		$contacts = $contacts->getCustomSQL("SELECT * FROM {$contacts->table} WHERE brand = {$brand}")[0];
		$form = new models\forms();
		$form = $form->getFormsData(array(1));
		$this->view->render('contacts.php','head.php',array(
			'title'=>'Контакты',
			'contacts'=>$contacts,
			'form'=>$form
		));
	}

	public function actionTestim()
	{
		echo "/home/www/oven-auto.ru/html/renault/../admin/content/available/12-04-2018-1140-39-86-X7LASRBA660558931";
		\app\core\Html::prA(\app\core\Image::getImgList("/home/www/oven-auto.ru/html/renault/../admin/content/available/12-04-2018-1140-39-86-X7LASRBA660558931"));	
	}
}