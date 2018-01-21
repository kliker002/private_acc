<?php require 'db.php';
unset($_SESSION['logged_user']);
setcookie ("login", $_SESSION['logged_user']->login,time()-3600); 
setcookie ("password", $_SESSION['logged_user']->password,time()-3600);
header('Location: /core/login.php');

?>