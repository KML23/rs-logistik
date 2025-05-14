<?php
if (preg_match("/\bindex.php\b/i", $_SERVER['REQUEST_URI'])) {
    exit;
} else {
    switch ($act) {
        // Default, tampilkan daftar data order barang
        default:
            // Query untuk mengambil data order barang dengan join ke tabel order dan barang
            $sqld = "SELECT ob.*, o.tgl_order, o.no_faktur, b.nama_barang FROM gl_order_barang ob 
                     JOIN gl_order o ON ob.id_gl_order = o.id 
                     JOIN gl_data_barang b ON ob.id_gl_data_barang = b.id 
                     WHERE ob.hapus = 0";
            $data = mysqli_query($db_result, $sqld);
            if (!$data) {
                die("Query Error: " . mysqli_error($db_result)); // Debugging
            }
            $ndata = mysqli_num_rows($data);

            $td_table = '';
            if ($ndata > 0) {
                $no = 0;
                while ($fdata = mysqli_fetch_assoc($data)) {
                    extract($fdata);
                    $no++;

                    // Tombol untuk edit dan hapus
                    $btn_edit = "<a href='$link_back&act=input&gket=edit&gid=$id' class='btn btn-xs btn-success'><i class='fa fa-edit'></i> Edit</a>";
                    $btn_hapus = "<a href='$link_back&act=hapus&gid=$id' onclick='return confirm(\"Apakah Anda yakin?\");' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i> Hapus</a>";

                    // Tabel data order barang
                    $td_table .= "<tr>
                        <td>$no</td>
                        <td>$tgl_order</td>
                        <td>$no_faktur</td>
                        <td>$nama_barang</td>
                        <td>$jml_barang</td>
                        <td>$harga_beli</td>
                        <td>$total_beli</td>
                        <td>$btn_edit $btn_hapus</td>
                    </tr>";
                }
            }

            // Query untuk mengambil data barang dari tabel gl_data_barang
            $sql_barang = "SELECT id, nama_barang FROM gl_data_barang WHERE hapus = 0";
            $result_barang = mysqli_query($db_result, $sql_barang);
            if (!$result_barang) {
                die("Query Error: " . mysqli_error($db_result)); // Debugging
            }
            $barangs = [];
            while ($row = mysqli_fetch_assoc($result_barang)) {
                $barangs[] = $row;
            }

            // Tombol tambah data order barang
            if ($lmn[$idsmenu][1] == 1) {
                $link_add = "$link_back&act=input&gket=tambah"; // Arahkan ke form tambah data order barang
                $btn_add = "<a href='$link_add' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah Data Order Barang</a>";
            } else {
                $btn_add = ""; // Tombol tidak ditampilkan jika pengguna tidak memiliki izin
            }

            // Tabel Data Order Barang
            echo "<div class='row'>
                <div class='col-md-12'>
                    <div class='box box-primary'>
                        <div class='box-header with-border'>
                            <h3 class='box-title'>Data Order Barang</h3>
                        </div>
                        <div class='box-body'>
                            $btn_add
                            <div class='table-responsive'>
                                <table id='dttable' class='table table-bordered table-striped'>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Order</th>
                                            <th>No Faktur</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Barang</th>
                                            <th>Harga Beli</th>
                                            <th>Total Beli</th>
                                            <th>Aksi</th>
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

        // Menambah atau Mengedit Data Order Barang
        case "input":
            // Ambil data barang untuk dropdown
            $sql_barang = "SELECT id, nama_barang FROM gl_data_barang WHERE hapus = 0";
            $result_barang = mysqli_query($db_result, $sql_barang);
            if (!$result_barang) {
                die("Query Error: " . mysqli_error($db_result)); // Debugging
            }
            $barangs = [];

            if ($result_barang) {
                while ($row = mysqli_fetch_assoc($result_barang)) {
                    $barangs[] = $row;
                }
            } else {
                echo "<div class='alert alert-danger'>Gagal mengambil data barang.</div>";
            }

            if ($gket == "tambah" && $lmn[$idsmenu][1] == 1) {
                $judul = "Tambah Data Order Barang";
            } elseif ($gket == "edit" && $lmn[$idsmenu][2] == 1) {
                $judul = "Edit Data Order Barang";

                $sqld = "SELECT * FROM gl_order_barang WHERE id = ? AND hapus = 0";
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
                echo "<div class='row'>
                    <div class='col-md-12'>
                        <div class='box box-primary'>
                            <div class='box-header with-border'>
                                Data &raquo; $judul
                            </div>
                            <div class='box-body'>
                                <form role='form' class='form-horizontal' method='post' action='$link_back&act=proses&gket=$gket'>
                                    <div class='form-group'>
                                        <label class='col-sm-2 text-left'><b>Order</b></label>
                                        <div class='col-sm-3'>
                                            <select name='id_gl_order' class='form-control' required>
                                                <option value=''>Pilih Order</option>";
                                                // Ambil data order untuk dropdown
                                                $sql_order = "SELECT id, no_faktur FROM gl_order WHERE hapus = 0";
                                                $result_order = mysqli_query($db_result, $sql_order);
                                                if (!$result_order) {
                                                    die("Query Error: " . mysqli_error($db_result)); // Debugging
                                                }
                                                while ($row_order = mysqli_fetch_assoc($result_order)) {
                                                    echo "<option value='{$row_order['id']}' " . ($id_gl_order == $row_order['id'] ? 'selected' : '') . ">{$row_order['no_faktur']}</option>";
                                                }
                                            echo "</select>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-sm-2 text-left'><b>Barang</b></label>
                                        <div class='col-sm-3'>
                                            <select name='id_gl_data_barang' class='form-control' required>
                                                <option value=''>Pilih Barang</option>";
                                                foreach ($barangs as $barang) {
                                                    echo "<option value='{$barang['id']}' " . ($id_gl_data_barang == $barang['id'] ? 'selected' : '') . ">{$barang['nama_barang']}</option>";
                                                }
                                            echo "</select>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-sm-2 text-left'><b>Jumlah Barang</b></label>
                                        <div class='col-sm-3'>
                                            <input type='text' class='form-control' name='jml_barang' value='$jml_barang' required />
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-sm-2 text-left'><b>Harga Beli</b></label>
                                        <div class='col-sm-3'>
                                            <input type='text' class='form-control' name='harga_beli' value='$harga_beli' required />
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-sm-2 text-left'><b>Total Beli</b></label>
                                        <div class='col-sm-3'>
                                            <input type='text' class='form-control' name='total_beli' value='$total_beli' required />
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='col-sm-offset-1 col-sm-5'>
                                            $edit
                                            <a href='$link_back' class='btn bg-navy'><i class='fa fa-caret-left'></i> Kembali</a>
                                            <button type='submit' class='btn btn-success'><i class='fa fa-save'></i> Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";
            } else {
                echo "<div class='alert alert-warning'>Data Tidak Ditemukan</div>";
                echo "<meta http-equiv='refresh' content='2;url=$link_back'>";
            }
            break;

        // Proses Menambah atau Mengedit Data Order Barang
        case "proses":
            if (count($_POST) > 0) {
                $id_gl_order = mysqli_real_escape_string($db_result, $_POST['id_gl_order']);
                $id_gl_data_barang = mysqli_real_escape_string($db_result, $_POST['id_gl_data_barang']);
                $jml_barang = mysqli_real_escape_string($db_result, $_POST['jml_barang']);
                $harga_beli = mysqli_real_escape_string($db_result, $_POST['harga_beli']);
                $total_beli = mysqli_real_escape_string($db_result, $_POST['total_beli']);

                if ($gket == "tambah" && $lmn[$idsmenu][1] == 1) {
                    $inp = "INSERT INTO gl_order_barang (id_gl_order, id_gl_data_barang, jml_barang, harga_beli, total_beli, hapus, tgl_insert, user_update)
                            VALUES (?, ?, ?, ?, ?, 0, NOW(), 'admin')";
                    $stmt = mysqli_prepare($db_result, $inp);
                    mysqli_stmt_bind_param($stmt, "iisii", $id_gl_order, $id_gl_data_barang, $jml_barang, $harga_beli, $total_beli);
                    $upd = mysqli_stmt_execute($stmt);
                    $nket = ($upd) ? "<div class='alert alert-success'>Data Berhasil Ditambah</div>" : "<div class='alert alert-danger'>Data Gagal Ditambah</div>";

                } elseif ($gket == "edit" && $lmn[$idsmenu][2] == 1) {
                    $pid = mysqli_real_escape_string($db_result, $_POST['pid']);
                    $inp = "UPDATE gl_order_barang SET 
                            id_gl_order = ?, 
                            id_gl_data_barang = ?, 
                            jml_barang = ?, 
                            harga_beli = ?, 
                            total_beli = ?, 
                            tgl_update = NOW(), 
                            user_update = 'admin' 
                            WHERE id = ?";
                    $stmt = mysqli_prepare($db_result, $inp);
                    mysqli_stmt_bind_param($stmt, "iisiii", $id_gl_order, $id_gl_data_barang, $jml_barang, $harga_beli, $total_beli, $pid);
                    $upd = mysqli_stmt_execute($stmt);
                    $nket = ($upd) ? "<div class='alert alert-success'>Data Berhasil Dirubah</div>" : "<div class='alert alert-danger'>Data Gagal Dirubah</div>";
                }
            }

            echo "$nket
            <meta http-equiv='refresh' content='2;url=$link_back'>";
            break;

        // Menghapus Data Order Barang
        case "hapus":
            if ($lmn[$idsmenu][3] == 1) {
                $inp = "UPDATE gl_order_barang SET hapus = 1, tgl_update = NOW(), user_update = 'admin' WHERE id = ?";
                $stmt = mysqli_prepare($db_result, $inp);
                mysqli_stmt_bind_param($stmt, "i", $gid);
                $upd = mysqli_stmt_execute($stmt);
                $nket = ($upd) ? "<div class='alert alert-success'>Data Berhasil Dihapus</div>" : "<div class='alert alert-danger'>Data Gagal Dihapus</div>";
            } else {
                $nket = "<div class='alert alert-warning'>Anda Tidak Memiliki Akses</div>";
            }

            echo "$nket
            <meta http-equiv='refresh' content='2;url=$link_back'>";
            break;
    }
}
?>