<?php
if(preg_match("/\bsuratijin.php\b/i", $_SERVER['REQUEST_URI'])){
	exit;
}else{

$target_dir="files/str";
$sqld2="select * from peg_surat_keterangan where hapus=\"0\" and id_pegawai=\"$id\" and id_jenis=\"1\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$nstr++;
		$no_str=$fdata2["no_surat"];
		$tgl_surat=$fdata2["tgl_surat"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_akhir=$fdata2["tgl_akhir"];
		$seumur_hidup=$fdata2["seumur_hidup"];
		$file_surat=$fdata2["file_surat"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_akhir);
		$ftgl3=TglFormat1($tgl_surat);
		
		if($file_surat!=""){
			$link_download="$target_dir/$file_surat";
			$btn_download="<a href=\"$link_download\" class=\"btn btn-xs btn-warning\"><i class=\"fa fa-download\"></i></a>";
		}else{
			$btn_download="";
		}
		
		if($seumur_hidup==1){
			$nama_sh="Seumur Hidup";
		}else{
			$nama_sh="$ftgl2";
		}
		
		$td_str.="<tr>
			<td>$nstr</td>
			<td>$no_str</td>
			<td>$ftgl3</td>
			<td>$ftgl1</td>
			<td>$nama_sh</td>
			<td>$btn_download</td>
		</tr>";
	}
}

$target_dir="files/sip";
$sqld2="select * from peg_surat_keterangan where hapus=\"0\" and id_pegawai=\"$id\" and id_jenis=\"2\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$nsip++;
		$no_sip=$fdata2["no_surat"];
		$tgl_surat=$fdata2["tgl_surat"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_akhir=$fdata2["tgl_akhir"];
		$file_surat2=$fdata2["file_surat"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_akhir);
		$ftgl3=TglFormat1($tgl_surat);
		
		if($file_surat2!=""){
			$link_download="$target_dir/$file_surat2";
			$btn_download="<a href=\"$link_download\" class=\"btn btn-xs btn-warning\"><i class=\"fa fa-download\"></i></a>";
		}else{
			$btn_download="";
		}
		
		$td_ijin_praktek.="<tr>
			<td>$nsip</td>
			<td>$no_sip</td>
			<td>$ftgl3</td>
			<td>$ftgl1</td>
			<td>$ftgl2</td>
			<td>$btn_download</td>
		</tr>";
	}
}

$nsip=0;
$target_dir="files/spk";
$sqld2="select * from peg_surat_keterangan where hapus=\"0\" and id_pegawai=\"$id\" and id_jenis=\"4\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$nsip++;
		$no_surat=$fdata2["no_surat"];
		$tgl_surat=$fdata2["tgl_surat"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_akhir=$fdata2["tgl_akhir"];
		$file_surat3=$fdata2["file_surat"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_akhir);
		$ftgl3=TglFormat1($tgl_surat);
		
		if($file_surat3!=""){
			$link_download="$target_dir/$file_surat3";
			$btn_download="<a href=\"$link_download\" class=\"btn btn-xs btn-warning\"><i class=\"fa fa-download\"></i></a>";
		}else{
			$btn_download="";
		}
		
		$td_spk.="<tr>
			<td>$nsip</td>
			<td>$no_surat</td>
			<td>$ftgl3</td>
			<td>$ftgl2</td>
			<td>$btn_download</td>
		</tr>";
	}
}

echo"<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Surat Tanda Registrasi</h3>
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
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_str
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class=\"clearfix\"></div><br />

<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Surat Ijin Praktek</h3>
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
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_ijin_praktek
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class=\"clearfix\"></div><br />

<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Surat Penugasan Klinis (SPK) dan Rincian Kewenangan Klinis (RKK)</h3>
	</div>
	
	<div class=\"box-body\">
		<div class=\"row\">
			<div class=\"col-md-12 text-right\">
				<a href=\"?pages=data-spk&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data SPK & RKK</a>
			</div>
		</div>
		<div class=\"clearfix\"></div><br />
		
		<div class=\"table-responsive\">
			<table class=\"table no-margin table-bordered table-hover\">
				<thead>
					<tr>
						<th width=\"50\">No</th>
						<th>No. SK</th>
						<th>Tgl. SK</th>
						<th>Berlaku Sampai</th>
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_spk
				</tbody>
			</table>
		</div>
	</div>
</div>";

}
?>