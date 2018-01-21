<?php
 require ('db.php');
session_start();
 $user = R::findOne('clients', 'login = ?', array($_SESSION['logged_user']->login));
 $today = date("d");
 // $order = R::getAll("SELECT * FROM `orders` where `status` = 'active' AND `client_id` = $user->id ");
 $order = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'active', ':cid' => $user->id]);
$j = 0;
$hp4 = 0;
$h_stats = array();
for ($i=0; $i < 8; $i++) { 
  $h_stats[$i] = 0;
}
foreach ($order as $key => $value) {
  $j++;
  // var_dump(json_decode($value->count_installed)[2]);
      // echo(json_decode($value->count_installed)[2]) . "<br>";
  if (strtotime(date("d.m", strtotime("-7days"))) <= strtotime(date("d.m", strtotime($value->start_time)))) {
    // echo "<br>" . ((date("d", strtotime($value->start_time)) + count(json_decode($value->count_installed)))  - ($today))  . "<br/>" ;
    // echo "Был создан <  7 дней <br>";
    if (strtotime(date("d.m", time())) >= strtotime(date("d.m", strtotime($value->start_time)) + count(json_decode($value->count_installed)))) {
       $an = 0;
       // $hp4 = 7 - count(json_decode($value->count_installed));
       $m_days = date("d", strtotime($value->start_time)) - (date("d", strtotime("-7days")));
       $hp4 = $m_days;

      while ( $hp4 < 8) {
        $h_stats[$hp4] += json_decode($value->count_installed)[$an];
         // echo $h_stats[$hp4] . "<br/>";

        $hp4 += 1;
        $an += 1;
      }
    }else{
      $hp4 = 0;
       while ( $hp4 < count(json_decode($value->count_installed)) + (((date("d", strtotime($value->start_time)) +
        count(json_decode($value->count_installed)))  - ($today))) + 1) {
        
        $h_stats[$hp4] += json_decode($value->count_installed)[$hp4];
         // echo $h_stats[$hp4] . "<br/>";
        $hp4 += 1;
    }
  }
  }else{
    $hp4 = 0;
    // echo "test <br/>";
    // echo "Был создан > 7 дней <br/>";
    if (strtotime(date("d.m", time())) > strtotime(date("d", strtotime($value->start_time)) + count(json_decode($value->count_installed)))) {
      $K = date("d", strtotime($value->start_time)) + count(json_decode($value->count_installed));
      $G = 7 - ($today - $K);
      // $an = ( $today - date("d", strtotime($value->start_time)) + count(json_decode($value->count_installed))) - (date("d", strtotime($value->start_time)));
      $an = count(json_decode($value->count_installed)) - $G;
      $hp4 = 0;
      while ( $hp4 < 8) {
        $h_stats[$hp4] += json_decode($value->count_installed)[$an];
        $an++;
        $hp4++;
      }

    }else{
      $an = ($today - 7) - (date("d", strtotime($value->start_time)));
      $excess = (date("d", strtotime($value->start_time))) - $an;
      // echo $excess;
      while ( $hp4 < count(json_decode($value->count_installed)) + 1) {
        $h_stats[$hp4] += json_decode($value->count_installed)[$an-1];
        $excess++;
        $an++;
        $hp4++;
      }
      // $an = (date("d", strtotime($value->start_time)) + count(json_decode($value->count_installed)) - $today);
      // echo "An is:" . $an;
    }
  }
  $hp4 = 0;
}
//=======
$today = date("Y-m-d H:i:s"); 
$day = R::find('orders', 'start_time');
foreach ($day as $key => $value) {
  // echo $value->start_time . "<hr/>";
  $ji = date( "Y-m-d H:i:s", strtotime($today) - strtotime($value->start_time));
  // echo $ji . "<hr/>";
}
//========

if (isset($_SESSION['logged_user']) || isset($_COOKIE['login'], $_COOKIE['password'])) {
  if (!isset($_SESSION['logged_user'])) {
    $_SESSION['logged_user'] = $user;
  }
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AppMind - Личный кабинет</title>
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
          <a class="navbar-item is-active" href="admin.php">
            Главная
          </a>
          <a class="navbar-item" href="companies.php">
            Компании
          </a>
          <a class="navbar-item" href="ref.php">
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
        <section class="hero is-info welcome is-small bd-rainbow">
          <div class="hero-body">
            <div class="container">
              <h1 class="title">
                Привет, <?php echo $_SESSION['logged_user']->login; ?>
              </h1>
              <h2 class="subtitle">
                Надеюсь у тебя удачный день!
              </h2>
            </div>
          </div>
        </section>       
        <section class="info-tiles">
          <div class="tile is-ancestor has-text-centered">
            <div class="tile is-parent">
              <article class="tile is-child box">
                <p class="title"><?php
                if(!isset($h_stats)){
                  $h_stats = 0;
                }

                 echo $h_stats[7]; ?></p>
                <p class="subtitle">Установок за сегодня</p>
              </article>
            </div>
            <div class="tile is-parent">
              <article class="tile is-child box">
                <p class="title"><?php echo $h_stats[7]*(R::findOne('orders', 'client_id = ?', array($_SESSION['logged_user']->id)))->cost_install . ' р.'; ?></p>
                <p class="subtitle">Потрачено за сегодня</p>
              </article>
            </div>
            <div class="tile is-parent">
              <article class="tile is-child box">
                <p class="title"><?php echo $j; ?></p>
                <p class="subtitle">Активных заказов</p>
              </article>
            </div>
            <div class="tile is-parent">
              <article class="tile is-child box">
                <p class="title"><?php echo $user->balance.' р.'; ?></p>
                <p class="subtitle">Баланс</p>
              </article>
            </div>
          </div>
        </section>
        <div class="columns">
          <div class="column is-8">
            <table class="table is-fullwidth">
              <thead>
                <tr>
                  <th>Дата</th>
                  <th>Количество установок</th>
                  <th>Стоимость</th>                  
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Итог</th>
                  <th><?php $total = 0; for ($i=0; $i < 7; $i++) { 
                    $total += $h_stats[$i];
                  }  echo $total; ?></th>
                  <th><?php echo $total*(R::findOne('orders', 'client_id = ?', array($_SESSION['logged_user']->id)))->cost_install . ' р.';  ?></th>                  
                </tr>
              </tfoot>
              <tbody>
                <tr>
                  <td><?php echo date("d.m.Y", strtotime("-7days"));   ?></td>
                  <td><?php echo $h_stats[0]; ?></td>
                  <td><?php echo $h_stats[0]*(R::findOne('orders', 'client_id = ?', array($_SESSION['logged_user']->id)))->cost_install . ' р.'; ?></td>                  
                </tr>  
                <tr>
                  <td><?php echo date("d.m.Y", strtotime("-6days"));   ?></td>
                  <td><?php echo $h_stats[1]; ?></td>
                  <td><?php echo $h_stats[1]*(R::findOne('orders', 'client_id = ?', array($_SESSION['logged_user']->id)))->cost_install . ' р.'; ?></td>                  
                </tr> 
                <tr>
                  <td><?php echo date("d.m.Y", strtotime("-5days"));   ?></td>
                  <td><?php echo $h_stats[2]; ?></td>
                  <td><?php echo $h_stats[2]*(R::findOne('orders', 'client_id = ?', array($_SESSION['logged_user']->id)))->cost_install . ' р.'; ?></td>                   
                </tr>
                  <tr>
                  <td><?php echo date("d.m.Y", strtotime("-4days"));   ?></td>
                  <td><?php echo $h_stats[3]; ?></td>
                  <td><?php echo $h_stats[3]*(R::findOne('orders', 'client_id = ?', array($_SESSION['logged_user']->id)))->cost_install . ' р.'; ?></td>                  
                </tr>  
                <tr>
                  <td><?php echo date("d.m.Y", strtotime("-3days"));   ?></td>
                  <td><?php echo $h_stats[4]; ?></td>
                  <td><?php echo $h_stats[4]*(R::findOne('orders', 'client_id = ?', array($_SESSION['logged_user']->id)))->cost_install . ' р.'; ?></td>                  
                </tr> 
                <tr>
                  <td><?php echo date("d.m.Y", strtotime("-2days"));   ?></td>
                  <td><?php echo $h_stats[5]; ?></td>
                  <td><?php echo $h_stats[5]*(R::findOne('orders', 'client_id = ?', array($_SESSION['logged_user']->id)))->cost_install . ' р.'; ?></td>                   
                </tr>
                  <tr>
                  <td><?php echo date("d.m.Y", strtotime("-1days"));   ?></td>
                  <td><?php echo $h_stats[6]; ?></td>
                  <td><?php echo $h_stats[6]*(R::findOne('orders', 'client_id = ?', array($_SESSION['logged_user']->id)))->cost_install . ' р.'; ?></td>                  
                </tr>
              </tbody>
            </table>           
          </div>
            
            <div class="column is-4">
                <a class="button is-primary" style="width:100%; margin-bottom:25px; font-size:30px;" href="new_company.php">+ Новая компания</a>
                <article class="message is-warning">
                  <div class="message-body">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. 
                  </div>
                </article>
                
                <nav class="panel">
  <p class="panel-heading">
    Инфо
  </p>
  <div class="panel-block">
   <?php $get_iblock = R::findOne('settings', ' `argument`=?', array('info_block'));
   echo $get_iblock->value;
    ?>
  </div>

  
</nav>
                
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
