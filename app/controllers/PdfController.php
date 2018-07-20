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
				table{width:100%;padding:0px;margin:0px;padding-left:10px;padding-right:10px;}
				tr{padding:0px;}
				td{padding:0px; font-size:10px;}	
				.page{padding-left:10px;padding-right:10px;margin:0px;font-size:14px;background:#eee;}			
		</style>";
		$html .= '<body style="">';

		if( (empty($car_id) ) || (!is_numeric($car_id)) ) header("Location: /myerror");
		$car = new \app\models\car_available();
		$car = $car->getAvaCar($car_id);
		require_once(ROOT.'/app/components/PDF/dompdf/dompdf_config.inc.php');
		require_once(ROOT.'/app/components/PDF/dompdf/include/functions.inc.php');
		//name
		
		$html .= '<h3 style="text-align:center;">Отдел продаж: 288-588</h3>';
		$html .= '<div style="width:49%; display:inline-block;">';
			$html .= '<h4 style="text-align:left;margin:5px;"> Renault '.$car->model->getParam('name').'</h4>';
			$html .= '<h4 style="text-align:left;margin:5px;"> '.$car->getParam('vin').'</h4>';
			$html .= '<h4 style="text-align:left;margin:5px;">'.$car->complect->getParam('name').' '.$car->motor->getMotorForUser().'</h4>';
			$html .= '<h3 style="text-align:left;margin:5px;">'.number_format($car->getCarPrice()-$car->getParam('sale'),0,'',' ').' руб.</h3>';
		$html .= '</div>';

		$html .= '<div style="text-align:center; display:inline-block;width:49%;"><img style="background:'.$car->getColorCar()->web_code.';width:200px;" src="'.ROOT.$car->model->getParam('alpha').'"></div>';

		$html .= '<h4 class="page">Состав комплектации</h4>';
		$html .= '<table>';
		$i=0;
		foreach ($car->complect->option as $key => $obj) {
			$i++;
			$bgcolor="";
			if($key%2==0) $bgcolor = "";
			
			if($key==0) $html .= '<tr>';
			if( ($key%2 == 0) && ($key != 0))$html .= '</tr><tr>';
			$html .= '<td >'.$obj->getParam('name').'</td>';
		}
		$html .= '</table>';

		$html .= '<h4 class="page">Дополнительные опции и аксессуары</h4>';
		
		$html .= '<table>';
		foreach ($car->packs as $obj) {
			if(!empty($obj->name))
				$name = $obj->name."<br/>".$obj->getParam('option_list');
			else
				$name = $obj->getParam('option_list');
			$money = \app\core\Html::money($obj->getParam('price'));
			$html .= "<tr>
				<td>{$name}</td>
				<td>{$money} руб.</td>
			</tr>";
		}
		$html .= '</table>';

		$total = \app\core\Html::money($car->getCarPrice());
		$html .= "
			<table style='padding:0px;border-collapse: collapse; '>
				<tr>
					<td><h4 class='page'>Итого коммерческое предложение</h4></td>
					<td><h4 class='page'>{$total} руб.</h4></td>
				</tr>
			</table>
		";

		/*$html .= '<table style="width:100%;">';
			$html .= '<tr style="">';
				$html .= '<td collspan="2" style="font-size:12px;vertical-align:top;width:100%;">';
					$html .= '<h4 style="margin:0px;">Технические характеристики</h4>';
				$html .= "</td>";
			$html .= "</tr>";
			
				foreach ($car->current_ttx as $obj) {
					$html .= "<tr>";
						$html .= '
								<td style="font-size:12px;width:50%;border-bottom:1px solid #ddd;">'.
									$obj->getParam('name').'
								</td>
								<td style="font-size:12px;width:50%;border-bottom:1px solid #ddd;">'.
									$obj->getParam('value').'
								</td>';
					$html .= '</tr>';
				
				}
			
		$html .= '</table>';*/

		$install = $car->getParam('install');
		if(!empty($install)) :
			$html .= '<table style="width:100%;">';
				$html .= '<tr style="">';
					$html .= '<td style="font-size:12px; vertical-align:top;width:100%;">';
						$html .= '<h4 style="margin:0px;">Дополнительное оборудование</h4>';
					$html .= "</td>";
				$html .= "</tr>";
				foreach (explode(PHP_EOL, $car->getParam('install')) as $value) {
					if($value!="") :
						$html.="<tr>";
							$html .= '<td style="font-size:12px;border-bottom:1px solid #ddd;">'.$value.'</td>';
						$html.="</tr>";
					endif;
				}
				
			$html .= '</table>';
		endif;


		//echo $car->current_complect->getParam('name');
		//Html::prA($car);


		$html .= '</body></html>';
		
		$dompdf = new \DOMPDF();

		$dompdf->load_html($html);
		//$dompdf->load_html($html)
		$dompdf->render();
		//Html::prA($dompdf);
		$dompdf->stream('x.pdf'); // Выводим результат (скачивание)*/
	}
}