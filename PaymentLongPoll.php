<?php
require 'vendor/autoload.php';
require 'controllers/connection.php';
require 'Config.php';


$billPayments = new Qiwi\Api\BillPayments(R::findOne( 'qiwi' , ' ORDER BY id DESC LIMIT 1')->secret);

while (true) {

  sleep(1);
  $payments = R::findAll('payment', " status = 'WAITING' ");

  foreach ($payments as $payment) {

    $bill = $billPayments->getBillInfo($payment->id);

    $payment->status = $bill['status']['value'];
    $payment->amount = $bill['amount']['value'];
    R::store($payment);

    if($bill['status']['value'] == 'PAID') {

      $customer = $payment->customer;
      $customer->balance += $bill['status']['value'];
      R::store($customer);
    }
  }

}
?>
