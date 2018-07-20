<?php
$cars = \app\core\car_2_model::getCarForForm();
		
		$form = '<h2 class="text-center">Записаться на сервис</h2>';		

		$form .= '<input required="" type="text" name="name" placeholder="Ваше имя">';
				
		$form .= '<input required="" type="text" name="phone" placeholder="Ваш телефон">';

		$form .= '<input type="text" name="mail" placeholder="Адрес Вашей электронной почты (необязательно)" id="mail">';

		$form .= '<select required="" name="car" >';
			
			$form .= '<option required="" disabled="" selected="">выберите автомобиль</option>';
		
			foreach ($cars as $key => $car) : 
				$form .= '<option value="'.$car->id.'">'.$car->name.'</option>';
			endforeach;
			
			$form .= '<option value="none">Другой</option>';
		
		$form .= '</select>';

		$form .= '<input type="text" class="datepicker-here" required="" name="date" placeholder="Выберите дату" value=""/>';

		$form .= '<textarea required="" name="comment" placeholder="Комментарии"></textarea>';

		$form .= '<label>';
			$form .= '<div class="col-sm-2"><input type="checkbox" required="" name="valid"></div>';
			$form .= '<div class="cols-sm-10" style="padding-top: 9px; ">Даю согласие на обработку своих персональных данных</div>';
		$form .= '</label>';
		$form .= '<button type="button" id="submit-button" class="btn button-main-page">Жду звонка</button>';

		return $form;
			