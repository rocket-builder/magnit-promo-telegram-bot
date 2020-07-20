<?php
require 'vendor/autoload.php';
require 'Config.php';
require 'utils/Telegram.php';
require 'utils/functions.php';
require 'controllers/connection.php';


$billPayments = new Qiwi\Api\BillPayments(SECRET_KEY);

?>
