<?php
 require ('db.php');
 $hash_test = $_REQUEST['notification_type'] . '&' . $_REQUEST['operation_id'] . '&' . $_REQUEST['amount'] . '&' . $_REQUEST['currency'] .
  '&' . $_REQUEST['datetime'] . '&' . $_REQUEST['sender'] . '&' . $_REQUEST['codepro'] . '&' . 'sUH4jc1yW15IBUv2UB6qem4L' . '&' . $_REQUEST['label'];
  if (sha1($hash_test) == $_REQUEST['sha1_hash']) {
    $fp = fopen("logs_callback.txt", "a"); // Открываем файл в режиме записи 
    $mytext = "ORDER_ID : " . $_REQUEST['label'] . "; "; // Исходная строка
    $test = fwrite($fp, $mytext); // Запись в файл
    if ($test) echo 'Данные в файл успешно занесены.';
    else echo 'Ошибка при записи в файл.';
    fclose($fp); //Закрытие файла
    $insert_db = R::findOne('orders', 'id = ?', array($_REQUEST['label']));
    $insert_db->balance += $_REQUEST['amount'];
    R::store($insert_db);
    die('All cool!');
  }   die('Hacker die!');
    //Так же, рекомендуется добавить проверку на сумму платежа и не была ли эта заявка уже оплачена или отменена
    //Оплата прошла успешно, можно проводить операцию.

 ?>