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

	public function actionPrintcar($car_id=NULL,$html = '<html><meta http-equiv="content-type" content="text/html; charset=utf-8" />')
	{	
		$html .= "<style>
				* { 
		            font-family: arial !important;
		            font-size: 14px;
		            line-height: 14px;
		        }
				.grey{
					padding:15px;
					background: #000;
					color:#fff;
					font-size:20px;
				}	
				.black{
					padding:15px;
					background: #ddd;
					color:#333;
					font-size:20px;
				}	
				table{
					width:100%;
					border-collapse: collapse; 
            		border-spacing: 0;
				}
				tr{width:100%;}
				td{width:50%;}
				.page{
					padding-top:15px;
					padding-bottom:5px;
					margin-bottom:5px;
					border-bottom:1px solid #000;
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
			$html .= '<div class="title">ООО "ФИРМА "ОВЕН-АВТО"</div>';
			$html.="<div class='title'> г. Сыктывкар, ул. Гаражная, 1</div>";
			$html .= '<div class="title">Телефон отдела продаж: 8 (8212) 288 588</div>';
		$html.="</div>";

		$html .= "<div class='black'>";
			$html .= "<table>";
				$html.="<tr>";
					$html .= '<td>';
						$html .= '<div style="font-weight:bold;text-align:left;margin:5px;">Модель: Renault '.$car->model->getParam('name').'</div>';
						$html .= '<div style="text-align:left;margin:5px;">VIN-номер: '.$car->getParam('vin').'</div>';
						$html .= '<div style="text-align:left;margin:5px;">Комплектация: '.$car->complect->getParam('name').' '.$car->motor->getMotorForUser().'</div>';
						$html .= '<div style="text-align:left;margin:5px;">Стоимость: '.number_format($car->getCarPrice()-$car->getParam('sale'),0,'',' ').' руб.</div>';
					$html .= '</td>';

					$html .= '<td style="text-align:right;">
						<img style="width:200px;border:1px solid #000;background:'.$car->getColorCar()->web_code.';" src="'.ROOT.$car->model->getParam('alpha').'">';
					$html .= "</td>";
				$html.="</tr>";
			$html .= "</table>";
		$html.="</div>";

		$html .= '<div class="page">
			<table>
				<tr>
					<td>Состав базовой комплектации</td>
					<td style="text-align:right;"> Цена в базе: '.number_format($car->complect->price,0,'',' ').' руб.</td>
				</tr>
			</table>
		</div>';
		$html .= '<table>';
		$i=0;

		$step = round(count($car->complect->option)/3);

		$col1 = 0 + $step;
		$col2 = $col1 + $step;
		$col3 = count($car->complect->option);
			$html .= "<tr>";


				$html .= "<td  style='vertical-align:top; width:33%; font-size:10px;'>";
					for($i=0;$i<$col1+1;$i++){
						$html .= ($i+1).') '.$car->complect->option[$i]->getParam('name').'<br/>';
					}
				$html .= "</td>";


				$html .= "<td style='vertical-align:top;width:33%; font-size:10px;'>";
					for($i=$col1+1;$i<$col2+2;$i++){
						$html .= ($i+1).') '.$car->complect->option[$i]->getParam('name').'<br/>';
					}
				$html .= "</td>";


				$html .= "<td  style='vertical-align:top;width:33%; font-size:10px;'>";
					for($i=$col2+2;$i<$col3-1;$i++){
						$html .= ($i+1).') '.$car->complect->option[$i]->getParam('name').'<br/>';
					}
				$html .= "</td>";


			$html .= "</tr>";
		$html .= '</table>';

		
		
		
		if(is_array($car->packs)) :
			
			$html .= '<div>';
			$html .= '<div class="page">
				<table>
					<tr>
						<td>Опционное оборудование</td>
						<td style="text-align:right;"> Цена опций: '.number_format($car->getPackPrice(),0,'',' ').' руб.</td>
					</tr>
				</table>
			</div>';
			foreach ($car->packs as $obj) {
				if(!empty($obj->name))
					$name = $obj->name."<br/>".'<span style="font-size:10px;">'.$obj->getParam('option_list').'</span>';
				else
					$name = $obj->getParam('option_list');
				$money = \app\core\Html::money($obj->getParam('price'));
				$html .= "
				<div>
					<div style='display:inline-block;width: 10%;vertical-align:top;'>".$obj->code."</div>
					<div style='display:inline-block;width: 65%;vertical-align:top;'>".$name."</div>
					<div style='display:inline-block;width: 25%;vertical-align:top;text-align:right;'>".number_format($obj->price,0,'',' ')." руб.</div>
				</div>";
			}
			$html .= '</div>';
		endif;
		

		
		if(!empty($car->install)) :
			$html .= '<div class="page">
				<table>
					<tr>
						<td>Дополнительное оборудование</td>
						<td style="text-align:right;"> Цена в допов: '.number_format($car->dopprice,0,'',' ').' руб.</td>
					</tr>
				</table>
			</div>';
			$html .= '<table style="width:100%;">';
				foreach (explode(PHP_EOL, $car->getParam('install')) as $value) {
					if($value!="") :
						$html.="<tr>";
							$html .= '<td style="font-size:12px;border-bottom:1px solid #ddd;">'.$value.'</td>';
						$html.="</tr>";
					endif;
				}
				
			$html .= '</table>';
		endif;

		//\app\core\Html::prA($car);

		$total = \app\core\Html::money($car->getCarPrice());
		$html .= "
		<div style='margin-top:80px;'>
			<table style='padding:0px;border-collapse: collapse; '>
				<tr>
					<td style='font-size:50px;'><b><i style='font-size:50px;'>Итого:</i></b> {$total} руб.</td>
				</tr>
			</table>
		</div>
		";


		


		//echo $car->current_complect->getParam('name');
		//Html::prA($car);


		$html .= '</body></html>';
		
		include_once ROOT . '/app/components/PDF/dompdf/autoload.inc.php';
		$dompdf = new \Dompdf\Dompdf();
		$dompdf->loadHtml($html, 'UTF-8');
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		// Вывод файла в браузер:
		$dompdf->stream('schet-10'); 

		// Или сохранение на сервере:
		$pdf = $dompdf->output(); 
		file_put_contents(ROOT . '/schet-10.pdf', $pdf); 
		/*$dompdf->load_html($html);
		//$dompdf->load_html($html)
		$dompdf->render();
		//Html::prA($dompdf);
		$dompdf->stream('x.pdf'); // Выводим результат (скачивание)*/
	}
}