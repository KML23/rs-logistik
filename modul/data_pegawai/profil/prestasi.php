<?php
if(preg_match("/\bprestasi.php\b/i", $_SERVER['REQUEST_URI'])){
	exit;
}else{

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
			<td>$btn_download</td>
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
			<td>$btn_download</td>
		</tr>";
	}
}

echo"<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Prestasi/Penghargaan</h3>
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
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_prestasi
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class=\"clearfix\"></div><br />

<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Sanksi</h3>
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
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_sanksi
				</tbody>
			</table>
		</div>
	</div>
</div>";

}
?>