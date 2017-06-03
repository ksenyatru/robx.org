<?php include("main/tallanto.php"); ?>

<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {


	$google_recaptcha_secret = getenv('RECAPTCHA');
	$api_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$google_recaptcha_secret."&response=".$_POST['g-recaptcha-response']);

	$api_response = json_decode($api_response, true);


	if (!empty($_POST && $api_response["success"] === true)) {
		$url = 'https://docs.google.com/forms/d/e/1FAIpQLSc72sii9QQ7n0RB_2GKgc_al5K80wzEQGRV124iXv4ErP0HEA/formResponse';

		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query(array(
	                        	'entry_598421956' => $_POST['name'],
					'entry_706895143' => $_POST['phone'],
	                        	'entry_30508999' => $_POST['date'],
					'entry_1552661339' => $_POST['address'],
					'entry_2103816587' => date_diff(date_create_from_format('Y-n-j', $_POST['birthday']), date_create())->y . '',
					'entry.800485612' => $_POST['email']
				))
			)
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) {
			var_dump(http_response_code(500));
		}

		$data = array(
			'first_name' => $_POST['name'],
			'phone_mobile' => $_POST['phone'],
			'description' => $_POST['date'],
			'email1' => $_POST['email'],
			'type_client_c' => 'ЛИД',
			'utm_medium' => $_POST['medium'],
			'utm_content' => $_POST['content'],
			'utm_term' => $_POST['term'],
			'utm_source' => $_POST['source'],
			'utm_campaign' => $_POST['campaign'],
			'birthdate' => $_POST['birthday']
		);

		if(array_key_exists('address', $_POST) && $_POST['address'] !== '') {
			$data['filial'] = array($_POST['address']);
		}

		$resultAccount = senderToTallanto('Contact',$data);
		 echo "<script>console.log('POST', " .  $api_response["success"]  .   " );</script>";
	}
	else{
		echo "<script>console.log( 'failure' );</script>";
	}
}

?>


<a name = "register"></a>
<div class = "register">
	<div class = "content">
		<div class = "intro">
			<div>
				<img src = "icons/arrows.png">
				<div>
					Запишите ребенка
					на первое бесплатное занятие в Кружке Робототехники!
				</div>
			</div>
			<div class = "information">
				<div class = "next">
					Ближайшие занятия:
					<div>
						5 - 11 Июня
					</div>
				</div>
				<div class = "free">

				</div>
				<div class = "rest">
					До занятия осталось:
					<div>
						-
					</div>
				</div>
			</div>
		</div>
		<div class = "form">
			<form action="http://robx.org/" target="_self" method='post'>
				<div class = 'entry required'>
					<input name = 'name' type = 'text' placeholder="ФИО Родителя" required>
				</div>
				<div class = 'entry date'>
					<input name = 'birthday' type = 'text' placeholder="Дата рождения ребенка">
				</div>
				<div class = 'entry required mobile-phone'>
					<input name = 'phone' type = 'text'placeholder="Контактный телефон" pattern='\+7 \([0-9]{3}\) [0-9]{7}' required>
				</div>
				<div class = 'entry required'>
					<input name='email' type='email' placeholder="Email адрес" required>
				</div>
				<div class = 'entry select'>
					<select name='address'>
						<option disabled="" selected="">Адрес класса</option>
						<option value="Пр. Медиков, д. 5">Пр. Медиков, д. 5 (ст. м. Петроградская)</option>
						<option value="Гражданский пр., д. 111">Гражданский пр., д. 111 (ст. м. Гражданский проспект)</option>
						<option value="Ленинский пр., д. 151">Ленинский пр., д. 151 (ст. м. Московская) </option>
					</select>
				</div>
        <div class="g-recaptcha" data-sitekey="6LdXMB0UAAAAAMM0MEAPJwJsCKYyqTUJnUT_aFuE"></div>
				<input type='submit' name='submit' class='submit'  value = 'записаться' disabled>
			</form>
			<div class = 'notification'>
				Спасибо, что оставили заявку, с Вами свяжется наш сотрудник накануне занятия для подтверждения времени.
			</div>
		</div>
	</div>
	<div class = "footnote">
		<div>
			*Мы уважаем вашу конфиденциальность, введенная в форму информация не будет передаваться третьим лицам.
		</div>
		<div>
			Заполняя настоящую форму, в соответствии с требованиями статьи 9 Федерального закона от 27.07.2006 No 152-ФЗ «О персональных данных»,
			Вы подтверждаете свое согласие на обработку вносимых в форму персональных данных, лицом оказывающим услуги на основании данной формы
		</div>
	</div>
</div>
