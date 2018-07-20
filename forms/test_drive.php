<?php
$cars = \app\core\car_available();
$cars = $cars->getTestDriveCars();
	
		$form = '<h2 class="text-center">Записаться на тест-драйв</h2>';		

		$form .= '<input required="" type="text" name="name" placeholder="Как к Вам обращаться?">';
				
		$form .= '<input required="" type="text" name="phone" placeholder="Ваш телефон">';

		$form .= '<input type="text" name="mail" placeholder="Адрес Вашей электронной почты (необязательно)" id="mail">';

		$form .= '<select required="" name="test_drive" >';
			
			$form .= '<option disabled="" selected="">Автомобиль для тест-драйва</option>';
			if(is_array($cars)) :
			foreach ($cars as $key => $car) : 
				$form .= '<option value="'.$car['id'].'">'.$car['mod_name'].' '.$car['com_name'].' '.$car['mot_size'].' '.$car['mot_power'].' л.с. '.$car['mot_valve'].' кл. '.$car['mot_transmission'].'</option>';
			endforeach;
			endif;
			
		
		$form .= '</select>';

		$form .= '<input type="text" class="datepicker-here" required="" name="date" placeholder="Выберите дату" value=""/>';

		$form .= '<textarea required="" name="comment" placeholder="Ваш вопрос"></textarea>';

		$form .= '<label>';
			$form .= '<div class="col-sm-2"><input type="checkbox" required="" name="valid"></div>';
			$form .= '<div class="cols-sm-10" style="padding-top: 9px; ">Даю согласие на обработку своих персональных данных</div>';
		$form .= '</label>';
		$form .= '<button type="button" id="submit-button" class="btn button-main-page">Записаться</button>';

		return $form;
			