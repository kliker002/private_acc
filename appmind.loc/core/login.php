<?php
  session_start();
  require ('db.php');
  $data = $_POST;
  if (isset($data['to_login'])) {
  $user = R::findOne('clients', 'login = ?', array($data['email']));
    if ($user->login) {
      if (password_verify($data['password'], $user->password)) {
        if ($data['chb_remember']) {
          setcookie('login', $user->login, time() + 1000*60*60*24);
          setcookie('password', $user->password, time() + 1000*60*60*24);
        }
         if ($_COOKIE['login'] == $user->login && $_COOKIE['password'] == $user->password) {
            $_SESSION['logged_user'] = $user;
          }else{}
       //действия когда вошли
        $_SESSION['logged_user'] = $user;
        // header('Location: index.php');
      }else{
        $errors[] = 'Неверно введён пароль!';
      }
    }else{
          $errors[] = 'Пользователь с таким логином или паролем не найден';
      }

  }

  if (!(isset($_SESSION['logged_user']))){
    if(isset($_COOKIE['login'],$_COOKIE['password'])): $_SESSION['logged_user'] = $user; header('Location: /core/admin.php');
    else:
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Вход | AppMind</title>
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
          <p class="subtitle has-text-grey">Войдите чтобы продолжить</p>
          <div class="box">
            <figure class="avatar">
              <img src="../images/logo128.png">
            </figure>
            <form method="POST">
              <div class="field">
                <div class="control">
                  <input class="input is-large" type="email" placeholder="Электропочта" autofocus="" name="email">
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <input class="input is-large" type="password" placeholder="Пароль" name="password">
                </div>
              </div>
              <div class="field">
                <label class="checkbox">
                  <input type="checkbox" name="chb_remember">
                  Запомнить меня
                </label>
              </div>
              <!-- <a class="button is-block is-info is-large">Вход</a> -->
              <button class="button is-block is-info is-large" name="to_login" style="width: 100%;">Вход</button>
              <?php
              if (!empty($errors)) {
                echo '<div style="color: red;">' . array_shift($errors) . '</div> <hr>';
              }
               ?>
            </form>
          </div>
          <p class="has-text-grey">
            <a href="../core/registration.php">Регистрация</a> &nbsp;·&nbsp;
            <a href="../core/forgot_password.php">Забыли пароль?</a> &nbsp;·&nbsp;
            <span>mail@mail.mail</span>
          </p>
        </div>
      </div>
    </div>
  </section>
  <script async type="text/javascript" src="../js/bulma.js"></script>
  <?php
  endif;
  }else{
    header("Location: /core/admin.php");
  }
   ?>
</body>
</html>
