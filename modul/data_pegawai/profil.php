<?php
if(preg_match("/\bprofil.php\b/i", $_SERVER['REQUEST_URI'])){
	exit;
}else{

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

/*keluarga*/
$skel=SelKeluarga();
$sqld2="select * from peg_keluarga where id_pegawai=\"$id\" and hapus=\"0\"";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_keluarga++;
		$nik=$fdata2["nik"];
		$tempat_lahir2=$fdata2["tempat_lahir"];
		$nama_keluarga=$fdata2["nama_keluarga"];
		
		$tanggal_lahir2=$fdata2["tanggal_lahir"];
		$ftanggal_lahir2=TglFormat1($tanggal_lahir2);
		
		$id_status_keluarga=$fdata2["id_status_keluarga"];
		$hkeluarga=$skel[$id_status_keluarga]["status_keluarga"];
		
		$td_keluarga.="<tr>
			<td>$no_keluarga</td>
			<td>$nama_keluarga</td>
			<td>$hkeluarga</td>
			<td>$nik</td>
			<td>$tempat_lahir2</td>
			<td>$ftanggal_lahir2</td>
		</tr>";
	}
}

/*pendidikan*/
$spend=SelPendidikan();
$sqld2="select * from peg_pendidikan where id_pegawai=\"$id\" and hapus=\"0\" order by tahun_lulus asc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_pendidikan++;
		$nama_sekolah=$fdata2["nama_sekolah"];
		$nama_prodi=$fdata2["nama_prodi"];
		$keahlian=$fdata2["keahlian"];
		$kode_ijazah=$fdata2["kode_ijazah"];
		$tahun_lulus=$fdata2["tahun_lulus"];
		$kota_sekolah=$fdata2["kota_sekolah"];
		
		$id_tingkat_pendidikan=$fdata2["id_tingkat_pendidikan"];
		$nama_pendidikan=$spend[$id_tingkat_pendidikan]["nama_pendidikan"];
		
		if($id_pendidikan==$id_tingkat_pendidikan){
			$gab_sekolah="($nama_pendidikan) $nama_prodi $nama_sekolah";
		}
		
		$td_pendidikan.="<tr>
			<td>$no_pendidikan</td>
			<td>$nama_pendidikan</td>
			<td>$nama_sekolah</td>
			<td>$nama_prodi</td>
			<td>$kota_sekolah</td>
			<td>$keahlian</td>
			<td>$kode_ijazah</td>
			<td>$tahun_lulus</td>
		</tr>";
	}
}

/*pelatihan*/
$spend=SelPendidikanNf();
$sqld2="select * from peg_pendnf where id_pegawai=\"$id\" and hapus=\"0\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_pelatihan++;
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_akhir=$fdata2["tgl_akhir"];
		$id_jenis_nf=$fdata2["id_jenis_nf"];
		$judul_pelatihan=$fdata2["judul_pelatihan"];
		$tempat_pelatihan=$fdata2["tempat_pelatihan"];
		$bagian=$fdata2["bagian"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_akhir);
		$nama_jenis=$spend[$id_jenis_nf]["nama_pendnf"];
		
		$td_pelatihan.="<tr>
			<td>$no_pelatihan</td>
			<td>$nama_jenis</td>
			<td>$judul_pelatihan</td>
			<td>$tempat_pelatihan</td>
			<td>$bagian</td>
			<td>$ftgl1</td>
			<td>$ftgl2</td>
		</tr>";
	}
}

/*riwayat kerja*/
$sqld2="select * from peg_riw_unitkerja where id_pegawai=\"$id\" and hapus=\"0\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_kerja++;
		$no_surat=$fdata2["no_surat"];
		$id_unitkerja=$fdata2["id_unitkerja"];
		$id_jabatan=$fdata2["id_jabatan"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_akhir=$fdata2["tgl_akhir"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_akhir);
		
		$sunit=LayananDaftar($id_unitkerja);
		$nama_unit2=$sunit[$id_unitkerja]["nama_unit"];
		
		$sjabatan=SelJabatan($id_jabatan);
		$nama_jabatan2=$sjabatan[$id_jabatan]["nama_jabatan"];
		
		$td_pekerjaan.="<tr>
			<td>$no_kerja</td>
			<td>$no_surat</td>
			<td>$nama_unit2</td>
			<td>$nama_jabatan2</td>
			<td>$ftgl2</td>
		</tr>";
	}
}

/*pangkat golongan*/
$sqld2="select * from peg_kepangkatan where id_pegawai=\"$id\" and hapus=\"0\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_pangkat++;
		$no_surat=$fdata2["no_surat"];
		$id_pangkat=$fdata2["id_pangkat"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_akhir=$fdata2["tgl_akhir"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_akhir);
		
		$sgolongan=SelGolongan($id_pangkat);
		$nama_pangkat=$sgolongan[$id_pangkat]["nama_golongan"];
		
		$td_pangkat.="<tr>
			<td>$no_pangkat</td>
			<td>$no_surat</td>
			<td>$nama_pangkat</td>
			<td>$ftgl2</td>
		</tr>";
	}
}

/*kepanitiaan*/
$sqld2="select * from peg_kepanitiaan where id_pegawai=\"$id\" and hapus=\"0\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_kpanitian++;
		$nama_kepanitiaan=$fdata2["nama_kepanitiaan"];
		$sebagai=$fdata2["sebagai"];
		$bagian=$fdata2["bagian"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_akhir=$fdata2["tgl_akhir"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_akhir);
		
		$td_kepanitiaan.="<tr>
			<td>$no_kpanitian</td>
			<td>$nama_kepanitiaan</td>
			<td>$sebagai</td>
			<td>$bagian</td>
			<td>$ftgl1</td>
			<td>$ftgl2</td>
		</tr>";
	}
}

/*organisasi*/
$sqld2="select * from peg_organisasi where id_pegawai=\"$id\" and hapus=\"0\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_org++;
		$nama_organisasi=$fdata2["nama_organisasi"];
		$sebagai=$fdata2["sebagai"];
		$bagian=$fdata2["bagian"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_akhir=$fdata2["tgl_akhir"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_akhir);
		
		$td_organisasi.="<tr>
			<td>$no_org</td>
			<td>$nama_organisasi</td>
			<td>$sebagai</td>
			<td>$bagian</td>
			<td>$ftgl1</td>
			<td>$ftgl2</td>
		</tr>";
	}
}					

/*prestasi*/
$sqld2="select * from peg_penghargaan where id_pegawai=\"$id\" and hapus=\"0\" and id_jenis_penghargaan=\"1\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_prestasi++;
		$keterangan=$fdata2["keterangan"];
		$no_surat=$fdata2["no_surat"];
		$tgl_surat=$fdata2["tgl_surat"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_akhir=$fdata2["tgl_akhir"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_akhir);
		$ftgl3=TglFormat1($tgl_surat);
		
		$td_prestasi.="<tr>
			<td>$no_prestasi</td>
			<td>$no_surat</td>
			<td>$keterangan</td>
			<td>$ftgl3</td>
		</tr>";
	}
}

/*sanksi*/
$sqld2="select * from peg_penghargaan where id_pegawai=\"$id\" and hapus=\"0\" and id_jenis_penghargaan=\"2\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_saksi++;
		$keterangan=$fdata2["keterangan"];
		$no_surat=$fdata2["no_surat"];
		$tgl_surat=$fdata2["tgl_surat"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_akhir=$fdata2["tgl_akhir"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_akhir);
		$ftgl3=TglFormat1($tgl_surat);
		
		$td_sanksi.="<tr>
			<td>$no_saksi</td>
			<td>$no_surat</td>
			<td>$keterangan</td>
			<td>$ftgl3</td>
		</tr>";
	}
}



$sqld2="select * from peg_surat_keterangan where hapus=\"0\" and id_pegawai=\"$id\" and id_jenis=\"1\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	$fdata2=mysqli_fetch_assoc($data2);
	$nstr++;
	$no_str=$fdata2["no_surat"];
	$tgl_surat=$fdata2["tgl_surat"];
	$tgl_awal=$fdata2["tgl_awal"];
	$tgl_akhir=$fdata2["tgl_akhir"];
	
	if($nstr==1){
		$nostr2="<strong><i class=\"fa fa-envelope-open margin-r-5\"></i> No. STR</strong>
		<p class=\"text-muted\">$no_str</p>
		<hr />";
	}
	
	$ftgl1=TglFormat1($tgl_awal);
	$ftgl2=TglFormat1($tgl_akhir);
	$ftgl3=TglFormat1($tgl_surat);
	
	$td_str.="<tr>
		<td>$nstr</td>
		<td>$no_str</td>
		<td>$ftgl3</td>
		<td>$ftgl1</td>
		<td>$ftgl2</td>
	</tr>";
	
}

$sqld2="select * from peg_surat_keterangan where hapus=\"0\" and id_pegawai=\"$id\" and id_jenis=\"2\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	$fdata2=mysqli_fetch_assoc($data2);
	$nsip++;
	$no_sip=$fdata2["no_surat"];
	$tgl_surat=$fdata2["tgl_surat"];
	$tgl_awal=$fdata2["tgl_awal"];
	$tgl_akhir=$fdata2["tgl_akhir"];
	
	if($nsip==1){
		$nosip2="
		<strong><i class=\"fa fa-envelope-open margin-r-5\"></i> No. SIP</strong>
		<p class=\"text-muted\">$no_sip</p>
		<hr />";
	}
	
	$ftgl1=TglFormat1($tgl_awal);
	$ftgl2=TglFormat1($tgl_akhir);
	$ftgl3=TglFormat1($tgl_surat);
	
	$td_ijin_praktek.="<tr>
		<td>$nsip</td>
		<td>$no_sip</td>
		<td>$ftgl3</td>
		<td>$ftgl1</td>
		<td>$ftgl2</td>
	</tr>";
}

$ket_sipstr="$nostr2 $nosip2";

$var_ttd="$phost/files/ttd/pegawai/$gid.png";
$file_headers = @get_headers("$var_ttd");
if($file_headers[0] != 'HTTP/1.1 404 Not Found'){
	$var_ttd2="<img src=\"$var_ttd\" width=\"100%\" height=\"auto\"/>";
}

$link_back="$link_back&gname=$gname&gsub=$gsub&ghal=$ghal";

echo"<div class=\"row\">
	<div class=\"col-md-4\">
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

				<a href=\"$link_back&act=input&gket=edit&gid=$id&gid2=1\" class=\"btn btn-success btn-block\"><b>Edit</b></a>
				$btn_ktp
			</div>
		</div>

		<div class=\"box box-primary\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Background</h3>
			</div>
			<div class=\"box-body\">
				<strong><i class=\"fa fa-graduation-cap margin-r-5\"></i> Pendidikan</strong>
				<p class=\"text-muted\">$gab_sekolah</p>
				<hr />

				<strong><i class=\"fa fa-map-marker margin-r-5\"></i> Alamat</strong>
				<p class=\"text-muted\">$alamat</p>
				<hr />
				
				<strong><i class=\"fa fa-building margin-r-5\"></i> Unit Kerja</strong>
				<p class=\"text-muted\">$nama_unit_induk ($nama_unit)</p>
				<hr />
				
				<strong><i class=\"fa fa-user-secret margin-r-5\"></i> Jabatan</strong>
				<p class=\"text-muted\">$nama_jabatan</p>
				<hr />
				
				<strong><i class=\"fa fa-vcard margin-r-5\"></i> Status Pegawai</strong>
				<p class=\"text-muted\">$nama_statuspegawai</p>
				<hr />
				
				$ket_sipstr
			</div>
		</div>
		
		<div class=\"box box-primary\">
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
								url: 'load_data.php?gid=ttdpegawai&gid2=$gid',
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
	
	<div class=\"col-md-8\">
		<div class=\"box box-info\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Data Keluarga</h3>

				<div class=\"box-tools pull-right\">
					<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
				</div>
			</div>
			
			<div class=\"box-body\">
				<div class=\"row\">
					<div class=\"col-md-12 text-right\">
						<a href=\"?pages=data-keluarga&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Keluarga</a>
					</div>
				</div>
				<div class=\"clearfix\"></div><br />
				
				<div class=\"table-responsive\">
					<table class=\"table no-margin table-bordered table-hover\">
						<thead>
							<tr>
								<th width=\"50\">No</th>
								<th>Nama</th>
								<th>Status Keluarga</th>
								<th>NIK</th>
								<th>Tempat Lahir</th>
								<th>Tanggal Lahir</th>
							</tr>
						</thead>
						<tbody>
							$td_keluarga
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class=\"box box-info\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Data Pendidikan</h3>

				<div class=\"box-tools pull-right\">
					<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
				</div>
			</div>
			
			<div class=\"box-body\">
				<div class=\"row\">
					<div class=\"col-md-12 text-right\">
						<a href=\"?pages=data-pendidikan&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Pendidikan</a>
					</div>
				</div>
				<div class=\"clearfix\"></div><br />
				
				<div class=\"table-responsive\">
					<table class=\"table no-margin table-bordered table-hover\">
						<thead>
							<tr>
								<th width=\"50\">No</th>
								<th>Pendidikan</th>
								<th>Sekolah/Universitas</th>
								<th>Program Studi/Jurusan</th>
								<th>Kota Sekolah /Univ.</th>
								<th>Keahlian</th>
								<th>Nomor Ijazah</th>
								<th>Tahun Lulus</th>
							</tr>
						</thead>
						<tbody>
							$td_pendidikan
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class=\"box box-info\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Data Pendidikan Nonformal (Pelatihan)</h3>

				<div class=\"box-tools pull-right\">
					<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
				</div>
			</div>
			
			<div class=\"box-body\">
				<div class=\"row\">
					<div class=\"col-md-12 text-right\">
						<a href=\"?pages=data-pelatihan&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Kegiatan</a>
					</div>
				</div>
				<div class=\"clearfix\"></div><br />
				
				<div class=\"table-responsive\">
					<table class=\"table no-margin table-bordered table-hover\">
						<thead>
							<tr>
								<th width=\"50\">No</th>
								<th>Jenis Kegiatan</th>
								<th>Kegiatan</th>
								<th>Lokasi</th>
								<th>Sebagai</th>
								<th>Tanggal Awal</th>
								<th>Tanggal Akhir</th>
							</tr>
						</thead>
						<tbody>
							$td_pelatihan
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class=\"box box-info\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Pekerjaan</h3>

				<div class=\"box-tools pull-right\">
					<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
				</div>
			</div>
			
			<div class=\"box-body\">
				<div class=\"row\">
					<div class=\"col-md-12 text-right\">
						<a href=\"?pages=data-riwkerja&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Pekerjaan</a>
					</div>
				</div>
				<div class=\"clearfix\"></div><br />
				
				<div class=\"table-responsive\">
					<table class=\"table no-margin table-bordered table-hover\">
						<thead>
							<tr>
								<th width=\"50\">No</th>
								<th>No. SK</th>
								<th>Unit Kerja</th>
								<th>Jabatan</th>
								<th>TMT</th>
							</tr>
						</thead>
						<tbody>
							$td_pekerjaan
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class=\"box box-info\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Pangkat/Golongan</h3>

				<div class=\"box-tools pull-right\">
					<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
				</div>
			</div>
			
			<div class=\"box-body\">
				<div class=\"row\">
					<div class=\"col-md-12 text-right\">
						<a href=\"?pages=data-pangkat&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Pangkat</a>
					</div>
				</div>
				<div class=\"clearfix\"></div><br />
				
				<div class=\"table-responsive\">
					<table class=\"table no-margin table-bordered table-hover\">
						<thead>
							<tr>
								<th width=\"50\">No</th>
								<th>No. SK</th>
								<th>Pangkat/Golongan</th>
								<th>TMT</th>
							</tr>
						</thead>
						<tbody>
							$td_pangkat
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class=\"box box-info\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Kepanitiaan</h3>

				<div class=\"box-tools pull-right\">
					<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
				</div>
			</div>
			
			<div class=\"box-body\">
				<div class=\"row\">
					<div class=\"col-md-12 text-right\">
						<a href=\"?pages=data-kepanitiaan&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Kepanitiaan</a>
					</div>
				</div>
				<div class=\"clearfix\"></div><br />
				
				<div class=\"table-responsive\">
					<table class=\"table no-margin table-bordered table-hover\">
						<thead>
							<tr>
								<th width=\"50\">No</th>
								<th>Kepanitiaan</th>
								<th>Unit/Sie.</th>
								<th>Sebagai</th>
								<th>Tanggal Awal</th>
								<th>Tanggal Akhir</th>
							</tr>
						</thead>
						<tbody>
							$td_kepanitiaan
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class=\"box box-info\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Organisasi</h3>

				<div class=\"box-tools pull-right\">
					<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
				</div>
			</div>
			
			<div class=\"box-body\">
				<div class=\"row\">
					<div class=\"col-md-12 text-right\">
						<a href=\"?pages=data-organisasi&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Organisasi</a>
					</div>
				</div>
				<div class=\"clearfix\"></div><br />
				
				<div class=\"table-responsive\">
					<table class=\"table no-margin table-bordered table-hover\">
						<thead>
							<tr>
								<th width=\"50\">No</th>
								<th>Organisasi</th>
								<th>Unit/Sie.</th>
								<th>Sebagai</th>
								<th>Tanggal Awal</th>
								<th>Tanggal Akhir</th>
							</tr>
						</thead>
						<tbody>
							$td_organisasi
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class=\"box box-info\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Prestasi/Penghargaan</h3>

				<div class=\"box-tools pull-right\">
					<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
				</div>
			</div>
			
			<div class=\"box-body\">
				<div class=\"row\">
					<div class=\"col-md-12 text-right\">
						<a href=\"?pages=data-prestasi&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Prestasi</a>
					</div>
				</div>
				<div class=\"clearfix\"></div><br />
				
				<div class=\"table-responsive\">
					<table class=\"table no-margin table-bordered table-hover\">
						<thead>
							<tr>
								<th width=\"50\">No</th>
								<th>No. SK</th>
								<th>Prestasi/Penghargaan</th>
								<th>Tanggal</th>
							</tr>
						</thead>
						<tbody>
							$td_prestasi
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class=\"box box-info\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Sanksi</h3>

				<div class=\"box-tools pull-right\">
					<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
				</div>
			</div>
			
			<div class=\"box-body\">
				<div class=\"row\">
					<div class=\"col-md-12 text-right\">
						<a href=\"?pages=data-sanksi&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Sanksi</a>
					</div>
				</div>
				<div class=\"clearfix\"></div><br />
				
				<div class=\"table-responsive\">
					<table class=\"table no-margin table-bordered table-hover\">
						<thead>
							<tr>
								<th width=\"50\">No</th>
								<th>No. SK</th>
								<th>Sanksi</th>
								<th>Tanggal</th>
							</tr>
						</thead>
						<tbody>
							$td_sanksi
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class=\"box box-info\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Surat Tanda Registrasi</h3>

				<div class=\"box-tools pull-right\">
					<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
				</div>
			</div>
			
			<div class=\"box-body\">
				<div class=\"row\">
					<div class=\"col-md-12 text-right\">
						<a href=\"?pages=data-str&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Tanda Registrasi</a>
					</div>
				</div>
				<div class=\"clearfix\"></div><br />
				
				<div class=\"table-responsive\">
					<table class=\"table no-margin table-bordered table-hover\">
						<thead>
							<tr>
								<th width=\"50\">No</th>
								<th>No. STR</th>
								<th>Tgl. STR</th>
								<th>Tanggal Awal</th>
								<th>Tanggal Akhir</th>
							</tr>
						</thead>
						<tbody>
							$td_ijin_praktek
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class=\"box box-info\">
			<div class=\"box-header with-border\">
				<h3 class=\"box-title\">Surat Ijin Praktek</h3>

				<div class=\"box-tools pull-right\">
					<button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i></button>
				</div>
			</div>
			
			<div class=\"box-body\">
				<div class=\"row\">
					<div class=\"col-md-12 text-right\">
						<a href=\"?pages=data-sip&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Ijin Praktek</a>
					</div>
				</div>
				<div class=\"clearfix\"></div><br />
				
				<div class=\"table-responsive\">
					<table class=\"table no-margin table-bordered table-hover\">
						<thead>
							<tr>
								<th width=\"50\">No</th>
								<th>No. SIP</th>
								<th>Tgl. SIP</th>
								<th>Tanggal Awal</th>
								<th>Tanggal Akhir</th>
							</tr>
						</thead>
						<tbody>
							$td_ijin_praktek
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
	</div>
</div>";
}