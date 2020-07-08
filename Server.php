<?php
include('vendor/autoload.php'); //Подключаем библиотеку
  use Telegram\Bot\Api;
  require 'Config.php';

  $telegram = new Api(Config::BOT_TOKEN); //Устанавливаем токен, полученный у BotFather
  //$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя

  while (true) {
    sleep(2);
    $updates = $telegram->getUpdates(); // Получаем обновление, методом getUpdates

    foreach ($updates as $update){

      $update = json_decode($update);

      if (isset($update->message->text)) { // Проверяем Update, на наличие текста
        $text = $update->message->text; // Переменная с текстом сообщения
        $chat_id = $update->message->chat->id; // Чат ID пользователя
        $first_name = $update->message->from->first_name; //Имя пользователя

        print_r("chat ".$chat_id." name ".$first_name." message ".$text."\n");

        if ($text == '/start'){ // Если пользователь подключился в первый раз, ему поступит приветствие
        $telegram->sendMessage($chat_id, 'Привет'. ' ' . $first_name . '!'); //Приветствует Пользователя
        } else {
          $telegram->sendMessage($chat_id, $first_name . '! Как дела?' ); // Спрашивает как дела
        }
      }
    }
  }
?>
