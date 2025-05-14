<?php
if(preg_match("/\bprofil2.php\b/i", $_SERVER['REQUEST_URI'])){
	exit;
}else{

$var_ttd="$phost/files/ttd/pegawai/$gid.png";
$file_headers = @get_headers("$var_ttd");
if($file_headers[0] != 'HTTP/1.1 404 Not Found'){
	$var_ttd2="<img src=\"$var_ttd\" width=\"200px\" height=\"auto\" style=\"margin:10px;\"/>";
}

$foto=($foto!="")? "files/foto/$foto" : "";

if($file_ktp!=""){
	$btn_ktp="<a href=\"files/ktp/$file_ktp\" class=\"btn btn-info btn-block\"><b>KTP</b></a>";
}else{
	$btn_ktp="";
}

$nama_gab=NamaGabung($nama_pegawai, $gelar_depan, $gelar_belakang);
$ftgl_lahir=TglFormat1($tgl_lahir);

$sjk=SelStatus();
$nama_kelamin=$sjk[$jenis_kelamin][3];

$sagama=MasterAgama($id_agama);
$nama_agama=$sagama[$id_agama]["nama_agama"];

$stpegawai=SelStatusPegawai($id_status_pegawai);
$nama_statuspegawai=$stpegawai[$id_status_pegawai]["status_pegawai"];

$sjp=SelJenisPegawai($id_jenis_pegawai);
$jenis_pegawai=$sjp[$id_jenis_pegawai]["jenis_pegawai"];

if($id_spesialis>0){
	$sdoktersp=SelDokterSpesialis($id_spesialis);
	$jenis_pegawai=$sdoktersp[$id_spesialis]["spesialis"];
}else{
	$jenis_pegawai="$jenis_pegawai";
}

if($id_jabatan>0){
	$nama_jabatan="";
}else{
	$nama_jabatan="Staf";
}

$iunit=LayananDaftar($id_unit_induk);
$nama_unit_induk=$iunit[$id_unit_induk]["nama_unit"];

$sunit=LayananDaftar($id_unit_kerja);
$nama_unit=$sunit[$id_unit_kerja]["nama_unit"];

$sjabatan=SelJabatan($id_jabatan);
$nama_jabatan=$sjabatan[$id_jabatan]["nama_jabatan"];

$link_back="$link_back&gname=$gname&gsub=$gsub&ghal=$ghal";

$ak1=($act2=="" or empty($act2))? "active" : "bg-navy text-white";
$ak2=($act2=="pendidikan")? "active" : "bg-navy text-white";
$ak3=($act2=="pekerjaan")? "active" : "bg-navy text-white";
$ak4=($act2=="pelatihan")? "active" : "bg-navy text-white";
$ak5=($act2=="prestasi")? "active" : "bg-navy text-white";
$ak6=($act2=="suratijin")? "active" : "bg-navy text-white";
$ak7=($act2=="keuangan")? "active" : "bg-navy text-white";
$ak8=($act2=="keluarga")? "active" : "bg-navy text-white";

echo"<div class=\"row\">
	<div class=\"col-md-3\">
		<div class=\"box box-primary\">
			<div class=\"box-body box-profile\">
				<a href=\"$link_back\" class=\"btn bg-navy btn-block\"><i class=\"fa fa-caret-left\"></i> <b>Kembali</b></a>
				<div class=\"clearfix\"></div><br />
				
				<img class=\"profile-user-img img-responsive img-circle\" src=\"$foto\" alt=\"User profile picture\">
				<h3 class=\"profile-username text-center\">$nama_gab</h3>
				<p class=\"text-muted text-center\">$jenis_pegawai</p>

				<ul class=\"list-group list-group-unbordered\">
					<li class=\"list-group-item\">
						<b>NIP</b> <a class=\"pull-right\">$nip_pegawai</a>
					</li>
					<li class=\"list-group-item\">
						<b>Jenis Kelamin</b> <a class=\"pull-right\">$nama_kelamin</a>
					</li>
					<li class=\"list-group-item\">
						<b>Tempat Lahir</b> <a class=\"pull-right\">$tmpt_lahir</a>
					</li>
					<li class=\"list-group-item\">
						<b>Tanggal Lahir</b> <a class=\"pull-right\">$ftgl_lahir</a>
					</li>
					<li class=\"list-group-item\">
						<b>Agama</b> <a class=\"pull-right\">$nama_agama</a>
					</li>
					<li class=\"list-group-item\">
						<b>Hp</b> <a class=\"pull-right\">$hp</a>
					</li>
					<li class=\"list-group-item\">
						<b>Email</b> <a class=\"pull-right\">$email</a>
					</li>
				</ul>
				
				<a href=\"$link_back&act=input&gket=edit&gid=$id&gid2=1\" class=\"btn btn-success btn-block\"><b>Edit Biodata</b></a>
			</div>
		</div>
	</div>
	
	<div class=\"col-md-9\">
		<div class=\"nav-tabs-custom\">
			<ul class=\"nav nav-tabs\">
				<li class=\"$ak1\"><a href=\"$link_back&act=$act&gid=$gid\">Profil</a></li>
				<li class=\"$ak8\"><a href=\"$link_back&act=$act&gid=$gid&act2=keluarga\">Keluarga</a></li>
				<li class=\"$ak2\"><a href=\"$link_back&act=$act&gid=$gid&act2=pendidikan\">Pendidikan</a></li>
				<li class=\"$ak4\"><a href=\"$link_back&act=$act&gid=$gid&act2=pelatihan\">Pelatihan</a></li>
				<li class=\"$ak3\"><a href=\"$link_back&act=$act&gid=$gid&act2=pekerjaan\">Pekerjaan</a></li>
				<li class=\"$ak5\"><a href=\"$link_back&act=$act&gid=$gid&act2=prestasi\">Prestasi</a></li>
				<li class=\"$ak6\"><a href=\"$link_back&act=$act&gid=$gid&act2=suratijin\">Surat Ijin</a></li>
				<li class=\"$ak7\"><a href=\"$link_back&act=$act&gid=$gid&act2=keuangan\">Keuangan</a></li>
			</ul>
		
			<div class=\"tab-content\">
				<div class=\"tab-pane active\">
				<div class=\"clearfix\"></div><br />";
					
					switch($act2){
						default: include"profil/biodata.php"; break;
						case"pendidikan": include"profil/pendidikan.php"; break;
						case"pekerjaan": include"profil/pekerjaan.php"; break;
						case"pelatihan": include"profil/pelatihan.php"; break;
						case"prestasi": include"profil/prestasi.php"; break;
						case"suratijin": include"profil/suratijin.php"; break;
						case"keuangan": include"profil/keuangan.php"; break;
						case"keluarga": include"profil/keluarga.php"; break;
					}
					
				echo"</div>
			</div>
		</div>
	</div>
</div>";

}
?>