<?php
// Prevent direct request with 'index.php' in URI
if (preg_match("/\bindex.php\b/i", $_SERVER['REQUEST_URI'])) {
    exit;
}

switch ($act) {
case 'detail':
        // Ambil ID transaksi (gid) dari parameter URL
        $gid = isset($_GET['gid']) ? intval($_GET['gid']) : 0;
    
        // Cek jika ID transaksi tidak valid
        if ($gid <= 0) {
            echo '<div class="alert alert-danger">ID Transaksi tidak valid.</div>';
            echo '<meta http-equiv="refresh" content="2;url=' . htmlspecialchars($link_back) . '">';
            exit;
        }
    
        // Query untuk mengambil data transaksi utama
        $sql_parent = "SELECT * FROM gl_barang_keluar WHERE id_barang_keluar = ?";
        $stmt_parent = mysqli_prepare($db_result, $sql_parent);
        mysqli_stmt_bind_param($stmt_parent, 'i', $gid);
        mysqli_stmt_execute($stmt_parent);
        $res_parent = mysqli_stmt_get_result($stmt_parent);
    
        // Cek apakah transaksi ditemukan
        if (!$res_parent || mysqli_num_rows($res_parent) == 0) {
            echo '<div class="alert alert-warning">Transaksi tidak ditemukan.</div>';
            echo '<meta http-equiv="refresh" content="2;url=' . htmlspecialchars($link_back) . '">';
            exit;
        }
    
        // Ambil data transaksi utama
        $parent = mysqli_fetch_assoc($res_parent);
        $parent_no_transaksi = htmlspecialchars($parent['no_transaksi']);
        $parent_nama_unit = htmlspecialchars($parent['nama_unit']);
        $parent_nama_pengambil = htmlspecialchars($parent['nama_pengambil']);
        $parent_tanggal_transaksi = date('d-m-Y H:i', strtotime($parent['tanggal_transaksi']));
        $parent_keterangan = htmlspecialchars($parent['keterangan']);
        $simpan = $parent['simpan'];
    
        // Query untuk mengambil detail barang keluar
        $sql_detail = "
            SELECT 
                d.id_detail_barang_keluar,
                b.nama_barang,
                sb.nama_satuan AS satuan,
                d.jumlah_keluar,
                b.id AS id_barang
            FROM 
                gl_barang_keluar_detail d
            JOIN 
                gl_data_barang b ON d.id_barang = b.id
            JOIN 
                gl_satuan_barang sb ON b.id_gl_satuan_barang = sb.id
            WHERE 
                d.id_barang_keluar = ? 
                AND d.hapus = 0
            ORDER BY 
                d.id_detail_barang_keluar DESC
        ";
        $stmt_detail = mysqli_prepare($db_result, $sql_detail);
        mysqli_stmt_bind_param($stmt_detail, 'i', $gid);
        mysqli_stmt_execute($stmt_detail);
        $res_detail = mysqli_stmt_get_result($stmt_detail);
    
        // Menyiapkan baris tabel untuk detail barang keluar
        $rows_detail = '';
        $counter = 0;
        $total_items = 0;
        while ($r = mysqli_fetch_assoc($res_detail)) {
            $counter++;
            $id_detail = $r['id_detail_barang_keluar'];
            $nama_barang = htmlspecialchars($r['nama_barang']);
            $satuan = htmlspecialchars($r['satuan']);
            $jumlah_keluar = htmlspecialchars($r['jumlah_keluar']);
            $id_barang = $r['id_barang'];
            $total_items += $jumlah_keluar;
    
            // Tombol Edit dan Hapus (hanya jika belum disimpan)
            $btn_actions = '';
            if ($simpan == 0) {
                $btn_edit = "<a href='?act=detail_input&gket=edit&gid={$id_detail}&parent_id=$gid' class='btn btn-xs btn-success'><i class='fa fa-edit'></i> Edit</a>";
                $btn_delete = "<a href='?act=detail_hapus&gid={$id_detail}&parent_id=$gid' onclick='return confirm(\"Yakin hapus item ini?\");' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i> Hapus</a>";
                $btn_actions = "{$btn_edit} {$btn_delete}";
            }
    
            $rows_detail .= "<tr>
                <td>{$counter}</td>
                <td>{$nama_barang}</td>
                <td>{$satuan}</td>
                <td class='text-right'>{$jumlah_keluar}</td>
                <td>{$btn_actions}</td>
            </tr>";
        }
    
        // Query untuk dropdown barang
        $sql_barang = "SELECT b.id, b.nama_barang, sb.nama_satuan, b.jml_stok_gudang 
                       FROM gl_data_barang b
                       JOIN gl_satuan_barang sb ON b.id_gl_satuan_barang = sb.id
                       WHERE b.hapus = 0
                       ORDER BY b.nama_barang";
        $res_barang = mysqli_query($db_result, $sql_barang);
        $options_barang = '<option value="">Pilih Barang</option>';
        while ($row = mysqli_fetch_assoc($res_barang)) {
            $stok = $row['jml_stok_gudang'];
            $options_barang .= "<option value='{$row['id']}' data-stok='{$stok}'>{$row['nama_barang']} (Stok: {$stok} {$row['nama_satuan']})</option>";
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail Barang Keluar</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo htmlspecialchars($link_back); ?>" class="btn btn-sm btn-default">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
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
                                                <td><?php echo $parent_no_transaksi; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal</th>
                                                <td><?php echo $parent_tanggal_transaksi; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Unit</th>
                                                <td><?php echo $parent_nama_unit; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Pengambil</th>
                                                <td><?php echo $parent_nama_pengambil; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Total Item</th>
                                                <td><?php echo $total_items; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <?php if ($simpan == 1): ?>
                                                        <span class="label label-success">Tersimpan</span>
                                                    <?php else: ?>
                                                        <span class="label label-warning">Draft</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                            <?php if ($simpan == 0): ?>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Tambah Barang</h4>
                                </div>
                                <div class="panel-body">
                                    <!-- Pastikan action mengarah ke home.php dengan parameter act yang benar -->
                                    <form id="form-tambah-barang" method="post" action="home.php?act=tambah_barang_keluar">
                                        <input type="hidden" name="gid" value="<?php echo $gid; ?>">
                                        
                                        <div class="form-group">
                                            <label>Barang</label>
                                            <select name="id_gl_data_barang" class="form-control select2" required>
                                                <?php echo $options_barang; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="number" name="jml_barang" class="form-control" min="1" required>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </form>

                                    
                                    <!-- Tambahkan ini untuk menampilkan pesan error/success -->
                                    <?php
                                    if (isset($_SESSION['error'])) {
                                        echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
                                        unset($_SESSION['error']);
                                    }
                                    if (isset($_SESSION['success'])) {
                                        echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
                                        unset($_SESSION['success']);
                                    }
                                    ?>
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
                                                            <th width="120">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php echo $rows_detail; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
    
                                <?php if ($simpan == 0 && $counter > 0): ?>
                                <form method="post" action="?act=finalize_transaction">
                                    <input type="hidden" name="gid" value="<?php echo $gid; ?>">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" onclick="return confirm('Simpan transaksi ini? Setelah disimpan tidak bisa diubah lagi.');">
                                            <i class="fa fa-save"></i> Simpan Transaksi
                                        </button>
                                        <a href="?act=detail&gid=<?php echo $gid; ?>" class="btn btn-default">
                                            <i class="fa fa-refresh"></i> Refresh
                                        </a>
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
            
            // Show stock info when item selected
            $('select[name="id_gl_data_barang"]').change(function() {
                var selected = $(this).find('option:selected');
                var stok = selected.data('stok');
                $('.stok-info').text('Stok tersedia: ' + stok);
                $('input[name="jml_barang"]').attr('max', stok);
            });
            
            // Form validation
            $('#form-tambah-barang').submit(function() {
                var jml = parseInt($('input[name="jml_barang"]').val());
                var stok = parseInt($('select[name="id_gl_data_barang"]').find('option:selected').data('stok'));
                
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
        break;
    
        case 'tambah_barang_keluar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                session_start();
                // Debug: Log semua POST data
                error_log("POST Data: " . print_r($_POST, true));
                
                $gid = isset($_POST['gid']) ? intval($_POST['gid']) : 0;
                $id_barang = isset($_POST['id_gl_data_barang']) ? intval($_POST['id_gl_data_barang']) : 0;
                $jumlah = isset($_POST['jml_barang']) ? intval($_POST['jml_barang']) : 0;
                $user_update = isset($_SESSION['username']) ? $_SESSION['username'] : 'system';

                // Debug: Log parameter
                error_log("Params: gid=$gid, id_barang=$id_barang, jumlah=$jumlah");
        
                // Validasi dasar
                if ($gid <= 0 || $id_barang <= 0 || $jumlah <= 0) {
                    $_SESSION['error'] = 'Data tidak lengkap! Pastikan semua field terisi dengan benar.';
                    header("Location: home.php?act=detail&gid=".$gid);
                    exit;
                }
        
                // Cek stok tersedia
                $sql_stok = "SELECT jml_stok_gudang FROM gl_data_barang WHERE id = ?";
                $stmt = mysqli_prepare($db_result, $sql_stok);
                mysqli_stmt_bind_param($stmt, 'i', $id_barang);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $stok = mysqli_fetch_assoc($result)['jml_stok_gudang'];
        
                if ($stok < $jumlah) {
                    $_SESSION['error'] = 'Stok tidak mencukupi! Stok tersedia: '.$stok;
                    header("Location: home.php?act=detail&gid=".$gid);
                    exit;
                }
        
                // Cek duplikasi barang
                $sql_cek = "SELECT COUNT(*) as total FROM gl_barang_keluar_detail 
                             WHERE id_barang_keluar = ? AND id_barang = ? AND hapus = 0";
                $stmt = mysqli_prepare($db_result, $sql_cek);
                mysqli_stmt_bind_param($stmt, 'ii', $gid, $id_barang);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
        
                if ($row['total'] > 0) {
                    $_SESSION['error'] = 'Barang sudah ada dalam daftar!';
                    header("Location: home.php?act=detail&gid=".$gid);
                    exit;
                }
        
                // Simpan ke database
                $sql_insert = "INSERT INTO gl_barang_keluar_detail 
                               (id_barang_keluar, id_barang, jumlah_keluar, hapus, tgl_insert, user_update)
                               VALUES (?, ?, ?, 0, NOW(), ?)";
                $stmt = mysqli_prepare($db_result, $sql_insert);
                mysqli_stmt_bind_param($stmt, 'iiis', $gid, $id_barang, $jumlah, $user_update);
        
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['success'] = 'Barang berhasil ditambahkan ke daftar!';
                } else {
                    $_SESSION['error'] = 'Gagal menambahkan barang: '.mysqli_error($db_result);
                }
        
                header("Location: home.php?act=detail&gid=".$gid);
                exit;
            }
            break;
        
                    
        case 'simpan_transaksi': // Case baru untuk finalisasi
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
        
                $gid = isset($_POST['gid']) ? intval($_POST['gid']) : 0;
                
                if ($gid <= 0) {
                    $_SESSION['error'] = 'ID Transaksi tidak valid!';
                    header("Location: home.php?act=detail&gid=".$gid);
                    exit;
                }
        
                // Mulai transaksi
                mysqli_begin_transaction($db_result);
                
                try {
                    // 1. Cek ada barangnya
                    $sql_cek = "SELECT COUNT(*) as total FROM gl_barang_keluar_detail 
                                WHERE id_barang_keluar = ? AND hapus = 0";
                    $stmt = mysqli_prepare($db_result, $sql_cek);
                    mysqli_stmt_bind_param($stmt, 'i', $gid);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
        
                    if ($row['total'] == 0) {
                        throw new Exception("Tidak ada barang dalam transaksi!");
                    }
        
                    // 2. Kurangi stok untuk semua barang
                    $sql_update_stok = "UPDATE gl_data_barang b
                                       JOIN gl_barang_keluar_detail d ON b.id = d.id_barang
                                       SET b.jml_stok_gudang = b.jml_stok_gudang - d.jumlah_keluar
                                       WHERE d.id_barang_keluar = ? AND d.hapus = 0";
                    $stmt = mysqli_prepare($db_result, $sql_update_stok);
                    mysqli_stmt_bind_param($stmt, 'i', $gid);
                    
                    if (!mysqli_stmt_execute($stmt)) {
                        throw new Exception("Gagal update stok barang!");
                    }
        
                    // 3. Tandai transaksi sebagai selesai
                    $sql_finalize = "UPDATE gl_barang_keluar 
                                    SET simpan = 1, tgl_update = NOW() 
                                    WHERE id_barang_keluar = ?";
                    $stmt = mysqli_prepare($db_result, $sql_finalize);
                    mysqli_stmt_bind_param($stmt, 'i', $gid);
                    
                    if (!mysqli_stmt_execute($stmt)) {
                        throw new Exception("Gagal finalisasi transaksi!");
                    }
        
                    mysqli_commit($db_result);
                    $_SESSION['success'] = 'Transaksi berhasil disimpan!';
                } catch (Exception $e) {
                    mysqli_rollback($db_result);
                    $_SESSION['error'] = $e->getMessage();
                }
        
                header("Location: home.php?act=detail&gid=".$gid);
                exit;
            }
            break;
        
    
    case 'finalize_transaction':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gid = isset($_POST['gid']) ? intval($_POST['gid']) : 0;
            
            if ($gid <= 0) {
                $_SESSION['error'] = 'ID Transaksi tidak valid!';
                header("Location: ?act=detail&gid=$gid");
                exit;
            }
    
            // Cek apakah ada barang dalam transaksi
            $sql_cek = "SELECT COUNT(*) as total FROM gl_barang_keluar_detail 
                        WHERE id_barang_keluar = ? AND hapus = 0";
            $stmt_cek = mysqli_prepare($db_result, $sql_cek);
            mysqli_stmt_bind_param($stmt_cek, 'i', $gid);
            mysqli_stmt_execute($stmt_cek);
            $result_cek = mysqli_stmt_get_result($stmt_cek);
            $row = mysqli_fetch_assoc($result_cek);
    
            if ($row['total'] == 0) {
                $_SESSION['error'] = 'Tidak bisa menyimpan transaksi kosong!';
                header("Location: ?act=detail&gid=$gid");
                exit;
            }
    
            // Update status transaksi
            $sql_update = "UPDATE gl_barang_keluar SET simpan = 1, tgl_update = NOW() 
                          WHERE id_barang_keluar = ?";
            $stmt_update = mysqli_prepare($db_result, $sql_update);
            mysqli_stmt_bind_param($stmt_update, 'i', $gid);
            $success = mysqli_stmt_execute($stmt_update);
    
            if ($success) {
                $_SESSION['success'] = 'Transaksi berhasil disimpan!';
            } else {
                $_SESSION['error'] = 'Gagal menyimpan transaksi: ' . mysqli_error($db_result);
            }
    
            header("Location: ?act=detail&gid=$gid");
            exit;
        }
        break;
    
    case 'detail_hapus':
        $id_detail = $_GET['gid'] ?? 0;
        $parent_id = $_GET['parent_id'] ?? 0;
    
        if ($id_detail > 0) {
            // Dapatkan jumlah dan id_barang sebelum menghapus
            $sql_get = "SELECT id_barang, jumlah_keluar FROM gl_barang_keluar_detail WHERE id_detail_barang_keluar = ?";
            $stmt_get = mysqli_prepare($db_result, $sql_get);
            mysqli_stmt_bind_param($stmt_get, 'i', $id_detail);
            mysqli_stmt_execute($stmt_get);
            $result_get = mysqli_stmt_get_result($stmt_get);
            $row = mysqli_fetch_assoc($result_get);
            
            if ($row) {
                $id_barang = $row['id_barang'];
                $jumlah_keluar = $row['jumlah_keluar'];
                
                // Hapus detail
                $sql_delete = "UPDATE gl_barang_keluar_detail SET hapus = 1, tgl_update = NOW() WHERE id_detail_barang_keluar = ?";
                $stmt_delete = mysqli_prepare($db_result, $sql_delete);
                mysqli_stmt_bind_param($stmt_delete, 'i', $id_detail);
                mysqli_stmt_execute($stmt_delete);
                
                // Kembalikan stok
                $sql_update_stok = "UPDATE gl_data_barang SET jml_stok_gudang = jml_stok_gudang + ? WHERE id = ?";
                $stmt_update_stok = mysqli_prepare($db_result, $sql_update_stok);
                mysqli_stmt_bind_param($stmt_update_stok, 'ii', $jumlah_keluar, $id_barang);
                mysqli_stmt_execute($stmt_update_stok);
            }
        }
        header("Location: ?act=detail&gid=$parent_id");
        break;
                
        }
    ?>
    