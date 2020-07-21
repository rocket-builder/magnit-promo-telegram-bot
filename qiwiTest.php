<?php
require 'controllers/connection.php';
require 'Config.php';

require 'vendor/autoload.php';

//
//
// const SECRET_KEY = 'eyJ2ZXJzaW9uIjoiUDJQIiwiZGF0YSI6eyJwYXlpbl9tZXJjaGFudF9zaXRlX3VpZCI6Im5jeHVwcy0wMCIsInVzZXJfaWQiOiI3OTk1MTMwNjk2MSIsInNlY3JldCI6ImQzODEzMGIxNWI3YzBiYjE1Y2RjYzcwNmU3YWJiMjllMWE2OWNhODI0NDc3YTZlNWU1ODU1NDZkNWYzYTQzMWMifX0=';
//
// $billPayments = new Qiwi\Api\BillPayments(SECRET_KEY);
//
// //$response = $billPayments->createBill($billId, $fields);
//
// //$response = $billPayments->cancelBill($billId);
// $response = $billPayments->getBillInfo($billId);
//
// print_r($response);

echo R::findOne( 'qiwi' , ' ORDER BY id DESC LIMIT 1')->token;


?>
