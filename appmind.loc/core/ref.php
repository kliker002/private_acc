<?php
  require ('db.php');
  session_start();
  $j = 0;
  $my_balance = R::findOne('clients', 'id = ?', array($_SESSION['logged_user']->id));
  $user = R::find( 'clients', ' referer = :referer ', [ ':referer' => $_SESSION['logged_user']->id ] );
  foreach ($user as $key => $value) {
    // echo $value->login . "<hr/>";
    // echo $value->date_reg . '<hr/>';
    // echo date("d.m.Y", strtotime($value->date_reg));
    // var_dump(strtotime($value->date_reg));
    $j++;
  }
// var_dump($user);
// echo $_SESSION['logged_user']->ref_code;

  if (isset($_SESSION['logged_user']) || isset($_COOKIE['login'], $_COOKIE['password'])) {
  if (!isset($_SESSION['logged_user'])) {
    $_SESSION['logged_user'] = $user;
    
  }
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
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AppMind - Рекламные компании</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <!-- Bulma Version 0.6.0 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css" integrity="sha256-HEtF7HLJZSC3Le1HcsWbz1hDYFPZCqDhZa9QsCgVUdw=" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>

  <!-- START NAV -->
  <nav class="navbar is-white">
    <div class="container">
      <div class="navbar-brand">        
        <div class="navbar-burger burger" data-target="navMenuTest">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div id="navMenuTest" class="navbar-menu">
        <div class="navbar-start">
          <a class="navbar-item" href="admin.php">
            Главная
          </a>
          <a class="navbar-item" href="companies.php">
            Компании
          </a>
          <a class="navbar-item is-active" href="ref.php">
            Рефералы
          </a>
          <a class="navbar-item" href="logout.php">
            Выход
          </a>
        </div>

      </div>
    </div>
  </nav>
  <!-- END NAV -->
  <div class="container">
    <div class="columns">
      <!-- <div class="column is-3">
        <aside class="menu">
          <p class="menu-label">
            General
          </p>
          <ul class="menu-list">
            <li><a class="is-active">Dashboard</a></li>
            <li><a>Customers</a></li>
          </ul>
          <p class="menu-label">
            Administration
          </p>
          <ul class="menu-list">
            <li><a>Team Settings</a></li>
            <li>
              <a>Manage Your Team</a>
              <ul>
                <li><a>Members</a></li>
                <li><a>Plugins</a></li>
                <li><a>Add a member</a></li>
              </ul>
            </li>
            <li><a>Invitations</a></li>
            <li><a>Cloud Storage Environment Settings</a></li>
            <li><a>Authentication</a></li>
          </ul>
          <p class="menu-label">
            Transactions
          </p>
          <ul class="menu-list">
            <li><a>Payments</a></li>
            <li><a>Transfers</a></li>
            <li><a>Balance</a></li>
          </ul>
        </aside>
      </div>-->
      <div class="column is-12">    
          <section class="hero welcome is-small is-info">
          <div class="hero-body">
            <div class="container">
              <h1 class="title">
                 <?php echo $_SESSION['logged_user']->login; ?>
              </h1>
              <h2 class="subtitle">
                Приводи друзей и получай % от их заказов!
              </h2>
            </div>
          </div>
        </section>  
        <section class="info-tiles">
          <div class="tile is-ancestor has-text-centered">
            <div class="tile is-parent">
              <article class="tile is-child box"  style="background:hsl(171, 100%, 41%);">
                    <span class="has-text-white has-text-white is-size-4">Реферальная ссылка: <br>appmind.ru/ref=<?php echo $_SESSION['logged_user']->ref_code; ?></span>
              </article>
            </div>
            <div class="tile is-parent">
              <article class="tile is-child box">
                <p class="title"><?php echo $j; ?></p>
                <p class="subtitle">Привлечено рефералов</p>
              </article>
            </div>
            <div class="tile is-parent">
              <article class="tile is-child box">
                <p class="title"><?php echo $my_balance->balance_referal; ?></p>
                <p class="subtitle">Доход от рефералов</p>
              </article>
            </div>
            <div class="tile is-parent">
              <article class="tile is-child box">
                <p class="title"><?php echo $my_balance->balance . ' р.';?></p>
                <p class="subtitle">Баланс</p>
              </article>
            </div>
          </div>
        </section>
        
            <div class="column is-12">
                <div class="box">
                    <table class="table is-fullwidth">
                      <thead>
                        <tr>
                            <th>Email</th>
                            <th>Дата</th>
                            <th>Потрачено</th> 
                            <th>Доход</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                            <th>Email</th>
                            <th>Дата</th>
                            <th>Потрачено</th> 
                            <th>Доход</th>                
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        foreach ($user as $key => $value) {
                          $spend = R::find('clients', "referer = $value->id");
                          $s = 0;
                          echo " <tr>
                          <td>" . $value->login . '</td>
                          <td><span class="tag is-info">' . date("d.m.Y", strtotime($value->date_reg)) .'</span></td>
                          <td>' . $value->balance . ' р.' . '</td> 
                          <td><span class="tag is-warning">' . $value->balance*$getPercent->value . '</span></td>
                          </tr>';
                          // cost_install+cost_retention*retention)
                          // +$value->cost_retention*$value->retention
                          // $orders = R::getAll(" SELECT * FROM `orders` WHERE client_id = $value->id");
                        }

                        ?>
                       <!--  <tr>                            
                            <td>Pupkin@fuck.ru</td>
                            <td><span class="tag is-info">14.11.2017</span></td>
                            <td>37 000р. </td> 
                            <td><span class="tag is-warning">1900р.</span></td>
                        </tr> -->
                         <!--  <tr>                            
                            <td>Pupkin@fuck.ru</td>
                            <td><span class="tag is-info">14.11.2017</span></td>
                            <td>37 000р. </td> 
                            <td><span class="tag is-warning">1900р.</span></td>
                        </tr>
                          <tr>                            
                            <td>Pupkin@fuck.ru</td>
                            <td><span class="tag is-info">14.11.2017</span></td>
                            <td>37 000р. </td> 
                            <td><span class="tag is-warning">1900р.</span></td>
                        </tr> -->
                        
                      </tbody>
                    </table>
                </div>
            </div>
        
      </div>
    </div>
  </div>
  <script async type="text/javascript" src="../js/bulma.js"></script>
  <?php
   }else{
    header('Location: /core/login.php');
  }

   ?>
</body>
</html>
