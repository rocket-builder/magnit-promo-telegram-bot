<?php
require 'Config.php';
require 'utils/API.php';
require 'utils/functions.php';
require 'controllers/connection.php';

$user = null;

$keyboard = [
    ['Купить', 'Наличие товаров'],
    ['Баланс', 'Личный кабинет'],
    ['Помощь', 'Правила', 'О боте']
];


$telegram = new Telegram(Config::BOT_TOKEN, Config::BOT_NAME);

while (true) {

	$update = $telegram->getupdates(@$update['update_id'] + 1);

  if (isset($update['message'])) {

      switch ($update['message']['text']) {
        case '/start':

           $user = R::findOrCreate('customer', ['telegram_id' => $update['message']['from']['id']]);

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

            $kb =
            [
              "keyboard" => [
                [[
                  "text" => "Главное меню"
                ]]
              ],
              "resize_keyboard" => true,
              "one_time_keyboard" => false
            ];

            foreach ($regions as $region) {
              array_push($kb['keyboard'], [[ "text" => $region['title'] ]]);
            }

            $telegram->api("sendMessage", array(
               'chat_id' => $update['message']['chat']['id'],
               'text' => 'Выберете регион',
               'reply_markup' => json_encode($kb)
            ));

          } else
            $telegram->api('sendMessage', [
              'chat_id' => $update['message']['chat']['id'],
              'text' => 'Промокодов пока нет в наличии, но они обязательно появятся очень скоро :)'
            ]);
          break;

        case 'Наличие товаров':

          $telegram->api('sendMessage', [
            'chat_id' => $update['message']['chat']['id'],
            'text' => 'Скоро появится'
          ]);
          break;

        case 'Баланс':

          $telegram->api('sendMessage', [
            'chat_id' => $update['message']['chat']['id'],
            'text' => 'Скоро появится'
          ]);
          break;

        case 'Личный кабинет':

          $telegram->api('sendMessage', [
            'chat_id' => $update['message']['chat']['id'],
            'text' => 'Скоро появится'
          ]);
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

        case 'Главное меню':

          $telegram->api("sendMessage", array(
             'chat_id' => $update['message']['chat']['id'],
             'text' => 'Главное меню',
             'reply_markup' => json_encode([
               "keyboard" => $keyboard,
               "resize_keyboard" => true,
               "one_time_keyboard" => false
             ])
          ));
          break;

        default:

          //BUY PROMO
          if(isset($regions) && isRegion($regions, $update['message']['text'])) {

            //buy promo
            $region = R::findOne('region', ' title = :title', [':title' => $update['message']['text']]);
            $promo = R::find('promo', ' region_id = :region_id and use_date is null', [':region_id' => $region->id]);

            $ranged_promo = getRangedPromoArray($promo);

            $mess = $update['message']['text']."\n";
            $kb =
            [
              "keyboard" => [
                [[
                  "text" => "Главное меню"
                ]]
              ],
              "resize_keyboard" => true,
              "one_time_keyboard" => false
            ];

            foreach ($ranged_promo as $pr) {
              $mess.=$pr['range']."\n";
              array_push($kb['keyboard'],  [[ "text" => $pr['range'] ]]);
            }

            $telegram->api('sendMessage', [
              'chat_id' => $update['message']['chat']['id'],
              'text' => $mess,
              'reply_markup' => json_encode($kb)
            ]);
          } elseif (isset($ranged_promo) && isRange($ranged_promo, $update['message']['text'])) {

            //BUY SINGLE PROMO
            $sell_promo = getRangedPromoByRange($ranged_promo, $update['message']['text']);
            $price = getRangedPromoPriceByRange($ranged_promo, $update['message']['text']);
            $max_promo = getMaxPromoFromRange($sell_promo);
            $max_promo['price'] = $price;

            $telegram->api('sendMessage', [
              'chat_id' => $update['message']['chat']['id'],
              'text' => '*Покупка товара:* '.str_split($update['message']['text'], strpos($update['message']['text'], '|'))[0]."\n".'*Количество товра:* 1шт'."\n".'*К оплате:* '.$price.'р',
              'reply_markup' => json_encode(
                  array(
                  "inline_keyboard" => array(array(array(
                  "text" => "Купить",
                  "callback_data" => json_encode($max_promo)
                  )))
                  )
              ),
              'parse_mode' => 'Markdown'
            ]);
          }


          else
            $telegram->api('sendMessage', [
              'chat_id' => $update['message']['chat']['id'],
              'text' => 'Я не знаю такой команды :('
            ]);
          break;
      }

  } elseif (isset($update['callback_query'])) {

    $promo = json_decode($update['callback_query']['data']);
    if($user->balance >= $promo->price) {
      $user->balance -= $promo->price;
      R::store($user);

      //delete promo from sell
      $promo_db = R::findOne('promo', ' value = :value and use_date is null', [':value' => $promo->value]);

      if(!is_null($promo_db)) {

        //use promo
        $promo_db->use_date = date('Y-m-d');
        R::store($promo_db);

        $url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=".$promo->value;

        //update keyboard
        $promo = R::find('promo', ' region_id = :region_id and use_date is null', [':region_id' => $promo_db->region->id]);
        $ranged_promo = getRangedPromoArray($promo);
        $kb =
        [
          "keyboard" => [
            [[
              "text" => "Главное меню"
            ]]
          ],
          "resize_keyboard" => true,
          "one_time_keyboard" => false
        ];
        foreach ($ranged_promo as $pr) {
          array_push($kb['keyboard'],  [[ "text" => $pr['range'] ]]);
        }

        $telegram->api('sendPhoto', [
          'chat_id' => $update['callback_query']['from']['id'],
          'photo' => $url,
          'caption' => 'Постоянная ссылка на промокод: '.$url,
          'reply_markup' => json_encode($kb)
        ]);

      } else {

        $telegram->api('sendMessage', [
          'chat_id' => $update['callback_query']['from']['id'],
          'text' => 'Промокод уже продан или еще не существует :('
        ]);
      }
    } else {
      $telegram->api('sendMessage', [
        'chat_id' => $update['callback_query']['from']['id'],
        'text' => 'Недостаточно средств на балансе :('
      ]);
    }

  }
}
?>
