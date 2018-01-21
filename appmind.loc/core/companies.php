<?php
  require ('db.php');
  session_start();
  setcookie ("key_stats", $$value->id,time()-3600);
   $user = R::findOne('clients', 'login = ?', array($_SESSION['logged_user']->login));
 // $order = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'active', ':cid' => $user->id]);
 $order = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'active', ':cid' => $user->id]);
 $order_mod = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'moderation', ':cid' => $user->id]);
 $order_cancel = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'cancel', ':cid' => $user->id]);
 $order_finished = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'finished', ':cid' => $user->id]);
 $order_accept = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'accept', ':cid' => $user->id]);
 $today = date("d");
 $sign_js = md5('63320'.'xd72fnkg');
 $mail_inf = $user->login;
 $pay_item = 0;
 $pay_value = 0;
	// $j = 0;
	// foreach ($order as $key => $value) {
 //  		$j++;
	// }

$for_stats = 0;

$hp4 = 0;
$h_stats = array();
for ($i=0; $i < 8; $i++) { 
  $h_stats[$i] = 0;
}
$j = 0;
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

  if (isset($_SESSION['logged_user']) || isset($_COOKIE['login'], $_COOKIE['password'])) {
  if (!isset($_SESSION['logged_user'])) {
    $_SESSION['logged_user'] = $user;
    
  }
ob_start();
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
  <!-- sdadas -->
  <!-- sdada -->
  <!-- Bulma Version 0.6.0 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css" integrity="sha256-HEtF7HLJZSC3Le1HcsWbz1hDYFPZCqDhZa9QsCgVUdw=" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="../css/admin.css">
  <link rel="stylesheet" href="../css/popup.css">
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
          <a class="navbar-item is-active" href="companies.php">
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
          <section class="hero welcome is-small is-info">
          <div class="hero-body">
            <div class="container">
              <h1 class="title">
                 <?php echo $_SESSION['logged_user']->login ;?>
              </h1>
              <h2 class="subtitle">
                Неплохой день, чтобы продвинуть пару приложений!
              </h2>
            </div>
          </div>
        </section>  
        <section class="info-tiles">
          <div class="tile is-ancestor has-text-centered">
            <div class="tile is-parent">
              <article class="tile is-child box"  style="background:hsl(171, 100%, 41%);">
                    <a class="button is-primary is-inverted is-outlined is-large" href="new_company.php">Новая компания</a>
              </article>
            </div>
            <div class="tile is-parent">
              <article class="tile is-child box">
                <p class="title"><?php echo $h_stats[7]; ?></p>
                <p class="subtitle">Установок за сегодня</p>
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
                <p class="title"><?php echo $user->balance . ' р.'; ?></p>
                <p class="subtitle">Баланс</p>
              </article>
            </div>
          </div>
        </section>
        
            <div class="column is-12">
              <div class="notification is-primary" id="popup">
                Ваш заказ был зарегистрирован!
              </div>
                              <div class="box">
                    <table class="table is-fullwidth">
                      <thead>
                        <tr>
                            <th>Компания</th>
                            <th>Статус</th>
                            <th>Ссылка</th> 
                            <th>Установок</th>
                            <th>Оплата</th>
                            <th>Управление</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                            <th>Компания</th>
                            <th>Статус</th>
                            <th>Ссылка</th> 
                            <th>Установок</th>
                            <th>Оплата</th>
                            <th>Управление</th>                  
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php 
                        $total = 0;
                        $give_money= 0;
                        $json_total = 0;
                         
                       foreach ($order as $key => $value) {
                        $json_total=0;
                        $total = 0;
                        for ($i=0; $i < count( json_decode($value->count_installed) ) ; $i++) { 
                          $json_total += json_decode($value->count_installed)[$i];
                        }
                        for ($i=0; $i < count( json_decode($value->count_daily) ) ; $i++) { 
                          $total += json_decode($value->count_daily)[$i];
                        }
                          echo ' <tr>                            
                            <td> ' . $value->title_order . '</td>
                             <td><span class="tag is-primary">Активна</span></td>
                             <td><a target="_blank" href="https://play.google.com/store/apps/details?id=' . $value->package . '">https://play.google.com/store/apps/details?id=' . $value->package. '</a></td> 
                              <td><span class="tag is-info">' . floor(($json_total*100)/$total) . ' % </span><br/> (' .
                               $json_total . '\ ' . $total . ')</td>
                               <td>' .
                               $value->cost*$value->count
                                . ' р. <span class="tag is-success"><i class="fa fa-check"></i></span></td> 
                              <td><form action="" method="POST"><button class="button is-warning item'. $for_stats . '" name="item'. $for_stats . '" style="margin-right:10px;"><span class="icon is-small"><i class="fa fa-cog fa-lg"></i></button></form></td>   
                              </tr> ';
                               if(isset($_POST["item" . $for_stats])){
                            	    setcookie ("key_stats", $$value->id,time()-3600);
                                  setcookie("key_stats",$value->id, time() + 1200);
                                  header("Location: /core/stats.php");
                              }
                             // 37 - x%;
                             // 100 - 100%
                              $for_stats +=1;
                       }
                      foreach ($order_accept as $key => $value) {
                         $total = 0;
                          $json_total=0;
                        for ($i=0; $i < count( json_decode($value->count_installed) ) ; $i++) { 
                          $json_total += json_decode($value->count_installed)[$i];
                        }
                        for ($i=0; $i < count( json_decode($value->count_daily) ) ; $i++) { 
                          $total += json_decode($value->count_daily)[$i];
                        }

                          if ($value->balance < $value->cost_install*$total) {

                            echo '
                            <td> ' . $value->title_order . '</td>
                             <td><span class="tag is-primary">Одобрена</span></td>
                             <td><a target="_blank" href="https://play.google.com/store/apps/details?id=' . $value->package . '">https://play.google.com/store/apps/details?id=' . $value->package. '</a></td> 
                              <td><span class="tag is-info">' . floor(($json_total*100)/$total) . ' % </span><br/> (' .
                               $json_total . '\ ' . $total . ')</td>
                               <td><a href="#" onclick="getid(' . $pay_item . ',' . $value->cost*$value->count . ')" class="button is-primary" id="to_pay' . $value->id . '">Пополнить ' . 
                               $value->cost*$value->count
                               // ($total*$value->cost_install - $value->balance) 
                                // (default_cost_install+default_extra_charge_install+(default_cost_retention+default_extra_charge_retention)*количество_дней ретеншена)*количество_инсталов
                               . ' р.</a></td>
                              <td><form action="" method="POST"><button class="button is-warning item'. $for_stats . '" name="item'. $for_stats . '" style="margin-right:10px;"><span class="icon is-small"><i class="fa fa-cog fa-lg"></i></button></form></td>   
                              </tr>';
                            // <a class="button is-primary"> Пополнить ' . $total*$value->cost_install . ' р. </a>

                          }else{
                            $value->status = "active";
                            R::store($value);
                            header("Location: /core/companies.php");
                          }
                           if(isset($_POST["item" . $for_stats])){
                                  setcookie ("key_stats", $value->id,time()-3600);
                                  setcookie("key_stats",$value->id, time() + 1200);
                                  header("Location: /core/stats.php");
                                }
                          $for_stats +=1;
                           $total = 0;
                           $json_total = 0;
                       }


                       foreach ($order_mod as $key => $value) {
                        $total = 0;
                       	$json_total = 0;
                         for ($i=0; $i < count( json_decode($value->count_installed) ) ; $i++) { 
                          $json_total += json_decode($value->count_installed)[$i];
                        }
                        for ($i=0; $i < count( json_decode($value->count_daily) ) ; $i++) { 
                          $total += json_decode($value->count_daily)[$i];
                        }
                           echo ' <tr>                            
                            <td> ' . $value->title_order . '</td>
                             <td><span class="tag is-warning">Модерация</span></td>
                             <td><a target="_blank" href="https://play.google.com/store/apps/details?id=' . $value->package . '">https://play.google.com/store/apps/details?id=' . $value->package. '</a></td> 
                              <td><span class="tag is-info">' . floor(($json_total*100)/$total) . ' % </span><br/> (' .
                               $json_total . '\ ' . $total . ')</td>
                               <td><span class="tag is-warning">На модерации</span></td> 
                            <td><form action="" method="POST"><button class="button is-warning item'. $for_stats . '" name="item'. $for_stats . '" style="margin-right:10px;"><span class="icon is-small"><i class="fa fa-cog fa-lg"></i></button></form></td>   
                              </tr> ';

                          // echo ' <tr>                            
                          //   <td> ' . $value->title . '</td>
                          //    <td><span class="tag is-warning">Модерация</span></td>
                          //    <td><a href="https://play.google.com/store/apps/details?id=' . $value->package . '">https://play.google.com/store/apps/details?id=' . $value->package. '</a></td> 
                          //     <td><span class="tag is-info">' . floor(($json_total*100)/$total) . ' % </span><br/> (' .
                          //      $json_total . '\ ' . $total . ')</td>
                          //      <td><a class="button is-primary"> Пополнить ' . $total*$value->cost_install . ' р. </a></td> 
                          //   <td><form action="" method="POST"><button class="button is-warning item'. $for_stats . '" name="item'. $for_stats . '" style="margin-right:10px;"><span class="icon is-small"><i class="fa fa-bar-chart"></i></button></form></td>   
                          //     </tr> ';
                               if(isset($_POST["item" . $for_stats])){
                                 	setcookie ("key_stats", $$value->id,time()-3600);
                                  setcookie("key_stats",$value->id, time() + 1200);
                                  header("Location: /core/stats.php");
                                }
                              $for_stats +=1;
                              $json_total = 0;
                       }
                       foreach ($order_cancel as $key => $value) {
                       	$json_total = 0;
                        $total = 0;
                         for ($i=0; $i < count( json_decode($value->count_installed) ) ; $i++) { 
                          $json_total += json_decode($value->count_installed)[$i];
                        }
                        for ($i=0; $i < count( json_decode($value->count_daily) ) ; $i++) { 
                          $total += json_decode($value->count_daily)[$i];
                        }

                          echo ' <tr>                            
                            <td> ' . $value->title_order . '</td>
                             <td><span class="tag is-danger">Отклонена</span></td>
                             <td><a target="_blank" href="https://play.google.com/store/apps/details?id=' . $value->package . '">https://play.google.com/store/apps/details?id=' . $value->package. '</a></td> 
                              <td><span class="tag is-info">' . floor(($json_total*100)/$total) . ' % </span><br/> (' .
                               $json_total . '\ ' . $total . ')</td>
                               <td><span class="tag is-danger"><i class="fa fa-close"></i></span></td> 
                            <td><form action="" method="POST"><button class="button is-warning item'. $for_stats . '" rel="popup' . $for_stats . '" name="item'. $for_stats . '"  style="margin-right:10px;"><span class="icon is-small"><i class="fa fa-cog fa-lg"></i></button></form></td></tr>';
                            if(isset($_POST["item" . $for_stats])){
                            	
                              setcookie("key_stats",$value->id, time() + 1200);
                              header("Location: /core/stats.php");
                            }
                              $for_stats +=1;
                              $json_total = 0;
                       }
                       foreach ($order_finished as $key => $value) {
                          $total = 0;
                          $json_total=0;
                        for ($i=0; $i < count( json_decode($value->count_installed) ) ; $i++) { 
                          $json_total += json_decode($value->count_installed)[$i];
                        }
                        for ($i=0; $i < count( json_decode($value->count_daily) ) ; $i++) { 
                          $total += json_decode($value->count_daily)[$i];
                        }

                          echo ' <tr>                            
                            <td> ' . $value->title_order . '</td>
                             <td><span class="tag is-primary">3авершена</span></td>
                             <td><a href="https://play.google.com/store/apps/details?id=' . $value->package . '">https://play.google.com/store/apps/details?id=' . $value->package. '</a></td> 
                              <td><span class="tag is-info">' . floor(($json_total*100)/$total) . ' % </span><br/> (' .
                               $json_total . '\ ' . $total . ')</td>
                               <td>' . $total*$value->cost_install . ' р. <span class="tag is-success"><i class="fa fa-check"></i></span></td> 
                              <td><form action="" method="POST"><button class="button is-warning item'. $for_stats . '" name="item'. $for_stats . '" style="margin-right:10px;"><span class="icon is-small"><i class="fa fa-cog fa-lg"></i></button></form></td>   
                              </tr> ';
                               if(isset($_POST["item" . $for_stats])){
                                  setcookie ("key_stats", $$value->id,time()-3600);
                                  setcookie("key_stats",$value->id, time() + 1200);
                                  header("Location: /core/stats.php");
                              }
                       }

                        ?>
                       <!--  <tr>                            
                            <td>Otso City</td>
                            <td><span class="tag is-primary">Активна</span></td>
                            <td><a href="https://play.google.com/store/apps/details?id=com.ubisoft.dragonfire">https://play.google.com/store/apps/details?id=com.ubisoft.dragonfire</a></td> 
                            <td><span class="tag is-info">37%</span> (3680\10000)</td>                            
                            <td>40 000 р.<span class="tag is-success"><i class="fa fa-check"></i></span></td> 
                            <td><a class="button is-warning" style="margin-right:10px;"><span class="icon is-small"><i class="fa fa-bar-chart"></i></a><a class="button is-danger"><span class="icon is-medium"><i class="fa fa-trash"></i></a></td>   
                        </tr>
                          <tr>                            
                            <td>Otso City</td>
                            <td><span class="tag is-warning">Модерация</span></td>
                            <td><a href="https://play.google.com/store/apps/details?id=com.ubisoft.dragonfire">https://play.google.com/store/apps/details?id=com.ubisoft.dragonfire</a></td> 
                            <td><span class="tag is-info">37%</span> (3680\10000)</td>                            
                            <td><a class="button is-primary">Пополнить 40 000р.</a></td> 
                            <td><a class="button is-warning" style="margin-right:10px;"><span class="icon is-small"><i class="fa fa-bar-chart"></i></a><a class="button is-danger"><span class="icon is-medium"><i class="fa fa-trash"></i></a></td>   
                         </tr> 
                                <tr>                            
                            <td>Otso City</td>
                            <td><span class="tag is-danger">Отклонена</span></td>
                            <td><a href="https://play.google.com/store/apps/details?id=com.ubisoft.dragonfire">https://play.google.com/store/apps/details?id=com.ubisoft.dragonfire</a></td> 
                            <td><span class="tag is-info">37%</span> (3680\10000)</td>                            
                            <td>40 000 р.<span class="tag is-success"><i class="fa fa-check"></i></span></td> 
                            <td><a class="button is-warning" style="margin-right:10px;"><span class="icon is-small"><i class="fa fa-bar-chart"></i></a><a class="button is-danger"><span class="icon is-medium"><i class="fa fa-trash"></i></a></td>   
                        </tr>  -->
                      </tbody>
                    </table>

                </div>
            </div>
        
      </div>
    </div>
  </div>
                <div id="overlay" style="display: none;background-color: #000;min-height: 100%; left: 0; opacity: 0.50; position: fixed;top: 0; width: 100%;z-index: 100;"></div>
                  <form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml" id="to_pay" style="display: none; position: absolute;z-index: 9999;background-color: white;top: 50%; position: fixed;left:45%;" > 
                  <input type="hidden" name="receiver" value="410011530243856"> 
                  <input type="hidden" name="formcomment" value="Оплата"> 
                  <input type="hidden" name="short-dest" value="Оплата"> 
                  <input type="hidden" name="label" id="pay_item" value=""> 
                  <input type="hidden" name="quickpay-form" value="donate"> 
                  <input type="hidden" name="targets" id="transaction" value="не смотри сюда"> 
                  <input type="hidden" name="sum" id="pay_value" value="" data-type="number"> 
                  <input type="hidden" name="comment" value="Оплата."> 
                  <input type="hidden" name="need-fio" value="false"> 
                  <input type="hidden" name="need-email" value="false"> 
                  <input type="hidden" name="need-phone" value="false"> 
                  <input type="hidden" name="need-address" value="false"> 
                  <label><input type="radio" id="Yandex_m" name="paymentType" value="PC"><!-- Яндекс.Деньгами --> <img src="../images/yandex_m.png" style="max-width: 500px;max-height: 150px;" alt="yandex_money"></label> <br>
                  <label><input type="radio" id="Bank_m" name="paymentType" value="AC">Банковской картой</label> <br>
                  <input type="submit" class="button is-primary" style="position: relative;left: 120px;" value="Перевести"> 
              </form>

<!-- <script type="text/javascript">
  document.getElementById('pay_item').setAttribute('value', 'privet');
  alert(document.getElementById('pay_item').value)
</script> -->
               
  <!-- <a class="button is-primary is-large modal-button">Launch example modal</a> -->
  <!-- <a href="#modal_content" class="popup"> Send e-mail</a> -->
  <!-- <div class="hidden">
  	<div class="content" style="display: none;">
  		<form action="" id="modal_content">
  		<input type="text" placeholder="412312312321"><br>
  		<input type="text" placeholder="412312312321"><br>
  		<input type="text" placeholder="412312312321"><br>
  		<button>Отправить</button>
  	</form>
  	</div>
  </div> -->


	<!-- <div class="overlay_popup"></div> -->
  <!-- <div class="popup" id="popup1">
		<div class="object">
				<table>
				<tbody>
				<tr>
				<td>Info</td>
				<td>Index</td>
				<td>Balance</td>
				<td>Id</td>
				</tr>
				</tbody>
				</table>
		</div>
	</div>
 -->

<?php

 ?>
  <!-- <script async type="text/javascript" src="../js/bulma.js"></script> -->
  <!-- <script>
    function getid(pitem, pvalue){
      document.getElementById('pay_item').setAttribute('value', '11');
    }
  </script> -->
  <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
  <!-- <script src="../js/jquery.magnific-popup.js"></script> -->
  <!-- <script type="text/javascript" src="../js/popup.js"></script> -->
  <!-- <script type="text/javascript" src="../js/js.js"></script> -->
<script type='text/javascript'>// Это не работает
var __pvalue;
  function getid(pitem, pvalue){// getid is not defined/ Функция привязана к тегу <a onclick="getid(1,1)>...</a>"
  __pvalue = pvalue;
  $('#pay_item').attr('value', pitem);
  $('#transaction').attr('value', 'транзакция ' + pitem);
  $('#pay_value').attr('value', pvalue);
  $('#to_pay').css('display', 'block');
  $('#to_pay').css('z-index', '9999');
  $('#overlay').css('display', 'block');
  $('#to_pay').delay(500).fadeIn();
  $('#popup').delay(1000).fadeOut(500);
  $('#to_pay').on('submit', '#order',function(e){
    e.preventDefault();
    });
  }
  $('#Yandex_m').on('click', function(){ // count '%' of order on Yandex money
    var v_index = __pvalue*0.5 + __pvalue;
    $('#pay_value').attr('value', v_index) ;
});
 $('#Bank_m').on('click', function(){ // count '%' of order on Bank card
    var v_index = __pvalue*0.2 + __pvalue;
    $('#pay_value').attr('value', v_index) ;
});
 $('#overlay').on('click', function(){
  $('#overlay').css('display', 'none');
   $('#to_pay').css('display', 'none');
 });
  </script>  
        
   <?php
   }else{
    header('Location: /core/login.php');
  }
  if (isset($_COOKIE['info_setc'])) {
    echo "<script type='text/javascript'>
    popup = $('#popup');
    popup.delay(500).fadeIn();
    $('#popup').delay(1000).fadeOut(500);
    popup.on('submit', '#order',function(e){
    e.preventDefault();
    });
    </script>";
    setcookie("info_setc", 1, time() - 3600);
  }

  ob_end_flush();
   ?>
</body>
</html>
