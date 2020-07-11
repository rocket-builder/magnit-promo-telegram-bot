<?php
require 'Config.php';
require 'utils/API.php';
require 'controllers/connection.php';


$keyboard = [
    ['Купить', 'Наличие товаров'],
    ['Баланс', 'Личный кабинет'],
    ['Помощь', 'Правила', 'О боте']
];


$telegram = new Telegram(Config::BOT_TOKEN, Config::BOT_NAME);

while (true) {

	$update = $telegram->getupdates(@$update['update_id'] + 1);

  if (isset($update['message']) && !isset($update['callback_query'])) {

      var_dump($update);

      switch ($update['message']['text']) {
        case '/start':

           $telegram->api("sendMessage", array(
              'chat_id' => $update['message']['chat']['id'],
              'text' => 'Привет!',
              'reply_markup' => json_encode([
                "keyboard" => $keyboard,
                "resize_keyboard" => true,
                "one_time_keyboard" => false
              ])
           ));
          break;

        case 'Купить':

          $regions = R::getAll('select title from region inner join promo on region.id = promo.region_id and promo.use_date is null group by title');

          if(count($regions) > 0) {

            $keys = [
              "keyboard" => [[]],
              "resize_keyboard" => true,
              "one_time_keyboard" => false
            ];

            $keys['keyboard'][0][0] = [ 'text' => 'Главное меню', 'callback_data' => 'Главное меню' ];
            foreach ($regions as $region) {
              array_push($keys['keyboard'][0], [ 'text' => $region['title'], 'callback_data' => $region['title']]);
            }

            var_dump($keys);


            $telegram->api("sendMessage", array(
               'chat_id' => $update['message']['chat']['id'],
               'text' => 'Выберете регион',
               'reply_markup' => json_encode($keys)
            ));

          } else
            $telegram->api('sendMessage', [
              'chat_id' => $update['message']['chat']['id'],
              'text' => 'Промокодов пока нет в наличии, но они обязательно появятся очень скоро :)'
            ]);
          break;

        case 'Наличие товаров':

          break;

        case 'Баланс':

          break;

        case 'Личный кабинет':

          break;

        case 'Помощь':

          $telegram->api('sendMessage', [
            'chat_id' => $update['message']['chat']['id'],
            'text' => Config::HELP
          ]);
          break;

        case 'Правила':

          $telegram->api('sendMessage', [
            'chat_id' => $update['message']['chat']['id'],
            'text' => Config::RULES
          ]);
          break;

        case 'О боте':

          $telegram->api('sendMessage', [
            'chat_id' => $update['message']['chat']['id'],
            'text' => Config::ABOUT
          ]);
          break;


        case 'button_0':
          echo "\nhello from callback";
          break;

        default:


          $telegram->api('sendMessage', [
            'chat_id' => $update['message']['chat']['id'],
            'text' => 'Я не знаю такой команды :('
          ]);
          break;
      }

  } else {
    var_dump($update);
  }
  // if(isset($update['callback_query'])) {
  //
  //   var_dump($update);
  //   // $callback_data = $update['callback_query']['data'];
  //   //
  //   // $telegram->api("sendMessage", array(
  //   //    'chat_id' => $update['message']['chat']['id'],
  //   //    'text' => $callback_data
  //   // ));
  //
  // }
}
?>
