<?php
if (preg_match("/\bindex.php\b/i", $_SERVER['REQUEST_URI'])) {
    exit;
} else {
    switch ($act) {
        // Menampilkan Data gl_data_supplier
        default:
            $sqld = "SELECT * FROM gl_data_supplier WHERE hapus = 0";
            $data = mysqli_query($db_result, $sqld);
            $ndata = mysqli_num_rows($data);
            
            $td_table = '';
            if ($ndata > 0) {
                $no = 0;
                while ($fdata = mysqli_fetch_assoc($data)) {
                    extract($fdata);
                    $no++;
                    
                    $btn_edit = "<a href='$link_back&act=input&gket=edit&gid=$id' class='btn btn-xs btn-success'>Edit</a>";
                    $btn_hapus = "<a href='$link_back&act=hapus&gid=$id' onclick=\"return confirm('Apakah Anda Yakin Menghapus Data ini?');\" class='btn btn-xs btn-danger'>Hapus</a>";
                    
                    $nama_status = ($status == 1) ? 'Aktif' : 'Tidak Aktif';
                    $btn_status = "<span class='badge bg-" . ($status == 1 ? 'green' : 'red') . "'>$nama_status</span>";
                    
                    $td_table .= "<tr>
                        <td>$no</td>
                        <td>$nama_supplier</td>
                        <td>$btn_status</td>
                        <td>$btn_edit $btn_hapus</td>
                    </tr>";
                }
            }
            
            $link_add = "$link_back&act=input&gket=tambah";
            $btn_add = "<a href='$link_add' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah Data</a>";

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
                                    <label class=\"col-sm-2 control-label text-left\">Cari Supplier</label>
                                    <div class=\"col-sm-3\">
                                        <input type=\"text\" class=\"form-control\" name=\"gname\" value=\"$gname\" placeholder=\"Nama Supplier\">
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
            
            echo "<div class='row'>
                <div class='col-md-12'>
                    <div class='box box-primary'>
                        <div class='box-header border-bottom1'>
                            <h3 class='box-title'>Data Supplier</h3>
                        </div>
                        <div class='box-body'>
                            $btn_add
                            <br /><br />
                            <div class='table-responsive'>
                                <table class='table table-bordered table-hover'>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Supplier</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>$td_table</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
            break;
        
        // Menambah atau Mengedit Data gl_data_supplier
        case "input":
            $judul = ($gket == "tambah") ? "Tambah Data Supplier" : "Edit Data Supplier";
            if ($gket == "edit" && isset($gid)) {
                $sqld = "SELECT * FROM gl_data_supplier WHERE id = ? AND hapus = 0";
                $stmt = mysqli_prepare($db_result, $sqld);
                mysqli_stmt_bind_param($stmt, "i", $gid);
                mysqli_stmt_execute($stmt);
                $data = mysqli_stmt_get_result($stmt);
                $fdata = mysqli_fetch_assoc($data);
                extract($fdata);
            }
            echo "<div class='row'>
                <div class='col-md-12'>
                    <div class='box box-primary'>
                        <div class='box-header with-border'>
                            <h3 class='box-title'>$judul</h3>
                        </div>
                        <div class='box-body'>
                            <form method='post' action='$link_back&act=proses&gket=$gket'>
                                <input type='hidden' name='gid' value='".($gid ?? '')."'>
                                <div class='form-group'>
                                    <label>Nama Supplier</label>
                                    <input type='text' class='form-control' name='nama_supplier' value='".($nama_supplier ?? '')."' required>
                                </div>
                                <div class='form-group'>
                                    <label>Status</label>
                                    <select name='status' class='form-control' required>
                                        <option value='1' ".(($status ?? '') == 1 ? 'selected' : '').">Aktif</option>
                                        <option value='0' ".(($status ?? '') == 0 ? 'selected' : '').">Tidak Aktif</option>
                                    </select>
                                </div>
                                <button type='submit' class='btn btn-success'>Simpan</button>
                                <a href='$link_back' class='btn btn-default'>Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";
            break;
        
        // Proses Tambah/Edit Data
        case "proses":
            $nama_supplier = mysqli_real_escape_string($db_result, $_POST['nama_supplier']);
            $status = intval($_POST['status']);
            $gid = isset($_POST['gid']) ? intval($_POST['gid']) : 0;
            
            if ($gket == "tambah") {
                $query = "INSERT INTO gl_data_supplier (nama_supplier, status, hapus, tgl_insert, user_update) VALUES (?, ?, 0, NOW(), 'admin')";
            } elseif ($gket == "edit" && $gid > 0) {
                $query = "UPDATE gl_data_supplier SET nama_supplier = ?, status = ?, tgl_update = NOW(), user_update = 'admin' WHERE id = ?";
            }
            
            $stmt = mysqli_prepare($db_result, $query);
            ($gket == "edit") ? mysqli_stmt_bind_param($stmt, "sii", $nama_supplier, $status, $gid) : mysqli_stmt_bind_param($stmt, "si", $nama_supplier, $status);
            $result = mysqli_stmt_execute($stmt);
            
            if ($result) {
                echo "<div class='alert alert-success'>Data Berhasil Disimpan</div>";
                echo "<meta http-equiv='refresh' content='2;url=$link_back'>";
            } else {
                echo "<div class='alert alert-danger'>Terjadi Kesalahan: " . mysqli_error($db_result) . "</div>";
            }
            break;
        
        // Menghapus Data
        case "hapus":
            $query = "UPDATE gl_data_supplier SET hapus = 1, tgl_update = NOW(), user_update = 'admin' WHERE id = ?";
            $stmt = mysqli_prepare($db_result, $query);
            mysqli_stmt_bind_param($stmt, "i", $gid);
            $result = mysqli_stmt_execute($stmt);
            echo $result ? "<div class='alert alert-success'>Data Berhasil Dihapus</div>" : "<div class='alert alert-danger'>Data Gagal Dihapus</div>";
            echo "<meta http-equiv='refresh' content='2;url=$link_back'>";
            break;
    }
}
