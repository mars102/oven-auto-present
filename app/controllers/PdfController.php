<?php 
namespace app\controllers;
Class PdfController extends \app\core\Controller
{
	public function actionPrice($id="",$html="")
	{
		$model = new Car_model();
		$model->getRowById($id);

		$complect = new Complect_model();
		$sql = "SELECT name,price,id, id_motor FROM car_6_complect WHERE id_model = ?";
		$mas = array($id);
		$complect = $complect->getCustomSQL($sql,$mas);

		$motor = new Motor_model();
		$ttx = new Character_model();

		$option = new Option_model();

		require_once(ROOT.'/project/components/tcpdf/tcpdf.php');
		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

		$pdf->setPrintHeader(false); 
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(20, 25, 25);
		$pdf->SetTitle('Renault '.$model->getParam('name'));
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('dejavusans', '', 10);
		$pdf->AddPage();
		$pdf->SetXY(10, 10);
		$pdf->SetTextColor(200, 150, 0); 
		//$pdf->Cell(0, 0, 'Прайс на автомобили Renault '.$model->getParam('name'), 0, 0);
		$html .= "<h2>Прайс на автомобили Renault {$model->getParam('name')}</h2>";
		$pdf->writeHTML($html, true, 0, true, 0);

		$pdf->SetTextColor(0, 0, 0); 
		/*TTX*/
		$sql = "SELECT v.id, c.name, v.value, v.id_model, v.id_character 
				FROM car_8_character_value as v 
				JOIN car_8_character_list as c 
				on v.id_character = c.id 
				WHERE v.id_model = ? 
				ORDER BY c.id";
		$mas = array(($model->getParam('id')));
		$ttx_array = $ttx->getCustomSQL($sql, $mas);
		$ttxString="<ul>";
		$i=0;
		foreach ($ttx_array as $key => $param) {
			$i++;
			//if($i % 2 != 0) $ttxString .= "<tr>";

			$ttxString .= '<li>'.$i.") ".$param->getParam('name')." ".$param->getParam('value')." </li>";

			//if($i % 2 == 0) $ttxString .= "</tr>";
		}
		$ttxString .="</ul>";
		$pdf->SetFont('dejavusans', '', 8);
		$pdf->writeHTML($ttxString, true, 0, true, 0);
		

		
		foreach ($complect as $key => $comp) {
			$complectString = "";
			$motor->getRowById($comp->getParam('id_motor'));
			$complectString .= "<p style='text-align:right;'>Комплектация ".$comp->getParam('name').$motor->getFullMotorName()." от ".number_format($comp->getParam('price'),0,'',' ')." руб. </p>";
			$pdf->SetFont('dejavusans', '', 10);
			$pdf->writeHTML($complectString, true, 0, true, 0);
			$sql="	
				SELECT o.name, o.parent, v.id_complect
				FROM car_5_option_list as o

				JOIN car_5_option_value as v
				ON v.id_option = o.id

				JOIN car_6_complect as c
				on c.id = v.id_complect

				JOIN car_2_model as m
				ON c.id_model = m.id

				WHERE c.id = ?";
			$mas = array($comp->getParam('id'));
			$options = $option->getCustomSQL($sql,$mas);
			$optionString="";
			foreach ($options as $okey => $opt) {
				$optionString .= "- ".$opt->getParam('name')."<br/>";
			}
			$pdf->SetFont('DejaVuSansCondensed', '', 8);
			$pdf->writeHTML($optionString, true, 0, true, 0);
			
		}
		//$pdf->writeHTML($html, true, 0, true, 0);
		//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		
		

		ob_end_clean(); 
		$pdf->Output('doc.pdf', 'I');
	}

	public function actionPrintcar($car_id=NULL,$company_id="", $html = '<html><meta http-equiv="content-type" content="text/html; charset=utf-8" />')
	{	
		$arrayCompany = array();
		if(!empty($company_id))
		{
			$company = new \app\models\company();
			$company_id = explode("_",$company_id);
			foreach ($company_id as $key => $value) {
				if(!empty($value))
				{
					$company->getRowById($value);
					$arrayCompany[] = clone($company);
				}
			}
		}

		include_once ROOT . '/app/components/QR/qrlib.php';
		\QRcode::png("http://www.renault.oven-auto.ru/content/viewavacar/".$car_id, "qrcode.png", "L", 4, 4);

		$html .= "<style>
				* { 
		            font-family: arial !important;
		            font-size: 14px;
		            line-height: 14px;		    
		        }
		        html,@page{
		        	padding:0px 15px;
		            margin:35px;
		            color:#333;
		        }
				.grey{
					padding:15px;
					background: #000;
					color:#fff;
					font-size:20px;
				}	
				.black{
					padding:15px;
					color:#333;
					font-size:12px !important;
				}	
				.black b{
					margin-right:10px;
				}
				table{
					width:100%;
					border-collapse: collapse; 
            		border-spacing: 0;
				}
				tr{width:100%;}
				td{width:50%;}
				.page{
					padding:15px;
					padding-top:5px;
					padding-bottom:5px;
					margin:10px 0px;;
					background:#dfdfdf;
					font-weight: 100;
				}
				.text-area{
					padding: 0 15px;
				}
				.text-area td,.option{
					vertical-align:top;width:33%; font-size:9px;color:#666;line-height:5px;
				}
				.option{
					padding-bottom:7px;
				}
				.left{
					display:inline-block;width:50%;text-align:right;
				}
				.right{
					display:inline-block;width:50%;text-align:left;
				}
				.address{
					font-size:12px;
				}
		</style>";
		$html .= '<body style="">';

		if( (empty($car_id) ) || (!is_numeric($car_id)) ) header("Location: /myerror");
		$car = new \app\models\car_available();
		$car = $car->getAvaCar($car_id);
		//require_once(ROOT.'/app/components/PDF/dompdf/dompdf_config.inc.php');
		//require_once(ROOT.'/app/components/PDF/dompdf/include/functions.inc.php');
		//name
		$html .= "<div class='grey'>";
		$html.="<table>";
			$html.="<tr>";

					$html.='<td style="width:15%;text-align:left">';
						$html.="<img src='".ROOT."/images/logo.png' style='width:70px;'>";
					$html.="</td>";
					
					$html.='<td style="width:70%;text-align:left;">';
						$html .= '<div class="title">ООО "ФИРМА "ОВЕН-АВТО"</div>';
						$html.="<div class='address'> г. Сыктывкар, ул. Гаражная, 1</div>";
						$html .= '<div class="address">Телефон отдела продаж: 8 (8212) 288 588</div>';
						$html .= '<div class="address">Email: renault@oven-auto.ru</div>';
					$html.="</td>";

					$html.='<td style="width:15%;text-align:right;">';
						$html.="<img src='".ROOT."/qrcode.png' style='width:70px;'>";
					$html.="</td>";

			$html.="</tr>";
		$html.="</table>";
		$html.="</div>";

		
		$html.="<div style='color:#333;background:#fc3;font-size:12px;text-align:center;padding: 10px 0;text-transform:uppercase;font-weight:bold;'>";
			$html.="Коммерческое предложение на автомобиль";
		$html.="</div>";

		$html .= "<div class='black'>";
			$html.="<table>";
				$html.="<tr>";
						$html.='<td style="width:70%;">';
							
							$html .= '<div class="left">';
								$html.='<b>Модель:</b> ';
							$html.='</div>';
							$html.='<div class="right">';
								$html.=' Renault '.$car->model->getParam('name');
							$html.='</div>';

							$html.="<div></div>";

							$html .= '<div class="left">';
								$html.='<b>Комплектация:</b> ';
							$html.='</div>';
							$html.='<div class="right">';
								$html.=$car->complect->getParam('name').' '.$car->motor->getMotorForUser();
							$html.='</div>';

							$html.="<div></div>";

							$html .= '<div class="left">';
								$html.='<b>Цвет:</b> ';
							$html.='</div>';
							$html.='<div class="right">';
								$html.=$car->getColorCar()->name;
							$html.='</div>';

							$html.="<div></div>";

							$html .= '<div class="left">';
								$html.='<b>VIN-номер:</b> ';
							$html.='</div>';
							$html.='<div class="right">';
								$html.=$car->getParam('vin');
							$html.='</div>';

							//$html .= '<div style="text-align:left;margin:5px 0px;">Стоимость: '.number_format($car->getCarPrice()-$car->getParam('sale'),0,'',' ').' руб.</div>';
						$html.="</td>";

						$html.="<td style='width:30%;'>";
							$html.="<div style='border:3px solid #dcdcdc;'>";
							$html.='<img style="width:200px;border:0px solid #fff;background:'.$car->getColorCar()->web_code.';" src="'.'http://admin.oven-auto.ru'.$car->model->getParam('alpha').'">';
							$html.="</div>";
						$html.="</td>";

				$html.="</tr>";
			$html.="</table>";
		$html.="</div>";


		$html.="<div style='width:100%;font-size:9px;color:#666;padding: 0 15px;'>";
			$html.="* - представленная фотография автомобиля носит информативный характер. Внешний вид автомобиля может изменяться в зависимости от комплектации и отличаться от данной фотографии";
		$html.="</div>";


		/*вывод стоковой комплектации*/
		$html .= '<div class="page">
			<table>
				<tr>
					<td>Состав базовой комплектации</td>
					<td style="text-align:right;"> Цена в базе: '.number_format($car->complect->price,0,'',' ').' руб.</td>
				</tr>
			</table>
		</div>';

		$html .= "<div class='text-area'>";
			$html .= '<table>';
			$i=0;

			$step = round(count($car->complect->option)/3);

			$col1 = 0 + $step;
			$col2 = $col1 + $step;
			$col3 = count($car->complect->option);
				$html .= "<tr>";


					$html .= "<td >";
						for($i=0;$i<$col1+1;$i++){
							$html .= $car->complect->option[$i]->getParam('name').'<br/>';
						}
					$html .= "</td>";


					$html .= "<td >";
						for($i=$col1+1;$i<$col2+2;$i++){
							$html .= $car->complect->option[$i]->getParam('name').'<br/>';
						}
					$html .= "</td>";


					$html .= "<td>";
						for($i=$col2+2;$i<$col3-1;$i++){
							$html .= $car->complect->option[$i]->getParam('name').'<br/>';
						}
					$html .= "</td>";


				$html .= "</tr>";
			$html .= '</table>';
		$html .= "</div>";
		/*конец вывода стоковой комплектации*/
		
		
		/*вывод установленных пакетов опций*/	
		if(is_array($car->packs)) :
			
			
			$html .= '<div class="page">
				<table>
					<tr>
						<td>Опционное оборудование</td>
						<td style="text-align:right;"> Цена опций: '.number_format($car->getPackPrice(),0,'',' ').' руб.</td>
					</tr>
				</table>
			</div>';

			$html.="<div class='text-area'>";
			foreach ($car->packs as $obj) {
				if(!empty($obj->name))
					$name = $obj->name."<br/>".'<span style="font-size:8px;line-height:8px;">'.$obj->getParam('option_list').'</span>';
				else
					$name = $obj->getParam('option_list');
				$money = \app\core\Html::money($obj->getParam('price'));
				$html .= "
				
					<div style='display:inline-block;width:33%;' class='option'>".$obj->code.' '.$name."</div>
				";
			}
			$html.="</div>";
		endif;
		/*конец вывода установленны опций*/

		/*вывод тюнинга авто*/
		if(!empty($car->install)) :
			$html.="<div>";
				$html .= '<div class="page">
					<table>
						<tr>
							<td>Дополнительное оборудование</td>
							<td style="text-align:right;"> Цена в допов: '.number_format($car->dopprice,0,'',' ').' руб.</td>
						</tr>
					</table>
				</div>';
				$html.="<div class='text-area'>";
				$car->install = trim($car->install,',');
				foreach (explode(',', $car->getParam('install')) as $key=>$value) {
					if($value!="") :
						$dops = new \app\models\dop_ob();
						$dops->getRowById($value);
						if($key%3==0) 
							$html.="<div></div>";
						$html .= '<div style="display:inline-block;width: 33%;" class="option">'.$dops->name.'</div>';
					endif;
				}
				$html.="</div>";
			$html.="</div>";
		endif;
		/*конец вывода тюнинга*/

		
		/*вывод итоговой цены авто без выгод и кредитов*/
		$total = \app\core\Html::money($car->getCarPrice());
		$html .= "
		<div class='page' style='background:#fc3;'>
			<table style='padding:0px;border-collapse: collapse; '>
				<tr>
					<td style='font-size:15px;'>Итого коммерческое предложение:</td>
					<td style='font-size:15px;text-align:right'>{$total} руб.</td>
				</tr>
			</table>
		</div>";
		/*конец вывода итоговой цены автомобиля*/

		//разрыв страницы
		$html.= '<div style="page-break-before: always;"></div>';

		/*начало вывода кредитов на данный авто*/
		$kredit = new \app\models\kredit();
		$kredit = $kredit->getKreditByIdCar($car->model->id);
		if(!empty($kredit))
		:
			$html.="<h2 style='text-align:center;'>Кредитные программы</h2>";
			foreach ($kredit as $key => $value) 
			:
				$html .= "<div style='border:1px dashed #a00;margin-bottom:20px;padding-bottom:15px;'>";
					$html.="<div class='page' style='margin-top:0px;'>".$value->name."</div>";
					$html.= "<table><tr>";
						$html.="<td style='width:40%;text-align:center;'><img style='width:250px;' src='http://admin.oven-auto.ru".$value->banner."' style='width:100px;'></td>";
						$html.="<td style='width:60%;' class='text-area' >";
							$html.="<div style='color:#666;font-size:12px;' >".$value->disklamer."</div>";
						$html.="</td>";
					$html.="</tr></table>";
				$html.="</div>";
			endforeach;
		endif;
		/*конец вывода кредитов на данный авто*/

		//разрыв страницы
		$html.= '<div style="page-break-before: always;"></div>';

		/*начало вывода выбранных выгод*/
		if(!empty($arrayCompany)) :
		$html.="<h2 style='text-align:center;'>Выбранные выгоды</h2>";
		foreach ($arrayCompany as $key => $value) {

			$value->replace($car);
			$html .= "<div style='border:1px dashed #a00;margin-bottom:20px;padding-bottom:15px;'>";
				$html.="<div class='page' style='margin-top:0px;'>".$value->title."</div>";

				$html.= "<table><tr>";
					$html.="<td style='width:40%;text-align:center;'><img src='".ROOT."/images/logo.png' style='width:100px;'></td>";
					$html.="<td style='width:60%;' class='text-area' >";
					$html.="<div style='margin-bottom:20px;' >".$value->ofer."</div>";
					$html.="<div style='color:#666;font-size:12px;' >".$value->text."</div>";
					$html.="</td>";
				$html.="</tr></table>";
			$html.="</div>";
		}
		endif;
		/*конец вывода выбранных выгод*/

		$html .= '</body></html>';

		//$html = ob_get_clean();
		
		include_once ROOT . '/app/components/PDF/dompdf/autoload.inc.php';

		$dompdf = new \Dompdf\Dompdf();

		//даём возможность читать внешние ссылки (для отображения картинок извне)
		//$dompdf->set_option('defaultFont', 'dejavu sans');
		$dompdf->set_option('isRemoteEnabled', true);

		$dompdf->loadHtml($html, 'UTF-8');
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream('лолкекчебурек.pdf',array('Attachment'=>0));
		// Вывод файла в браузер:
		//$dompdf->stream('schet-10'); 

		// Или сохранение на сервере:
		//$pdf = $dompdf->output(); 
		//file_put_contents(ROOT . '/schet-10.pdf', $pdf); 
		/*$dompdf->load_html($html);
		//$dompdf->load_html($html)
		$dompdf->render();
		//Html::prA($dompdf);
		$dompdf->stream('x.pdf'); // Выводим результат (скачивание)*/

	}

	public function actionQrcode()
	{
		include_once ROOT . '/app/components/QR/qrlib.php';
		\QRcode::png("http://www.ruseller.com", "qrcode.png", "L", 4, 4);
	}
}