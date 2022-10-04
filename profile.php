<?php
	include "config/base_url.php";
	include "config/db.php";
	include "common/time.php";

	if(isset($_GET["nickname"])){
		$prep = mysqli_prepare($con,
		"SELECT b.*, u.nickname, c.name FROM blogs b
		LEFT OUTER JOIN users u ON u.id=b.author_id
		LEFT OUTER JOIN categories c ON c.id=b.category_id
		WHERE u.nickname =?");
		mysqli_stmt_bind_param($prep, "s", $_GET["nickname"]);
		mysqli_stmt_execute($prep);
		$blogs = mysqli_stmt_get_result($prep);
	}else{
		header("Location: $BASE_URL/index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Профиль</title>
	<?php include "views/head.php"; ?>
</head>
<body data-baseurl="<?=$BASE_URL?>">

<?php include "views/header.php"; ?>

<section class="container page">
	<div class="page-content">
		<div class="page-header">

		<?php
		$user_prep = mysqli_prepare($con,
		"SELECT * FROM users WHERE nickname=?");
		mysqli_stmt_bind_param($user_prep, "s", $_GET["nickname"]);
		mysqli_stmt_execute($user_prep);
		$user_info = mysqli_stmt_get_result($user_prep);
		$user = mysqli_fetch_assoc($user_info);
		if($user["nickname"] == $_SESSION["nickname"]){
		?>

			<h2>Мои блоги</h2> 
			<a class="button" href="newblog.php">Новый блог</a>

		<?php
			} else {
		?>

			<h2>Блоги <?=$user["nickname"]?></h2> 
			
		<?php
			}
		?>
		</div>

		<div class="blogs"></div>
	</div>
	<div class="page-info">
		<div class="user-profile">
			<img class="user-profile--ava" src="images/avatar.png" alt="">

			<h1><?=$_SESSION["full_name"]?></h1>
			<h2>В основном пишу про веб - разработку, на React & Redux</h2>
			<p>285 постов за все время</p>
			<a href="<?=$BASE_URL?>/update-user.php" class="button">Редактировать</a>
			<a href="<?=$BASE_URL?>/api/user/signout.php" class="button button-danger"> Выход</a>
		</div>
	</div>
</section>	
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="./js/profile.js"></script>
</body>
</html>