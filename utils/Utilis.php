<?php
  class Utils {

    public static function curl_get($url, $params) {

      $url = $url . "?" . http_build_query($params);

      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      $response = curl_exec($curl);
      curl_close($curl);

      return json_decode($response);
    }

    public static function tg_request($method, $params) {

      $res = self::curl_get("https://api.tlgr.org/bot".Config::BOT_TOKEN."/$method", $params);

      if (!$res->ok) {
        print($res->error->error_msg. PHP_EOL);
        return false;
      }

      return $res->result;
    }
  }
?>
