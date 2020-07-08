<?php
include('vendor/autoload.php'); //Подключаем библиотеку
  use Telegram\Bot\Api;
  require 'Config.php';

  $file = file_get_contents('https://api.tlgr.org/bot'.Config::BOT_TOKEN.'/getUpdates');

  $updates = json_decode($file)->result;
  foreach ($updates as $update) {

    $chat_id = $update->message->chat->id;

    $messsage = file_get_contents('https://api.tlgr.org/bot'.Config::BOT_TOKEN.'/sendMessage?chat_id='.$chat_id.'&text='.'hello');
    var_dump($messsage);
  }
  var_dump($updates);
?>
