<?php
if(preg_match("/\bkepanitiaan.php\b/i", $_SERVER['REQUEST_URI'])){
	exit;
}else{

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
			<td>$btn_download</td>
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
			<td>$btn_download</td>
		</tr>";
	}
}

echo"<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Kepanitiaan</h3>
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
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_kepanitiaan
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class=\"clearfix\"></div><br />

<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Organisasi</h3>
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
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_organisasi
				</tbody>
			</table>
		</div>
	</div>
</div>";

}
?>