<?php
require 'Config.php';
require 'utils/API.php';


$telegram=new Telegram(Config::BOT_TOKEN, Config::BOT_NAME);

while (true) {

	$upd = $telegram->getupdates(@$upd['update_id'] + 1);

  $update = (object)$upd;
  if (isset($update->message)) {

      // $message = $update->message;
      // var_dump($messsage);
      var_dump($update);
  }
}
?>
