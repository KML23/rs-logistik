<?php
$ndate=date("Y-m-d");
$ntime=date("H:i:s");
$ndatetime="$ndate $ntime";

$batas="25";
$pages=$_GET["pages"];
$act=$_GET["act"];
$act2=$_GET["act2"];
$act3=$_GET["act3"];
$act4=$_GET["act4"];
$act5=$_GET["act5"];
$act6=$_GET["act6"];
$gid=$_GET["gid"];
$tab=$_GET["tab"];
$gid2=$_GET["gid2"];
$gid3=$_GET["gid3"];
$gid4=$_GET["gid4"];
$gid5=$_GET["gid5"];
$ghal=$_GET["ghal"];
$gket=$_GET["gket"];
$gsub=$_GET["gsub"];
$gup=$_GET["gup"];
$gm=$_GET["gm"];
$galamat=$_GET["galamat"];

$gtahun=$_GET["gtahun"];
$gbulan=$_GET["gbulan"];
$gtanggal=$_GET["gtanggal"];
$gtanggal2=$_GET["gtanggal2"];
$gname=$_GET["gname"];
$gstatus=$_GET["gstatus"];

$pages=mysqli_real_escape_string($db_result, $pages);
$act=mysqli_real_escape_string($db_result, $act);
$act2=mysqli_real_escape_string($db_result, $act2);
$act3=mysqli_real_escape_string($db_result, $act3);
$act4=mysqli_real_escape_string($db_result, $act4);
$act5=mysqli_real_escape_string($db_result, $act5);
$act6=mysqli_real_escape_string($db_result, $act6);
$tab=mysqli_real_escape_string($db_result, $tab);
$gname=mysqli_real_escape_string($db_result, $gname);
$gket=mysqli_real_escape_string($db_result, $gket);
$ghal=mysqli_real_escape_string($db_result, $ghal);
$gid=mysqli_real_escape_string($db_result, $gid);
$gid2=mysqli_real_escape_string($db_result, $gid2);
$gid3=mysqli_real_escape_string($db_result, $gid3);
$gid4=mysqli_real_escape_string($db_result, $gid4);
$gid5=mysqli_real_escape_string($db_result, $gid5);
$gsub=mysqli_real_escape_string($db_result, $gsub);
$gup=mysqli_real_escape_string($db_result, $gup);
$gm=mysqli_real_escape_string($db_result, $gm);
$gtahun=mysqli_real_escape_string($db_result, $gtahun);
$gbulan=mysqli_real_escape_string($db_result, $gbulan);
$gtanggal=mysqli_real_escape_string($db_result, $gtanggal);
$gtanggal2=mysqli_real_escape_string($db_result, $gtanggal2);
$gstatus=mysqli_real_escape_string($db_result, $gstatus);
$galamat=mysqli_real_escape_string($db_result, $galamat);

$link_back="?pages=$pages";
$ghal=($ghal>=1)? "$ghal" : "1";

$phost=$_SERVER["HTTP_HOST"];
$phost="http://localhost/logistik";

$arvar=Variable();
foreach($arvar as $kk => $dt){$$kk=$dt;}

?>