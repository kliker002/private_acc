<?php
  require ('db.php');
  session_start();
   $user = R::findOne('clients', 'login = ?', array($_SESSION['logged_user']->login));
 // $order = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'active', ':cid' => $user->id]);
 $order = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'active', ':cid' => $user->id]);
 $order_mod = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'moderation', ':cid' => $user->id]);
 $order_cancel = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'cancel', ':cid' => $user->id]);
 $order_accept = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'accept', ':cid' => $user->id]);
 $today = date("d");
 $find_ord = R::findOne('orders', ' id = ?', array($_COOKIE['key_stats']));
 $sign_js = md5('63320'.'xd72fnkg');
 $mail_inf = $user->login;
  $otziv = 0;
if($value->comment){
  $otziv = 2;
}
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
  // var_dump($find_ord->title);
  // var_dump($_COOKIE['key_stats']);
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
  <link rel="stylesheet" href="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
  <!-- sdada -->
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
          <a class="navbar-item is-active" href="companies.php">
            Компании
          </a>
          <a class="navbar-item" href="ref.php">
            Рефералы
          </a>
          <a class="navbar-item" href="admin.php">
            Выход
          </a>
        </div>

      </div>
    </div>
  </nav>
  <!-- END NAV -->
  <div class="container">
    <div class="columns">

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
               <div class="box">
               	<table style="width: 100%;">
               		<thead>
               			<tr>
                            <th>Компания</th>
                            <th>Статус</th>
                            <th>Ссылка</th> 
                            <th>Установок</th>
                            <th>Оплата</th>
                        </tr>
               		</thead>
               		<tbody>
               			<tr>
               				<td><?php echo $find_ord->title ?></td>
               				<td><?php switch ($find_ord->status) {
               					case 'active':
               						echo '<span class="tag is-primary">Активна</span>';
               						break;
               					case 'cancel':
               						echo '<span class="tag is-danger">Отклонена</span>';
               						break;
               					case 'moderation':
               						echo '<span class="tag is-warning">Модерация</span>';
               						break;
               					case 'finished':
               						echo '<span class="tag is-primary">Завершена</span>';
               						break;
                        case 'accept': 
                          echo '<span class="tag is-primary">Одобрена</span>';
               					default:break;
               				} ?></td>
               				<td><?php echo "<a target='_blank' href='https://play.google.com/store/apps/details?id=" . $find_ord->package . "'>https://play.google.com/store/apps/details?id=" . $find_ord->package; ?></td>
               				<td><?php 

               				$json_total = 0;

               				for ($i=0; $i < count( json_decode($find_ord->count_installed) ) ; $i++) { 
                     	     $json_total += json_decode($find_ord->count_installed)[$i];
                   		    }
                   		    for ($i=0; $i < count( json_decode($find_ord->count_daily) ) ; $i++) { 
                     	     $total += json_decode($find_ord->count_daily)[$i];
                   		     }
                            if ($find_ord->status == $find_ord->cost_install*$total) {
                              echo ' <span class="tag is-info">' . floor(($json_total*100)/$total) . ' % </span><br/> (' .
                              $json_total . '\ ' . $total . ')</td>
                              <td>' . $find_ord->cost*$value->count . '  р. <span class="tag is-success"><i class="fa fa-check"></i></span></td>';
                        }
                        if($find_ord->status == 'accept'){
                             echo ' <span class="tag is-info">' . floor(($json_total*100)/$total) . ' % </span><br/> (' .
                              $json_total . '\ ' . $total . ')</td>
                            <td><a class="button is-primary" onclick="getid(' . $find_ord->id . ',' . $find_ord->cost*$value->count . ')"> Пополнить ' . $find_ord->cost*$find_ord->count . ' р. </a></td>';
                        }else if($find_ord->status == 'active'){
                           echo ' <span class="tag is-info">' . floor(($json_total*100)/$total) . ' % </span><br/> (' .
                              $json_total . '\ ' . $total . ')</td>
                            <td>' . $find_ord->cost*$find_ord->count . ' р. <span class="tag is-success"><i class="fa fa-check"></i></span></td>';
                        }else{
                          echo ' <span class="tag is-info">' . floor(($json_total*100)/$total) . ' % </span><br/> (' .
                              $json_total . '\ ' . $total . ')</td>
                            <td><div class="button is-warning">Пополнение для данного заказа недоступно!</div></td>';
                        }


                          ?>
               			</tr>
               		</tbody>
               	</table>
               	<div class="columns">

               		<div class="column is-6">
               			<table style="width: 100%;">
               				<thead>
               					<tr>
               						<th>Дата</th>
               						<th>Количество установок</th>
               						<th>Цена за установки</th>

               					</tr>
               				</thead>
               				<tbody>

               					<?php
               					for ($i=0; $i < count(json_decode($find_ord->count_installed)); $i++) { 
               						echo '<tr><td>' . date("d.m.Y", strtotime($find_ord->start_time  . ' +' . $i . 'days')) . '</td>';
               						echo '<td>' . json_decode($find_ord->count_installed)[$i] . '</td>';
               						echo '<td>' . json_decode($find_ord->count_installed)[$i] * $find_ord->cost_install . '</td></tr>';

               					}

               					 ?>
               				</tbody>
               			</table>
               		</div>
               		<div class="column is-6">
                    <canvas class="ct-chart ct-golden-section" id="ct_chart"></canvas>
               </div>
               	</div>
               </div>
            </div>
        
      </div>
    </div>
  </div>

  <!-- <script async type="text/javascript" src="../js/bulma.js"></script> -->
  <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
  <!-- <script src="../js/jquery.magnific-popup.js"></script> -->
  <script src="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
  <script src="../js/Chart.js"></script>
  <!-- <script type="text/javascript" src="../js/js.js"></script> -->
   <script src="//www.free-kassa.ru/widget/w.js"></script>
    <?php $array_ordkey = array(); $array_ordval = array();
    $total = 0;
       for ($i=0; $i < count( json_decode($find_ord->count_daily) ) ; $i++) { 
          $total += json_decode($find_ord->count_daily)[$i];
        }
      $array_ordkey[] = $find_ord->id;
      $array_ordval[] = $total*$find_ord->cost_install - $find_ord->balance;
 ?>
    <script>
      var orders = {
        <?php for($i = 0; $i < count($array_ordkey); $i++){
          echo "'$array_ordkey[$i]'" . " : " . "'$array_ordval[$i]',";
          }?>
      }

      function load_form(id) {
        var form = new FK();
        form.loadWidget({
          merchant_id: '63320',
          amount: orders[id],
          order_id: id,
          email: '<?php echo $mail_inf; ?>',
          phone: '',
          sign: "<?php echo $sign_js; ?>",
          us_user: 1,
          us_desc: 'Test',
        });
      }
</script>
  <?php $za = 4; $xa =5; $ca = 6; $va = 7; $json_byjs = json_encode($find_ord->count_installed);
  $time_plus = count(json_decode($find_ord->count_installed));
  $json_time = date("d.m", strtotime($find_ord->start_time . ' +' . $time_plus . 'days')) ;
  $array_date = array();
  $temp = 0;
  while (date("d.m", strtotime($find_ord->start_time . ' +' . $temp . 'days')) != $json_time) {
  	$array_date[] = date("d.m", strtotime($find_ord->start_time . ' +' . $temp . 'days'));
  	$temp++;
  }
  $poqwe = json_encode($array_date);
  // echo $toJSS;
  // var_dump( json_decode($toJS));

  ?>
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
  	<script>
  		var lab = [JSON.parse(eval('<?php echo $json_byjs; ?>'))];
  		var ser = [JSON.parse(<?php echo json_encode($poqwe); ?>)];
      var step = 1;
  		// alert(lab[0]);
var data = {
    labels: ser[0],
    datasets: [
        {
            label: "Установок в день",
            backgroundColor: "rgba(255,99,132,0.2)",
            borderColor: "rgba(255,99,132,1)",
            borderWidth: 1,
            hoverBackgroundColor: "rgba(255,99,132,0.4)",
            hoverBorderColor: "rgba(255,99,132,1)",
            data: lab[0],
            scaleOverride:true,
            scaleSteps:1,
            scaleStartValue:0,
            scaleStepWidth:1
        }
    ]
};
var myBarChart = new Chart($("#ct_chart"), {
    type: 'line',
    data: data,
    options: {
      scales: {
       yAxes: [{
        ticks: {
          beginAtZero: true,
          callback: function(value) {if (value % 1 === 0) {return value;}}
        }
      }],
                xAxes: [{
                  ticks: {
                    min: 0,
                    stepSize: 1
                  },
                  scaleLabel: {
                    display: true
                  },
                }]
      }
    }
});
</script>
   <?php
   }else{
    header('Location: /core/login.php');
  }

  ob_end_flush();
   ?>
</body>
</html>
