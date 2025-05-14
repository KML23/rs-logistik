<?php
if (preg_match("/\bindex.php\b/i", $_SERVER['REQUEST_URI'])) {
    exit;
} else {
    switch ($act) {
        // Menampilkan Data Satuan Barang dengan fitur pencarian
        default:
            // Ambil nilai pencarian dari parameter GET
            $gname = isset($_GET['gname']) ? mysqli_real_escape_string($db_result, $_GET['gname']) : '';

            // Query dengan filter pencarian
            $sqld = "SELECT * FROM gl_jenis_barang WHERE hapus = 0 AND nama_jenis LIKE '%$gname%'";
            $data = mysqli_query($db_result, $sqld);
            $ndata = mysqli_num_rows($data);

            if ($ndata > 0) {
                $no = 0;
                $td_table = '';
                while ($fdata = mysqli_fetch_assoc($data)) {
                    extract($fdata);
                    $no++;

                    $btn_edit = "<a href=\"$link_back&act=input&gket=edit&gid=$id\" class=\"btn btn-xs btn-success\">Edit</a>";
                    $btn_hapus = "<a href=\"$link_back&act=hapus&gid=$id\" onclick=\"return confirm('Apakah Anda Yakin Menghapus Data ini?');\" class=\"btn btn-xs btn-danger\">Hapus</a>";

                    $nama_status = ($status == 1) ? 'Aktif' : 'Tidak Aktif';
                    $btn_status = "<span class=\"badge bg-" . ($status == 1 ? 'green' : 'red') . "\">$nama_status</span>";

                    $td_table .= "<tr>
                        <td>$no</td>
                        <td>$nama_jenis</td>
                        <td>$btn_status</td>
                        <td>$btn_edit $btn_hapus</td>
                    </tr>";
                }
            }

            if ($lmn[$idsmenu][1] == 1) {
                $link_add = "$link_back&act=input&gket=tambah";
                $btn_add = "<a href=\"$link_add\" class=\"btn btn-primary\"><i class=\"fa fa-plus\"></i> Tambah Data</a>";
            }

            // Form Pencarian
            echo "<div class=\"row\">
                <div class=\"col-md-12\">
                    <div class='box box-primary'>
                        <div class=\"box-header border-bottom1\">
                            <h3 class=\"box-title\">Pencarian</h3>
                        </div>
                        <div class=\"box-body\">
                            <form role=\"form\" class=\"form-horizontal\" method=\"get\">
                                <input name=\"pages\" type=\"hidden\" value=\"$pages\" />
                                <div class=\"form-group\">
                                    <label class=\"col-sm-2 control-label text-left\">Cari Jenis Barang</label>
                                    <div class=\"col-sm-3\">
                                        <input type=\"text\" class=\"form-control\" name=\"gname\" value=\"$gname\" placeholder=\"Nama Jenis Barang\">
                                    </div>
                                </div>
                                <div class=\"form-group\">
                                    <div class=\"col-sm-offset-1 col-sm-5\">
                                        <button type=\"submit\" class=\"btn bg-maroon\"><i class=\"fa fa-search\"></i> Cari</button>
                                        <a href=\"$link_back\" class=\"btn btn-info\"><i class=\"fa fa-refresh\"></i> Refresh</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";

            // Tampilkan Data
            echo "<div class=\"row\">
                <div class=\"col-md-12\">
                    <div class='box box-primary'>
                        <div class=\"box-header border-bottom1\">
                            <h3 class=\"box-title\">Data Jenis Barang</h3>
                        </div>
                        <div class=\"box-body\">
                            $btn_add
                            <div class=\"clearfix\"></div><br />
                            <div class=\"table-responsive\">
                                <table id=\"dttable\" class=\"table table-bordered table-hover\">
                                    <thead>
                                        <tr>
                                            <th width=\"50\">No</th>
                                            <th>Nama Jenis Barang</th>
                                            <th width=\"50\">Status</th>
                                            <th width=\"150\">Aksi</th>
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
        // Menambah atau Mengedit Data Jenis Barang
        case "input":
            if ($gket == "tambah" && $lmn[$idsmenu][1] == 1) {
                $judul = "Tambah Data Jenis Barang";
            } elseif ($gket == "edit" && $lmn[$idsmenu][2] == 1) {
                $judul = "Edit Data Jenis Barang";

                $sqld = "SELECT * FROM gl_jenis_barang WHERE id = ? AND hapus = 0";
                $stmt = mysqli_prepare($db_result, $sqld);
                mysqli_stmt_bind_param($stmt, "i", $gid);
                mysqli_stmt_execute($stmt);
                $data = mysqli_stmt_get_result($stmt);
                $ndata = mysqli_num_rows($data);

                if ($ndata > 0) {
                    $fdata = mysqli_fetch_assoc($data);
                    extract($fdata);
                    $edit = "<input name=\"pid\" type=\"hidden\" value=\"$id\" />";
                }
            }

            if ($ndata > 0 || $gket == "tambah") {
                echo "<div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class='box box-primary'>
                            <div class=\"box-header border-bottom1\">
                                Data &raquo; $judul
                            </div>
                            <div class=\"box-body\">
                                <form role=\"form\" class=\"form-horizontal\" method=\"post\" action=\"$link_back&act=proses&gket=$gket\">
                                    <div class=\"form-group\">
                                        <label class=\"col-sm-2 text-left\"><b>Nama Jenis Barang</b></label>
                                        <div class=\"col-sm-3\">
                                            <input type=\"text\" class=\"form-control\" name=\"nama_jenis\" value=\"$nama_jenis\" required />
                                        </div>
                                    </div>
                                    <div class=\"form-group\">
                                        <label class=\"col-sm-2 text-left\"><b>Status</b></label>
                                        <div class=\"col-sm-3\">
                                            <select name=\"status\" class=\"form-control\" required>
                                                <option value=\"1\" " . ($status == 1 ? 'selected' : '') . ">Aktif</option>
                                                <option value=\"2\" " . ($status == 2 ? 'selected' : '') . ">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class=\"form-group\">
                                        <div class=\"col-sm-offset-1 col-sm-5\">
                                            $edit
                                            <a href=\"$link_back\" class=\"btn bg-navy\"><i class=\"fa fa-caret-left\"></i> Kembali</a>
                                            <button type=\"submit\" class=\"btn btn-success\"><i class=\"fa fa-save\"></i> Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";
            } else {
                echo "<div class=\"alert alert-warning\">Data Tidak Ditemukan</div>";
                echo "<meta http-equiv=\"refresh\" content=\"2;url=$link_back\">";
            }
            break;

        // Proses Menambah atau Mengedit Data Jenis Barang
        case "proses":
            if (count($_POST) > 0) {
                $nama_jenis = mysqli_real_escape_string($db_result, $_POST['nama_jenis']);
                $status = mysqli_real_escape_string($db_result, $_POST['status']);

                if ($gket == "tambah" && $lmn[$idsmenu][1] == 1) {
                    $inp = "INSERT INTO gl_jenis_barang (nama_jenis, status, hapus, tgl_insert, user_update)
                            VALUES (?, ?, 0, NOW(), 'admin')";
                    $stmt = mysqli_prepare($db_result, $inp);
                    mysqli_stmt_bind_param($stmt, "si", $nama_jenis, $status);
                    $upd = mysqli_stmt_execute($stmt);
                    $nket = ($upd) ? "<div class=\"alert alert-success\">Data Berhasil Ditambah</div>" : "<div class=\"alert alert-danger\">Data Gagal Ditambah</div>";
                } elseif ($gket == "edit" && $lmn[$idsmenu][2] == 1) {
                    $pid = mysqli_real_escape_string($db_result, $_POST['pid']);
                    $inp = "UPDATE gl_jenis_barang SET 
                            nama_jenis = ?, 
                            status = ?, 
                            tgl_update = NOW(), 
                            user_update = 'admin' 
                            WHERE id = ?";
                    $stmt = mysqli_prepare($db_result, $inp);
                    mysqli_stmt_bind_param($stmt, "sii", $nama_jenis, $status, $pid);
                    $upd = mysqli_stmt_execute($stmt);
                    $nket = ($upd) ? "<div class=\"alert alert-success\">Data Berhasil Dirubah</div>" : "<div class=\"alert alert-danger\">Data Gagal Dirubah</div>";
                }
            }

            echo "$nket
            <meta http-equiv=\"refresh\" content=\"2;url=$link_back\">";
            break;

        // Menghapus Data Jenis Barang
        case "hapus":
            if ($lmn[$idsmenu][3] == 1) {
                $inp = "UPDATE gl_jenis_barang SET hapus = 1, tgl_update = NOW(), user_update = 'admin' WHERE id = ?";
                $stmt = mysqli_prepare($db_result, $inp);
                mysqli_stmt_bind_param($stmt, "i", $gid);
                $upd = mysqli_stmt_execute($stmt);
                $nket = ($upd) ? "<div class=\"alert alert-success\">Data Berhasil Dihapus</div>" : "<div class=\"alert alert-danger\">Data Gagal Dihapus</div>";
            } else {
                $nket = "<div class=\"alert alert-warning\">Anda Tidak Memiliki Akses</div>";
            }

            echo "$nket
            <meta http-equiv=\"refresh\" content=\"2;url=$link_back\">";
            break;
    }
}
?>
