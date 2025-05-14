<?php
if(preg_match("/\bpendidikan.php\b/i", $_SERVER['REQUEST_URI'])){
	exit;
}else{

$target_dir="files/pendidikan";

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
		$file_ijazah=$fdata2["file_ijazah"];
		
		$id_tingkat_pendidikan=$fdata2["id_tingkat_pendidikan"];
		$nama_pendidikan=$spend[$id_tingkat_pendidikan]["nama_pendidikan"];
		
		if($id_pendidikan==$id_tingkat_pendidikan){
			$gab_sekolah="($nama_pendidikan) $nama_prodi $nama_sekolah";
		}
		
		if($file_ijazah!=""){
			$link_download="$target_dir/$file_ijazah";
			$btn_download="<a href=\"$link_download\" class=\"btn btn-xs btn-warning\"><i class=\"fa fa-download\"></i></a>";
		}else{
			$btn_download="";
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
			<td>$btn_download</td>
		</tr>";
	}
}

echo"<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Data Pendidikan</h3>
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
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_pendidikan
				</tbody>
			</table>
		</div>
	</div>
</div>";

}
?>