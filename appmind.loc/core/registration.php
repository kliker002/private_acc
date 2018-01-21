<?php
	require ('db.php');
	$data = $_POST;	
  setcookie("ref", $_GET['ref'], time()+1000);
  $ref = $_COOKIE['ref'];
    // $verif = rand(1000,9999);
    $ref_code = rand(10000,1000000);
    if (isset($data['to_register'])) {
    	$errors = array();
      if(strlen($data['email']) < 14){
        $errors[] = 'Такой e-mail не подходит!';
      }
    	if ($data['password'] == '') {
    		$errors[] = "Введите пароль!";
    	}   
    	if ($data['email'] == '') {
    		$errors[] = "Введите E-mail!";
    	}   	
		while ((R::count('clients',"ref_code = ?", array($ref_code)) > 0 )) {
			$ref_code = rand(10000,1000000);
		}
    	if (R::count('clients',"login = ?", array($data['email'])) > 0 ) {
			$errors[] = 'Пользователь с таким логином уже существует!';
		}
		if (!(isset($data['chb_rules'])) ) {
			$errors[] = 'Не отмечено согласие с правилами';
		}
		if (empty($errors)) {
			$user = R::dispense('clients');
       $anyGET = R::findOne('clients', 'ref_code = ?', array($ref));
      if (!is_null($ref)) {
        if ($ref == $anyGET->ref_code) {
          $user->referer = $anyGET->id;          
        }
      }
			$user->login = $data['email'];
			$user->password = password_hash($data['password'], PASSWORD_DEFAULT);
			$user->balance = 0;
			$user->ref_code = $ref_code;
      // $ref = $_GET['ref'];
			R::store($user);
  $message = "Спасибо за регистрацию";//текст сообщения
  $to = $_POST['email'];// Кому
  $from = 'asd@mail.ru';//От кого(мыло сайта)
  $headers = "From: $from \r\nReply-to:$from\r\nContent-type: text/html; charset=utf-8\r\n";
  $subject = 'Регистрация Appmind';//Тема
  $subject = "=?utf-8?B?".base64_encode($subject)."?=";
  mail($to, $subject, $message, $headers);
			header('Location: /core/login.php');
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
  <title>AppMind - Registration</title>
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
          <p class="subtitle has-text-grey">Зарегистрируйтесь прямо сейчас :)</p>
          <div class="box">
            <figure class="avatar">
              <img src="../images/logo128.png">
            </figure>
            <form action="/core/registration.php" method="POST">
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
                  <input type="checkbox" name="chb_rules">
                  Я согласен с  
                </label>
                  <a class="modal-button has-text-info" data-target="modal-ter">правилами использования сайта</a>
              </div>
             <!--  <a class="button is-block is-info is-large" name="to_register">Регистрация</a> -->
             <button class="button is-block is-info is-large" name="to_register" style="width: 100%;">Регистрация</button>
            </form>
            <?php
            if (isset($data['to_register'])) {
            	echo '<div style="color: red;">' . array_shift($errors) . '</div>';
            }
             ?>
          </div>
          <p class="has-text-grey">
            <a href="../core/login.php">Вход</a> &nbsp;·&nbsp;
            <span>mail@mail.mail</span>  
          </p>
        </div>
      </div>
    </div>
  </section>
  <script async type="text/javascript" src="../js/bulma.js"></script>
    <!--modal-->
   <div id="modal-ter" class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Правила пользования</p>
      <button class="delete"></button>
    </header>
    <section class="modal-card-body">
      <div class="content">
        <h1>Hello World</h1>

    </section>
    <footer class="modal-card-foot">      
    </footer>
  </div>
</div>
 <?php
  endif;
  }else{
    header("Location: /core/admin.php");
  }
   ?>
</body>
</html>
