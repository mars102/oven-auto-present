<?php 
namespace app\controllers;
use \app\models as models;
Class AjaxController extends \app\core\Controller
{
    public function actionAddtocart()
	{	
		if(array_key_exists($_POST['param'],$_SESSION['cart'])) unset($_SESSION['cart'][$_POST['param']]);
		else $_SESSION['cart'][$_POST['param']] = $_POST['param'];
		echo (trim(count($_SESSION['cart'])));
	}

	public function actionDelcar()
	{
		if(isset($_POST['id']))
		{
			if(isset($_SESSION['cart'][$_POST['id']]))
				unset($_SESSION['cart'][$_POST['id']]);
		}
		echo count($_SESSION['cart']);
	}

	public function actionClearcart()
	{
		$_SESSION['cart']=null;
		$_SESSION['selectedcars'] = null;
		$_SESSION['cartcolor'] = null;
	}

	public function actionLoadform($type)
	{
		$form = new \app\models\forms();
		$data = $form->getCustomSQL("SELECT * FROM forms WHERE type=?",array($type))[0];
		$result = include_once ROOT.'/forms/'.$data->html;
		$result .= "<input type='hidden' value='{$data->type}' name='type'>";
		echo json_encode(array('header'=>$data->head,'html'=>$result));
	}

	public function actionProcessor()
	{
		$sumpack = 0;
		$packs = "";
		if(empty($_POST['type']))
		{
			echo "Произошла ошибка, сообщение не доставлено.";
			return;
		}
		if(isset($_POST['comment']))
		{
			$mystring = $_POST['comment'];
			$findme   = 'http';
			$pos = strpos($mystring, $findme);
			// Заметьте, что используется ===.  Использование == не даст верного
			// результата, так как 'a' находится в нулевой позиции.
			if ($pos === false) {
			    
			} else {
			    echo "Ошибка: нельзя передаватьссылки в письме.";
			    return;
			}
		}
		$model = new \app\models\car_2_model();
		$complect = new \app\models\car_6_complect();
		$car = new \app\models\car_available();

		$form = new \app\models\forms();
		$form = $form->getCustomSQL(
			"SELECT * FROM forms WHERE type = ?",
			array($_POST['type'])
		)[0];
		$order = new \app\models\orders();
		$order->client_name = @$_POST['name'];
		$order->client_phone = @$_POST['phone'];
		$order->client_comment = @$_POST['comment'];
		$order->trafic = $form->getParam('trafic');
		$order->page = @$_SERVER['HTTP_REFERER'];
		$order->test = @$_POST['test'];
		if(!isset($_POST['test']))
		{
			$order->car = @$_POST['id_avacar'];
			$order->complect = @$_POST['id_complect'];
			$order->model = @$_POST['id_model'];
		}
		$order->color = @$_POST['id_color'];
		$order->id_pack = @implode(',',$_POST['packs']);
		$order->status = 1;
		$order->date_in = strtotime(date('d-m-Y'));
		$order->client_date = @$_POST['date'];
		$order->form = @$form->getParam('head');
		$order->part = @$_POST['part'];
		$order->service = @$_POST['service'];

		$result = $order->insertData();

		/*MESSAGE*/
		$model = $order->getParam('model');
		if(!empty($model))
			$order->getModel();

		$complect = $order->getParam('complect');
		if(!empty($complect))
			$order->getComplect();

		$car = $order->getParam('car');
		if(!empty($car))
		{
			$order->getCar();
			$packs = $order->getCustomSQLNonClass("SELECT price FROM packprice WHERE id = {$order->car->getParam('id')}")[0]['price'];
		}
		$test = $order->getParam('test');
		if(!empty($test))
		{
			$order->getTest();
			$packs = $order->getCustomSQLNonClass("SELECT price FROM packprice WHERE id = {$order->car->getParam('id')}")[0]['price'];
		}
		$packobj = $order->getParam('id_pack');
		if(!empty($packobj))
		{
			$pack = new Pack_model();
			$packs = $pack->getCustomSQL("SELECT * FROM {$pack->getParam('table')} WHERE id in ({$order->getParam('id_pack')})");
			//$this->data['packs'] = $packs;
			
			foreach ($packs as $key => $value) {
				$sumpack+=$value->getParam('price');
			}
			//$this->data['sumpack'] = $sumpack;
		}
		/*END MESSAGE*/
		
		
		if($result)
		{
			$mmm = $this->getMessage($order,$packs,$sumpack);
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: ORDER <siterobot@renault.oven-auto.ru>\r\n";
			$headers .= "Cc: ORDER FROM SITE\r\n";
			$headers .= "Bcc: birthdaycheck@example.com\r\n";
			$message = "С сайта пришла заявка ".$form->getParam('trafic').", подробности 
				<a style='color:#00f;' href='http://".$_SERVER['HTTP_HOST']."/adminorder/orderview/".$result."'>
					по ссылке
				</a>";
			$to = $form->getParam('mail');
			$subject = $form->getParam('trafic');
			$htmlHead = "<html>
				<head>
					<title>".$subject."</title>
					<meta charset='utf-8'>
				</head>
				<body>
					{$mmm}
				</body>
			</html>";
			$send = mail($to, $subject, $htmlHead, $headers); 
			if($send)
			{
				echo "Ваше сообщение успешно доставлено. В ближайшее время наш специалист с Вами свяжется.";
				return;
			}
			else
			{
				echo "Произошла ошибка, письмо не доставлено.";
				//echo $mmm;
				return;
			}
		}
		echo "Произошла ошибка, отсутствует соединение с БД.";
		//echo $mmm;
		return;
	}

	private function getMessage($order,$packs,$sumpack)
	{
		$packFORLIST = "";
		$str = "<div style='font-size: 20px;'>Тип трафика: 
			{$order->getParam('trafic')}
		</div>";
		
		$str .= "<div style='height: 1px;background: #ccc; margin: 15px 0;'></div>";
		
		$str .= "<div>Дата: 
			".date('d-m-Y',$order->date_in)."
		</div>";
		$str .= "<div>Отправлено со страницы: 
			<a target='_blank' href='{$order->page}'>
				{$order->page}
			</a>
		</div>";

		$str .= "<div style='height: 1px;background: #ccc; margin: 15px 0;'></div>";
		
		$str .= "<div style='font-size: 20px;'>Отправлено из формы 
			{$order->form}
		</div>";
		/*TESTDRIVE*/
		$test = $order->getParam('test');
		if(!empty($test)) : 
			$str .= "<div class=''>
				Интересуемый автомобиль: 
				{$order->car->model->getParam('name')}
				{$order->car->complect->getParam('name')}
				{$order->car->complect->motor->getParam('size')} л.
				{$order->car->complect->motor->getParam('power')} л.с.	
				{$order->car->complect->motor->getParam('transmission')} 
				{$order->car->complect->motor->getParam('privod')}
				VIN: {$order->car->getParam('vin')}	
			</div>";
			$str .= "<div class=''>
				Желаемая дата проведения тест-драйва: ".$order->getParam('client_date')."
			</div>";
			$str .= "<div class=''>
				Полная стоимость автомобиля: ".number_format($order->car->getTotalCarPrice(),0,'',' ')." руб.
			</div>";
			$str .= "<div class=''>
				Цена базы: ".number_format($order->car->complect->getParam('price'),0,'',' ')." руб.
			</div>";
			$str .= "<div class=''>
				Цена опций: ".number_format($packs,0,'',' ')." руб.
			</div>";
			$str .= "<div class=''>
				Цена доп. оборудования: ".number_format($order->car->getParam('dopprice'),0,'',' ')." руб.
			</div>";
			$str .= "<div class=''>
				Действующая скидка: ".number_format($order->car->getParam('sale'),0,'',' ')." руб.
			</div>";
		endif;

		/*МОДЕЛЬ*/
		$model=$order->getParam('model');
		if(!empty($model)) :
			$str .= "<div class=''>Интересуемая модель: ".$order->model->getParam('name')."</div>";
		endif;
		
		/*МАШИНА*/
		$car = $order->getParam('car'); $test = $order->getParam('test');
		if(!empty($car) && empty($test)) : 
			$str .= "<div class=''>
				Интересуемый автомобиль: 
				{$order->car->model->getParam('name')}
				{$order->car->complect->getParam('name')}
				{$order->car->complect->motor->getParam('size')} л.
				{$order->car->complect->motor->getParam('power')} л.с.	
				{$order->car->complect->motor->getParam('transmission')} 
				{$order->car->complect->motor->getParam('privod')} 
				VIN: {$order->car->getParam('vin')}	
			</div>
			<div class=''>
				Полная стоимость автомобиля: ".number_format($order->car->getCarPrice()-$order->car->sale,0,'',' ')." руб.
			</div>
			<div class=''>
				Цена базы: ".number_format($order->car->complect->getParam('price'),0,'',' ')." руб.
			</div>
			<div class=''>
				Цена опций: ".number_format($packs,0,'',' ')." руб.
			</div>
			<div class=''>
				Цена доп. оборудования: ".number_format($order->car->getParam('dopprice'),0,'',' ')." руб.
			</div>
			<div class=''>
				Действующая скидка: ".number_format($order->car->getParam('sale'),0,'',' ')." руб.
			</div>";
		endif;
		
		/*КОМПЛЕКТАЦИЯ*/
		if(!empty($order->complect)) : 
			$str .= "<div class=''>Клиент сконфигурировал автомобиль</div>
			<div class=''> 
				{$order->complect->model->getParam('name')}
				{$order->complect->getParam('name')}
				{$order->complect->motor->getParam('size')}
				({$order->complect->motor->getParam('power')} л.с.)	
				{$order->complect->motor->getParam('transmission')} 
				{$order->complect->motor->getParam('privod')}
				{$order->complect->getParam('code')}
				(".number_format($order->complect->getParam('price'),0,'',' ')." руб.)
			</div>
			<div class=''>Выбранный цвет: {$order->color}</div>
			";
			if((isset($packs)) && (is_array($packs))) :
				$str .= "<div class=''>Выбранные опции:</div>";
				foreach ($packs as $key => $value) : 
					$str .= "<div>
						{$value->getParam('name')} 
						".$value->getParam('code')."
						(".number_format($value->getParam('price'),0,'',' ')." руб.)	
					</div>";
					$packFORLIST .= $value->getParam('code')." (".number_format($value->getParam('price'),0,'',' ')." руб.), ";	
				endforeach;
				$str .= "<div class=''>
					Итоговая цена сконфигурированного автомобиля: 
					".number_format($order->complect->getParam('price')+$sumpack,0,'',' ')." руб.
				</div>";
			endif;
		endif;

		$service = $order->getParam('service');
		if(!empty($service) && empty($order->part)) : 
			$str .= "<div class=''>Название модели: {$order->service}</div>
				<div>Желаемая дата: {$order->getParam('client_date')}</div>";
		endif;

		if(!empty($order->part)) : 
			$str .= "<div class=''>Название модели: {$order->service}</div>
			<div class=''>Название запчасти: {$order->part}</div>";
		endif;

		$str .= "<div style='height: 1px;background: #ccc; margin: 15px 0;'></div>";
		$str .= "<div>Имя клиента: {$order->client_name}</div>";
		$str .= "<div>Телефон клиента: {$order->client_phone}</div>";
		$str .= "<div>Комментарий клиента: {$order->client_comment}</div>";
		
		if(!empty($order->complect) && (empty($order->model))) :
			$str .= "<h3>Для вставки в комментарий рабочего листа</h3>";
			$str .= $order->getParam('trafic').
				". Страница конфигуратора ".$order->complect->model->getParam('name').
				". Клиент готов обсудить покупку автомобиля ".$order->complect->model->getParam('name').' '.$order->complect->getParam('name').' '.
				' '.$order->complect->motor->getMotorForUser().' '.$order->complect->getParam('code').' '.
				' ('.number_format($order->complect->getParam('price'),0,' ','').' руб.) '.
				'. Опции: '.$packFORLIST.
				' цена автомобиля: '.number_format($order->complect->getParam('price')+$sumpack,0,'',' ').
				'. Комментарий: '.$order->client_comment.
				'. Необходимо оперативно связаться с клиентом.'
			;
		endif;
		if(!empty($order->model)) :
			$str .= "<h3>Для вставки в комментарий рабочего листа</h3>";
			$str .= $order->getParam('trafic').
				". Страница модели ".$order->model->getParam('name').
				". Клиент готов обсудить модель Renault ".$order->model->getParam('name').
				'. Комментарий: '.$order->client_comment.
				'. Необходимо оперативно связаться с клиентом'
			;
		endif;
		if(!empty($order->car) && (empty($order->test)))
		{
			$str .= "<h3>Для вставки в комментарий рабочего листа</h3>";
			$str .= $order->getParam('trafic').
				". Страница автомобиля в продаже Renault ".$order->car->model->getParam('name').' '.$order->car->complect->getParam('name').
				' '.$order->car->complect->motor->getParam('size').' л. '.
				' '.$order->car->complect->motor->getParam('power').' л.с. '.	
				' '.$order->car->complect->motor->getParam('transmission').' '.
				' '.$order->car->complect->motor->getParam('privod').' VIN: '.$order->car->getParam('vin').
				". Клиент готов обсудить покупку автомобиля. ".
				" Полная стоимость автомобиля: ".number_format($order->car->getCarPrice()-$order->car->sale,0,'',' ')." руб.".
				" Цена базы: ".number_format($order->car->complect->getParam('price'),0,'',' ')." руб.".
				" Цена опций: ".number_format($packs,0,'',' ')." руб.".
				" Цена доп. оборудования: ".number_format($order->car->getParam('dopprice'),0,'',' ')." руб.".
				" Действующая скидка: ".number_format($order->car->getParam('sale'),0,'',' ')." руб."
			;
		}
		if(!empty($order->test))
		{
			$str .= "<h3>Для вставки в комментарий рабочего листа</h2>";
			$str .= $order->getParam('trafic');
			$str .= 
				"Клиент хочет пройти тест-драйв на автомобиле Renault ".$order->car->model->getParam('name').' '.
				$order->car->complect->getParam('name').
				' '.$order->car->complect->motor->getParam('size').' л. '.
				' '.$order->car->complect->motor->getParam('power').' л.с. '.	
				' '.$order->car->complect->motor->getParam('transmission').' '.
				' '.$order->car->complect->motor->getParam('privod').' VIN: '.$order->car->getParam('vin').
				'. Желаемая дата: '.$order->client_date;
				;
		}
		return $str;
	}
}