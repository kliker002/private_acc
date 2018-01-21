<?php 
require ('db.php');
  $pas = random_int(1000000000, 9999999999999);
  $errors = array();
if (isset($_POST['sent'])) {
  $man = R::findOne('clients', 'login = ?', array($_POST['email']));
  if (isset($man)) {
    $man->password = password_hash($pas, PASSWORD_DEFAULT);
  $message = "Ваш новый пароль: $pas";//текст сообщения
  $to = $_POST['email'];// Кому
  $from = 'asd@mail.ru';//От кого(мыло сайта)
  $headers = "From: $from \r\nReply-to:$from\r\nContent-type: text/html; charset=utf-8\r\n";
  $subject = 'Восстановление пароля Appmind';//Тема
  $subject = "=?utf-8?B?".base64_encode($subject)."?=";
  mail($to, $subject, $message, $headers);
  }{
    $errors[] = 'Введён неверный E-mail!';
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Регистрация | AppMind</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <!-- Bulma Version 0.6.0 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css" integrity="sha256-HEtF7HLJZSC3Le1HcsWbz1hDYFPZCqDhZa9QsCgVUdw=" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
  <section class="hero is-success is-fullheight">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <h3 class="title has-text-grey">AppMind</h3>
          <p class="subtitle has-text-grey">Введите свой email и ожидайте письмо с новым паролем</p>
          <span class="error" style="color: red;"><?php  echo array_shift($errors) ?></span>
          <div class="box">
            <figure class="avatar">
              <img src="../images/logo128.png">
            </figure>
            <form action="" method="POST">
              <div class="field">
                <div class="control">
                  <input class="input is-large" type="email" placeholder="Электоропочта" name="email" autofocus="">
                </div>
              </div>              
              <button class="button is-block is-info is-large" style="width: 100%;" name="sent">Отправить письмо</button>
            </form>
          </div>
          <p class="has-text-grey">
            <a href="../core/login.php">Логин</a> &nbsp;·&nbsp;
            <a href="../core/registration.php">Регистрация</a> &nbsp;·&nbsp;
            <span>mail@mail.mail</span>
          </p>
        </div>
      </div>
    </div>
  </section>
  <script async type="text/javascript" src="../js/bulma.js"></script>
</body>
</html>
