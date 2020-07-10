<?php
require 'Config.php';
require 'utils/API.php';

  // $file = file_get_contents('https://api.tlgr.org/bot'.Config::BOT_TOKEN.'/getUpdates');
  //
  // $updates = json_decode($file)->result;
  // foreach ($updates as $update) {
  //
  //   $chat_id = $update->message->chat->id;
  //
  //   $messsage = file_get_contents('https://api.tlgr.org/bot'.Config::BOT_TOKEN.'/sendMessage?chat_id='.$chat_id.'&text='.'hello');
  //   var_dump($messsage);
  // }
  // var_dump($updates);

  $telegram = new Telegram(Config::BOT_TOKEN);

  while (true) {
    if(!is_null($updates)) {

        $updates = array_diff($updates, $telegram->getUpdates(1));
    } else {
      $updates = $telegram->getUpdates(1);
    }
    // foreach ($updates as $update) {
    //
    //   //$messsage = $telegram->sendMessage($update->message->chat->id, "hello from telegram api");
    //   //var_dump($messsage);
    // }

    var_dump($updates);
  }
?>
