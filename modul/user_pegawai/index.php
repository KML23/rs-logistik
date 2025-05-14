<?php
if(preg_match("/\bindex.php\b/i", $_SERVER['REQUEST_URI'])){
    exit;
}else{

$format_files=array("jpg","jpeg","png");
$target_dir="files/foto";

switch($act){
	default:
		if($level_id!=1){
			$wgid="and id=\"$ss_pegawai\"";
		}

		$jpegawai=SelJenisPegawai();
		
		$sqld="select * from db_pegawai where hapus=\"0\" and nama_pegawai like \"%$gname%\" and alamat like \"%$gsub%\" $wgid";
		$data=mysqli_query($db_result, $sqld);
		$ndata=mysqli_num_rows($data);
		if($ndata>0){
			while($fdata=mysqli_fetch_assoc($data)){
				extract($fdata);
				$nama_gab=NamaGabung($nama_pegawai, $gelar_depan, $gelar_belakang);
				$jk=($jenis_kelamin==1)? "L" : "P";
				$jenis_pegawai=$jpegawai[$id_jenis_pegawai]["jenis_pegawai"];
				$no++;

				$link_detail="$link_back&act=hakakses&gid=$id";
				$btn_detail="<a href=\"$link_detail\" class=\"btn btn-xs bg-maroon\">Akses</a>";
				
				$sunit=LayananDaftar($id_unit_kerja);
				$nama_unit=$sunit[$id_unit_kerja]["nama_unit"];

				/*ambil user*/
				$sqld2="select a.*, b.nama_level from db_user as a inner join db_user_level as b on a.level_user=b.id where a.hapus=\"0\" and b.hapus=\"0\" and a.id_pegawai=\"$id\"";
				$data2=mysqli_query($db_result, $sqld2);
				$fdata2=mysqli_fetch_assoc($data2);
				$username=$fdata2["username"];
				$hak_akses=$fdata2["nama_level"];

				$td_table.="<tr>
					<td>$no</td>
					<td>$nip_pegawai</td>
					<td>$nama_gab</td>
					<td>$jenis_pegawai</td>
					<td>$nama_unit</td>
					<td>$username</td>
					<td>$hak_akses</td>
					<td>$btn_detail</td>
				</tr>";
			}
		}
		
		echo"$binfo
		<div class=\"row\">
			<div class=\"col-md-12\">
				
				<div class=\"box\">
					<div class=\"box-header border-bottom1\">
						<h3 class=\"box-title\">Data Pegawai</h3>
					</div>

					<div class=\"box-body\">
						<form role=\"form\" class=\"form-horizontal\" method=\"get\">
							<input name=\"pages\" type=\"hidden\" value=\"$pages\" />

							<div class=\"form-group\">
								<label class=\"col-sm-2 control-label text-left\">Nama</label>
								<div class=\"col-sm-3\"><input type=\"text\" class=\"form-control\" name=\"gname\"></div>
							</div>
							<div class=\"form-group\">
								<label class=\"col-sm-2 control-label text-left\">Alamat</label>
								<div class=\"col-sm-3\"><input type=\"text\" class=\"form-control\" name=\"gsub\"></div>
							</div>
							<div class=\"form-group\">
								<div class=\"col-sm-offset-1 col-sm-5\">
									<button type=\"submit\" class=\"btn bg-maroon\"><i class=\"fa fa-search\"></i> Cari</button>
									<a href=\"$link_back\" class=\"btn btn-info\"><i class=\"fa fa-refresh\"></i> Refresh</a>
								</div>
							</div>
						</form>
					</div>

					<div class=\"box-body\">
						<div class=\"table-responsive\">
							<table id=\"dttable\" class=\"table table-bordered table-hover\">
								<thead>
									<tr>
										<th width=\"50\">No</th>
										<th>NIP</th>
										<th>Nama</th>
										<th>Jenis Pegawai</th>
										<th>Unit Kerja</th>
										<th>Username</th>
										<th>Akses</th>
										<th width=\"25\">Aksi</th>
									</tr>
								</thead>
								<tbody>
									$td_table
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>";
	break;
	
	case"hakakses":
		if($level_id!=1){
			$gid="$ss_pegawai";
			$disnos="style=\"display:none;\"";
		}else{
			$gid="$gid";
			$disnos="";
		}

		$sqld="select * from db_pegawai where id=\"$gid\" and hapus=\"0\"";
		$data=mysqli_query($db_result, $sqld);
		$ndata=mysqli_num_rows($data);
		if($ndata>0){
			$fdata=mysqli_fetch_assoc($data);
			extract($fdata);
			$nama_gab=NamaGabung($nama_pegawai, $gelar_depan, $gelar_belakang);

			$sjp=SelJenisPegawai($id_jenis_pegawai);
			$jenis_pegawai=$sjp[$id_jenis_pegawai]["jenis_pegawai"];

			if($id_spesialis>0){
				$sdoktersp=SelDokterSpesialis($id_spesialis);
				$jenis_pegawai=$sdoktersp[$id_spesialis]["spesialis"];
			}else{
				$jenis_pegawai="$jenis_pegawai";
			}

			if($id_jabatan>0){
				$sjabatan=SelJabatan($id_jabatan);
				$nama_jabatan=$sjabatan[$id_jabatan]["nama_jabatan"];
			}else{
				$nama_jabatan="Staf";
			}

			$sunit=LayananDaftar($id_unit_kerja);
			$nama_unit=$sunit[$id_unit_kerja]["nama_unit"];
			
			/*cek username*/
			$sqld2="select * from db_user where id_pegawai=\"$gid\" and hapus=\"0\" and id_pegawai>\"0\"";
			$data2=mysqli_query($db_result, $sqld2);
			$ndata2=mysqli_num_rows($data2);
			if($ndata2>0){
				$fdata2=mysqli_fetch_assoc($data2);
				extract($fdata2);

				$status_user=$fdata2["status"];
				$pw1="$password";
				$pw2="$password";
			}

			$sstatus=SelStatus();
			foreach($sstatus as $sstatus1){
				$sel1=($sstatus1[0]==$status_user)? "selected=\"selected\"" : "";
				$opt_status.="<option value=\"$sstatus1[0]\" $sel1>$sstatus1[1]</option>";
			}

			$sslevel=LevelUser();
			if(count($sslevel)>0){
				foreach($sslevel as $sslevel1){
					$sel1=($sslevel1["id"]==$level_user)? "selected=\"selected\"" : "";
					$opt_level.="<option value=\"$sslevel1[id]\" $sel1>$sslevel1[nama_level]</option>";
				}
			}
			

			echo"<div class=\"row\">
				<div class=\"col-md-3\">
					<div class=\"box box-primary\">
						<div class=\"box-body box-profile\">
							<img class=\"profile-user-img img-responsive img-circle\" src=\"\" alt=\"User profile picture\">
							<h3 class=\"profile-username text-center\">$nama_gab</h3>
							<p class=\"text-muted text-center\">$jenis_pegawai</p>

							<ul class=\"list-group list-group-unbordered\">
								<li class=\"list-group-item\">
									<b>NIP</b> <a class=\"pull-right\">$nip_pegawai</a>
								</li>
								<li class=\"list-group-item\">
									<b>Hp</b> <a class=\"pull-right\">$hp</a>
								</li>
								<li class=\"list-group-item\">
									<b>Email</b> <a class=\"pull-right\">$email</a>
								</li>
								<li class=\"list-group-item\">
									<b>Unit Kerja</b> <a class=\"pull-right\">$nama_unit</a>
								</li>
								<li class=\"list-group-item\">
									<b>Jabatan</b> <a class=\"pull-right\">$nama_jabatan</a>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class=\"col-md-9\">
					<div class=\"box box-info\">
						<div class=\"box-header with-border\">
							<h3 class=\"box-title\">Hak Akses</h3>
						</div>

						<div class=\"box-body\">
							<div class=\"row\">
								<form role=\"form\" class=\"form-horizontal\" method=\"post\" action=\"$link_back&act=proses&gid=$gid\">
									<div class=\"col-md-12\">
										<div class=\"form-group\">
											<label class=\"col-md-3\">Username *</label>
											<div class=\"col-md-7\">
												<input type=\"text\" name=\"username\" value=\"$username\" class=\"form-control\" required/>
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-md-3\">Password *</label>
											<div class=\"col-md-7\">
												<input type=\"password\" name=\"pw1\" value=\"$pw1\" class=\"form-control\" required/>
											</div>
										</div>
										<div class=\"form-group\">
											<label class=\"col-md-3\">Ulangi Password *</label>
											<div class=\"col-md-7\">
												<input type=\"password\" name=\"pw2\" value=\"$pw2\" class=\"form-control\" required/>
											</div>
										</div>
										<div class=\"form-group\" $disnos>
											<label class=\"col-md-3\">Hak Akses *</label>
											<div class=\"col-md-4\">
												<select name=\"level_user\" class=\"form-control\" required>
													<option value=\"\">- Pilih -</option>
													$opt_level
												</select>
											</div>
										</div>
										<div class=\"form-group\" $disnos>
											<label class=\"col-sm-3\"><b>Status *</b></label>
											<div class=\"col-sm-3\">
												<select name=\"status\" class=\"form-control\" required>
													<option value=\"\">- Pilih -</option>
													$opt_status
												</select>
											</div>
										</div>
										<div class=\"form-group\">
											<div class=\"col-md-12\">
												$edit
												<a href=\"$link_back\" class=\"btn bg-navy\"><i class=\"fa fa-caret-left\"></i> Kembali</a>
												<button type=\"submit\" class=\"btn btn-success\"><i class=\"fa fa-save\"></i> Simpan</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>";
		}else{
			echo"<div class=\"alert alert-warning\">Data Tidak Ditemukan</div>
			<meta http-equiv=\"refresh\" content=\"2;url=$link_back\">";
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

		$error="";
		$error.=(empty($username))? "&bull; Username Masih Kosong<br />" : "";
		$error.=(($pw1=="") or ($pw2==""))? "&bull; Password Masih Kosong<br />" : "";
		$error.=($pw1!="$pw2")? "&bull; Password tidak Sama<br />" : "";
		$error.=(empty($level_user))? "&bull; Hak Akses Masih Kosong<br />" : "";
		$error.=(empty($status))? "&bull; Statsus Masih Kosong<br />" : "";

		if($level_id!=1){
			$gid="$ss_pegawai";
		}else{
			$gid="$gid";
		}
		
		if(empty($error)){
			$sqld2="select * from db_user where id_pegawai=\"$gid\" and hapus=\"0\" and id_pegawai>\"0\"";
			$data2=mysqli_query($db_result, $sqld2);
			$ndata2=mysqli_num_rows($data2);
			if($ndata2>0){
				$fdata2=mysqli_fetch_assoc($data2);
				$fid=$fdata2["id"];
				$psw1=$fdata2["password"];


				if($psw1!="$pw1"){
					$wpass="password=password(\"$pw1\"),";
				}
				
				if($lmn[$idsmenu][2]==1){
					$sqld2="select * from db_user where username=\"$username\" and hapus=\"0\"";
					$data2=mysqli_query($db_result, $sqld2);
					$ndata2=mysqli_num_rows($data2);
					if($ndata2>0){
						$fdata2=mysqli_fetch_assoc($data2);
						$id2=$fdata2["id_pegawai"];
						$user_update="$ss_id, ".$fdata2["user_update"];

						if($id2=="$gid"){
							$vdata="$wpass level_user=\"$level_user\", status=\"$status\", tgl_update=\"$ndatetime\", user_update=\"$user_update\"";
							$vvalues="id=\"$fid\"";

							$inp="update db_user set $vdata where $vvalues";
							$upd=mysqli_query($db_result, $inp);
							if($upd==1){
								echo"<div class=\"alert alert-success\">Data Berhasil Dirubah</div>";
							}else{
								echo"<div class=\"alert alert-danger\">Data Gagal Dirubah</div>";
							}
						}else{
							echo"<div class=\"alert alert-warning\">Username <b>$username</b> sudah digunakan Pegawai lain</div>";
						}
					}else{
						$vdata="$wpass username=\"$username\", level_user=\"$level_user\", status=\"$status\", tgl_update=\"$ndatetime\", user_update=\"$user_update\"";
						$vvalues="id=\"$fid\"";

						$inp="update db_user set $vdata where $vvalues";
						$upd=mysqli_query($db_result, $inp);
						if($upd==1){
							echo"<div class=\"alert alert-success\">Data Berhasil Dirubah</div>";
						}else{
							echo"<div class=\"alert alert-danger\">Data Gagal Dirubah</div>";
						}
					}
				}else{
					echo"<div class=\"alert alert-error\">Anda Tidak Diizinkan Mengakses Menu ini</div>";
				}

			}else{
				$sqld="select * from db_pegawai where id=\"$gid\" and hapus=\"0\"";
				$data=mysqli_query($db_result, $sqld);
				$ndata=mysqli_num_rows($data);
				if($ndata>0){
					$fdata2=mysqli_fetch_assoc($data);
					$id_pegawai=$fdata2["id"];
					$no_telp=$fdata2["hp"];
					$nama_user=$fdata2["nama_pegawai"];

					$sqld2="select * from db_user where username=\"$username\" and hapus=\"0\"";
					$data2=mysqli_query($db_result, $sqld2);
					$ndata2=mysqli_num_rows($data2);
					if($ndata2==0){
						
						if($lmn[$idsmenu][1]==1){
							$vdata="username, no_telp, password, nama_user, id_pegawai, level_user, status, hapus, tgl_insert, tgl_update, user_update";
							$vvalues="\"$username\", \"$no_telp\", password(\"$pw1\"), \"$nama_user\", \"$id_pegawai\", \"$level_user\", \"$status\", \"0\", \"$ndatetime\", \"$ndatetime\", \"$ss_id\"";

							$inp="insert into db_user ($vdata) values ($vvalues)";
							$upd=mysqli_query($db_result, $inp);
							if($upd==1){
								echo"<div class=\"alert alert-success\">Data Berhasil Ditambah</div>";
							}else{
								echo"<div class=\"alert alert-danger\">Data Gagal Ditambah</div>";
							}
						}else{
							echo"<div class=\"alert alert-error\">Anda Tidak Diizinkan Mengakses Menu ini</div>";
						}
					}else{
						echo"<div class=\"alert alert-error\">Username <b>$username</b> Sudah Digunakan</div>";
					}
				}else{
					echo"<div class=\"alert alert-warning\">Data Tidak Ditemukan</div>";
				}
			}
		}else{
			echo"<div class=\"alert alert-warning\">$error</div>";
		}

		echo"<meta http-equiv=\"refresh\" content=\"2;url=$link_back\">";
	break;


}
}
?>
