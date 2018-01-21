<?php
 require ('db.php');
 require_once '../parser/simple_html_dom.php';
session_start();
ob_start();
 $user = R::findOne('clients', 'login = ?', array($_SESSION['logged_user']->login));
 $order = R::find('orders', " `status` = :status AND  `client_id` = :cid ", [':status' => 'active', ':cid' => $user->id]);
$j = 0;
$today = date("d");
$html; $img_play; $title_play;
// foreach ($order as $key => $value) {
//   $j++;
// }
$hp4 = 0;
$h_stats = array();
foreach ($order as $key => $value) {
  $j++;
  // var_dump(json_decode($value->count_installed)[2]);
      // echo(json_decode($value->count_installed)[2]) . "<br>";
  if ((date("d.m", strtotime("-7days"))) <= date("d.m", strtotime($value->start_time))) {

    // echo "<br>" . ((date("d", strtotime($value->start_time)) + count(json_decode($value->count_installed)))  - ($today))  . "<br/>" ;
    // echo "Был создан <  7 дней <br>";
    if ($today >= date("d", strtotime($value->start_time)) + count(json_decode($value->count_installed))) {
       $an = 0;
       // $hp4 = 7 - count(json_decode($value->count_installed));
       $m_days = date("d", strtotime($value->start_time)) - (date("d", strtotime("-7days")));
       $hp4 = $m_days + 1;

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
    if ($today > date("d", strtotime($value->start_time)) + count(json_decode($value->count_installed)) ) {
      $K = date("d", strtotime($value->start_time)) + count(json_decode($value->count_installed));
      $G = 7 - ($today - $K);
      // $an = ( $today - date("d", strtotime($value->start_time)) + count(json_decode($value->count_installed))) - (date("d", strtotime($value->start_time)));
      $an = count(json_decode($value->count_installed)) - $G - 1;
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
if (isset($_POST['to_create'])) {
  $errors = array();
  $day_on_install = 0;
  for ($i=0; $i < (count(json_decode(json_encode($_POST['amount_days'])))); $i++) {  // сравнение с количеством установок всего и введённых установок
    $day_on_install +=json_decode($_POST['amount_days'][$i]);
  }
  if ($_POST['title'] == '') {
    $errors[] = 'Вы не ввели название компании';
  }
  if($_POST['package'] == ''){
    $errors[] = 'Вы не ввели Bundle приложения';
  }
  if (!isset($_POST['amount_days'])) {
    $errors[] = 'Введите установки по дням!';
  }
  if ($_POST['install_num'] != $day_on_install) {
    $errors[] = 'Вы ввели неверное количество установок по дням!';
  }
  if (!(isset($_POST['install_num']))) {
    $errors[] = 'Вы не ввели количество установок!';
  }

  if (!(isset($_POST['retention']))) {
    $errors[] = 'Вы не ввели количество возвратов в приложение!';
  }
  error_reporting( E_ERROR ); // Отключение Варнингов и Нотайс
  $url=file_get_contents("https://play.google.com/store/apps/details?id=" . $_POST['package']); 
  if ($url==""){
    $errors[] = "Неверный  bundle";
  }else{
     $html = file_get_html("https://play.google.com/store/apps/details?id=" . $_POST['package']);
    $img_play = $html->find("img[class=cover-image]");
    $title_play = $html->find("div.id-app-title");
  }


  if (isset($_POST['chb_responses'])) {
    $_POST['chb_responses'] = R::findOne('settings', 'argument = ?', array('default_cost_review'))->value;
    // if (isset($_POST['text_response'])) {
    //   $errors[] = 'Вы не ввели инструкцию к отзывам';
    // }
  }else{
    $_POST['chb_responses'] = 0;
  }
  if (empty($errors)) {


    $hss = R::findOne('settings', 'argument = ?', array('default_cost_install'));
    $R = R::dispense('orders');
    $R->title = $title_play[0]->plaintext;
    $R->title_order = $_POST['title'];
    $R->package = $_POST['package'];
    // $R->icon_link = $news[0]->src;
    $R->geo = $_POST['geo'];
    $R->count = $_POST['install_num'];
    $R->retention = $_POST['retention'];
    $R->app_key = $_POST['keywords'];
    $R->count_daily = json_encode($_POST['amount_days']);
    $R->comment = $_POST['chb_responses'];
    $R->comment_key = $_POST['text_response'];
    $R->description = $_POST['perfom_cond'];
    $R->status = 'moderation';
    $R->cost_retention = (R::findOne('settings', 'argument = ?', array('default_cost_retention')))->value;
    $R->cost_install = $hss->value;
    $R->count_installed = "[0]";
    $R->count_completed = "[0]";
    $R->retention = $_POST['retention'];
    $R->client_id = $user->id;
    $R->count_started = "[0]";
    $R->cost = (R::findOne('settings', 'argument = ?', array('default_extra_charge_install')))->value + $hss->value + ((R::findOne('settings', 'argument = ?', array('default_cost_retention')))->value + R::findOne('settings', 'argument = ?', array('default_extra_charge_retention'))->value)* $_POST['retention'] + $_POST['chb_responses'];
    $R->icon_link = "https:" . $img_play[0]->src;
    R::store($R);
    setcookie("info_setc", 1, time() + 3600);
    header("Location: /core/companies.php ");
    // echo R::find('settings', 'default_cost_install');
    // echo R::find('settings', 'argument = default_cost_install');
    
    
  }
// $d
  // echo json_encode($_POST['amount_days']);
  // foreach ($_POST['amount_days'] as $key => $value) {
    
  // }
}
// var_dump( $_SESSION['logged_user']);
// echo $_SESSION['logged_user'];
// foreach ($_SESSION['logged_user'] as $key => $value) {
//   // print_r($value);
//   echo $value->;
// }


if (isset($_SESSION['logged_user']) || isset($_COOKIE['login'], $_COOKIE['password'])) {
  if (!isset($_SESSION['logged_user'])) {
    $_SESSION['logged_user'] = $user;
    // var_dump($_SESSION['logged_user']);
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
   <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>   


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
     
      <div class="column is-12">    
          <section class="hero welcome is-small is-info">
          <div class="hero-body">
            <div class="container">
              <h1 class="title">
                 <?php echo $user->login; ?>
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
                    <a class="button is-primary is-inverted is-outlined is-large">Новая компания</a>
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
                <p class="title"><?php echo $j ?></p>
                <p class="subtitle">Активных заказов</p>
              </article>
            </div>
            <div class="tile is-parent">
              <article class="tile is-child box">
                <p class="title"><?php echo $user->balance . " р." ?></p>
                <p class="subtitle">Баланс</p>
              </article>
            </div>
          </div>
        </section>
        
            <div class="column is-12">
                <div class="box">                    
                    <form  method="post" name="to_create" action="/core/new_company.php"> 
                        <div class="column is-12">
                                <div class="columns" style="border-bottom: 1px solid #dbdbdb;">
                                <div class="column is-7">
                                <div class="field">
                                  <label class="label">Название компании*</label>
                                  <div class="control">
                                    <input class="input" type="text" placeholder="Название" name="title" value="<?php echo @$_POST['title'] ?>">
                                  </div>
                                </div>
                                </div>
                                <div class="column is-5">
                                    <div class="content">
                                        <blockquote>Называй компанию как хочешь, всё для твоего удобства</blockquote>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="columns" style="border-bottom: 1px solid #dbdbdb;">
                                <div class="column is-7">
                                <div class="field">
                                  <label class="label">Bundle приложения*</label>
                                  <div class="control">
                                    <input class="input" type="text" name="package" placeholder="com.companyname.application" value="<?php echo @$_POST['package'] ?>">
                                  </div>
                                </div>
                                </div>
                                <div class="column is-5">
                                    <div class="content">
                                        <blockquote>Уникальный идентификатор Android-приложения (имя пакета приложения или package name), взять его можно из ссылки на приложение  https://play.google.com/store/apps/details?id=<strong>com.tvoi.bundle</strong></blockquote>
                                    </div></div>
                                </div>
                                
                                <div class="columns" style="border-bottom: 1px solid #dbdbdb;">
                                <div class="column is-7">
                                <div class="field">
                                  <div class="control">
                                      <label class="label">ГЕО*</label>
                                    <div class="select">                                     
                                    <select name="geo">
                                      <option value="ru">Россия</option>
                                        <option value="ua">Украина</option>
                                        <option value="bur">Белоруссия</option>
                                    </select>
                                    </div>
                                </div>
                                </div>
                                </div>
                                <div class="column is-5">
                                    <div class="content">
                                        <blockquote>Выбери страну из которой бы ты хотел получать установки</blockquote>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="columns" style="border-bottom: 1px solid #dbdbdb;">
                                <div class="column is-7">
                                <div class="field">
                                  <label class="label">Количество установок* <span class="tag is-info">4 руб.\шт.</span></label>
                                  <div class="control">
                                    <input class="input" name="install_num" id="input_install" type="text" placeholder="5000" value="<?php echo @$_POST['install_num'] ?>">
                                  </div>
                                </div>
                                </div>
                                <div class="column is-5">
                                    <div class="content">
                                        <blockquote>Введи общее количество установок, для твоего приложения</blockquote>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="columns" style="border-bottom: 1px solid #dbdbdb;">
                                <div class="column is-7">
                                <div class="field">
                                  <label class="label">Возврат в приложение* (от 0 до 20 дней) <span class="tag is-info">1руб.\день</span></label>
                                  <div class="control">
                                    <input class="input" id="retention" type="text" placeholder="7" name="retention" value="<?php echo @$_POST['retention'] ?>">
                                  </div>
                                </div>
                                </div>
                                <div class="column is-5">
                                    <div class="content">
                                        <blockquote>В данном поле отметь, сколько дней пользователи должны заходить в твое приложение. От 0 до 20 дней. За каждый день возврата в приложение прибавляй к стоимости установки 1 рубль. </blockquote>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="columns" style="border-bottom: 1px solid #dbdbdb;">
                                <div class="column is-7">
                                <div class="field">
                                  <label class="label">Ключевые слова</label>
                                  <div class="control">
                                    <textarea class="textarea" placeholder="Ключевые слова, по которым пользователи будут находить ваше приложение" name="keywords"></textarea>
                                  </div>
                                </div>
                                </div>
                                <div class="column is-5">
                                    <div class="content">
                                        <blockquote>Если тебя инетересует продвижение по ключевым словам, впиши их сюда и пользователи будут устанавливать твое приложение, находя его по одному из слов. <strong>Удостоверься что твое приложение показывается по данным ключевым словам!</strong></blockquote>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="columns" style="border-bottom: 1px solid #dbdbdb;">
                                <div class="column is-7">
                               <div class="field"><!-- //mycreate -->
                                  <label class="label">Количество дней</label>
                                  <div class="control">
                                   <input class="input" type="text" placeholder="Days" id="days">
                                  </div>
                                  <div class = "column is-12" id="i_days">
                                  </div>
                                  <div class = "column is-12" id="counter" style="display:inline-block;">
                                  </div>
                                 </div>
                                 </div>
                                <div class="column is-5">
                                    <div class="content">
                                        <blockquote>Введи количество дней, в течении которых будут распределены установки. В появившихся окошках, по порядку распредели желаемое количество установок по дням. <br> NB! Советуем распределять установки с нарастанием по дням, например, 100 - 150 - 200 - 250</blockquote>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="columns" style="border-bottom: 1px solid #dbdbdb;">
                                <div class="column is-7">
                                <label class="checkbox">
                                  <input type="checkbox" id="comments" name="chb_responses">
                                  Нужны ли отзывы? <span class="tag is-info"><b>2 руб.\отзыв</b></span>
                                </label>
    <!--                             <div class="field">
                                  <label class="label">Количество отзывов</label>
                                  <div class="control">
                                    <input class="input" type="number" placeholder="Рекомендуется не более 2% от числа установок" name="amount_response" value="<?php echo @$_POST['amount_response'] ?>">
                                  </div>
                                </div> -->
                                </div>
                                <div class="column is-5">
                                    <div class="content">
                                        <blockquote>Отметь, если хочешь чтобы пользователи оставляли отзывы к твоему приложению. Цена установки вырастит на 2 рубля.<br> NB! Мы используем гибридную схему привлечения мотивированного трафика, поэтому наши отзывы не списываются, а за установки не будет пессимизации со стороны Google Play. </blockquote>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="columns" style="border-bottom: 1px solid #dbdbdb;">
                                <div class="column is-7">
                                <div class="field">
                                  <label class="label">Инструкция к отзывам</label>
                                  <div class="control">
                                    <textarea class="textarea" placeholder="Расскажите исполнителям что нужно писать в отзывах" name="text_response"></textarea>
                                  </div>
                                </div>
                                </div>
                                <div class="column is-5">
                                    <div class="content">
                                        <blockquote>Оставь краткую и понятную инструкцию, тем кто будет устанавливать и писать отзыв к твоему приложению. Например: Необходимо поставить 5 или 4 звезды, в отзыве использовать слова "авто", "машина", "автомобиль". </blockquote>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="columns" style="border-bottom: 1px solid #dbdbdb;">
                                <div class="column is-7">
                                <div class="field">
                                  <label class="label">Примечание к заказу</label>
                                  <div class="control">
                                    <textarea class="textarea" placeholder="Опишите, что должны делать исполнители, пробыть 2 минуты в приложении, сыграть 1 уровень и.т.д" name="perfom_cond"></textarea>
                                  </div>
                                </div>
                                </div>
                                <div class="column is-5">
                                    <div class="content">
                                        <blockquote>Напиши небольшое примечание для тех кто будет устанавливать приложение. Например: Пробыть в приложении 2 -3 минуты, сыграть один уровень.</blockquote>
                                    </div>
                                </div>
                                </div>
                                <!-- <input type="submit" class="button is-success"> -->
                                <?php 
                                if (isset($_POST['to_create'])) {
                                  echo '<div style="color: red;">' . array_shift($errors) . '</div>';
                                }
                                  ?>
                                  <div class="columns" style="border-bottom: 1px solid #dbdbdb;">
                                <div class="column is-7">
                                <button class="button is-success" name="to_create">Отправить</button>
                                </div>
                                <div class="column is-5">
                                    <div class="content">
                                        <blockquote>
                                          <span id="info_cost"></span>
                                        Не так уж и сложно, верно? ;)
                                      </blockquote>
                                    </div>
                                </div>
                                </div>
                              </div>
                          </div>
                        </div>
                    </form> 
            </div>
      </div>
    </div>
  </div>
  
      <script src="/js/bulma.js"></script>

      <script src="/../js/js.js"></script>
      <script>
        var inp_inst = <?php echo R::findOne('settings', 'argument = ?', array('default_cost_install'))->value + R::findOne('settings', 'argument = ?', array('default_extra_charge_install'))->value ?>;
        var retention = <?php echo R::findOne('settings', 'argument = ?', array('default_cost_retention'))->value + R::findOne('settings', 'argument = ?', array('default_extra_charge_retention'))->value ?>;
        var comments = <?php echo R::findOne('settings', 'argument = ?', array('default_cost_review'))->value ?>;
        var stringprice = '';
        var price = 0;
        $('input').on('change', function() {
          if (parseInt($('#input_install').val()) > 0 ) {
            price = inp_inst;
          }
          if ( parseInt($('#retention').val()) > 0 && parseInt($('#input_install').val()) > 0) {
              price = inp_inst + retention*parseInt($('#retention').val());
            }
          if ($('#comments').prop('checked') && parseInt($('#input_install').val()) > 0) {
              price = inp_inst + comments;
          }
          if ($('#comments').prop('checked') && parseInt($('#retention').val())>0 && parseInt($('#input_install').val()) > 0) {
              price = inp_inst + retention*parseInt($('#retention').val()) + comments;
          }
          $('#info_cost p').remove();
          $('#info_cost').append('<p><strong> Стоимость одной установки: ' + price + ' р. <br/>Итоговая стоимость: ' + parseInt($('#input_install').val())*price + ' р. </strong></p>');

        });
      </script>
   <?php
   ob_end_flush();
  }else{
    header('Location: /core/login.php');
  }

   ?>
</body>
</html>
