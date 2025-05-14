<?php
if(preg_match("/\bkeluarga.php\b/i", $_SERVER['REQUEST_URI'])){
	exit;
}else{

$target_dir2="files/keluarga";

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
		$file_keluarga=$fdata2["file_keluarga"];
		
		$tanggal_lahir2=$fdata2["tanggal_lahir"];
		$ftanggal_lahir2=TglFormat1($tanggal_lahir2);
		
		$id_status_keluarga=$fdata2["id_status_keluarga"];
		$hkeluarga=$skel[$id_status_keluarga]["status_keluarga"];
		
		if($file_keluarga!=""){
			$btn_download="<a href=\"$target_dir2/$file_keluarga\" class=\"btn btn-xs btn-warning\"><i class=\"fa fa-download\"></i></a>";
		}else{
			$btn_download="";
		}
		
		$td_keluarga.="<tr>
			<td>$no_keluarga</td>
			<td>$nama_keluarga</td>
			<td>$hkeluarga</td>
			<td>$nik</td>
			<td>$tempat_lahir2</td>
			<td>$ftanggal_lahir2</td>
			<td>$btn_download</td>
		</tr>";
	}
}

echo"<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Data Keluarga</h3>
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
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_keluarga
				</tbody>
			</table>
		</div>
	</div>
</div>";

}
?>