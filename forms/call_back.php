<?php
return '
	<h2 class="text-center">Заказать звонок</h2>
	<input type="text" name="name" placeholder="Как к Вам обращаться?" id="name" required="true">
	<input type="text" name="phone" placeholder="Ваш телефон" id="phone" required="true">
	<input type="text" name="mail" placeholder="Адрес Вашей электронной почты (необязательно)" id="mail">
	<textarea required="true" name="comment" placeholder="Ваш вопрос"></textarea>
	<label>
		<div class="col-sm-2 text-rigth"><input required="true" type="checkbox" name="valid"></div>
		<div class="cols-sm-10 text-center" style="padding-top: 9px; ">Даю согласие на обработку своих персональных данных</div>
	</label>
	<button type="button" id="submit-button" class="btn button-main-page">Отправить запрос</button>
	';
