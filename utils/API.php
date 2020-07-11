<?php

class Telegram {
	public function __construct($token, $name)
	{
		set_time_limit(0);
		ignore_user_abort(0);
		ini_set('max_execution_time', 0); //exec time
		ini_set('memory_limit', '999999999M'); //memmory limit
		date_default_timezone_set('Asia/Jakarta'); // timezone
		define('BOT_TOKEN', $token); // Token
		define('USERNAME', 'rocket'); // author Username
		define('BOTNAME', $name); // alias bot Name
	}

	public function api($method, $datas = []) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.BOT_TOKEN.'/'.$method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$res = curl_exec($ch);
		curl_close($ch);

		return json_decode($res, 1);
		unset($ch,$method,$datas,$res);
	}

	public function getUpdates($up_id) {
		$get=$this->api('getupdates', ['offset' => $up_id]);

		return end($get['result']);
		unset($get,$up_id);
	}

}
?>
