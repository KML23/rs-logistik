<?php
if (preg_match("/\bindex.php\b/i", $_SERVER['REQUEST_URI'])) {
    exit;
} else {
    switch ($act) {
        // Default, tampilkan daftar data order
        default:
            // Inisialisasi variabel pencarian
            $gname = isset($_GET['gname']) ? mysqli_real_escape_string($db_result, $_GET['gname']) : '';

            // Query untuk mengambil data order dengan join ke tabel supplier
            $sqld = "SELECT o.*, s.nama_supplier FROM gl_order o 
                     JOIN gl_data_supplier s ON o.id_gl_supplier = s.id 
                     WHERE o.hapus = 0";

            // Tambahkan filter pencarian jika ada input
            if (!empty($gname)) {
                $sqld .= " AND s.nama_supplier LIKE '%$gname%'";
            }

            $data = mysqli_query($db_result, $sqld);
            $ndata = mysqli_num_rows($data);

            $td_table = '';
            if ($ndata > 0) {
                $no = 0;
                while ($fdata = mysqli_fetch_assoc($data)) {
                    extract($fdata);
                    $no++;
            
                    // Tombol untuk edit, hapus, dan detail
                    $btn_edit = "<a href='$link_back&act=input&gket=edit&gid=$id' class='btn btn-xs btn-success'><i class='fa fa-edit'></i> Edit</a>";
                    $btn_hapus = "<a href='$link_back&act=hapus&gid=$id' onclick='return confirm(\"Apakah Anda yakin?\");' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i> Hapus</a>";
                    $btn_detail = "<a href='$link_back&act=detail&gid=$id' class='btn btn-xs btn-info'><i class='fa fa-info-circle'></i> Detail</a>";
                 
                    // Status order
                    $nama_status = ($status == 1) ? 'Aktif' : 'Tidak Aktif';
                    $btn_status = "<span class='label label-" . ($status == 1 ? 'success' : 'danger') . "'>$nama_status</span>";
            
                    // Tabel data order
                    $td_table .= "<tr>
                        <td>$no</td>
                        <td>$tgl_order</td>
                        <td>$nama_supplier</td>
                        <td>$tgl_datang</td>
                        <td>$no_faktur</td>
                        <td>$btn_status</td>
                        <td>";
                        // Jika order sudah disimpan, hanya tampilkan tombol "Lihat" dan nonaktifkan "Edit"
                        if ($simpan == 1) {
                            // Tombol Lihat Saja
                            $td_table .= "<a href='$link_back&act=detail&gid=$id' class='btn btn-xs btn-success' style='margin-right: 5px;'><i class='fa fa-eye'></i> Lihat</a>";
                            // Tombol Hapus dinonaktifkan dan diberikan arahan untuk membatalkan order
                            $td_table .= "<a href='$link_back&act=batal_order&gid=$id' class='btn btn-xs btn-danger' style='margin-right: 5px;' onclick='return confirmCancel();'><i class='fa fa-times'></i> Batalkan Order</a>";
                        } else {
                            // Tombol Edit, hanya tampilkan jika order belum disimpan
                            $td_table .= "<a href='$link_back&act=input&gket=edit&gid=$id' class='btn btn-xs btn-success' style='margin-right: 5px;'><i class='fa fa-edit'></i> Edit<br></a>";
                            // Tombol Hapus (Tetap ada hanya jika order belum disimpan)
                            $td_table .= "<a href='$link_back&act=hapus&gid=$id' onclick='return confirm(\"Apakah Anda yakin?\");' class='btn btn-xs btn-danger' style='margin-right: 5px;'><i class='fa fa-trash'></i> Hapus</a>";
                        }
                        
                        // Tombol Detail
                        $td_table .= "<a href='$link_back&act=detail&gid=$id' class='btn btn-xs btn-info'><i class='fa fa-info-circle'></i> Detail</a>";
                        $td_table .= "</td></tr>";
                }
            } else {
                $td_table .= "<tr><td colspan='7' class='text-center'>Tidak ada data ditemukan</td></tr>";
            }

            // Query untuk mengambil data supplier dari tabel gl_data_supplier
            $sql_supplier = "SELECT id, nama_supplier FROM gl_data_supplier WHERE status = 1 AND hapus = 0";
            $result_supplier = mysqli_query($db_result, $sql_supplier);
            $suppliers = [];
            while ($row = mysqli_fetch_assoc($result_supplier)) {
                $suppliers[] = $row;
            }

            // Tombol tambah data order
            if ($lmn[$idsmenu][1] == 1) {
                $link_add = "$link_back&act=input&gket=tambah"; // Arahkan ke form tambah data order
                $btn_add = "<a href='$link_add' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah Data Order</a>";
            } else {
                $btn_add = ""; // Tombol tidak ditampilkan jika pengguna tidak memiliki izin
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

            // Tabel Data Order
            echo "<div class='row'>
                <div class='col-md-12'>
                    <div class='box box-primary'>
                        <div class='box-header with-border'>
                            <h3 class='box-title'>Data Order</h3>
                        </div>
                        <div class='box-body'>
                            $btn_add
                            <div class=\"clearfix\"></div><br />
                            <div class='table-responsive'>
                                <table id='dttable' class='table table-bordered table-striped'>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Order</th>
                                            <th>Supplier</th>
                                            <th>Tanggal Datang</th>
                                            <th>No Faktur</th>
                                            <th>Status</th>
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

        // Menambah atau Mengedit Data Order
        case "input":
    // Ambil data supplier untuk dropdown
    $sql_supplier = "SELECT id, nama_supplier FROM gl_data_supplier WHERE status = 1 AND hapus = 0";
    $result_supplier = mysqli_query($db_result, $sql_supplier);
    $suppliers = [];

    if ($result_supplier) {
        while ($row = mysqli_fetch_assoc($result_supplier)) {
            $suppliers[] = $row;
        }
    } else {
        echo "<div class='alert alert-danger'>Gagal mengambil data supplier.</div>";
    }

    if ($gket == "tambah" && $lmn[$idsmenu][1] == 1) {
        $judul = "Tambah Data Order";
    } elseif ($gket == "edit" && $lmn[$idsmenu][2] == 1) {
        $judul = "Edit Data Order";

        // Ambil data order berdasarkan ID
        $sqld = "SELECT * FROM gl_order WHERE id = ?";
        $stmt = mysqli_prepare($db_result, $sqld);
        mysqli_stmt_bind_param($stmt, "i", $gid);
        mysqli_stmt_execute($stmt);
        $data = mysqli_stmt_get_result($stmt);
        $ndata = mysqli_num_rows($data);

        if ($ndata > 0) {
            $fdata = mysqli_fetch_assoc($data);
            extract($fdata); // Ambil data ke dalam variabel

            // Jika data dihapus, tampilkan keterangan
            if ($hapus == 1) {
                echo "<div class='alert alert-warning'>
                    <strong>Data ini sebelumnya dihapus!</strong><br>
                    Keterangan: $keterangan
                </div>";
            }

            // Buat input hidden untuk ID agar dapat diupdate
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
                                <label class='col-sm-2 text-left'><b>Tanggal Order</b></label>
                                <div class='col-sm-3'>
                                    <input type='date' class='form-control' name='tgl_order' value='$tgl_order' required />
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-sm-2 text-left'><b>Supplier</b></label>
                                <div class='col-sm-3'>
                                    <select name='id_gl_supplier' class='form-control' required>
                                        <option value=''>Pilih Supplier</option>";
                                        foreach ($suppliers as $supplier) {
                                            echo "<option value='{$supplier['id']}' " . ($id_gl_supplier == $supplier['id'] ? 'selected' : '') . ">{$supplier['nama_supplier']}</option>";
                                        }
                                    echo "</select>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-sm-2 text-left'><b>Tanggal Datang</b></label>
                                <div class='col-sm-3'>
                                    <input type='date' class='form-control' name='tgl_datang' value='$tgl_datang' required />
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-sm-2 text-left'><b>No Faktur</b></label>
                                <div class='col-sm-3'>
                                    <input type='text' class='form-control' name='no_faktur' value='$no_faktur' required />
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-sm-2 text-left'><b>Status</b></label>
                                <div class='col-sm-3'>
                                    <select name='status' class='form-control' required>
                                        <option value='1' " . ($status == 1 ? 'selected' : '') . ">Aktif</option>
                                        <option value='2' " . ($status == 2 ? 'selected' : '') . ">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-sm-2 text-left'><b>Keterangan</b></label>
                                <div class='col-sm-5'>
                                    <textarea class='form-control' name='keterangan'>$keterangan</textarea>
                                </div>
                            </div>";
                            
                            // Jika merestore data yang dihapus
                            if ($gket == "restore") {
                                echo "<input type='hidden' name='restore' value='1'>";
                            }
                            
                            echo "<div class='form-group'>
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



case "proses":
    if (count($_POST) > 0) {
        $tgl_order = mysqli_real_escape_string($db_result, $_POST['tgl_order']);
        $id_gl_supplier = mysqli_real_escape_string($db_result, $_POST['id_gl_supplier']);
        $tgl_datang = mysqli_real_escape_string($db_result, $_POST['tgl_datang']);
        $no_faktur = mysqli_real_escape_string($db_result, $_POST['no_faktur']);
        $status = mysqli_real_escape_string($db_result, $_POST['status']);
        $keterangan = mysqli_real_escape_string($db_result, $_POST['keterangan']);

        // Update order data
        if ($gket == "edit" && $lmn[$idsmenu][2] == 1) {
            $pid = mysqli_real_escape_string($db_result, $_POST['pid']);
            $inp = "UPDATE gl_order SET 
                        tgl_order = ?, 
                        id_gl_supplier = ?, 
                        tgl_datang = ?, 
                        no_faktur = ?, 
                        status = ?, 
                        keterangan = ?,
                        tgl_update = NOW(), 
                        user_update = 'admin' 
                    WHERE id = ?";

            $stmt = mysqli_prepare($db_result, $inp);
            mysqli_stmt_bind_param($stmt, "sissssi", $tgl_order, $id_gl_supplier, $tgl_datang, $no_faktur, $status, $keterangan, $pid);
            $upd = mysqli_stmt_execute($stmt);
            $nket = ($upd) ? "<div class='alert alert-success'>Data Berhasil Dirubah</div>" : "<div class='alert alert-danger'>Data Gagal Dirubah</div>";
        }
    }

    echo "$nket
    <meta http-equiv='refresh' content='2;url=$link_back'>";
    break;





        // Menampilkan Detail Order
        case "detail":
            // Ambil data order berdasarkan ID
            $sqld = "SELECT o.*, s.nama_supplier FROM gl_order o
                    JOIN gl_data_supplier s ON o.id_gl_supplier = s.id
                    WHERE o.id = ? AND o.hapus = 0";
        
            $stmt = mysqli_prepare($db_result, $sqld);
            mysqli_stmt_bind_param($stmt, "i", $gid);
            mysqli_stmt_execute($stmt);
            $data = mysqli_stmt_get_result($stmt);
            $ndata = mysqli_num_rows($data);
        
            if ($ndata > 0) {
                $fdata = mysqli_fetch_assoc($data);
                $simpan = $fdata['simpan'];
                $status = $fdata['status'];
                
                // Query untuk detail barang
                $sql_barang = "SELECT ob.*, b.nama_barang, s.nama_satuan 
                              FROM gl_order_barang ob 
                              JOIN gl_data_barang b ON ob.id_gl_data_barang = b.id 
                              JOIN gl_satuan_barang s ON b.id_gl_satuan_barang = s.id 
                              WHERE ob.id_gl_order = ? AND ob.hapus = 0";
                $stmt_barang = mysqli_prepare($db_result, $sql_barang);
                mysqli_stmt_bind_param($stmt_barang, "i", $gid);
                mysqli_stmt_execute($stmt_barang);
                $data_barang = mysqli_stmt_get_result($stmt_barang);
                
                // Hitung total item dan total beli
                $total_items = 0;
                $total_beli = 0;
                $rows_barang = '';
                $counter = 0;
                while ($row = mysqli_fetch_assoc($data_barang)) {
                    $counter++;
                    $total_items += $row['jml_barang'];
                    $total_beli += $row['total_beli'];
                    
                    $btn_edit = $simpan == 0 ? "<a href='{$link_back}&act=edit_barang&gid={$row['id']}' class='btn btn-xs btn-success'><i class='fa fa-edit'></i> Edit</a>" : "";
                    $btn_hapus = $simpan == 0 ? "<a href='{$link_back}&act=hapus_barang&gid={$row['id']}' class='btn btn-xs btn-danger' onclick='return confirm(\"Yakin hapus item ini?\");'><i class='fa fa-trash'></i> Hapus</a>" : "";
                    
                    $rows_barang .= "<tr>
                        <td>{$counter}</td>
                        <td>".htmlspecialchars($row['nama_barang'])."</td>
                        <td>".htmlspecialchars($row['nama_satuan'])."</td>
                        <td class='text-right'>{$row['jml_barang']}</td>
                        <td class='text-right'>".number_format($row['harga_beli'], 0, ',', '.')."</td>
                        <td class='text-right'>".number_format($row['total_beli'], 0, ',', '.')."</td>
                        <td>{$btn_edit} {$btn_hapus}</td>
                    </tr>";
                }
                
                // Query untuk dropdown barang
                $sql_data_barang = "SELECT id, nama_barang FROM gl_data_barang WHERE hapus = 0";
                $result_data_barang = mysqli_query($db_result, $sql_data_barang);
                $options_barang = '<option value="">Pilih Barang</option>';
                while ($row = mysqli_fetch_assoc($result_data_barang)) {
                    $options_barang .= "<option value='{$row['id']}'>{$row['nama_barang']}</option>";
                }
                
                // Format tanggal
                $tgl_order = date('d-m-Y H:i', strtotime($fdata['tgl_order']));
                $tgl_datang = $fdata['tgl_datang'] ? date('d-m-Y H:i', strtotime($fdata['tgl_datang'])) : '-';
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Order Barang</h3>
                                <div class="box-tools pull-right">

                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Detail Order</h4>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table table-condensed">
                                                    <tr>
                                                        <th width="120">Tanggal Order</th>
                                                        <td><?php echo $tgl_order; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Supplier</th>
                                                        <td><?php echo htmlspecialchars($fdata['nama_supplier']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Datang</th>
                                                        <td><?php echo $tgl_datang; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>No Faktur</th>
                                                        <td><?php echo htmlspecialchars($fdata['no_faktur']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status</th>
                                                        <td>
                                                            <?php if ($status == 1): ?>
                                                                <span class="label label-success">Aktif</span>
                                                            <?php else: ?>
                                                                <span class="label label-danger">Tidak Aktif</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Item</th>
                                                        <td><?php echo $total_items; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Beli</th>
                                                        <td>Rp <?php echo number_format($total_beli, 0, ',', '.'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status Simpan</th>
                                                        <td>
                                                            <?php if ($simpan == 1): ?>
                                                                <span class="label label-success">Tersimpan</span>
                                                            <?php else: ?>
                                                                <span class="label label-warning">Draft</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Keterangan</th>
                                                        <td><?php echo htmlspecialchars($fdata['keterangan']); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <a href="<?php echo htmlspecialchars($link_back); ?>" class="btn btn-sl btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                                    </div>
                                    <div class="col-md-8">
                                        <?php if ($simpan == 0): ?>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Tambah Barang ke Order</h4>
                                            </div>
                                            <div class="panel-body">
                                                <form method="post" action="<?php echo htmlspecialchars($link_back.'&act=add_barang&gid='.$gid); ?>">
                                                    <div class="form-group row">
                                                        <label class="col-md-2 col-form-label">Barang</label>
                                                        <div class="col-md-4">
                                                            <select name="id_gl_data_barang" class="form-control select2" required>
                                                                <?php echo $options_barang; ?>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-2 col-form-label">Jumlah</label>
                                                        <div class="col-md-4">
                                                            <input type="number" class="form-control" name="jml_barang" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-2 col-form-label">Harga Beli</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" name="harga_beli" required />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-success">Tambah Barang</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <div class="alert alert-warning">Data sudah disimpan dan tidak dapat diubah lagi.</div>
                                        <?php endif; ?>
                                        
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Daftar Barang dalam Order</h4>
                                            </div>
                                            <div class="panel-body">
                                                <?php if ($counter == 0): ?>
                                                    <div class="alert alert-info">Belum ada barang yang ditambahkan</div>
                                                <?php else: ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th width="30">No</th>
                                                                    <th>Nama Barang</th>
                                                                    <th>Satuan</th>
                                                                    <th width="100">Jumlah</th>
                                                                    <th width="120">Harga Beli</th>
                                                                    <th width="150">Total Beli</th>
                                                                    <th width="120">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php echo $rows_barang; ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th colspan="3" class="text-right">Total</th>
                                                                    <th class="text-right"><?php echo $total_items; ?></th>
                                                                    <th></th>
                                                                    <th class="text-right">Rp <?php echo number_format($total_beli, 0, ',', '.'); ?></th>
                                                                    <th></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <?php if ($simpan == 0 && $counter > 0): ?>
                                        <form method="post" action="<?php echo htmlspecialchars($link_back.'&act=simpan_stok'); ?>">
                                            <input type="hidden" name="gid" value="<?php echo $gid; ?>">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" onclick="return confirm('Simpan order ini? Setelah disimpan tidak bisa diubah lagi.');">
                                                    <i class="fa fa-save"></i> Simpan Stok
                                                </button>
                                            </div>
                                        </form>
                                        <?php elseif ($simpan == 1): ?>
                                        <div class="alert alert-info">Stok sudah disimpan.</div>
                                        <form method="post" action="<?php echo htmlspecialchars($link_back.'&act=batal_order&gid='.$gid); ?>" class="pull-right">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Batalkan order ini? Stok akan dikembalikan.');">
                                                <i class="fa fa-times"></i> Batalkan Order
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                $(document).ready(function() {
                    // Initialize select2
                    $('.select2').select2();
                    
                    // Format input harga
                    $('input[name="harga_beli"]').on('keyup', function() {
                        var value = $(this).val().replace(/\D/g, '');
                        $(this).val(formatNumber(value));
                    });
                    
                    function formatNumber(num) {
                        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
                    }
                });
                </script>
                <?php
            } else {
                echo "<div class='alert alert-warning'>Data Tidak Ditemukan</div>";
                echo "<meta http-equiv='refresh' content='2;url=".htmlspecialchars($link_back)."'>";
            }
            break;

        case "edit_barang":
            if (isset($_GET['gid'])) {
                $gid_barang = $_GET['gid']; // ID barang yang akan diedit
                
                // Ambil data barang berdasarkan ID
                $sql_barang = "SELECT * FROM gl_order_barang WHERE id = ?";
                $stmt_barang = mysqli_prepare($db_result, $sql_barang);
                mysqli_stmt_bind_param($stmt_barang, "i", $gid_barang);
                mysqli_stmt_execute($stmt_barang);
                $data_barang = mysqli_stmt_get_result($stmt_barang);

                if (mysqli_num_rows($data_barang) > 0) {
                    $barang = mysqli_fetch_assoc($data_barang);
                    $id_barang = $barang['id_gl_data_barang'];
                    $jml_barang = $barang['jml_barang'];
                    $harga_beli = $barang['harga_beli'];

                // Menampilkan form untuk edit barang
                echo "<div class='row'>
                    <div class='col-md-12'>
                        <div class='box box-primary'>
                            <div class='box-header with-border'>
                                <h3 class='box-title'>Edit Barang dalam Order</h3>
                            </div>
                            <div class='box-body'>
                                <form method='post' action='$link_back&act=update_barang'>
                                    <input type='hidden' name='gid_barang' value='$gid_barang' />
                                    <div class='form-group'>
                                        <label>Jumlah Barang</label>
                                        <input type='number' name='jml_barang' class='form-control' value='$jml_barang' required />
                                    </div>
                                    <div class='form-group'>
                                        <label>Harga Beli</label>
                                        <input type='text' name='harga_beli' class='form-control' value='$harga_beli' required />
                                    </div>
                                    <div class='form-group'>
                                        <button type='submit' class='btn btn-success'>Simpan Perubahan</button>
                                        <a href='$link_back' class='btn btn-danger'>Batal</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";

                } else {
                    echo "<div class='alert alert-danger'>Barang tidak ditemukan.</div>";
                }
            }
            break;


            case "update_barang":
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $gid_barang = $_POST['gid_barang'];
                    $jml_barang = mysqli_real_escape_string($db_result, $_POST['jml_barang']);
                    $harga_beli = mysqli_real_escape_string($db_result, $_POST['harga_beli']);
                    $total_beli = $jml_barang * $harga_beli; // Hitung total beli

                    // Pastikan query update sudah benar
                    $sql_update = "UPDATE gl_order_barang SET jml_barang = ?, harga_beli = ?, total_beli = ?, tgl_update = NOW(), user_update = 'admin' WHERE id = ?";
                    $stmt_update = mysqli_prepare($db_result, $sql_update);
                    mysqli_stmt_bind_param($stmt_update, "isii", $jml_barang, $harga_beli, $total_beli, $gid_barang);
                    $upd = mysqli_stmt_execute($stmt_update);

                    if ($upd) {
                        echo "<div class='alert alert-success'>Data Barang Berhasil Diperbarui</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Gagal memperbarui data barang</div>";
                    }

                    // Redirect ke halaman detail order setelah update
                    echo "<meta http-equiv='refresh' content='2;url=$link_back&act=detail&gid=$gid'>";
                }
                break;



        case "simpan_stok":
        
            if (count($_POST) > 0) {
                if (!isset($_POST['gid']) || empty($_POST['gid'])) {
                    echo "<div class='alert alert-danger'>ID Order tidak ditemukan!</div>";
                    exit;
                }
                $gid = intval($_POST['gid']);
                
                // Ambil semua barang dalam order yang belum dihapus
                $sql_barang = "SELECT id_gl_data_barang, jml_barang FROM gl_order_barang WHERE id_gl_order = ? AND hapus = 0";
                $stmt_barang = mysqli_prepare($db_result, $sql_barang);
                mysqli_stmt_bind_param($stmt_barang, "i", $gid);
                mysqli_stmt_execute($stmt_barang);
                $data_barang = mysqli_stmt_get_result($stmt_barang);
                var_dump($data_barang);

                
                // Loop melalui setiap barang dalam order
                while ($row_barang = mysqli_fetch_assoc($data_barang)) {
                    $id_gl_data_barang = $row_barang['id_gl_data_barang'];
                    $jml_barang = $row_barang['jml_barang'];
                    
                    // Ambil jumlah stok saat ini
                    $sql_stok = "SELECT jml_stok_gudang FROM gl_data_barang WHERE id = ?";
                    $stmt_stok = mysqli_prepare($db_result, $sql_stok);
                    mysqli_stmt_bind_param($stmt_stok, "i", $id_gl_data_barang);
                    mysqli_stmt_execute($stmt_stok);
                    $result_stok = mysqli_stmt_get_result($stmt_stok);
                    $data_stok = mysqli_fetch_assoc($result_stok);
                    $stok_sekarang = $data_stok['jml_stok_gudang'] ?? null;
                    
                    if ($stok_sekarang === null) {
                        echo "<div class='alert alert-danger'>Barang ID $id_gl_data_barang tidak ditemukan dalam database!</div>";
                        exit;
                    }
                    
                    // Hitung stok baru
                    $stok_baru = $stok_sekarang + $jml_barang;
                    
                    // Update jumlah stok di gl_data_barang
                    $sql_update_stok = "UPDATE gl_data_barang SET jml_stok_gudang = ? WHERE id = ?";
                    $stmt_update_stok = mysqli_prepare($db_result, $sql_update_stok);
                    mysqli_stmt_bind_param($stmt_update_stok, "ii", $stok_baru, $id_gl_data_barang);
                    
                    if (!mysqli_stmt_execute($stmt_update_stok)) {
                        echo "<div class='alert alert-danger'>Error: " . mysqli_error($db_result) . "</div>";
                        exit;
                    }
                }

                // Update status simpan menjadi 1 di tabel gl_order
                $sql_update_simpan = "UPDATE gl_order SET simpan = 1 WHERE id = ?";
                $stmt_update_simpan = mysqli_prepare($db_result, $sql_update_simpan);
                mysqli_stmt_bind_param($stmt_update_simpan, "i", $gid);
                mysqli_stmt_execute($stmt_update_simpan);

                echo "<div class='alert alert-success'>Stok berhasil diperbarui dan order telah disimpan!</div>";
                echo "<meta http-equiv='refresh' content='2;url=$link_back'>";
            }
            break;


        case "add_barang":
            if (count($_POST) > 0) {
                $id_gl_order = mysqli_real_escape_string($db_result, $gid); // ID order dari URL
                $id_gl_data_barang = mysqli_real_escape_string($db_result, $_POST['id_gl_data_barang']);
                $jml_barang = mysqli_real_escape_string($db_result, $_POST['jml_barang']);
                $harga_beli = mysqli_real_escape_string($db_result, $_POST['harga_beli']);
                $total_beli = $jml_barang * $harga_beli; // Hitung total beli

                // Query untuk menambahkan barang ke gl_order_barang
                $inp = "INSERT INTO gl_order_barang (id_gl_order, id_gl_data_barang, jml_barang, harga_beli, total_beli, hapus, tgl_insert, user_update)
                        VALUES (?, ?, ?, ?, ?, 0, NOW(), 'admin')";
                $stmt = mysqli_prepare($db_result, $inp);
                mysqli_stmt_bind_param($stmt, "iisii", $id_gl_order, $id_gl_data_barang, $jml_barang, $harga_beli, $total_beli);
                $upd = mysqli_stmt_execute($stmt);
                $nket = ($upd) ? "<div class='alert alert-success'>Barang Berhasil Ditambahkan</div>" : "<div class='alert alert-danger'> Barang Gagal Ditambahkan</div>";
            }

            echo "$nket 
            <meta http-equiv='refresh' content='2;url=$link_back&act=detail&gid=$gid'>";
            break;
        
        // Menghapus Barang dari Order
        case "hapus_barang":
            if ($lmn[$idsmenu][3] == 1) {
                // Pastikan $gid adalah ID barang yang ingin dihapus
                $inp = "UPDATE gl_order_barang SET hapus = 1, tgl_update = NOW(), user_update = 'admin' WHERE id = ?";
                $stmt = mysqli_prepare($db_result, $inp);
                mysqli_stmt_bind_param($stmt, "i", $gid); // $gid harus berisi ID barang yang ingin dihapus
                $upd = mysqli_stmt_execute($stmt);
                
                // Cek apakah penghapusan berhasil
                if ($upd) {
                    $nket = "<div class='alert alert-success'>Barang Berhasil Dihapus</div>";
                } else {
                    $nket = "<div class='alert alert-danger'>Barang Gagal Dihapus</div>";
                }
            } else {
                $nket = "<div class='alert alert-warning'>Anda Tidak Memiliki Akses</div>";
            }

            // Redirect ke halaman detail order
            echo "$nket
            <meta http-equiv='refresh' content='2;url=$link_back&act=detail&gid=$gid'>";
            break;


        // Menghapus Data Order (soft delete)
        case "hapus":
            if ($lmn[$idsmenu][3] == 1) {
                // Pertama, tampilkan form konfirmasi pembatalan dengan alasan
                if (!isset($_POST['confirm_delete'])) {
                    // Ambil data order untuk ditampilkan
                    $sqld = "SELECT o.*, s.nama_supplier FROM gl_order o 
                            JOIN gl_data_supplier s ON o.id_gl_supplier = s.id 
                            WHERE o.id = ?";
                    $stmt = mysqli_prepare($db_result, $sqld);
                    mysqli_stmt_bind_param($stmt, "i", $gid);
                    mysqli_stmt_execute($stmt);
                    $data = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($data) > 0) {
                        $order = mysqli_fetch_assoc($data);

                        // Tampilkan form konfirmasi dengan alasan pembatalan
                        echo "<div class='row'>
                            <div class='col-md-12'>
                                <div class='box box-danger'>
                                    <div class='box-header with-border'>
                                        <h3 class='box-title'>Konfirmasi Pembatalan Order</h3>
                                    </div>
                                    <div class='box-body'>
                                        <div class='alert alert-warning'>
                                            <h4><i class='icon fa fa-warning'></i> Peringatan!</h4>
                                            Anda akan membatalkan order berikut:<br><br>
                                            <strong>Supplier:</strong> {$order['nama_supplier']}<br>
                                            <strong>Tanggal Order:</strong> {$order['tgl_order']}<br>
                                            <strong>No Faktur:</strong> {$order['no_faktur']}<br>
                                            <strong>Status Simpan:</strong> " . ($order['simpan'] == 1 ? "Sudah Disimpan" : "Belum Disimpan") . "<br><br>
                                            Silakan berikan alasan pembatalan:
                                        </div>
                                        <form method='post' action='$link_back&act=hapus&gid=$gid'>
                                            <div class='form-group'>
                                                <label>Alasan Pembatalan</label>
                                                <textarea name='keterangan' class='form-control' rows='3' required></textarea>
                                            </div>
                                            <div class='form-group'>
                                                <button type='submit' name='confirm_delete' value='1' class='btn btn-danger'>
                                                    <i class='fa fa-trash'></i> Konfirmasi Pembatalan
                                                </button>
                                                <a href='$link_back' class='btn btn-default'>
                                                    <i class='fa fa-times'></i> Batal
                                                </a>
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
                } else {
                    // Proses penghapusan setelah konfirmasi
                    $keterangan = mysqli_real_escape_string($db_result, $_POST['keterangan']);

                    // Ambil data order terlebih dahulu
                    $sql_order = "SELECT simpan FROM gl_order WHERE id = ?";
                    $stmt_order = mysqli_prepare($db_result, $sql_order);
                    mysqli_stmt_bind_param($stmt_order, "i", $gid);
                    mysqli_stmt_execute($stmt_order);
                    $result_order = mysqli_stmt_get_result($stmt_order);
                    $order = mysqli_fetch_assoc($result_order);

                    if ($order['simpan'] == 1) {
                        // Jika order sudah disimpan, kurangi stok barang terlebih dahulu
                        $sql_barang = "SELECT id_gl_data_barang, jml_barang FROM gl_order_barang 
                                    WHERE id_gl_order = ? AND hapus = 0";
                        $stmt_barang = mysqli_prepare($db_result, $sql_barang);
                        mysqli_stmt_bind_param($stmt_barang, "i", $gid);
                        mysqli_stmt_execute($stmt_barang);
                        $result_barang = mysqli_stmt_get_result($stmt_barang);

                        while ($barang = mysqli_fetch_assoc($result_barang)) {
                            $id_barang = $barang['id_gl_data_barang'];
                            $jml_barang = $barang['jml_barang'];

                            // Update stok di gl_data_barang
                            $sql_update_stok = "UPDATE gl_data_barang 
                                                SET jml_stok_gudang = jml_stok_gudang - ? 
                                                WHERE id = ?";
                            $stmt_update = mysqli_prepare($db_result, $sql_update_stok);
                            mysqli_stmt_bind_param($stmt_update, "ii", $jml_barang, $id_barang);
                            mysqli_stmt_execute($stmt_update);
                        }
                    }

                    // Soft delete order dan barang terkait, set simpan ke 0
                    $inp_order = "UPDATE gl_order SET 
                                hapus = 1, 
                                simpan = 0, 
                                tgl_update = NOW(), 
                                user_update = 'admin',
                                keterangan = ? 
                                WHERE id = ?";
                    $stmt_order = mysqli_prepare($db_result, $inp_order);
                    mysqli_stmt_bind_param($stmt_order, "si", $keterangan, $gid);
                    $upd_order = mysqli_stmt_execute($stmt_order);

                    // Soft delete barang terkait
                    $inp_barang = "UPDATE gl_order_barang SET 
                                hapus = 1, 
                                tgl_update = NOW(), 
                                user_update = 'admin'
                                WHERE id_gl_order = ?";
                    $stmt_barang = mysqli_prepare($db_result, $inp_barang);
                    mysqli_stmt_bind_param($stmt_barang, "i", $gid);
                    mysqli_stmt_execute($stmt_barang);

                    if ($upd_order) {
                        $nket = "<div class='alert alert-success'>Order berhasil dibatalkan. Stok barang telah dikurangi dan status simpan direset.</div>";
                    } else {
                        $nket = "<div class='alert alert-danger'>Gagal membatalkan order</div>";
                    }

                    echo "$nket
                    <meta http-equiv='refresh' content='2;url=$link_back'>";
                }
            } else {
                $nket = "<div class='alert alert-warning'>Anda Tidak Memiliki Akses</div>";
                echo "$nket
                <meta http-equiv='refresh' content='2;url=$link_back'>";
            }
            break;

            
        // Batalkan Order
        case "batal_order":
            if ($lmn[$idsmenu][3] == 1) {
                // Mengembalikan stok barang yang telah ditambahkan dalam order
                $sql_barang = "SELECT id_gl_data_barang, jml_barang FROM gl_order_barang WHERE id_gl_order = ? AND hapus = 0";
                $stmt_barang = mysqli_prepare($db_result, $sql_barang);
                mysqli_stmt_bind_param($stmt_barang, "i", $gid);
                mysqli_stmt_execute($stmt_barang);
                $data_barang = mysqli_stmt_get_result($stmt_barang);

                while ($row_barang = mysqli_fetch_assoc($data_barang)) {
                    $id_gl_data_barang = $row_barang['id_gl_data_barang'];
                    $jml_barang = $row_barang['jml_barang'];

                    // Ambil jumlah stok saat ini
                    $sql_stok = "SELECT jml_stok_gudang FROM gl_data_barang WHERE id = ?";
                    $stmt_stok = mysqli_prepare($db_result, $sql_stok);
                    mysqli_stmt_bind_param($stmt_stok, "i", $id_gl_data_barang);
                    mysqli_stmt_execute($stmt_stok);
                    $result_stok = mysqli_stmt_get_result($stmt_stok);
                    $data_stok = mysqli_fetch_assoc($result_stok);
                    $stok_sekarang = $data_stok['jml_stok_gudang'] ?? 0;

                    // Mengembalikan stok
                    $stok_baru = $stok_sekarang + $jml_barang;

                    // Update jumlah stok di gl_data_barang
                    $sql_update_stok = "UPDATE gl_data_barang SET jml_stok_gudang = ? WHERE id = ?";
                    $stmt_update_stok = mysqli_prepare($db_result, $sql_update_stok);
                    mysqli_stmt_bind_param($stmt_update_stok, "ii", $stok_baru, $id_gl_data_barang);

                    if (!mysqli_stmt_execute($stmt_update_stok)) {
                        echo "<div class='alert alert-danger'>Error saat mengembalikan stok barang.</div>";
                        exit;
                    }
                }

                // Mengubah status simpan menjadi 0 (mengizinkan edit kembali)
                $inp_order = "UPDATE gl_order SET simpan = 0, tgl_update = NOW(), user_update = 'admin' WHERE id = ?";
                $stmt_order = mysqli_prepare($db_result, $inp_order);
                mysqli_stmt_bind_param($stmt_order, "i", $gid);
                $upd_order = mysqli_stmt_execute($stmt_order);

                if ($upd_order) {
                    echo "<div class='alert alert-success'>Order telah dibatalkan dan stok barang dikembalikan. Anda dapat mengedit kembali order ini.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Gagal membatalkan order.</div>";
                }
                echo "<meta http-equiv='refresh' content='2;url=$link_back'>";
            }
            break;




    }
}
?>
<script type="text/javascript">
    function confirmCancel() {
        var confirmation = confirm("Apakah Anda yakin ingin membatalkan order ini?");
        if (confirmation) {
            return true;  // Melanjutkan pengiriman form
        } else {
            return false; // Menghentikan pengiriman form
        }
    }
</script>
<script type="text/javascript">
    function confirmSaveStock() {
        var confirmation = confirm("Apakah Anda yakin ingin menyimpan stok untuk order ini?");
        if (confirmation) {
            return true;  // Melanjutkan pengiriman form
        } else {
            return false; // Menghentikan pengiriman form
        }
    }
</script>
<script type="text/javascript">
    // Fungsi untuk konfirmasi pembatalan order
    function confirmCancel() {
        var confirmation = confirm("Apakah Anda yakin ingin membatalkan order ini?");
        if (confirmation) {
            return true;  // Melanjutkan pengiriman form
        } else {
            return false; // Menghentikan pengiriman form
        }
    }
</script>