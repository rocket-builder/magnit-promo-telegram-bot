<?php
require 'Config.php';
require 'utils/API.php';


$telegram=new Telegram(Config::BOT_TOKEN, Config::BOT_NAME);

while (true) {

	$update = $telegram->getupdates(@$update['update_id'] + 1);

  if (isset($update['message'])) {

      switch ($update['message']['text']) {
        case '/start':

          $telegram->api('sendMessage', [
            'chat_id' => $update['message']['chat']['id'],
            'text' => 'Привет'
          ]);
          break;

        default:

          $telegram->api('sendMessage', [
            'chat_id' => $update['message']['chat']['id'],
            'text' => 'Как дела, это новый кадилак'
          ]);
          break;
      }

  }
}
?>
