<?php
ini_set('display_errors', 0);
session_start();
$ss_user=$_SESSION["ss_user"];
$ss_id=$_SESSION["ss_id"];
$ss_ket=$_SESSION["ss_ket"];

if(!empty($ss_user) and !empty($ss_id)){
	header("Location:home.php?pages=home");
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Rumah Sakit Universitas Muhammadiyah Malang</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="robots" content="noindex, nofollow">

	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap/css/font-awesome.min.css">
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="plugins/iCheck/square/blue.css">


</head>

<body class="hold-transition login-page">
<div class="login-box">
	<div class="login-logo">
		<div class="fleft marginright10"><img src="images/hospital.png" alt="logo" width="130"/></div>
		<div class="align-left"><b>Rumah Sakit UMM</b></div>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>

	<div class="login-box-body">
		<p class="login-box-msg"><?php echo"$ss_ket"; ?></p>
		<form action="signin.php" method="post">
			<div class="form-group has-feedback">
				<input type="text" name="username" class="form-control" placeholder="Username" required>
				<span class="fa fa-user form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" name="password" class="form-control" placeholder="Password" required>
				<span class="fa fa-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-3.3.1.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>

<script>
$(function () {
	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%'
	});
});

</script>
</body>
</html>
<?php
unset($_SESSION["ss_ket"]);
}
?>
