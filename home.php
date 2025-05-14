<?php
ini_set('display_errors', 0);
session_start();

$ss_user=$_SESSION["ss_user"];
$ss_id=$_SESSION["ss_id"];

if(empty($ss_user) and empty($ss_id)){
	header("Location:./");
}else{

include"setting/kon.php";
include"setting/function.php";
include"setting/variable.php";

$usr=User($ss_id);
$ssnama_user=$usr["nama_user"];
$level_id=$usr["level_user"];
$ss_pegawai=$usr["id_pegawai"];

$lmn = AksesMenu($level_id);
$idmenu = "";

foreach ($lmn as $lmn1) {
    $idmenu .= "'$lmn1[0]',";
}
$idmenu = substr($idmenu, 0, -1);

$tmn = Menu($idmenu);
$list_menu = "";

foreach ($tmn["menu"] as $tmn1) {
    $lmenu2 = "";
    $class1 = "";
    $class2 = "";
    $class3 = "";

    if ($pages == $tmn1[3]) {
        $fmodul = (!empty($tmn1[4])) ? "modul/$tmn1[4]/index.php" : "";
        $class1 = "active";
        $namamenu = "$tmn1[1]";
        $idsmenu = $tmn1[0];
    } else {
        $class1 = "";
    }

    if (!empty($tmn1[5]) && is_array($tmn1[5])) {
        foreach ($tmn1[5] as $lm51) {
            $class2 = "";

            if ($pages == $lm51[3]) {
                $fmodul = (!empty($lm51[4])) ? "modul/$lm51[4]/index.php" : "";
                $class2 = "class=\"active\"";
                $class3 = "active";
                $namamenu = "$tmn1[1] / $lm51[1]";
                $idsmenu = $lm51[0];
            }

            // Menampilkan ikon pada sub-menu jika ada
            $faicon_sub = !empty($lm51[2]) ? $lm51[2] : "fa-circle-o";

            $lmenu2 .= "<li $class2>
                <a href=\"?pages=$lm51[3]\" title=\"$lm51[1]\">
                    <i class=\"fa $faicon_sub\"></i> $lm51[1]
                </a>
            </li>";
        }

        $lmenu2 = "<ul class=\"treeview-menu\">$lmenu2</ul>";
        $href2 = "#";
        $cstre = "treeview";
        $tpull = "<i class=\"fa fa-angle-left pull-right\"></i>";
    } else {
        $lmenu2 = "";
        $href2 = "?pages=$tmn1[3]";
        $class3 = "$class1";
        $cstre = "";
        $tpull = "";
    }

    // Menampilkan ikon utama pada menu
    $faicon_main = !empty($tmn1[2]) ? $tmn1[2] : "fa-folder";

    $list_menu .= "<li class=\"$class3 $cstre\">
        <a href=\"$href2\" title=\"$tmn1[1]\">
            <i class=\"fa $faicon_main\"></i> $tmn1[1] $tpull
        </a>
        $lmenu2
    </li>";
}

if (empty($list_menu)) {
    $list_menu = "";
}

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
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="plugins/select2/select2.min.css">
	<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
	<link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.min.css">
	<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

	<script src="plugins/jQuery/jQuery-3.3.1.js"></script>
	
	<style>
		.text-white a{
			color:#ffffff !important;
		}
		
		.text-white a:hover{
			color:#00ffff !important;
		}
	</style>
</head>

<body class="hold-transition sidebar-mini skin-blue">
<div class="wrapper">

<header class="main-header">
	<!-- Logo -->
	<span class="logo">
		<span class="logo-mini"><img src="images/hospital.png" width="45" height="45" alt="logo"></span>
		<span class="logo-lg"><img src="images/hospital.png" width="45" height="45" alt="logo"></span>
	</span>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</a>

	<span class="title-web hidden-xs">Rumah Sakit Universitas Muhammadiyah Malang</span>

	<div class="navbar-custom-menu">
		<ul class="nav navbar-nav">
			<li class="messages-menu">
				<a href="<?php echo"?pages=komentar"; ?>">
					<i class="fa fa-envelope-o"></i>
					<span class="label label-success"><?php echo "$newpesan"; ?></span>
				</a>
			</li>
			<li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-user"></i>
					<span class="hidden-xs"><?php echo"$nama_user"; ?></span>
				</a>
				<ul class="dropdown-menu">
					<li class="user-footer">
						<div class="pull-left">
							<a href="" class="btn btn-primary btn-flat">Profile</a>
						</div>
						<div class="pull-right">
							<a href="signout.php" class="btn btn-primary btn-flat">Sign out</a>
						</div>
					</li>
					<li class="user-header">
						<p>
							<?php echo"$nama_user"; ?>
							<small>Last Login</small>
						</p>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>
</header>

<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu">
			<?php echo $list_menu; ?>
		</ul>
	</section>
</aside>

<div class="content-wrapper">
	<section class="content-header">
		<h1><?php echo"$namamenu"; ?></h1>
	</section>

	<section class="content">
		<?php
			if(!strstr($fmodul, "//")){
            	include"$fmodul";
        	}
        ?>
	</section>

</div>

<footer class="main-footer">
	<div class="pull-right hidden-xs">
		Developed by Infokom UMM
	</div>
	Copyright &copy; 2017 All rights reserved. Themes by <a href="http://almsaeedstudio.com">Almsaeed Studio</a>
</footer>

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="plugins/select2/select2.full.js"></script>
<script src="plugins/typeahead/typeahead.min.js"></script>
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="dist/js/moment.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="plugins/fastclick/fastclick.min.js"></script>
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="dist/js/app.min.js"></script>


<script>
$(function () {
	$(".timepicker").timepicker({
    	showInputs: false,
		showMeridian : false,
		minuteStep: 1
    });

	$(".datepicker").datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	});

	$('.textarea').wysihtml5();
	$('[data-mask]').inputmask();
	$('.select2').select2();

	$('#dttable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'pageLength'	: 50,
	  'buttons'		: [ 'copy', 'excel', 'pdf', 'colvis' ]
    });

   	$("#propinsi").change(function(){
		var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();
		if(kecv!=0){
			$("#hprov").val(kecc);
			$("#kota").removeAttr("disabled").load("load_data.php?gid=propinsi&gid2="+kecv,
				function(){
					$("#kota").trigger("liszt:updated");
				}
			);

			$("#kec").removeAttr("disabled").load("load_data.php?gid=&gid2="+kecv,
				function(){
					$("#kec").trigger("liszt:updated");
				}
			);

		}
	}).each(function(){
	 	var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();

		if(kecv!=0 && kecv!=null){
			$("#hprov").val(kecc);
			var seldesa=$("#hkota").val();
			var lload="load_data.php?gid=propinsi&gid2="+kecv;

			if(seldesa!=0){ lload+="&gid3="+seldesa; }

			$("#kota").removeAttr("disabled").load(lload,
				function(){
					$("#kota").trigger("liszt:updated");
				}
			);
		}
	});

	$("#kota").change(function(){
		var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();
		if(kecv!=0){
			$("#hkota").val(kecc);
			$("#kec").removeAttr("disabled").load("load_data.php?gid=kota&gid2="+kecv,
				function(){
					$("#kec").trigger("liszt:updated");
				}
			);
		}
	}).each(function(){
		var kecv=$("#hkota").val();
		var kecc=$(this).children(':selected').text();

		if(kecv!=0 && kecv!=null){
			$("#hkota").val(kecc);
			var seldesa=$("#hkec").val();
			var lload="load_data.php?gid=kota&gid2="+kecv;

			if(seldesa!=0){ lload+="&gid3="+seldesa; }

			$("#kec").removeAttr("disabled").load(lload,
				function(){
					$("#kec").trigger("liszt:updated");
				}
			);

			$("#desa").removeAttr("disabled").load("load_data.php?gid=&gid2="+kecv,
				function(){
					$("#desa").trigger("liszt:updated");
				}
			);
		}
	});

	$("#kec").change(function(){
		var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();
		if(kecv!=0){
			$("#hkec").val(kecc);
			$("#desa").removeAttr("disabled").load("load_data.php?gid=kec&gid2="+kecv,
				function(){
					$("#desa").trigger("liszt:updated");
				}
			);
		}
	}).each(function(){
	 	var kecv=$("#hkec").val();
		var kecc=$(this).children(':selected').text();

		if(kecv!=0 && kecv!=null){
			$("#hkec").val(kecc);
			var seldesa=$("#hdesa").val();
			var lload="load_data.php?gid=kec&gid2="+kecv;

			if(seldesa!=0){ lload+="&gid3="+seldesa; }

			$("#desa").removeAttr("disabled").load(lload,
				function(){
					$("#desa").trigger("liszt:updated");
				}
			);
		}
	});

	//form daftar
	$("#propinsi_asal").change(function(){
		var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();
		if(kecv!=0){
			$("#hprov_asal").val(kecc);
			$("#kota_asal").removeAttr("disabled").load("load_data.php?gid=propinsi&gid2="+kecv,
				function(){
					$("#kota_asal").trigger("liszt:updated");
				}
			);

			$("#kec_asal").removeAttr("disabled").load("load_data.php?gid=&gid2="+kecv,
				function(){
					$("#kec_asal").trigger("liszt:updated");
				}
			);

		}
	}).each(function(){
	 	var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();

		if(kecv!=0 && kecv!=null){
			$("#hprov_asal").val(kecc);
			var seldesa=$("#hkota_asal").val();
			var lload="load_data.php?gid=propinsi&gid2="+kecv;

			if(seldesa!=0){ lload+="&gid3="+seldesa; }

			$("#kota_asal").removeAttr("disabled").load(lload,
				function(){
					$("#kota_asal").trigger("liszt:updated");
				}
			);
		}
	});

	$("#kota_asal").change(function(){
		var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();
		if(kecv!=0){
			$("#hkota_asal").val(kecc);
			$("#kec_asal").removeAttr("disabled").load("load_data.php?gid=kota&gid2="+kecv,
				function(){
					$("#kec_asal").trigger("liszt:updated");
				}
			);
		}
	}).each(function(){
		var kecv=$("#hkota_asal").val();
		var kecc=$(this).children(':selected').text();

		if(kecv!=0 && kecv!=null){
			$("#hkota_asal").val(kecc);
			var seldesa=$("#hkec_asal").val();
			var lload="load_data.php?gid=kota&gid2="+kecv;

			if(seldesa!=0){ lload+="&gid3="+seldesa; }

			$("#kec_asal").removeAttr("disabled").load(lload,
				function(){
					$("#kec_asal").trigger("liszt:updated");
				}
			);

			$("#desa_asal").removeAttr("disabled").load("load_data.php?gid=&gid2="+kecv,
				function(){
					$("#desa_asal").trigger("liszt:updated");
				}
			);
		}
	});

	$("#kec_asal").change(function(){
		var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();
		if(kecv!=0){
			$("#hkec_asal").val(kecc);
			$("#desa_asal").removeAttr("disabled").load("load_data.php?gid=kec&gid2="+kecv,
				function(){
					$("#desa_asal").trigger("liszt:updated");
				}
			);
		}
	}).each(function(){
	 	var kecv=$("#hkec_asal").val();
		var kecc=$(this).children(':selected').text();

		if(kecv!=0 && kecv!=null){
			$("#hkec_asal").val(kecc);
			var seldesa=$("#hdesa_asal").val();
			var lload="load_data.php?gid=kec&gid2="+kecv;

			if(seldesa!=0){ lload+="&gid3="+seldesa; }

			$("#desa_asal").removeAttr("disabled").load(lload,
				function(){
					$("#desa_asal").trigger("liszt:updated");
				}
			);
		}
	});

	$("#propinsi_sekarang").change(function(){
		var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();
		if(kecv!=0){
			$("#hprov_sekarang").val(kecc);
			$("#kota_sekarang").removeAttr("disabled").load("load_data.php?gid=propinsi&gid2="+kecv,
				function(){
					$("#kota_sekarang").trigger("liszt:updated");
				}
			);

			$("#kec_sekarang").removeAttr("disabled").load("load_data.php?gid=&gid2="+kecv,
				function(){
					$("#kec_sekarang").trigger("liszt:updated");
				}
			);

		}
	}).each(function(){
	 	var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();

		if(kecv!=0 && kecv!=null){
			$("#hprov_sekarang").val(kecc);
			var seldesa=$("#hkota_sekarang").val();
			var lload="load_data.php?gid=propinsi&gid2="+kecv;

			if(seldesa!=0){ lload+="&gid3="+seldesa; }

			$("#kota_sekarang").removeAttr("disabled").load(lload,
				function(){
					$("#kota_sekarang").trigger("liszt:updated");
				}
			);
		}
	});

	$("#kota_sekarang").change(function(){
		var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();
		if(kecv!=0){
			$("#hkota_sekarang").val(kecc);
			$("#kec_sekarang").removeAttr("disabled").load("load_data.php?gid=kota&gid2="+kecv,
				function(){
					$("#kec_sekarang").trigger("liszt:updated");
				}
			);
		}
	}).each(function(){
		var kecv=$("#hkota_sekarang").val();
		var kecc=$(this).children(':selected').text();

		if(kecv!=0 && kecv!=null){
			$("#hkota_sekarang").val(kecc);
			var seldesa=$("#hkec_sekarang").val();
			var lload="load_data.php?gid=kota&gid2="+kecv;

			if(seldesa!=0){ lload+="&gid3="+seldesa; }

			$("#kec_sekarang").removeAttr("disabled").load(lload,
				function(){
					$("#kec_sekarang").trigger("liszt:updated");
				}
			);

			$("#desa_sekarang").removeAttr("disabled").load("load_data.php?gid=&gid2="+kecv,
				function(){
					$("#desa_sekarang").trigger("liszt:updated");
				}
			);
		}
	});

	$("#kec_sekarang").change(function(){
		var kecv=$(this).val();
		var kecc=$(this).children(':selected').text();
		if(kecv!=0){
			$("#hkec_sekarang").val(kecc);
			$("#desa_sekarang").removeAttr("disabled").load("load_data.php?gid=kec&gid2="+kecv,
				function(){
					$("#desa_sekarang").trigger("liszt:updated");
				}
			);
		}
	}).each(function(){
	 	var kecv=$("#hkec_sekarang").val();
		var kecc=$(this).children(':selected').text();

		if(kecv!=0 && kecv!=null){
			$("#hkec_sekarang").val(kecc);
			var seldesa=$("#hdesa_sekarang").val();
			var lload="load_data.php?gid=kec&gid2="+kecv;

			if(seldesa!=0){ lload+="&gid3="+seldesa; }

			$("#desa_sekarang").removeAttr("disabled").load(lload,
				function(){
					$("#desa_sekarang").trigger("liszt:updated");
				}
			);
		}
	});

	$("#id_unit_induk").change(function(){
		var kecv=$(this).val();
		if(kecv!=0){
			$("#id_unitkerja").removeAttr("disabled").load("load_data.php?gid=unit&gid2="+kecv,
				function(){
					$("#id_unitkerja").trigger("liszt:updated");
				}
			);
		}
	}).each(function(){
	 	var kecv=$(this).val();

		if(kecv!=0 && kecv!=null){
			var seldesa=$("#id_unitkerja").val();
			var lload="load_data.php?gid=unit&gid2="+kecv;

			if(seldesa!=0){ lload+="&gid3="+seldesa; }

			$("#id_unitkerja").removeAttr("disabled").load(lload,
				function(){
					$("#id_unitkerja").trigger("liszt:updated");
				}
			);
		}
	});

	// Typeahead
	$(".typeahead").each(function(i, el){
		var $this = $(el),
			opts = {
				name: $this.attr('name') ? $this.attr('name') : ($this.attr('id') ? $this.attr('id') : 'tt')
			};

		if($this.hasClass('tagsinput'))
			return;

		if($this.data('local')){
			var local = $this.data('local');
			local = local.replace(/\s*,\s*/g, ',').split(',');
			opts['local'] = local;
		}

		if($this.data('prefetch')){
			var prefetch = $this.data('prefetch');
			opts['prefetch'] = prefetch;
		}

		if($this.data('remote')){
			var remote = $this.data('remote');
			opts['remote'] = remote;
		}

		if($this.data('template')){
			var template = $this.data('template');
			opts['template'] = template;
			opts['engine'] = Hogan;
		}

		$this.typeahead(opts);
	});
});

function Onumber(obj) {
	var a = "^[0-9]*$";
    rx = new RegExp(a);

    if (!obj.value.match(rx)){
        if (obj.lastMatched){
            obj.value = obj.lastMatched;
        }else{
            obj.value = "";
        }
    }else{
        obj.lastMatched = obj.value;
    }
}

 function copas(f) {
	if(f.copyto.checked == true) {
		f.propinsi_sekarang.value = f.propinsi_asal.value;
		f.alamat_sekarang.value = f.alamatpasien_asal.value;
		f.rt_sekarang.value = f.rt_asal.value;
		f.rw_sekarang.value = f.rw_asal.value;

		f.hpropinsi_sekarang.value = f.propinsi_asal.value;
		f.hkota_sekarang.value = f.kota_asal.value;
		f.hkec_sekarang.value = f.kecamatan_asal.value;
		f.hdesa_sekarang.value = f.kelurahan_asal.value;

		$("#kota_sekarang").removeAttr("disabled").load("load_data.php?gid=propinsi&gid2="+f.propinsi_asal.value+"&gid3="+f.kota_asal.value,
			function(){
				$("#kota_sekarang").trigger("liszt:updated");
			}
		);

		$("#kec_sekarang").removeAttr("disabled").load("load_data.php?gid=kota&gid2="+f.kota_asal.value+"&gid3="+f.kecamatan_asal.value,
			function(){
				$("#kec_sekarang").trigger("liszt:updated");
			}
		);

		$("#desa_sekarang").removeAttr("disabled").load("load_data.php?gid=kec&gid2="+f.kecamatan_asal.value+"&gid3="+f.kelurahan_asal.value,
			function(){
				$("#desa_sekarang").trigger("liszt:updated");
			}
		);
	}
}

function PopUp(a) {
	params  = 'width='+screen.width;
	params += ', height='+screen.height;
	params += ', top=0, left=0'
	params += ', fullscreen=yes';
    window.open(a, "_blank", params);
}

/*$(document).ready(function(){
	$(document).on('keydown', '.potongan', function() {
        var harga_awal = parseInt(document.getElementById('harga_awal').value);
        var besarppn = (parseInt(document.getElementById('ppn').value) / 100) * parseInt(document.getElementById('harga_awal').value);
        var besarmargin = (parseInt(document.getElementById('margin').value) / 100) * parseInt(document.getElementById('harga_awal').value);
        var total_pertama = harga_awal + besarppn + besarmargin;
        var besarpotongan = (parseInt(document.getElementById('potongan').value) / 100) * total_pertama;
        var harga_jual =  total_pertama - besarpotongan;
        document.getElementById('harga_jual').value = harga_jual;
    });
});

$(document).ready(function(){
	$(document).on('keydown', '.jumlah_beli', function() {
        var harga_total_pembelian_detail = parseInt(document.getElementById('harga_obat').value) * parseInt(document.getElementById('jumlah_beli').value);
        document.getElementById('sub_total_detail_pembelian').value = harga_total_pembelian_detail;
    });
});*/

</script>

</body>
</html>
<?php
mysqli_close($db_result);
}
?>
