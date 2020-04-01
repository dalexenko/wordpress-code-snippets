<?php

function writeToLog($data, $title = '') {
 $log = "\n------------------------\n";
 $log .= date("Y.m.d G:i:s") . "\n";
 $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
 $log .= print_r($data, 1);
 $log .= "\n------------------------\n";
 file_put_contents(getcwd() . '/hook.log', $log, FILE_APPEND);
 return true;
}

function adopt($text) {
    return '=?UTF-8?B?'.Base64_encode($text).'?=';
}

function sendMessageToTelegram($chat_id, $text, $token) {
	$url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id;
        $url = $url . "&parse_mode=html&text=" . urlencode($text);
	$ch = curl_init();
	$optArray = array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true
	);
	curl_setopt_array($ch, $optArray);
	$result = curl_exec($ch);
	curl_close($ch);
	return $url;
}
if(empty($_POST['phone']) or strlen($_POST['phone'])<17 or strlen($_POST['phone'])>17) {
        header('HTTP/1.1 200 OK');
		header('Location: http://'.$_SERVER['SERVER_NAME']);
    } else {
		$phone = trim($_POST['phone']);
                $name = trim($_POST['name']);
                $email = trim($_POST['email']);
                $message = $_POST['message'];
		$to = "test@gmail.com";
		$subject = "Обратный звонок";
		$text =  "Имя: ".$name."\nКонтактный телефон: ". $phone."\nКонтактный email: ". $$email."\n___________________\n Сообщение: ".$message;
                
		$headers = "MIME-Version: 1.0" . PHP_EOL .
			"Content-Type: text/html; charset=utf-8" . PHP_EOL .
			'From: test site' . PHP_EOL .
			'Reply-To: '.$to.'' . PHP_EOL;
			$sending = mail($to, $subject, $text, $headers);

		// телеграмм

		$token = "";
		$chat_id = "";
		//$chat_id_copy = "356819341";

		 //sendMessageToTelegram($chat_id, $text, $token);
		 //sendMessageToTelegram($chat_id_copy, $text, $token);
		 
		// bitrix24 lead

		$queryUrl = 'https://test.bitrix24.ua/url/crm.lead.add.json';
		// формируем параметры для создания лида в переменной $queryData
		$queryData = http_build_query(array(
				'fields' => array(
				'TITLE' => $subject,
				'NAME' => $name,
				'PHONE' => array (array('VALUE' => $phone, 'VALUE_TYPE' => 'WORK')),
                                'EMAIL' => array (array("VALUE" => $email, "VALUE_TYPE" => "WORK")),
				'COMMENTS' => $message,
				'params' => array('REGISTER_SONET_EVENT' => 'Y')
				)));

		// обращаемся к Битрикс24 при помощи функции curl_exec
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_POST => 1,
		  CURLOPT_HEADER => 0,
		  CURLOPT_RETURNTRANSFER => 1,
		  CURLOPT_URL => $queryUrl,
		  CURLOPT_POSTFIELDS => $queryData,
		));
		$result = curl_exec($curl);
		curl_close($curl);
		$result = json_decode($result, 1);
                writeToLog($result, 'webform result');
		if (array_key_exists('error', $result)) echo "Ошибка при сохранении лида: ".$result['error_description']."<br/>";
                 $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
	header('Location: http://'.$_SERVER['SERVER_NAME'].'/url/');
	} 
?> 

