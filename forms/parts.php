<?php
$cars = \app\core\car_2_model::getCarForForm();
		
		$form = '<h2 class="text-center">Заказать запсные части</h2>';		

		$form .= '<input type="text" required="" name="name" placeholder="Ваше имя">';

		$form .= '<input type="text" required="" name="phone" placeholder="Ваш телефон">';

		$form .= '<select required="" name="car" >';
			
			$form .= '<option disabled="" selected="">выберите автомобиль</option>';
		
			foreach ($cars as $key => $car) : 
				$form .= '<option value="'.$car->id.'">'.$car->name.'</option>';
			endforeach;
			
			$form .= '<option value="none">Другой</option>';
		
		$form .= '</select>';

		$form .= '<input required="" type="text" name="part" placeholder="Название запчасти">';

		$form .= '<textarea required="" name="comment" placeholder="Комментарии"></textarea>';

		$form .= '<label>';
			$form .= '<div class="col-sm-2"><input type="checkbox" required=""  name="valid"></div>';
			$form .= '<div class="cols-sm-10" style="padding-top: 9px; ">Даю согласие на обработку своих персональных данных</div>';
		$form .= '</label>';
		$form .= '<button type="button" id="submit-button" class="btn button-main-page">Жду звонка</button>';

		return $form;
			