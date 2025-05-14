<?php
if(preg_match("/\bpekerjaan.php\b/i", $_SERVER['REQUEST_URI'])){
	exit;
}else{

$target_dir="files/riyawatkerja";
$target_dir2="files/pangkat";

/*status pegawai*/
$na_stp=SelStatusPegawai();
$sqld2="select * from peg_riw_status_pegawai where hapus=\"0\" and id_pegawai=\"$id\" order by tgl_awal desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_stp++;
		$no_surat=$fdata2["no_surat"];
		$id_status_pegawai=$fdata2["id_status_pegawai"];
		$id_unitkerja=$fdata2["id_unitkerja"];
		$id_jabatan=$fdata2["id_jabatan"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_surat=$fdata2["tgl_surat"];
		$file_surat=$fdata2["file_surat"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl3=TglFormat1($tgl_surat);
		
		$nama_status=$na_stp[$id_status_pegawai]["status_pegawai"];
		
		if($file_surat!=""){
			$link_download="$target_dir/$file_surat";
			$btn_download="<a href=\"$link_download\" class=\"btn btn-xs btn-warning\"><i class=\"fa fa-download\"></i></a>";
		}else{
			$btn_download="";
		}

		$td_status_pegawai.="<tr>
			<td>$no_stp</td>
			<td>$no_surat</td>
			<td>$ftgl3</td>
			<td>$nama_status</td>
			<td>$btn_download</td>
		</tr>";
	}
}

/*mutasi*/
$sunit=LayananDaftar();
$sbidang=SelBidang();
$sqld2="select a.*, b.id_unit_kerja_bidang from peg_riw_unitkerja as a left join db_unit_kerja2 as b on a.id_unit_induk=b.id where a.id_pegawai=\"$id\" and a.hapus=\"0\" order by a.tgl_awal desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		$no_kerja++;
		$no_surat=$fdata2["no_surat"];
		$id_unit_induk=$fdata2["id_unit_induk"];
		$id_unitkerja=$fdata2["id_unitkerja"];
		$id_unit_kerja_bidang=$fdata2["id_unit_kerja_bidang"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_surat=$fdata2["tgl_surat"];
		$file_surat=$fdata2["file_surat"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_surat);
		
		$nama_unit_induk=$sunit[$id_unit_induk]["nama_unit"];
		$nama_unit_kerja=$sunit[$id_unitkerja]["nama_unit"];
		$nama_bidang=$sbidang[$id_unit_kerja_bidang]["nama_bidang"];
		
		if($file_surat!=""){
			$link_download="$target_dir/$file_surat";
			$btn_download="<a href=\"$link_download\" class=\"btn btn-xs btn-warning\"><i class=\"fa fa-download\"></i></a>";
		}else{
			$btn_download="";
		}
		
		$td_rotasi.="<tr>
			<td>$no_kerja</td>
			<td>$no_surat</td>
			<td>$ftgl2</td>
			<td>$nama_unit_induk</td>
			<td>$nama_unit_kerja</td>
			<td>$nama_bidang</td>
			<td>$btn_download</td>
		</tr>";
	}
}

/*pangkat golongan dan berkala*/
$sqld2="select * from peg_kepangkatan where id_pegawai=\"$id\" and hapus=\"0\" order by tgl_awal desc";
$data2=mysqli_query($db_result, $sqld2);
$ndata2=mysqli_num_rows($data2);
if($ndata2>0){
	while($fdata2=mysqli_fetch_assoc($data2)){
		
		$no_surat=$fdata2["no_surat"];
		$id_pangkat=$fdata2["id_pangkat"];
		$tgl_awal=$fdata2["tgl_awal"];
		$tgl_surat=$fdata2["tgl_surat"];
		$file_surat=$fdata2["file_surat"];
		
		$ftgl1=TglFormat1($tgl_awal);
		$ftgl2=TglFormat1($tgl_surat);
		
		$sgolongan=SelGolongan($id_pangkat);
		$nama_pangkat=$sgolongan[$id_pangkat]["nama_golongan"];
		
		if($file_surat!=""){
			$link_download="$target_dir2/$file_surat";
			$btn_download="<a href=\"$link_download\" class=\"btn btn-xs btn-warning\"><i class=\"fa fa-download\"></i></a>";
		}else{
			$btn_download="";
		}
		
		if($id_berkala==2){
			$no_berkala++;
			
			$td_berkala.="<tr>
				<td>$no_berkala</td>
				<td>$no_surat</td>
				<td>$ftgl2</td>
				<td>$nama_pangkat</td>
				<td>Berkala</td>
				<td>$btn_download</td>
			</tr>";
			
		}else{
			$no_pangkat++;
			
			$td_pangkat.="<tr>
				<td>$no_pangkat</td>
				<td>$no_surat</td>
				<td>$ftgl2</td>
				<td>$nama_pangkat</td>
				<td>Naik Pangkat</td>
				<td>$btn_download</td>
			</tr>";
		}
		
		
	}
}

echo"<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Status Pegawai/Pekerjaan</h3>
	</div>
	
	<div class=\"box-body\">
		<div class=\"row\">
			<div class=\"col-md-12 text-right\">
				<a href=\"?pages=peg-riw-statuspegawai&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Status Pegawai</a>
			</div>
		</div>
		<div class=\"clearfix\"></div><br />
		
		<div class=\"table-responsive\">
			<table class=\"table no-margin table-bordered table-hover\">
				<thead>
					<tr>
						<th width=\"50\">No</th>
						<th>No. SK</th>
						<th>Tgl SK</th>
						<th>Status Pegawai</th>
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_status_pegawai
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class=\"clearfix\"></div><br />

<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Rotasi/Mutasi</h3>
	</div>
	
	<div class=\"box-body\">
		<div class=\"row\">
			<div class=\"col-md-12 text-right\">
				<a href=\"?pages=data-riwkerja&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Rotasi/Mutasi</a>
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
						<th>Unit Kerja</th>
						<th>Sub Unit Kerja</th>
						<th>Bidang</th>
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_rotasi
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Pangkat dan Golongan</h3>
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
						<th>Tgl. SK</th>
						<th>Pangkat/Golongan</th>
						<th>STB</th>
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_pangkat
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class=\"box box-default\">
	<div class=\"box-header with-border\">
		<h3 class=\"box-title\">Gaji Berkala</h3>
	</div>
	
	<div class=\"box-body\">
		<div class=\"row\">
			<div class=\"col-md-12 text-right\">
				<a href=\"?pages=data-pangkat&act=detail&gid=$gid\" class=\"btn btn-xs btn-warning\">Data Berkala</a>
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
						<th>Pangkat/Golongan</th>
						<th>STB</th>
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					$td_berkala
				</tbody>
			</table>
		</div>
	</div>
</div>";

}
?>