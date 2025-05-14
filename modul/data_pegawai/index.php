<?php
if(preg_match("/\bindex.php\b/i", $_SERVER['REQUEST_URI'])){
    exit;
}else{

$format_files=array("jpg","jpeg","png");
$format_files2=array("jpg","jpeg","png","pdf");
$target_dir="files/foto";
$target_dir2="files/ktp";
$target_dir3="files/npwp";
$target_dir4="files/ktam";

switch($act){
	default:
		if (!in_array($level_id, array(1,45))) {
			echo"<meta http-equiv=\"refresh\" content=\"0;url=$link_back&act=profil&gid=$ss_pegawai\">";
			exit;
		}

		$jpegawai=SelJenisPegawai();
		$stkawin=MasterStatusKawin();
		$posisi=CariPosisi($batas, $ghal);
		
		$ld=LayananDaftar("", "", "sub_id=\"0\"");
		if(count($ld)>0){
			foreach($ld as $ld1){
				$sel1=($ld1["id"]=="$gup")? "selected=\"selected\"" : "";
				$list_unit.="<option value=\"$ld1[id]\" $sel1>$ld1[nama_unit]</option>";
				
				/* $ld2=LayananDaftar("", "", "sub_id=\"$ld1[id]\"");
				if(count($ld2)>0){
					foreach($ld2 as $ld21){
						$sel1=($ld21["id"]=="$gup")? "selected=\"selected\"" : "";
						$list_unit.="<option value=\"$ld21[id]\" $sel1>&nbsp; &bull; $ld21[nama_unit]</option>";
					}
				} */
				
			}
		}
		
		if($gup!=""){
			$wgup="and id_unit_induk=\"$gup\"";
		}
		
		if($gstatus!=""){
			$wgstatus="and id_unit_kerja=\"$gstatus\"";
		}
		
		$sqld="select * from db_pegawai where hapus=\"0\" and nama_pegawai like \"%$gname%\" and alamat like \"%$gsub%\" $wgup $wgstatus";
		$data=mysqli_query($db_result, "$sqld limit $posisi, $batas");
		$ndata=mysqli_num_rows($data);
		if($ndata>0){
			$no=$posisi+1;
			$sunit=LayananDaftar();
			
			while($fdata=mysqli_fetch_assoc($data)){
				extract($fdata);
				$nama_gab=NamaGabung($nama_pegawai, $gelar_depan, $gelar_belakang);
				$jk=($jenis_kelamin==1)? "L" : "P";
				$jenis_pegawai=$jpegawai[$id_jenis_pegawai]["jenis_pegawai"];
				
				if($lmn[$idsmenu][2]==1){
					$link_edit="$link_back&act=input&gket=edit&gid=$id&gname=$gname&gsub=$gsub&ghal=$ghal";
					$btn_edit="<a href=\"$link_edit\" class=\"btn btn-xs btn-success\">Edit</a>";
				}else{
					$btn_edit="";
				}

				if($lmn[$idsmenu][3]==1){
					$link_hapus="$link_back&act=hapus&gid=$id&gname=$gname&gsub=$gsub&ghal=$ghal";
					$btn_hapus="<a href=\"$link_hapus\" onclick=\"return confirm('Apakah Anda Yakin Menghapus Data ini?');\" class=\"btn btn-xs btn-danger\">Hapus</a>";
				}else{
					$btn_hapus="";
				}
				
				$link_detail="$link_back&act=profil&gid=$id&gname=$gname&gsub=$gsub&ghal=$ghal";
				$btn_detail="<a href=\"$link_detail\" class=\"btn btn-xs bg-maroon\">Profil</a>";
				
				$unit_induk=$sunit[$id_unit_induk]["nama_unit"];
				$nama_unit=$sunit[$id_unit_kerja]["nama_unit"];

				$td_table.="<tr>
					<td>$no</td>
					<td>$nip_pegawai</td>
					<td>$nama_gab</td>
					<td>$jk</td>
					<td>$hp</td>
					<td>$email</td>
					<td>$jenis_pegawai</td>
					<td>$unit_induk</td>
					<td>$nama_unit</td>
					<td>$btn_edit $btn_detail $btn_hapus</td>
				</tr>";

				$no++;
			}
		}
		
		$data2=mysqli_query($db_result, $sqld);
		$jmldata=mysqli_num_rows($data2);
		if($jmldata>$batas){
			$jh=JumlahHalaman($jmldata, $batas);
			$np=NavPage($ghal, $jh);
			
			$fghal=NumberFormat($ghal);
			$fjh=NumberFormat($jh);
			$fjmldata=NumberFormat($jmldata);
		
			$pg1="";
			foreach($np as $np1){
				$npclass="";
				$nplink="$link_back&gname=$gname&gsub=$gsub&ghal=$np1[0]";

				if($np1[1]=="first"){
					$np0="First";
				}
				elseif($np1[1]=="back"){
					$np0="Previous";
				}
				elseif($np1[1]=="last"){
					$np0="Last";
				}
				elseif($np1[1]=="next"){
					$np0="Next";
				}
				elseif($np1[1]=="active"){
					$nplink="#";
					$np0="$np1[0]";
					$npclass="active";
				}
				else{
					$np0="$np1[0]";
				}

				$pg1.="<li class=\"paginate_button $npclass\"><a href=\"$nplink\">$np0</a></li>";
			}
			
			$list_pag="<div class=\"row\">
				<div class=\"col-sm-5\">
					<div class=\"dataTables_info\">Halaman ke $fghal dari $fjh Halaman - $fjmldata Data</div>
				</div>
				<div class=\"col-sm-7\">
					<div class=\"dataTables_paginate paging_simple_numbers\">
						<ul class=\"pagination\">
							$pg1
						</ul>
					</div>
				</div>
			</div>";
		}

		echo"$binfo
		<div class=\"row\">
			<div class=\"col-md-12\">
				
				<div class=\"box\">
					<div class=\"box-header border-bottom1\">
						<h3 class=\"box-title\">Data Pegawai</h3>
						
						<div class=\"box-tools pull-right\">
							
						</div>
					</div>

					<div class=\"box-body\">
						<script>
							$(function () {
								$(\"#unit\").change(function(){
									var kecv=$(this).val();
									var kecc=$(this).children(':selected').text();
									if(kecv!=0){
										$(\"#hunit\").val(kecc);
										$(\"#subunit\").removeAttr(\"disabled\").load(\"load_data.php?gid=unitpegawai&gid2=\"+kecv,
											function(){
												$(\"#subunit\").trigger(\"liszt:updated\");
											}
										);

									}
								}).each(function(){
									var kecv=$(this).val();
									var kecc=$(this).children(':selected').text();

									if(kecv!=0 && kecv!=null){
										$(\"#hunit\").val(kecc);
										var seldesa=$(\"#hsubunit\").val();
										var lload=\"load_data.php?gid=unitpegawai&gid2=\"+kecv;

										if(seldesa!=0){ lload+=\"&gid3=\"+seldesa; }

										$(\"#subunit\").removeAttr(\"disabled\").load(lload,
											function(){
												$(\"#subunit\").trigger(\"liszt:updated\");
											}
										);
									}
								});
							});
						</script>
						
						
						<form role=\"form\" class=\"form-horizontal\" method=\"get\">
							<div class=\"row\">
								<input name=\"pages\" type=\"hidden\" value=\"$pages\" />
								
								<div class=\"col-md-4\">
									<div class=\"form-group\">
										<label class=\"col-sm-3 control-label text-left\">Nama</label>
										<div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" name=\"gname\" value=\"$gname\"></div>
									</div>
									<div class=\"form-group\">
										<label class=\"col-sm-3 control-label text-left\">Alamat</label>
										<div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" name=\"gsub\" value=\"$gsub\"></div>
									</div>
								</div>
								
								<div class=\"col-md-4\">
									<div class=\"form-group\">
										<label class=\"col-sm-4 control-label text-left\">Unit Kerja</label>
										<div class=\"col-sm-8\">
											<select class=\"form-control select2\" name=\"gup\" id=\"unit\">
												<option value=\"\">Pilih</option>
												$list_unit
											</select>
											<input type=\"hidden\" class=\"form-control\" name=\"hunit\" id=\"hunit\" value=\"$gup\">
										</div>
									</div>
									
									<div class=\"form-group\">
										<label class=\"col-sm-4 control-label text-left\">Sub Unit Kerja</label>
										<div class=\"col-sm-8\">
											<select class=\"form-control\" name=\"gstatus\" id=\"subunit\">
												<option value=\"\">Pilih</option>
											</select>
											<input type=\"hidden\" class=\"form-control\" name=\"hsubunit\" id=\"hsubunit\" value=\"$gstatus\">
										</div>
									</div>
								</div>
							</div>
							
							<div class=\"form-group\">
								<div class=\"col-md-12\">
									<button type=\"submit\" class=\"btn bg-maroon\"><i class=\"fa fa-search\"></i> Cari</button>
									<a href=\"$link_back\" class=\"btn btn-info\"><i class=\"fa fa-refresh\"></i> Refresh</a>
								</div>
							</div>
						</form>
					</div>

					<div class=\"box-body\">
						<div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover\">
								<thead>
									<tr>
										<th width=\"50\">No</th>
										<th>NIP</th>
										<th>Nama</th>
										<th>JK</th>
										<th>Hp</th>
										<th>Email</th>
										<th>Jenis Pegawai</th>
										<th>Unit Induk</th>
										<th>Unit Kerja</th>
										<th width=\"175\">Aksi</th>
									</tr>
								</thead>
								<tbody>
									$td_table
								</tbody>
							</table>
						</div>

						$list_pag
					</div>
				</div>
			</div>
		</div>";
	break;
	
	case"input":
		if (!in_array($level_id, array(1,45))) {
			$gid="$ss_pegawai";
			$std="style=\"display:none;\"";
		}else{
			$gid="$gid";
			$std="";
		}

		if($gket=="edit" and $lmn[$idsmenu][2]==1){
			$judul="Edit Data";

			$sqld="select * from db_pegawai where id=\"$gid\" and hapus=\"0\"";
			$data=mysqli_query($db_result, $sqld);
			$ndata=mysqli_num_rows($data);
			if($ndata>0){
				$fdata=mysqli_fetch_assoc($data);
				extract($fdata);

				$edit="<input name=\"pid\" type=\"hidden\" value=\"$id\" />";
				
				$disp_foto=($foto!="")? "<br /><a href=\"files/foto/$foto\" target=\"_blank\" class=\"btn btn-xs btn-warning\">Download</a>" : "";
				$disp_ktp=($file_ktp!="")? "<br /><a href=\"files/ktp/$file_ktp\" target=\"_blank\" class=\"btn btn-xs btn-warning\">Download</a>" : "";
				$disp_npwp=($file_npwp!="")? "<br /><a href=\"files/npwp/$file_npwp\" target=\"_blank\" class=\"btn btn-xs btn-warning\">Download</a>" : "";
				$disp_nbm=($file_nbm!="")? "<br /><a href=\"files/ktam/$file_nbm\" target=\"_blank\" class=\"btn btn-xs btn-warning\">Download</a>" : "";
			}
		}
	
		if($ndata>0){
			$sjk=SelStatus();
			foreach ($sjk as $sjk1) {
				$sel1=($sjk1[0]=="$jenis_kelamin")? "selected=\"selected\"" : "";
				$list_jk.="<option value=\"$sjk1[0]\" $sel1>$sjk1[3]</option>";
				
				$sel2=($sjk1[0]=="$status_pns")? "selected=\"selected\"" : "";
				$list_pns.="<option value=\"$sjk1[0]\" $sel2>$sjk1[7]</option>";
			}
			
			$sagama=MasterAgama();
			if(count($sagama)>0){
				foreach($sagama as $sagama1) {
					$sel1=($sagama1["id"]=="$id_agama")? "selected=\"selected\"" : "";
					$list_agama.="<option value=\"$sagama1[id]\" $sel1>$sagama1[nama_agama]</option>";
				}
			}

			$skawin=MasterStatusKawin();
			if(count($skawin)>0){
				foreach($skawin as $skawin1) {
					$sel1=($skawin1["id"]=="$id_status_kawin")? "selected=\"selected\"" : "";
					$list_kawin.="<option value=\"$skawin1[id]\" $sel1>$skawin1[status_kawin]</option>";
				}
			}

			$sgdarah=MasterGolDarah();
			if(count($sgdarah)>0){
				foreach($sgdarah as $sgdarah1) {
					$sel1=($sgdarah1["id"]=="$id_goldarah")? "selected=\"selected\"" : "";
					$list_gdarah.="<option value=\"$sgdarah1[id]\" $sel1>$sgdarah1[gol_darah]</option>";
				}
			}
			
			if($gid2==1){
				$link_back="$link_back&act=profil&gid=$gid&gid2=$gid2";
			}else{
				$link_back="$link_back";
			}
			
			echo"<div class=\"row\">
				<div class=\"col-md-12\">

					<div class=\"box\">
						<div class=\"box-header border-bottom1\">
							Data &raquo; $judul
						</div>

						<div class=\"box-body\">
							
							<form role=\"form\" class=\"form-horizontal\" method=\"post\" action=\"$link_back&act=proses&gket=$gket&gid2=$gid2&gname=$gname&gsub=$gsub&ghal=$ghal\" enctype=\"multipart/form-data\">
								<div class=\"row\">
									<div class=\"col-md-12\">
										<div class=\"form-group\">
											<label class=\"col-sm-2\">Nama Pegawai *</label>
											<div class=\"col-sm-3\">
												<input type=\"text\" name=\"gelar_depan\" value=\"$gelar_depan\" class=\"form-control\" placeholder=\"Gelar Depan\"/>
											</div>
											<div class=\"col-sm-4\">
												<input type=\"text\" name=\"nama_pegawai\" value=\"$nama_pegawai\" class=\"form-control\" placeholder=\"Nama *\" required/>
											</div>
											<div class=\"col-sm-3\">
												<input type=\"text\" name=\"gelar_belakang\" value=\"$gelar_belakang\" class=\"form-control\" placeholder=\"Gelar Belakang\"/>
											</div>
										</div>
									</div>
									<div class=\"clearfix\"></div><br />
									
									<div class=\"col-md-6\">
										<div class=\"form-group\">
											<label class=\"col-sm-4\">No. Register *</label>
											<div class=\"col-sm-8\">
												<input type=\"text\" name=\"no_reg\" value=\"$no_reg\" class=\"form-control\" required />
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">NIP</label>
											<div class=\"col-sm-8\">
												<input type=\"text\" name=\"nip_pegawai\" value=\"$nip_pegawai\" class=\"form-control\" />
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Tempat Lahir *</label>
											<div class=\"col-sm-8\">
												<input type=\"text\" name=\"tmpt_lahir\" value=\"$tmpt_lahir\" class=\"form-control\" required />
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Tanggal Lahir *</label>
											<div class=\"col-sm-8\">
												<input type=\"text\" name=\"tgl_lahir\" value=\"$tgl_lahir\" class=\"form-control datepicker\" required/>
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Jenis Kelamin *</label>
											<div class=\"col-sm-8\">
												<select class=\"form-control select2\" name=\"jenis_kelamin\" required>
													<option value=\"\">Pilih</option>
													$list_jk
												</select>
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Agama *</label>
											<div class=\"col-sm-8\">
												<select class=\"form-control select2\" name=\"id_agama\" required>
													<option value=\"\">Pilih</option>
													$list_agama
												</select>
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Kawin *</label>
											<div class=\"col-sm-8\">
												<select class=\"form-control select2\" name=\"id_status_kawin\" required>
													<option value=\"\">Pilih</option>
													$list_kawin
												</select>
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Golongan Darah</label>
											<div class=\"col-sm-8\">
												<select class=\"form-control select2\" name=\"id_gol_darah\">
													<option value=\"\">Pilih</option>
													$list_gdarah
												</select>
											</div>
										</div>
										<div class=\"form-group\" $std>
											<label class=\"col-sm-4\">Foto</label>
											<div class=\"col-sm-8\">
												<input type=\"file\" name=\"filex\" class=\"form-control\" />
												<small>File KTP yang diupload harus dalam bentuk/format (jpg, jpeg, png, pdf)</small>
												$disp_foto
											</div>
										</div>
										<div class=\"form-group\" $std>
											<label class=\"col-sm-4\">Kode DPJP</label>
											<div class=\"col-sm-3\">
												<input type=\"text\" name=\"kode_dpjp\" value=\"$kode_dpjp\" class=\"form-control\" />
											</div>
										</div>
									</div>
									
									<div class=\"col-md-6\">
										<div class=\"form-group\">
											<label class=\"col-sm-4\">No. KTP *</label>
											<div class=\"col-sm-8\">
												<input type=\"text\" name=\"no_ktp\" value=\"$no_ktp\" class=\"form-control\" required />
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">File KTP</label>
											<div class=\"col-sm-8\">
												<input type=\"file\" name=\"file_ktp\" class=\"form-control\" />
												<small>File KTP yang diupload harus dalam bentuk/format (jpg, jpeg, png, pdf)</small>
												$disp_ktp
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">No. NPWP</label>
											<div class=\"col-sm-8\">
												<input type=\"text\" name=\"no_npwp\" value=\"$no_npwp\" class=\"form-control\"/>
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">File NPWP</label>
											<div class=\"col-sm-8\">
												<input type=\"file\" name=\"file_npwp\" class=\"form-control\" />
												<small>File NPWP yang diupload harus dalam bentuk/format (jpg, jpeg, png, pdf)</small>
												$disp_npwp
											</div>
										</div>
										
										<div class=\"form-group\">
											<label class=\"col-sm-4\">No. KTAM/NBM</label>
											<div class=\"col-sm-8\">
												<input type=\"text\" name=\"no_nbm\" value=\"$no_nbm\" class=\"form-control\"/>
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">File KTAM/NBM</label>
											<div class=\"col-sm-8\">
												<input type=\"file\" name=\"file_nbm\" class=\"form-control\" />
												<small>File KTAM/NBM yang diupload harus dalam bentuk/format (jpg, jpeg, png, pdf)</small>
												$disp_nbm
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">HP *</label>
											<div class=\"col-sm-8\">
												<input type=\"number\" name=\"hp\" value=\"$hp\" class=\"form-control\" required />
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Email</label>
											<div class=\"col-sm-8\">
												<input type=\"email\" name=\"email\" value=\"$email\" class=\"form-control\" />
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Alamat *</label>
											<div class=\"col-sm-8\">
												<textarea name=\"alamat\" rows=\"5\" class=\"form-control\">$alamat</textarea>
											</div>
										</div>
									</div>
									<div class=\"clearfix\"></div><br />
									
									<div class=\"col-md-6\" $std>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Kode Arsip</label>
											<div class=\"col-sm-3\">
												<input type=\"text\" name=\"kode_arsip\" value=\"$kode_arsip\" class=\"form-control\" />
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Nomor Figer Print</label>
											<div class=\"col-sm-3\">
												<input type=\"text\" name=\"idf\" value=\"$idf\" class=\"form-control\"/>
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Nomor Urut Excel</label>
											<div class=\"col-sm-3\">
												<input type=\"text\" name=\"id_urutan\" value=\"$id_urutan\" class=\"form-control\"/>
											</div>
										</div>
									</div>
									
									<div class=\"col-md-6\" $std>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">Status PNS *</label>
											<div class=\"col-sm-8\">
												
												<select class=\"form-control select2\" name=\"status_pns\" required>
													<option value=\"\">Pilih</option>
													$list_pns
												</select>
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-sm-4\">NIP PNS</label>
											<div class=\"col-sm-8\">
												<input type=\"text\" name=\"nip_pns\" value=\"$nip_pns\" class=\"form-control\"/>
												<small>Isikan jika status PNS = <b>Ya</b></small>
											</div>
										</div>
									</div>
									<div class=\"clearfix\"></div><br />
									
									<div class=\"col-md-12\">
										<div class=\"form-group\">
											<div class=\"col-sm-12\">
												$edit
												<a href=\"$link_back&gname=$gname&gsub=$gsub&ghal=$ghal\" class=\"btn bg-navy\"><i class=\"fa fa-caret-left\"></i> Kembali</a>
												<button type=\"submit\" class=\"btn btn-success\"><i class=\"fa fa-save\"></i> Simpan</button>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>";
		}else{
			echo"<div class=\"alert alert-warning\">Data Tidak Ditemukan</div>";
			echo"<meta http-equiv=\"refresh\" content=\"2;url=$link_back&gname=$gname&gsub=$gsub&ghal=$ghal\">";
		}
	break;

	case"proses":
		if(count($_POST)>0){
			foreach($_POST as $pkey => $pvalue){
				$post1=mysqli_escape_string($db_result, $pvalue);
				$post1=preg_replace('/\s+/', ' ', $post1);
				$post1=trim($post1);

				$arpost[$pkey]="$post1";
			}

			extract($arpost);
			$no_telp=str_replace("_", "", $no_telp);
		}

		if (!in_array($level_id, array(1,45))) {
			$pid="$ss_pegawai";
		}else{
			$pid="$pid";
		}

		$error="";
		$error.=(empty($no_reg))? "&bull; No. Register Masih Kosong<br />" : "";
		$error.=(empty($nama_pegawai))? "&bull; Nama Pegawai Masih Kosong<br />" : "";
		$error.=(empty($tmpt_lahir))? "&bull; Tempat Lahir Masih Kosong<br />" : "";
		$error.=(empty($tgl_lahir))? "&bull; Tanggal Lahir Masih Kosong<br />" : "";
		$error.=(empty($jenis_kelamin))? "&bull; Jenis Kelamin Masih Kosong<br />" : "";
		$error.=(empty($id_agama))? "&bull; Agama Masih Kosong<br />" : "";
		$error.=(empty($no_ktp))? "&bull; No. KTP Masih Kosong<br />" : "";
		$error.=(empty($hp))? "&bull; HP Masih Kosong<br />" : "";
		$error.=(empty($alamat))? "&bull; Alamat Masih Kosong<br />" : "";

		$nama_file=$_FILES["filex"]["name"];
		$size_file=$_FILES["filex"]["size"];
		$tmp_file=$_FILES["filex"]["tmp_name"];
		
		if(!empty($nama_file)){
			$ex_file=explode(".", $nama_file);
			$ec_file=count($ex_file);
			$a1_file=$ec_file-1;
			$ext_file=$ex_file[$a1_file];
			$ndt1=date("YmdHis");
			$file_foto="foto_$pid"."_$ndt1.$ext_file";
			
			$error.=(in_array(strtolower($ext_file), $format_files))? "" : "File foto yang diupload harus dalam bentuk/format (jpg, jpeg, png)<br />";
		}
		
		$nama_ktp=$_FILES["file_ktp"]["name"];
		$size_ktp=$_FILES["file_ktp"]["size"];
		$tmp_ktp=$_FILES["file_ktp"]["tmp_name"];
		
		if(!empty($nama_ktp)){
			$ex_ktp=explode(".", $nama_ktp);
			$ec_ktp=count($ex_ktp);
			$a1_ktp=$ec_ktp-1;
			$ext_ktp=$ex_ktp[$a1_ktp];
			$ndt1=date("YmdHis");
			$uniq1=uniqid();
			$file_ktp="ktp_$pid"."_$ndt1"."_$uniq1.$ext_ktp";
			
			$error.=(in_array(strtolower($ext_ktp), $format_files2))? "" : "File KTP yang diupload harus dalam bentuk/format (jpg, jpeg, png, pdf)<br />";
		}
		
		$nama_npwp=$_FILES["file_npwp"]["name"];
		$size_npwp=$_FILES["file_npwp"]["size"];
		$tmp_npwp=$_FILES["file_npwp"]["tmp_name"];
		
		if(!empty($nama_npwp)){
			$ex_npwp=explode(".", $nama_npwp);
			$ec_npwp=count($ex_npwp);
			$a1_npwp=$ec_npwp-1;
			$ext_npwp=$ex_npwp[$a1_npwp];
			$ndt1=date("YmdHis");
			$uniq1=uniqid();
			$file_npwp="npwp_$pid"."_$ndt1"."_$uniq1.$ext_npwp";
		}
		
		$nama_nbm=$_FILES["file_nbm"]["name"];
		$size_nbm=$_FILES["file_nbm"]["size"];
		$tmp_nbm=$_FILES["file_nbm"]["tmp_name"];
		
		if(!empty($nama_nbm)){
			$ex_nbm=explode(".", $nama_nbm);
			$ec_nbm=count($ex_nbm);
			$a1_nbm=$ec_nbm-1;
			$ext_nbm=$ex_nbm[$a1_nbm];
			$ndt1=date("YmdHis");
			$uniq1=uniqid();
			$file_nbm="nbm_$pid"."_$ndt1"."_$uniq1.$ext_nbm";
		}
		
		if($gid2==1){
			$link_back="$link_back&act=profil&gid=$pid&gid2=$gid2";
		}else{
			$link_back="$link_back&gname=$gname&gsub=$gsub&ghal=$ghal";
		}
		
		if(empty($error)){
			if(!is_dir("$target_dir")) {
				mkdir("$target_dir", 0755, true);
				mkdir("$target_dir/hapus", 0755, true);
			}
			
			if(!is_dir("$target_dir2")) {
				mkdir("$target_dir2", 0755, true);
				mkdir("$target_dir2/hapus", 0755, true);
			}
			
			if(!is_dir("$target_dir3")) {
				mkdir("$target_dir3", 0755, true);
				mkdir("$target_dir3/hapus", 0755, true);
			}
			
			if(!is_dir("$target_dir4")) {
				mkdir("$target_dir4", 0755, true);
				mkdir("$target_dir4/hapus", 0755, true);
			}

			if($gket=="edit" and $lmn[$idsmenu][2]==1){
				$n=1;

				$sqld="select * from db_pegawai where id=\"$pid\" and hapus=\"0\"";
				$data=mysqli_query($db_result, $sqld);
				$ndata=mysqli_num_rows($data);
				if($ndata>0){
					$fdata=mysqli_fetch_assoc($data);
					$fid=$fdata["id"];
					$user_update="$ss_id,".$fdata["user_update"];
					
					if(!empty($nama_file)){
						$simfoto=", foto=\"$file_foto\"";
					}
					
					if(!empty($nama_ktp)){
						$simktp=", file_ktp=\"$file_ktp\"";
					}
					
					if(!empty($nama_npwp)){
						$simnpwp=", file_npwp=\"$file_npwp\"";
					}
					
					if(!empty($nama_nbm)){
						$simnbm=", file_nbm=\"$file_nbm\"";
					}
					
					$vdata="no_reg=\"$no_reg\", nip_pegawai=\"$nip_pegawai\", gelar_depan=\"$gelar_depan\", gelar_belakang=\"$gelar_belakang\", nama_pegawai=\"$nama_pegawai\", alamat=\"$alamat\", tmpt_lahir=\"$tmpt_lahir\", tgl_lahir=\"$tgl_lahir\", jenis_kelamin=\"$jenis_kelamin\", id_goldarah=\"$id_gol_darah\", id_status_kawin=\"$id_status_kawin\", id_agama=\"$id_agama\", hp=\"$hp\", email=\"$email\", no_npwp=\"$no_npwp\", no_ktp=\"$no_ktp\", no_nbm=\"$no_nbm\", kode_arsip=\"$kode_arsip\", idf=\"$idf\", kode_dpjp=\"$kode_dpjp\", status_pns=\"$status_pns\", nip_pns=\"$nip_pns\", id_urutan=\"$id_urutan\", tgl_update=\"$ndatetime\", user_update=\"$user_update\" $simfoto $simktp $simnpwp $simnbm";
					
					$vvalues="id=\"$fid\"";

					$inp="update db_pegawai set $vdata where $vvalues";
					$upd=mysqli_query($db_result, $inp);
					if($upd==1){
						if(!empty($nama_file)){
							$target_file="$target_dir/$file_foto";
							$mv_file=move_uploaded_file($tmp_file, $target_file);
							if($mv_file){
								$nket="<div class=\"alert alert-success\">Data Berhasil Dirubah dan File Berhasil Diupload</div>";
							}else{
								$nket="<div class=\"alert alert-warning\">Data Berhasil Dirubah dan File Gagal Diupload</div>";
							}
						}else{
							$nket="<div class=\"alert alert-success\">Data Berhasil Dirubah</div>";
						}
						
						if(!empty($nama_ktp)){
							$target_file2="$target_dir2/$file_ktp";
							@move_uploaded_file($tmp_ktp, $target_file2);
						}
						
						if(!empty($nama_npwp)){
							$target_file3="$target_dir3/$file_npwp";
							@move_uploaded_file($tmp_npwp, $target_file3);
						}
						
						if(!empty($nama_nbm)){
							$target_file4="$target_dir4/$file_nbm";
							@move_uploaded_file($tmp_nbm, $target_file4);
						}
						
					}else{
						$nket="<div class=\"alert alert-danger\">Data Gagal Dirubah</div>";
					}
				}else{
					$nket="<div class=\"alert alert-warning\">Data Tidak Ditemukan</div>";
				}
			}

			if($n==1){
				echo"$nket";
			}else{
				echo"<div class=\"alert alert-warning\">Data Tidak Ditemukan</div>";
			}
		}else{
			echo"<div class=\"alert alert-warning\">$error</div>";
		}

		echo"<meta http-equiv=\"refresh\" content=\"2;url=$link_back\">";
	break;

	case"hapus":
		if($lmn[$idsmenu][3]==1){
			$sqld="select * from db_pegawai where id=\"$gid\" and hapus=\"0\"";
			$data=mysqli_query($db_result, $sqld);
			$ndata=mysqli_num_rows($data);
			if($ndata>0){
				$fdata=mysqli_fetch_assoc($data);
				$pid=$fdata["id"];
				$user_update="$ss_id,".$fdata["user_update"];

				$vdata="hapus=\"1\", tgl_update=\"$ndatetime\", user_update=\"$user_update\"";
				$vvalues="id=\"$pid\"";

				$inp="update db_pegawai set $vdata where $vvalues";
				$upd=mysqli_query($db_result, $inp);
				if($upd==1){
					$nket="<div class=\"alert alert-success\">Data Berhasil Dihapus</div>";
				}else{
					$nket="<div class=\"alert alert-danger\">Data Gagal Dihapus</div>";
				}
			}else{
				$nket="<div class=\"alert alert-warning\">Data Tidak Ditemukan</div>";
			}
		}else{
			$nket="<div class=\"alert alert-warning\">Data Tidak Ditemukan</div>";
		}

		echo"$nket
		<meta http-equiv=\"refresh\" content=\"2;url=$link_back&gname=$gname&gsub=$gsub&ghal=$ghal\">";
	break;
	
	case"profil":
		if (!in_array($level_id, array(1,45))) {
			$gid="$ss_pegawai";
		}else{
			$gid="$gid";
		}

		$sqld="select * from db_pegawai where id=\"$gid\" and hapus=\"0\"";
		$data=mysqli_query($db_result, $sqld);
		$ndata=mysqli_num_rows($data);
		if($ndata>0){
			$fdata=mysqli_fetch_assoc($data);
			extract($fdata);
			
			include"profil2.php";
		}else{
			echo"<div class=\"alert alert-warning\">Data Tidak Ditemukan</div>
			<meta http-equiv=\"refresh\" content=\"2;url=$link_back&gname=$gname&gsub=$gsub&ghal=$ghal\">";
		}
	break;
	
	case"profil2":
		if (!in_array($level_id, array(1,45))) {
			$gid="$ss_pegawai";
		}else{
			$gid="$gid";
		}

		$sqld="select * from db_pegawai where id=\"$gid\" and hapus=\"0\"";
		$data=mysqli_query($db_result, $sqld);
		$ndata=mysqli_num_rows($data);
		if($ndata>0){
			$fdata=mysqli_fetch_assoc($data);
			extract($fdata);
			
			include"profil2.php";
		}else{
			echo"<div class=\"alert alert-warning\">Data Tidak Ditemukan</div>
			<meta http-equiv=\"refresh\" content=\"2;url=$link_back&gname=$gname&gsub=$gsub&ghal=$ghal\">";
		}
	break;
}
}
?>
