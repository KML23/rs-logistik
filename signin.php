<?php
session_start();
include"setting/kon.php";

$username=$_POST["username"];
$password=$_POST["password"];

if($username==""){
	$_SESSION["ss_ket"]="Username Masih Kosong!";
	header("Location:./");
}elseif($password==""){
	$_SESSION["ss_ket"]="Maaf Username dan Password Anda Salah!";
	header("Location:./");
}else{
	$username=mysqli_escape_string($db_result, $username);
	$password=mysqli_escape_string($db_result, $password);
	
	#cek login langsung data sendiri
	#$sqld="select * from db_user where username=\"$username\" and password=password(\"$password\") and status=\"1\" and hapus=\"0\"";
	$sqld="select * from db_user where username=\"$username\" and status=\"1\" and hapus=\"0\"";
	$data=mysqli_query($db_result, $sqld);
	$ndata=mysqli_num_rows($data);
	if($ndata>0){
		$fdata=mysqli_fetch_assoc($data);
		extract($fdata);
		$_SESSION["ss_user"]="$username";
		$_SESSION["ss_id"]="$id";
		
		header("Location:home.php?pages=home");
	}else{
		$_SESSION["ss_ket"]="Maaf Username tidak Ditemukan";
		header("Location:./");
	}
}

?>
<!DOCTYPE html>
<html><head>
	<title>Rumah Sakit Universitas Muhammadiyah Malang</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="noindex, nofollow">
</head><body>
</body></html>
