<?php
require 'db.php';
require_once '../parser/simple_html_dom.php';
session_start();


$user = R::findOne('clients', 'login = ?', array($_SESSION['logged_user']->login));
$active_orders = R::find('orders', 'status = :status', [':status' => 'active']);
if ($user->status != 1) {
	header('location: Location: /core/login.php');
}
$moderate = R::find('orders', "status = 'moderation'");
$i = 0;
$k = 0;
// $settings = R::findOne('settings', 'argument = ?', array("default_cost_install"));
	$up_retention = R::findOne('settings', '`argument` = ?', array('default_cost_retention'));
	$up_install = R::findOne('settings', ' `argument`=?', array('default_cost_install'));
	// $up_install = R::find('settings', 'argument =:argument', [':argument'=>'default_cost_install']);
	// foreach ($up_install as $key => $value) {
	// 	$value->value = 3;
	// 	R::storeAll($up_install);
	// }

if (isset($_POST['install'])) {
	$up_install->value = $_POST['cost_install'];
	R::store($up_install);
	// $up_install = R::findAll('settings', 'argument = :argument', [':argument'=>'default_cost_install']);
	// $settings->value = $_POST['cost_install'];
	// R::store($settings);
	// $up_install->value = $_POST['cost_install'];
	// R::storeAll($up_install);
}

if (isset($_POST['retention'])) {
	$up_retention->value = $_POST['cost_retention'];
	R::store($up_retention);
}
if (isset($_POST['set_inf'])) {
	$up_infblock = R::findOne('settings', ' `argument`=?', array('info_block'));
	$up_infblock->value = $_POST['inf_block'];
	R::store($up_infblock);
}
if (isset($_POST['set_percent'])) {
	$up_percent = R::findOne('settings', ' `argument`=?', array('referal_percent'));
	$up_percent->value = $_POST['percent_r'];
	R::store($up_percent);
	// var_dump($_POST['percent_r']);
}
ob_start();
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Admin Panel</title>
 </head>
 <body>
 	<p class="template" style="float: right; width: 30%;">1. Найти в Google Play приложение по фразе "". <br>2. Скачать и запустить <br> 3. Сохранить на 3 дня <br></p><br>
 	<div class="main" style="float:left; width: 70%;">
 		<form action="/core/apanel.php" method="POST">
 		<p>
		<strong>Цена за инстал:</strong>
	 	<input type="number" name="cost_install">
	 	<input type="submit" name="install">
	 	</p>
	 	<p>
		<strong>Цена за retention:</strong>
	 	<input type="number" name="cost_retention">
	 	<input type="submit" name="retention">
	 	</p>
	 	</form>
	 	<form action="/core/apanel.php" method="POST">
	 		<textarea name="inf_block" cols="30" rows="10"></textarea>
	 		<button name="set_inf">Обновить инфо-блок на странице</button>
	 	</form>
	 	<br>
	 	<form action="/core/apanel.php" method="POST">
	 		<strong>Изменить процент на:</strong>
	 		<input type="number" name="percent_r" placeholder="0.05" step="0.01" max="1">
	 		<input type="submit" name="set_percent" value="Change!">
	 	</form>
	 	<select>
	 		<option value="0"><?php echo  'Всего активных заказов: ' . count($active_orders) ?></option>
	 		<?php
	 		$user_orders = 1;
	 		foreach ($active_orders as $key => $value) {
	 			$user_of_order = R::findOne('clients', "id = ?", array($value->client_id));
	 			echo '<option value="$user_orders">' . $value->title . '('. $user_of_order->login . ')</option>';
	 			$user_orders++;
	 		}


	 		 ?>
	 	</select>
	 	<hr
>	</div>
	 	<table style="width: 100%; border: 4px double black;">
	 		<tr>
	 			<td>Логин пользователя(ид)</td>
	 			<td>Имя компании</td>
	 			<td>Имя компании 2(title_order)</td>
	 			<td>Cost</td>
	 			<td>Cost_install</td>
	 			<td>Cost_retention</td>
	 			<td>Retention</td>
	 			<td>Comment</td>
	 			<td>Скачивания по дням</td>
	 			<td> Всего скачиваний </td>
	 			<td>Баланс заказа</td>
	 			<td>Комент_Кей</td>
	 			<td>App_key</td>
	 			<td>Geo(ru,ua)</td>
	 			<td>Description</td>
	 			<td>Решение</td>
	 		</tr>
	 		<?php 
	 		foreach ($moderate as $key => $value) {
				$user_moderate = R::findOne('clients', ' id = ?', array($value->client_id));
				// print_r($key);
				// var_dump($user_moderate);
				echo '<form action="/core/apanel.php" method="POST">
				<tr>
				<td>' . $user_moderate->login . '(' . $value->client_id . ')' . '</td>
				<td>
				<textarea name="title" cols="10" rows="5">' . $value->title . '</textarea>
				<button name="title' . $i .'">Обновить</button>
				</td>
				<td><textarea name="title_order" cols="10" rows="5">' . $value->title_order . '</textarea>
				<button name="title_order' . $i .'">Обновить</button></td>

				<td><textarea name="cost" cols="10" rows="5">' . $value->cost . '</textarea>
				<button name="cost' . $i .'">Обновить</button></td>

				<td><textarea name="cost_install" cols="10" rows="5">' . $value->cost_install . '</textarea>
				<button name="cost_install' . $i .'">Обновить</button></td>

				<td><textarea name="cost_retention" cols="10" rows="5">' . $value->cost_retention . '</textarea>
				<button name="cost_retention' . $i .'">Обновить</button></td>

				<td><textarea name="retention" cols="10" rows="5">' . $value->retention . '</textarea>
				<button name="retention' . $i .'">Обновить</button></td>

				<td><textarea name="comment" cols="10" rows="5">' . $value->comment . '</textarea>
				<button name="comment' . $i .'">Обновить</button></td>

				<td><textarea name="count_daily" cols="10" rows="5">' . $value->count_daily . '</textarea>
				<button name="count_daily' . $i .'">Обновить</button></td>

				<td><textarea name="count" cols="10" rows="5">' . $value->count . '</textarea>
				<button name="count' . $i .'">Обновить</button></td>

				<td><textarea name="balance" cols="10" rows="5">' . $value->balance . '</textarea>
				<button name="balance' . $i .'">Обновить</button></td>
				<td>
				<textarea name="comment_key" cols="10" rows="5">' . $value->comment_key . '</textarea>
				<button name="comment_key' . $i .'">Обновить</button></td>
				<td>
				<textarea name="app_key" cols="10" rows="5">' . $value->app_key . '</textarea>
				<button name="app_key' . $i .'">Обновить</button></td>
				<td>
				<textarea name="geo" cols="10" rows="5">' . $value->geo . '</textarea>
				<button name="geo' . $i .'">Обновить</button></td>
				<td>
	 		<textarea name="descript" cols="10" rows="5">' . $value->description . '</textarea>
	 		<button name="set_descript' . $i .'">Обновить</button></td>
				<td><button name="confirm' . $i .'">Одобрить</button>
				<button name="cancel' . $i .'">Отклонить</button></td>
				</tr>
				</form>';
				if(isset($_POST['set_descript'.$i])){
					$value->description = $_POST['descript'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['comment'.$i])){
					$value->comment = $_POST['comment'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['cost'.$i])){
					$value->cost = $_POST['cost'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['cost_install'.$i])){
					$value->cost_install = $_POST['cost_install'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['cost_retention'.$i])){
					$value->cost_retention = $_POST['cost_retention'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['retention'.$i])){
					$value->retention = $_POST['retention'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['geo'.$i])){
					$value->geo = $_POST['geo'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['count_daily'.$i])){
					$value->count_daily = $_POST['count_daily'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['count'.$i])){
					$value->count = $_POST['count'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['title_order'.$i])){
					$value->title_order = $_POST['title_order'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if (isset($_POST["title".$i])) {
					$value->title = $_POST['title'];
					R::store($value);
					// echo "<script type=text/javascript>location.reload();
					// </script>";
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['balance'.$i])){
					$value->balance = $_POST['balance'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['comment_key'.$i])){
					$value->comment_key = $_POST['comment_key'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST['app_key'.$i])){
					$value->app_key = $_POST['app_key'];
					R::store($value);
					header("Location: /core/apanel.php");
				}
				if(isset($_POST["confirm".$i])){
					$value->status ="accept";
					R::store($value);
					// echo "<script type=text/javascript>location.reload();
					// </script>";
					header("Location: /core/apanel.php");
					// header('location: Location: /core/apanel.php');
				}
				if (isset($_POST["cancel".$i])) {
					$value->status ="cancel";
					R::store($value);
					// echo "<script type=text/javascript>location.reload();
					// </script>";
					header("Location: /core/apanel.php");
				}


				$i++;
	 		}
	 		?>
	 	</table>
<?php   ob_end_flush(); ?>
 </body>
 </html>