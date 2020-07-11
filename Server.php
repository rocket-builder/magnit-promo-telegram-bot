<?php
require 'Config.php';
require 'utils/API.php';
require 'controllers/connection.php';

$card = R::load('card',1);

$customer = R::dispense('customer');
$customer->name = '1213322';
$customer->balance = 12.23;
R::store($customer);

$orders = R::dispense('orders');
$orders->card = $card;
$orders->customer = $customer;
$orders->date = date('Y-m-d');
R::store($orders);



// $keyboard = [
//     ['Купить', 'Наличие товаров'],
//     ['Баланс', 'Личный кабинет'],
//     ['Помощь', 'Правила', 'О боте']
// ];
//
//
// $telegram = new Telegram(Config::BOT_TOKEN, Config::BOT_NAME);
//
// while (true) {
//
// 	$update = $telegram->getupdates(@$update['update_id'] + 1);
//
//   if (isset($update['message'])) {
//
//       switch ($update['message']['text']) {
//         case '/start':
//
//                $resp = array("keyboard" => $keyboard,"resize_keyboard" => true,"one_time_keyboard" => false);
//                $reply = json_encode($resp);
//
//            $telegram->api("sendMessage", array(
//               'chat_id' => $update['message']['chat']['id'],
//               'text' => 'Привет!',
//               'reply_markup' => $reply
//            ));
//           break;
//
//         case 'Купить':
//
//
//           break;
//
//         case 'Наличие товаров':
//
//           break;
//
//         case 'Баланс':
//
//           break;
//
//         case 'Личный кабинет':
//
//           break;
//
//         case 'Помощь':
//
//           $telegram->api('sendMessage', [
//             'chat_id' => $update['message']['chat']['id'],
//             'text' => Config::HELP
//           ]);
//           break;
//
//         case 'Правила':
//
//           $telegram->api('sendMessage', [
//             'chat_id' => $update['message']['chat']['id'],
//             'text' => Config::RULES
//           ]);
//           break;
//
//         case 'О боте':
//
//           $telegram->api('sendMessage', [
//             'chat_id' => $update['message']['chat']['id'],
//             'text' => Config::ABOUT
//           ]);
//           break;
//
//         default:
//
//           $telegram->api('sendMessage', [
//             'chat_id' => $update['message']['chat']['id'],
//             'text' => 'Я не знаю такой команды :('
//           ]);
//           break;
//       }
//
//   }
// }
?>
