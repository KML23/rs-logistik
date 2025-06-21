<?php
// Prevent direct request with 'index.php' in URI
if (preg_match("/\bindex.php\b/i", $_SERVER['REQUEST_URI'])) {
    exit;
}

switch ($act) {
    case 'input':
        // Display form for adding or editing data

        $gket = isset($_GET['gket']) ? $_GET['gket'] : '';
        $gid = isset($_GET['gid']) ? intval($_GET['gid']) : 0;
        $judul = ($gket == 'edit') ? 'Edit Transaksi' : 'Tambah Transaksi';

        // Initialize form values
        $no_transaksi = '';
        $nama_unit = '';
        $nama_pengambil = '';
        $tanggal_transaksi = '';
        $keterangan = '';
        $edit_hidden = '';

        if ($gket === 'edit' && $gid > 0) {
            $sql = "SELECT * FROM gl_barang_keluar WHERE id_barang_keluar = ? AND hapus = 0";
            $stmt = mysqli_prepare($db_result, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $gid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $no_transaksi = $row['no_transaksi'];
                $nama_unit = $row['nama_unit'];
                $nama_pengambil = $row['nama_pengambil'];
                $tanggal_transaksi = $row['tanggal_transaksi'];
                $keterangan = $row['keterangan'];

                if ($row['hapus'] == 1) {
                    echo '<div class="alert alert-warning">
                            <strong>Data ini sebelumnya dihapus!</strong><br>
                            Keterangan: ' . htmlspecialchars($keterangan) . '
                          </div>';
                }

                $edit_hidden = '<input type="hidden" name="pid" value="' . htmlspecialchars($gid) . '">';
            } else {
                echo '<div class="alert alert-warning">Data Tidak Ditemukan</div>';
                echo '<meta http-equiv="refresh" content="2;url=' . htmlspecialchars($link_back) . '">';
                exit;
            }
        }

        // Prepare value for datetime-local input format
        $tanggal_input_value = '';
        if ($tanggal_transaksi) {
            $tanggal_input_value = date('Y-m-d\TH:i', strtotime($tanggal_transaksi));
        }

        ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    Data &raquo; <?php echo $judul; ?>
                </div>
                <div class="box-body">
                    <form role="form" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($link_back . '&act=proses&gket=' . $gket); ?>">
                        <div class="form-group">
                            <label class="col-sm-2 text-left"><b>No Transaksi</b></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="no_transaksi" value="<?php echo htmlspecialchars($no_transaksi); ?>" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 text-left"><b>Nama Unit</b></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="nama_unit" value="<?php echo htmlspecialchars($nama_unit); ?>" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 text-left"><b>Nama Pengambil</b></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="nama_pengambil" value="<?php echo htmlspecialchars($nama_pengambil); ?>" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 text-left"><b>Tanggal Transaksi</b></label>
                            <div class="col-sm-3">
                                <input type="datetime-local" class="form-control" name="tanggal_transaksi" value="<?php echo $tanggal_input_value; ?>" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 text-left"><b>Keterangan</b></label>
                            <div class="col-sm-5">
                                <textarea class="form-control" name="keterangan"><?php echo htmlspecialchars($keterangan); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-5">
                                <?php echo $edit_hidden; ?>
                                <a href="<?php echo htmlspecialchars($link_back); ?>" class="btn bg-navy"><i class="fa fa-caret-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    break;

case 'proses':
    // Process form data for insert or update
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '<div class="alert alert-danger">Metode permintaan tidak valid.</div>';
        exit;
    }

    $gket = isset($_GET['gket']) ? $_GET['gket'] : '';
    $pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
    $no_transaksi = isset($_POST['no_transaksi']) ? trim($_POST['no_transaksi']) : '';
    $nama_unit = isset($_POST['nama_unit']) ? trim($_POST['nama_unit']) : '';
    $nama_pengambil = isset($_POST['nama_pengambil']) ? trim($_POST['nama_pengambil']) : '';
    $tanggal_transaksi = isset($_POST['tanggal_transaksi']) ? $_POST['tanggal_transaksi'] : '';
    $keterangan = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';

    // Basic validation
    if (empty($no_transaksi) || empty($nama_unit)) {
        echo '<script>alert("No Transaksi dan Nama Unit harus diisi!"); window.history.back();</script>';
        exit;
    }

    // Convert datetime-local to datetime format 'Y-m-d H:i:s'
    $tanggal_db = date('Y-m-d H:i:s', strtotime($tanggal_transaksi));

    if ($gket === 'edit' && $pid > 0) {
        // Update existing record
        $sql = "UPDATE gl_barang_keluar SET no_transaksi = ?, nama_unit = ?, nama_pengambil = ?, tanggal_transaksi = ?, keterangan = ?, tgl_update = NOW(), user_update = 'admin' WHERE id_barang_keluar = ?";
        $stmt = mysqli_prepare($db_result, $sql);
        if (!$stmt) {
            die('Prepare failed: ' . mysqli_error($db_result));
        }
        mysqli_stmt_bind_param($stmt, "sssssi", $no_transaksi, $nama_unit, $nama_pengambil, $tanggal_db, $keterangan, $pid);
        $success = mysqli_stmt_execute($stmt);
        if ($success) {
            echo '<div class="alert alert-success">Data berhasil diperbarui.</div>';
        } else {
            echo '<div class="alert alert-danger">Gagal memperbarui data: ' . htmlspecialchars(mysqli_error($db_result)) . '</div>';
        }
    } else {
        // Insert new record
        $sql = "INSERT INTO gl_barang_keluar (no_transaksi, nama_unit, nama_pengambil, tanggal_transaksi, keterangan, hapus, tgl_insert, user_update) VALUES (?, ?, ?, ?, ?, 0, NOW(), 'admin')";
        $stmt = mysqli_prepare($db_result, $sql);
        if (!$stmt) {
            die('Prepare failed: ' . mysqli_error($db_result));
        }
        mysqli_stmt_bind_param($stmt, "sssss", $no_transaksi, $nama_unit, $nama_pengambil, $tanggal_db, $keterangan);
        $success = mysqli_stmt_execute($stmt);
        if ($success) {
            echo '<div class="alert alert-success">Data berhasil disimpan.</div>';
        } else {
            echo '<div class="alert alert-danger">Gagal menyimpan data: ' . htmlspecialchars(mysqli_error($db_result)) . '</div>';
        }
    }

    // Redirect back after 2 seconds
    echo '<meta http-equiv="refresh" content="2;url=' . htmlspecialchars($link_back) . '">';
    exit;

case 'hapus':
    // Soft delete the record
    $gid = isset($_GET['gid']) ? intval($_GET['gid']) : 0;
    if ($gid > 0) {
        $sql = "UPDATE gl_barang_keluar SET hapus = 1, tgl_update = NOW() WHERE id_barang_keluar = ?";
        $stmt = mysqli_prepare($db_result, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $gid);
            mysqli_stmt_execute($stmt);
        }
    }
    echo '<script>window.location.href="' . htmlspecialchars($link_back) . '";</script>';
    break;

    default:
    // Inisialisasi variabel pencarian
    $gunit = isset($_GET['gunit']) ? trim($_GET['gunit']) : '';

    // Query untuk mengambil data barang keluar dengan filter nama unit
    $sql = "SELECT * FROM gl_barang_keluar WHERE hapus = 0 AND nama_unit LIKE ? ORDER BY tanggal_transaksi DESC";
    $stmt = mysqli_prepare($db_result, $sql);
    $search = '%' . $gunit . '%';
    mysqli_stmt_bind_param($stmt, 's', $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $ndata = mysqli_num_rows($result);

    $td_table = '';
    if ($ndata > 0) {
        $no = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $no++;
            $id = htmlspecialchars($row['id_barang_keluar']);
            $no_transaksi = htmlspecialchars($row['no_transaksi']);
            $nama_unit = htmlspecialchars($row['nama_unit']);
            $nama_pengambil = htmlspecialchars($row['nama_pengambil']);
            $tanggal_transaksi = date('d-m-Y H:i', strtotime($row['tanggal_transaksi']));
            $keterangan = htmlspecialchars($row['keterangan']);

            // Tombol untuk Edit, Hapus, dan Detail
            $btn_edit = '<a href="' . htmlspecialchars($link_back) . '&act=input&gket=edit&gid=' . $id . '" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</a>';
            $btn_hapus = '<a href="' . htmlspecialchars($link_back) . '&act=hapus&gid=' . $id . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus transaksi ini?\');" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</a>';
            $btn_detail = '<a href="' . htmlspecialchars($link_back) . '&act=detail_keluar&gid=' . $id . '" class="btn btn-xs btn-info"><i class="fa fa-info-circle"></i> Detail</a>';  // Tombol Detail

            // Menambahkan data pada tabel
            $td_table .= '<tr>
                <td>' . $no . '</td>
                <td>' . $no_transaksi . '</td>
                <td>' . $nama_unit . '</td>
                <td>' . $nama_pengambil . '</td>
                <td>' . $tanggal_transaksi . '</td>
                <td>' . $keterangan . '</td>
                <td>' . $btn_edit . ' ' . $btn_hapus . ' ' . $btn_detail . '</td>
            </tr>';
        }
    } else {
        $td_table .= "<tr><td colspan='7' class='text-center'>Tidak ada data ditemukan</td></tr>";
    }

    // Tombol untuk menambahkan data baru (Tambah Data)
    $btn_add = (isset($lmn[$idsmenu][1]) && $lmn[$idsmenu][1] == 1)
        ? '<a href="' . htmlspecialchars($link_back) . '&act=input&gket=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>'
        : '';

    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border"><h3 class="box-title">Pencarian Transaksi</h3></div>
                <div class="box-body">
                    <form class="form-horizontal" method="get">
                        <input type="hidden" name="pages" value="<?php echo htmlspecialchars($pages); ?>" />
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-left">Nama Unit</label>
                            <div class="col-sm-3">
                                <input type="text" name="gunit" value="<?php echo htmlspecialchars($gunit); ?>" class="form-control" placeholder="Nama Unit" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-5">
                                <button type="submit" class="btn bg-maroon"><i class="fa fa-search"></i> Cari</button>
                                <a href="<?php echo htmlspecialchars($link_back); ?>" class="btn btn-info"><i class="fa fa-refresh"></i> Refresh</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Barang Keluar</h3>
                </div>
                <div class="box-body">
                    <?php echo $btn_add; ?>
                    <div class="clearfix"></div><br />
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="40">No</th>
                                    <th>No. Transaksi</th>
                                    <th>Unit</th>
                                    <th>Pengambil</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th width="130">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $td_table; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    break;

// Menampilkan Detail Barang Keluar
case "detail_keluar":
    // Ambil data barang keluar berdasarkan ID
    $sqld = "SELECT * FROM gl_barang_keluar WHERE id_barang_keluar = ? AND hapus = 0";
    
    $stmt = mysqli_prepare($db_result, $sqld);
    mysqli_stmt_bind_param($stmt, "i", $gid);
    mysqli_stmt_execute($stmt);
    $data = mysqli_stmt_get_result($stmt);
    $ndata = mysqli_num_rows($data);

    if ($ndata > 0) {
        $fdata = mysqli_fetch_assoc($data);
        $simpan = $fdata['simpan'];
        
        // Query untuk detail barang
        $sql_detail = "
            SELECT 
                d.id_detail_barang_keluar,
                b.nama_barang,
                s.nama_satuan,
                d.jumlah_keluar,
                b.jml_stok_gudang
            FROM 
                gl_barang_keluar_detail d
            JOIN 
                gl_data_barang b ON d.id_barang = b.id
            JOIN 
                gl_satuan_barang s ON b.id_gl_satuan_barang = s.id
            WHERE 
                d.id_barang_keluar = ? 
                AND d.hapus = 0
            ORDER BY 
                d.id_detail_barang_keluar DESC
        ";
        $stmt_detail = mysqli_prepare($db_result, $sql_detail);
        mysqli_stmt_bind_param($stmt_detail, "i", $gid);
        mysqli_stmt_execute($stmt_detail);
        $data_detail = mysqli_stmt_get_result($stmt_detail);
        
        // Hitung total item
        $total_items = 0;
        $rows_detail = '';
        $counter = 0;
        while ($row = mysqli_fetch_assoc($data_detail)) {
            $counter++;
            $total_items += $row['jumlah_keluar'];
            $btn_edit = $simpan == 0 ? "<a href='{$link_back}&act=edit_barang_keluar&gid={$row['id_detail_barang_keluar']}' class='btn btn-xs btn-success'><i class='fa fa-edit'></i> Edit</a>" : "";
            $btn_hapus = $simpan == 0 ? "<a href='{$link_back}&act=hapus_barang_keluar&gid={$row['id_detail_barang_keluar']}' class='btn btn-xs btn-danger' onclick='return confirm(\"Yakin hapus item ini?\");'><i class='fa fa-trash'></i> Hapus</a>" : "";
            
            $rows_detail .= "<tr>
                <td>{$counter}</td>
                <td>".htmlspecialchars($row['nama_barang'])."</td>
                <td>".htmlspecialchars($row['nama_satuan'])."</td>
                <td class='text-right'>{$row['jumlah_keluar']}</td>
                <td>{$row['jml_stok_gudang']}</td>
                <td>{$btn_edit} {$btn_hapus}</td>
            </tr>";
        }
        
        // Query untuk dropdown barang
        $sql_barang = "SELECT b.id, b.nama_barang, s.nama_satuan, b.jml_stok_gudang 
                       FROM gl_data_barang b
                       JOIN gl_satuan_barang s ON b.id_gl_satuan_barang = s.id
                       WHERE b.hapus = 0 AND b.jml_stok_gudang > 0
                       ORDER BY b.nama_barang";
        $res_barang = mysqli_query($db_result, $sql_barang);
        $options_barang = '<option value="">Pilih Barang</option>';
        while ($row = mysqli_fetch_assoc($res_barang)) {
            $options_barang .= "<option value='{$row['id']}' data-stok='{$row['jml_stok_gudang']}'>{$row['nama_barang']} (Stok: {$row['jml_stok_gudang']} {$row['nama_satuan']})</option>";
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail Barang Keluar</h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">Informasi Transaksi</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-condensed">
                                            <tr>
                                                <th width="120">No. Transaksi</th>
                                                <td><?php echo htmlspecialchars($fdata['no_transaksi']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal</th>
                                                <td><?php echo htmlspecialchars($fdata['tanggal_transaksi']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Unit</th>
                                                <td><?php echo htmlspecialchars($fdata['nama_unit']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Pengambil</th>
                                                <td><?php echo htmlspecialchars($fdata['nama_pengambil']); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Total Item</th>
                                                <td><?php echo $total_items; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <?php if ($simpan == 1): ?>
                                                        <span class="label label-success">Sudah Difinalisasi</span>
                                                    <?php else: ?>
                                                        <span class="label label-warning">Draft (Belum Disimpan)</span>
                                                    <?php endif; ?>
                                                </td>
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
                                        <h4 class="panel-title">Tambah Barang</h4>
                                    </div>
                                    <div class="panel-body">
                                        <form method="post" action="<?php echo htmlspecialchars($link_back.'&act=add_barang_keluar&gid='.$gid); ?>">
                                            <div class="form-group">
                                                <label>Barang</label>
                                                <select name="id_barang" class="form-control select2" required>
                                                    <?php echo $options_barang; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Jumlah</label>
                                                <input type="number" name="jumlah_keluar" class="form-control" min="1" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-plus"></i> Tambah
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">Daftar Barang Keluar</h4>
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
                                                            <th width="100">Stok Saat Ini</th>
                                                            <th width="120">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php echo $rows_detail; ?>
                                                    </tbody>
                                                </table>
                                             </div>
            <?php endif; ?>
            
            <?php if ($simpan == 1): ?>
                <div class="alert alert-warning">
                    <h4><i class="icon fa fa-warning"></i> Transaksi Sudah Difinalisasi</h4>
                    <p>Transaksi ini sudah disimpan/difinalisasi dan tidak dapat diubah. Jika perlu, Anda dapat membatalkan seluruh transaksi untuk mengembalikan stok barang ke sistem.</p>
                    
                    <form method="post" action="<?php echo htmlspecialchars($link_back.'&act=batal_keluar&gid='.$gid); ?>" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini? Stok barang akan dikembalikan ke sistem.');">
                        <button type="submit" class="btn pull-right btn-danger">
                            <i class="fa fa-times"></i> Batalkan Transaksi
                        </button>
                        <p class="help-block"><small>Membatalkan transaksi akan mengembalikan stok barang ke sistem dan mengubah status menjadi draft.</small></p>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if ($simpan == 0 && $counter > 0): ?>
    <form method="post" action="<?php echo htmlspecialchars($link_back.'&act=finalisasi_keluar'); ?>">
        <input type="hidden" name="gid" value="<?php echo $gid; ?>">
        <div class="form-group pull-right">
        <p class="help-block"><small>Finalisasi transaksi akan mengurangi stok barang dan mengunci transaksi.</small></p>
            <button type="submit" class="btn btn-success pull-right" onclick="return confirm('Simpan transaksi ini? Setelah disimpan tidak bisa diubah lagi.');">
                <i class="fa fa-save"></i> Finalisasi Transaksi
            </button>
            
        </div>
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
            
            // Form validation
            $('form').submit(function() {
                var jml = parseInt($('input[name="jumlah_keluar"]').val());
                var stok = parseInt($('select[name="id_barang"]').find('option:selected').data('stok'));
                
                if (jml > stok) {
                    alert('Jumlah melebihi stok yang tersedia!');
                    return false;
                }
                
                if (jml <= 0) {
                    alert('Jumlah harus lebih dari 0!');
                    return false;
                }
                
                return true;
            });
        });
        </script>
        <?php
    } else {
        echo "<div class='alert alert-warning'>Data Tidak Ditemukan</div>";
        echo "<meta http-equiv='refresh' content='2;url=".htmlspecialchars($link_back)."'>";
    }
    break;

// Edit Barang Keluar
case "edit_barang_keluar":
    if (isset($_GET['gid'])) {
        $gid_detail = $_GET['gid']; // ID detail barang yang akan diedit
        
        // Ambil data barang berdasarkan ID
        $sql_barang = "SELECT d.*, b.nama_barang, b.jml_stok_gudang 
                      FROM gl_barang_keluar_detail d
                      JOIN gl_data_barang b ON d.id_barang = b.id
                      WHERE d.id_detail_barang_keluar = ?";
        $stmt_barang = mysqli_prepare($db_result, $sql_barang);
        mysqli_stmt_bind_param($stmt_barang, "i", $gid_detail);
        mysqli_stmt_execute($stmt_barang);
        $data_barang = mysqli_stmt_get_result($stmt_barang);

        if (mysqli_num_rows($data_barang) > 0) {
            $barang = mysqli_fetch_assoc($data_barang);
            $id_barang = $barang['id_barang'];
            $jml_keluar = $barang['jumlah_keluar'];
            $stok_sekarang = $barang['jml_stok_gudang'] + $jml_keluar; // Kembalikan stok sementara untuk validasi

        // Menampilkan form untuk edit barang
        echo "<div class='row'>
            <div class='col-md-12'>
                <div class='box box-primary'>
                    <div class='box-header with-border'>
                        <h3 class='box-title'>Edit Barang Keluar</h3>
                    </div>
                    <div class='box-body'>
                        <form method='post' action='$link_back&act=update_barang_keluar'>
                            <input type='hidden' name='gid_detail' value='$gid_detail' />
                            <input type='hidden' name='id_barang' value='$id_barang' />
                            <div class='form-group'>
                                <label>Nama Barang</label>
                                <input type='text' class='form-control' value='{$barang['nama_barang']}' readonly />
                            </div>
                            <div class='form-group'>
                                <label>Stok Tersedia</label>
                                <input type='text' class='form-control' value='$stok_sekarang' readonly />
                            </div>
                            <div class='form-group'>
                                <label>Jumlah Keluar</label>
                                <input type='number' name='jumlah_keluar' class='form-control' value='$jml_keluar' min='1' max='$stok_sekarang' required />
                            </div>
                            <div class='form-group'>
                                <button type='submit' class='btn btn-success'>Simpan Perubahan</button>
                                <a href='$link_back&act=detail_keluar&gid={$barang['id_barang_keluar']}' class='btn btn-danger'>Batal</a>
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

// Update Barang Keluar
case "update_barang_keluar":
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $gid_detail = $_POST['gid_detail'];
        $id_barang = $_POST['id_barang'];
        $jumlah_keluar = mysqli_real_escape_string($db_result, $_POST['jumlah_keluar']);

        // Ambil data lama untuk perhitungan
        $sql_old = "SELECT jumlah_keluar, id_barang_keluar FROM gl_barang_keluar_detail WHERE id_detail_barang_keluar = ?";
        $stmt_old = mysqli_prepare($db_result, $sql_old);
        mysqli_stmt_bind_param($stmt_old, "i", $gid_detail);
        mysqli_stmt_execute($stmt_old);
        $result_old = mysqli_stmt_get_result($stmt_old);
        $old_data = mysqli_fetch_assoc($result_old);
        $old_jumlah = $old_data['jumlah_keluar'];
        $id_transaksi = $old_data['id_barang_keluar'];

        // Update data barang keluar
        $sql_update = "UPDATE gl_barang_keluar_detail SET jumlah_keluar = ?, tgl_update = NOW(), user_update = 'admin' WHERE id_detail_barang_keluar = ?";
        $stmt_update = mysqli_prepare($db_result, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "ii", $jumlah_keluar, $gid_detail);
        $upd = mysqli_stmt_execute($stmt_update);

        if ($upd) {
            echo "<div class='alert alert-success'>Data Barang Berhasil Diperbarui</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal memperbarui data barang</div>";
        }

        // Redirect ke halaman detail transaksi
        echo "<meta http-equiv='refresh' content='2;url=$link_back&act=detail_keluar&gid=$id_transaksi'>";
    }
    break;

// Tambah Barang Keluar
case "add_barang_keluar":
    if (count($_POST) > 0) {
        $id_transaksi = mysqli_real_escape_string($db_result, $gid); // ID transaksi dari URL
        $id_barang = mysqli_real_escape_string($db_result, $_POST['id_barang']);
        $jumlah_keluar = mysqli_real_escape_string($db_result, $_POST['jumlah_keluar']);

        // Cek stok tersedia
        $sql_stok = "SELECT jml_stok_gudang FROM gl_data_barang WHERE id = ?";
        $stmt_stok = mysqli_prepare($db_result, $sql_stok);
        mysqli_stmt_bind_param($stmt_stok, "i", $id_barang);
        mysqli_stmt_execute($stmt_stok);
        $result_stok = mysqli_stmt_get_result($stmt_stok);
        $stok = mysqli_fetch_assoc($result_stok);

        if ($stok['jml_stok_gudang'] < $jumlah_keluar) {
            $nket = "<div class='alert alert-danger'>Stok tidak mencukupi. Stok tersedia: {$stok['jml_stok_gudang']}</div>";
        } else {
            // Query untuk menambahkan barang ke gl_barang_keluar_detail
            $inp = "INSERT INTO gl_barang_keluar_detail (id_barang_keluar, id_barang, jumlah_keluar, hapus, tgl_insert, user_update)
                    VALUES (?, ?, ?, 0, NOW(), 'admin')";
            $stmt = mysqli_prepare($db_result, $inp);
            mysqli_stmt_bind_param($stmt, "iii", $id_transaksi, $id_barang, $jumlah_keluar);
            $upd = mysqli_stmt_execute($stmt);
            $nket = ($upd) ? "<div class='alert alert-success'>Barang Berhasil Ditambahkan</div>" : "<div class='alert alert-danger'>Barang Gagal Ditambahkan</div>";
        }
    }

    echo "$nket 
    <meta http-equiv='refresh' content='2;url=$link_back&act=detail_keluar&gid=$id_transaksi'>";
    break;

// Hapus Barang Keluar
case "hapus_barang_keluar":
    if ($lmn[$idsmenu][3] == 1) {
        // Ambil ID transaksi untuk redirect
        $sql_trans = "SELECT id_barang_keluar FROM gl_barang_keluar_detail WHERE id_detail_barang_keluar = ?";
        $stmt_trans = mysqli_prepare($db_result, $sql_trans);
        mysqli_stmt_bind_param($stmt_trans, "i", $gid);
        mysqli_stmt_execute($stmt_trans);
        $result_trans = mysqli_stmt_get_result($stmt_trans);
        $trans = mysqli_fetch_assoc($result_trans);
        $id_transaksi = $trans['id_barang_keluar'];

        // Soft delete barang
        $inp = "UPDATE gl_barang_keluar_detail SET hapus = 1, tgl_update = NOW(), user_update = 'admin' WHERE id_detail_barang_keluar = ?";
        $stmt = mysqli_prepare($db_result, $inp);
        mysqli_stmt_bind_param($stmt, "i", $gid);
        $upd = mysqli_stmt_execute($stmt);
        
        if ($upd) {
            $nket = "<div class='alert alert-success'>Barang Berhasil Dihapus</div>";
        } else {
            $nket = "<div class='alert alert-danger'>Barang Gagal Dihapus</div>";
        }
    } else {
        $nket = "<div class='alert alert-warning'>Anda Tidak Memiliki Akses</div>";
    }

    echo "$nket
    <meta http-equiv='refresh' content='2;url=$link_back&act=detail_keluar&gid=$id_transaksi'>";
    break;

// Finalisasi Barang Keluar (kurangi stok)
case "finalisasi_keluar":
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_transaksi = $_POST['gid'];
        
        // Cek apakah ada barang dalam transaksi
        $sql_cek = "SELECT COUNT(*) as total FROM gl_barang_keluar_detail WHERE id_barang_keluar = ? AND hapus = 0";
        $stmt_cek = mysqli_prepare($db_result, $sql_cek);
        mysqli_stmt_bind_param($stmt_cek, "i", $id_transaksi);
        mysqli_stmt_execute($stmt_cek);
        $result_cek = mysqli_stmt_get_result($stmt_cek);
        $cek = mysqli_fetch_assoc($result_cek);

        if ($cek['total'] == 0) {
            echo "<div class='alert alert-danger'>Tidak ada barang dalam transaksi ini. Tidak dapat difinalisasi.</div>";
            echo "<meta http-equiv='refresh' content='2;url=$link_back'>";
            break;
        }

        // Ambil semua barang dalam transaksi
        $sql_barang = "SELECT id_barang, jumlah_keluar FROM gl_barang_keluar_detail WHERE id_barang_keluar = ? AND hapus = 0";
        $stmt_barang = mysqli_prepare($db_result, $sql_barang);
        mysqli_stmt_bind_param($stmt_barang, "i", $id_transaksi);
        mysqli_stmt_execute($stmt_barang);
        $data_barang = mysqli_stmt_get_result($stmt_barang);

        $error = false;
        mysqli_autocommit($db_result, false); // Mulai transaksi

        // Loop melalui setiap barang dalam transaksi
        while ($row_barang = mysqli_fetch_assoc($data_barang)) {
            $id_barang = $row_barang['id_barang'];
            $jumlah_keluar = $row_barang['jumlah_keluar'];
            
            // Kurangi stok di gl_data_barang
            $sql_update = "UPDATE gl_data_barang SET jml_stok_gudang = jml_stok_gudang - ? WHERE id = ? AND jml_stok_gudang >= ?";
            $stmt_update = mysqli_prepare($db_result, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "iii", $jumlah_keluar, $id_barang, $jumlah_keluar);
            
            if (!mysqli_stmt_execute($stmt_update)) {
                $error = true;
                break;
            }

            // Cek apakah stok benar-benar terupdate
            if (mysqli_affected_rows($db_result) == 0) {
                $error = true;
                break;
            }
        }

        if ($error) {
            mysqli_rollback($db_result);
            echo "<div class='alert alert-danger'>Gagal memfinalisasi transaksi. Stok tidak mencukupi.</div>";
        } else {
            // Update status transaksi menjadi final
            $sql_final = "UPDATE gl_barang_keluar SET simpan = 1, tgl_update = NOW(), user_update = 'admin' WHERE id_barang_keluar = ?";
            $stmt_final = mysqli_prepare($db_result, $sql_final);
            mysqli_stmt_bind_param($stmt_final, "i", $id_transaksi);
            
            if (mysqli_stmt_execute($stmt_final)) {
                mysqli_commit($db_result);
                echo "<div class='alert alert-success'>Transaksi berhasil difinalisasi. Stok barang telah dikurangi.</div>";
            } else {
                mysqli_rollback($db_result);
                echo "<div class='alert alert-danger'>Gagal memfinalisasi transaksi.</div>";
            }
        }

        mysqli_autocommit($db_result, true); // Akhiri transaksi
        echo "<meta http-equiv='refresh' content='2;url=$link_back'>";
    }
    break;

// Batalkan Transaksi Barang Keluar
case "batal_keluar":
    if ($lmn[$idsmenu][3] == 1) {
        // Cek apakah transaksi sudah difinalisasi
        $sql_check = "SELECT simpan FROM gl_barang_keluar WHERE id_barang_keluar = ?";
        $stmt_check = mysqli_prepare($db_result, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "i", $gid);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        $transaksi = mysqli_fetch_assoc($result_check);
        
        if ($transaksi['simpan'] != 1) {
            echo "<div class='alert alert-warning'>Transaksi belum difinalisasi atau sudah dibatalkan</div>";
            echo "<meta http-equiv='refresh' content='2;url=$link_back'>";
            break;
        }

        // Mulai transaksi database
        mysqli_autocommit($db_result, false);
        $error = false;
        
        // 1. Ambil semua barang dalam transaksi untuk dikembalikan stoknya
        $sql_barang = "SELECT d.id_barang, d.jumlah_keluar, b.jml_stok_gudang
                      FROM gl_barang_keluar_detail d
                      JOIN gl_data_barang b ON d.id_barang = b.id
                      WHERE d.id_barang_keluar = ? AND d.hapus = 0";
        $stmt_barang = mysqli_prepare($db_result, $sql_barang);
        mysqli_stmt_bind_param($stmt_barang, "i", $gid);
        mysqli_stmt_execute($stmt_barang);
        $data_barang = mysqli_stmt_get_result($stmt_barang);
        
        // 2. Kembalikan stok untuk setiap barang
        while ($row_barang = mysqli_fetch_assoc($data_barang)) {
            $id_barang = $row_barang['id_barang'];
            $jumlah_keluar = $row_barang['jumlah_keluar'];
            
            $sql_update_stok = "UPDATE gl_data_barang 
                               SET jml_stok_gudang = jml_stok_gudang + ? 
                               WHERE id = ?";
            $stmt_update = mysqli_prepare($db_result, $sql_update_stok);
            mysqli_stmt_bind_param($stmt_update, "ii", $jumlah_keluar, $id_barang);
            
            if (!mysqli_stmt_execute($stmt_update)) {
                $error = true;
                break;
            }
        }
        
        // 3. Jika pengembalian stok berhasil, update status transaksi
        if (!$error) {
            // Update status transaksi menjadi draft (belum final)
            $inp_trans = "UPDATE gl_barang_keluar 
                         SET simpan = 0, tgl_update = NOW(), user_update = 'admin' 
                         WHERE id_barang_keluar = ?";
            $stmt_trans = mysqli_prepare($db_result, $inp_trans);
            mysqli_stmt_bind_param($stmt_trans, "i", $gid);
            $upd_trans = mysqli_stmt_execute($stmt_trans);
            
            if (!$upd_trans) {
                $error = true;
            }
        }
        
        // 4. Commit atau rollback transaksi
        if (!$error) {
            mysqli_commit($db_result);
            $nket = "<div class='alert alert-success'>Transaksi berhasil dibatalkan. Stok barang telah dikembalikan.</div>";
        } else {
            mysqli_rollback($db_result);
            $nket = "<div class='alert alert-danger'>Gagal membatalkan transaksi</div>";
        }
        
        mysqli_autocommit($db_result, true);
        
        echo "$nket
        <meta http-equiv='refresh' content='2;url=$link_back'>";
    } else {
        echo "<div class='alert alert-warning'>Anda tidak memiliki izin untuk membatalkan transaksi</div>";
        echo "<meta http-equiv='refresh' content='2;url=$link_back'>";
    }
    break;
}
?>

<script type="text/javascript">
    // Fungsi untuk konfirmasi finalisasi
    function confirmFinalize() {
        var confirmation = confirm("Apakah Anda yakin ingin memfinalisasi transaksi ini? Stok barang akan dikurangi dan transaksi tidak dapat diubah lagi.");
        if (confirmation) {
            return true;
        } else {
            return false;
        }
    }

    // Fungsi untuk konfirmasi pembatalan
    function confirmCancel() {
        var confirmation = confirm("Apakah Anda yakin ingin membatalkan transaksi ini? Semua data akan dihapus.");
        if (confirmation) {
            return true;
        } else {
            return false;
        }
    }
</script>