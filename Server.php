<?php
require 'Config.php';
require 'utils/API.php';

  $telegram = new Telegram(Config::BOT_TOKEN);

  while (true) {
    sleep(2);

    $updates = $telegram->getUpdates(); // Получаем обновление, методом getUpdates
    foreach ($updates as $update){
      if (isset($update->message->text)) { // Проверяем Update, на наличие текста

        $text = $update->message->text; // Переменная с текстом сообщения
        $chat_id = $update->message->chat->id; // Чат ID пользователя
        $first_name = $update->message->chat->first_name; //Имя пользователя

        print_r($chat_id);
        if ($text == '/start') { // Если пользователь подключился в первый раз, ему поступит приветствие
          $telegram->sendMessage($chat_id, 'Привет'. ' ' . $first_name . '!');
        } else {
          $telegram->sendMessage($chat_id, $first_name . '! Как дела?' );
        }

      }
    }

  }
?>
