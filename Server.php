<?php
require 'Config.php';
require 'utils/API.php';

  $telegram = new Telegram(Config::BOT_TOKEN);

  $next_id = $telegram->getUpdates()[count($telegram->getUpdates()) - 1]->update_id + 1;

  while(true) {

    sleep(2);

    $updates = $telegram->getUpdates(['offset' => $next_id]);
    if(count($updates) > 0) {

        var_dump($updates);

        $next_id++;
    }
  }
?>
