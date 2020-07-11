<?php

class Telegram {

  public $token;
  public function __construct($token)
  {
    $this->token = $token;
  }

  private function curl_get($url, $params) {

    $url = $url . "?" . http_build_query($params);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response);
  }

  private function api($method, $params = []) {
      $res = self::curl_get("https://api.tlgr.org/bot".$this->token ."/". $method, $params);

      return $res->result;
  }

  public function sendMessage($params = []) {
    return $this->api('sendMessage', $params);
  }

  public function getUpdates($params = []) {
    return $this->api('getUpdates', $params);
  }

}
?>
