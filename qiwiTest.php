<?php
require 'vendor/autoload.php';

$billId = '3';

$pay_timeout = 15;
$date = getdate();
$pay_timeout_date = date('Y-m-d').'T'.$date['hours'].':'.($date['minutes'] + $pay_timeout).':'.$date['seconds'].'+03:00';

$fields = [
  'amount' => 2.00,
  'currency' => 'RUB',
  'comment' => 'test1',
  'expirationDateTime' => $pay_timeout_date
];

const SECRET_KEY = 'eyJ2ZXJzaW9uIjoiUDJQIiwiZGF0YSI6eyJwYXlpbl9tZXJjaGFudF9zaXRlX3VpZCI6Im5jeHVwcy0wMCIsInVzZXJfaWQiOiI3OTk1MTMwNjk2MSIsInNlY3JldCI6ImQzODEzMGIxNWI3YzBiYjE1Y2RjYzcwNmU3YWJiMjllMWE2OWNhODI0NDc3YTZlNWU1ODU1NDZkNWYzYTQzMWMifX0=';

$billPayments = new Qiwi\Api\BillPayments(SECRET_KEY);

//$response = $billPayments->createBill($billId, $fields);

//$response = $billPayments->cancelBill($billId);
$response = $billPayments->getBillInfo($billId);

print_r($response);
?>
