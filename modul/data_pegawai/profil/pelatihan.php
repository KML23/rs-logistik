<?php
if(preg_match("/\bpendidikan.php\b/i", $_SERVER['REQUEST_URI'])){
	exit;
}else{

$target_dir="files/pelatihan";

/*pelatihan*/
$spend=SelPendidikanNf();
$selreg=SelTingkatReg();

$sqld2="select * from peg_pendnf where id_pegawai=\"$id\" and hapus=\"0\" order by tgl_akhir desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_pelatihan++;
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_akhir=$fdata2["tgl_akhir"];
		$id_jenis_nf=$fdata2["id_jenis_nf"];
		$id_tingkat_reg=$fdata2["id_tingkat_reg"];
		$judul_pelatihan=$fdata2["judul_pelatihan"];
		$tempat_pelatihan=$fdata2["tempat_pelatihan"];
		$bagian=$fdata2["bagian"];
		$file_sertifikat=$fdata2["file_sertifikat"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_akhir);
		$nama_jenis=$spend[$id_jenis_nf]["nama_pendnf"];
		$nama_tingkat=$selreg[$id_tingkat_reg]["nama_tingkat"];
		
		if($file_sertifikat!=""){
			$link_download="$target_dir/$file_sertifikat";
			$btn_download="<a href=\"$link_download\" class=\"btn btn-xs btn-warning\"><i class=\"fa fa-download\"></i></a>";
		}else{
			$btn_download="";
		}
		
		$td_pelatihan.="<tr>
			<td>$no_pelatihan</td>
			<td>$nama_jenis</td>
			<td>$nama_tingkat</td>
			<td>$judul_pelatihan</td>
			<td>$tempat_pelatihan</td>
			<td>$bagian</td>
			<td>$ftgl1</td>
			<td>$ftgl2</td>
			<td>$btn_download</td>
		</tr>";
	}
}

echo"<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Pelatihan</h3>
	</div>
	
	<div class=\"box-body\">
		<div class=\"row\">
			<div class=\"col-md-12 text-right\">
				<a href=\"?pages=data-pelatihan&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Pelatihan</a>
			</div>
		</div>
		<div class=\"clearfix\"></div><br />
		
		<div class=\"table-responsive\">
			<table class=\"table no-margin table-bordered table-hover\">
				<thead>
					<tr>
						<th width=\"50\">No</th>
						<th>Jenis Kegiatan</th>
						<th>Tingkat</th>
						<th>Kegiatan</th>
						<th>Lokasi</th>
						<th>Sebagai</th>
						<th>Tanggal Awal</th>
						<th>Tanggal Akhir</th>
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_pelatihan
				</tbody>
			</table>
		</div>
	</div>
</div>";

}
?>