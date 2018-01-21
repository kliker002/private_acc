<?php
  require ('db.php');
 $my_balance = R::findOne('clients', 'id = ?', array($_SESSION['logged_user']->id));
 $referers = R::find('clients','referer =  :referer', ['referer'=>$_SESSION['logged_user']->id]);
 $getPercent = R::findOne('settings', 'argument = ?', array('referal_percent'));
  $ref_balance = 0;
  foreach ($referers as $key => $value) {
  	$ref_balance += $value->balance;
  }
  if ($ref_balance != $my_balance->balance_referal_minus) {
  	$ref_balance = $ref_balance - $my_balance->balance_referal_minus;
  	$my_balance->balance_referal += $ref_balance*$getPercent->value;
  	$my_balance->balance_referal_minus = $ref_balance;
  	R::store($my_balance);
  }

 $all_stats = R::find('orders');
 foreach ($all_stats as $key => $value) {
   if (strtotime(date("d.m", strtotime($value->start_time . '+  ' . count(json_decode($value->count_installed)) . 'days'))) < strtotime(date("d.m", time()))) {
     $value->status = 'finished';
     R::store($value);
   }
 }
 ?>