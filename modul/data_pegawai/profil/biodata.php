<?php
if(preg_match("/\bbiodata.php\b/i", $_SERVER['REQUEST_URI'])){
	exit;
}else{

$sgdarah=MasterGolDarah();
$nama_gdarah=$sgdarah[$id_goldarah]["gol_darah"];

$stpegawai=SelStatusPegawai($id_status_pegawai);
$nama_statuspegawai=$stpegawai[$id_status_pegawai]["status_pegawai"];

$sjp=SelJenisPegawai($id_jenis_pegawai);
$jenis_pegawai=$sjp[$id_jenis_pegawai]["jenis_pegawai"];

$iunit=LayananDaftar($id_unit_induk);
$nama_unit_induk=$iunit[$id_unit_induk]["nama_unit"];

$sunit=LayananDaftar($id_unit_kerja);
$nama_unit=$sunit[$id_unit_kerja]["nama_unit"];

$sjabatan=SelJabatan($id_jabatan);
$nama_jabatan=$sjabatan[$id_jabatan]["nama_jabatan"];

$stkawin=MasterStatusKawin();
$nama_status_kawin=$stkawin[$id_status_kawin]["status_kawin"];

$info_kurang="";

if($file_ktp!=""){
	$btn_ktp="<a href=\"files/ktp/$file_ktp\" class=\"btn btn-info\">KTP</a>";
}else{
	$btn_ktp="";
	$info_kurang.="<b>KTP</b>, ";
}

if($filekk!=""){
	$btn_kk="<a href=\"files/kk/$filekk\" class=\"btn btn-warning\">Kartu Keluarga</a>";
}else{
	$btn_kk="";
	$info_kurang.="<b>Kartu Keluarga</b>, ";
}

if($file_npwp!=""){
	$btn_npwp="<a href=\"files/npwp/$file_npwp\" class=\"btn btn-success\">NPWP</a>";
}else{
	$btn_npwp="";
	$info_kurang.="<b>NPWP</b>, ";
}

if($file_nbm!=""){
	$btn_nbm="<a href=\"files/ktam/$file_nbm\" class=\"btn btn-github\">KTAM/NBM</a>";
}else{
	$btn_nbm="";
	$info_kurang.="<b>KTAM/NBM</b>, ";
}

if($info_kurang!=""){
	$info_kurang=substr($info_kurang,0,-2);
	
	$alert_kurang="<div class=\"row\">
		<div class=\"col-md-12\">
			<div class=\"alert alert-warning\">
				<b><i class=\"fa fa-bullhorn\"></i> Informasi</b><br />
				Kekurangan file/data yang belum dilengkapi antara lain: $info_kurang
			</div>
		</div>
	</div>";
}else{
	$alert_kurang="";
}

echo"<div class=\"form-horizontal\">
	<div class=\"row\">
		<div class=\"col-md-4\">
			<div class=\"form-group\">
				<label class=\"col-md-4\">Nama Pegawai</label>
				<div class=\"col-md-6\">$nama_gab</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-4\">NIP</label>
				<div class=\"col-md-6\">$nip_pegawai</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-4\">Tempat Lahir</label>
				<div class=\"col-md-6\">$tmpt_lahir</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-4\">Tanggal Lahir</label>
				<div class=\"col-md-6\">$ftgl_lahir</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-4\">Jenis Kelamin</label>
				<div class=\"col-md-6\">$nama_kelamin</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-4\">HP</label>
				<div class=\"col-md-6\">$hp</div>
			</div>
		</div>
		<div class=\"col-md-4\">
			<div class=\"form-group\">
				<label class=\"col-md-4\">Email</label>
				<div class=\"col-md-6\">$email</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-4\">No. KTP</label>
				<div class=\"col-md-6\">$no_ktp</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-4\">NBM</label>
				<div class=\"col-md-6\">$no_nbm</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-4\">NPWP</label>
				<div class=\"col-md-6\">$no_npwp</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-4\">Agama</label>
				<div class=\"col-md-6\">$nama_agama</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-4\">Kawin</label>
				<div class=\"col-md-6\">$nama_status_kawin</div>
			</div>
		</div>
		<div class=\"col-md-4\">
			<div class=\"form-group\">
				<label class=\"col-md-6\">Golongan Darah</label>
				<div class=\"col-md-6\">$nama_gdarah</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-6\">Status Pegawai</label>
				<div class=\"col-md-6\">$nama_statuspegawai</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-6\">Jenis Pegawai</label>
				<div class=\"col-md-6\">$jenis_pegawai</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-6\">Unit Kerja</label>
				<div class=\"col-md-6\">$nama_unit_induk ($nama_unit)</div>
			</div>
			<div class=\"form-group\">
				<label class=\"col-md-6\">Jabatan Struktural</label>
				<div class=\"col-md-6\">$nama_jabatan</div>
			</div>
		</div>
	</div>
	<div class=\"row\">
		<div class=\"col-md-12\">
			<div class=\"form-group\">
				<label class=\"col-md-12\">Alamat</label>
				<div class=\"col-md-12\">$alamat</div>
			</div>
		</div>
	</div>
</div>
<div class=\"clearfix\"></div><br />

<div class=\"row\">
	<div class=\"col-md-6\">
		<div class=\"box box-default\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">File/ Dokumen</h3>
			</div>
			
			<div class=\"box-body\">
				$alert_kurang
				
				$btn_ktp $btn_kk $btn_npwp $btn_nbm
			</div>
		</div>
	</div>
	<div class=\"col-md-6\">
		<div class=\"box box-default\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Tanda Tangan</h3>
			</div>
			<div class=\"box-body\">
				<style>
					#signature{
						width: 300px; height: 200px;
						border: 1px solid black;
					}
				</style>
				<script src=\"$phost/plugins/sign/signature_pad.js\"></script> 
				
				<div id=\"signature\" style=''>
					<canvas id=\"signature-pad\" class=\"signature-pad\" width=\"300px\" height=\"200px\"></canvas>
				</div>
				
				$var_ttd2
				
				<br />
				<button id=\"simpanttd\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i> Simpan TTD</button>
				<a href=\"\" class=\"btn btn-info\"><i class=\"fa fa-refresh\"></i> Ulangi</a>
				
				<script>
					$(document).ready(function() {
						var signaturePad = new SignaturePad(document.getElementById('signature-pad'));
						
						$('#simpanttd').click(function(){
							var canvas_img_data = signaturePad.toDataURL('image/png');
							var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, \"\");
							
							$.ajax({
								url: 'load_data.php?gid=ttd&gid2=$kode_rm',
								data: { img_data:img_data },
								type: 'post',
								dataType: 'json',
								success: function (response) {
								   alert('Tanda Tangan Berhasil Disimpan');
								   window.location.reload();
								}
							});
						});
					});
				</script>
			</div>
		</div>
	</div>
</div>";

}
?>