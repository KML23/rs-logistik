<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan koneksi database tersedia
if (!isset($db_result) || !$db_result) {
    die("Koneksi database tidak tersedia.");
}

// Cegah akses langsung ke index.php
if (preg_match("/\bindex.php\b/i", $_SERVER['REQUEST_URI'])) {
    exit;
}

// Query untuk mendapatkan jumlah barang, jenis, satuan, dan user
$sqld = "SELECT 
            (SELECT COUNT(*) FROM gl_data_barang WHERE hapus = 0) as total_barang,
            (SELECT COUNT(*) FROM gl_jenis_barang WHERE hapus = 0) as jenis_barang,
            (SELECT COUNT(*) FROM gl_satuan_barang WHERE hapus = 0) as satuan_barang,
            (SELECT COUNT(*) FROM db_user WHERE hapus = 0) as total_user";

$data = mysqli_query($db_result, $sqld);

// Periksa apakah query berhasil dieksekusi
if (!$data) {
    die("Query error: " . mysqli_error($db_result));
}

$fdata = mysqli_fetch_assoc($data);
$total_barang = $fdata['total_barang'] ?? 0;
$jenis_barang = $fdata['jenis_barang'] ?? 0;
$satuan_barang = $fdata['satuan_barang'] ?? 0;
$total_user = $fdata['total_user'] ?? 0; // Menambahkan total user

// Output tampilan statistik dengan tombol More Info yang mengarah ke halaman yang sesuai
echo "<div class='row'>
    <div class='col-lg-3 col-xs-6'>
        <div class='small-box bg-red'>
            <div class='inner'>
                <h3>$total_user</h3>
                <p>Total User</p>
            </div>
            <div class='icon'>
                <i class='fa fa-user'></i>
            </div>
            <a href='?pages=data-user' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
        </div>
    </div>
    <div class='col-lg-3 col-xs-6'>
        <div class='small-box bg-aqua'>
            <div class='inner'>
                <h3>$total_barang</h3>
                <p>Total Data Barang</p>
            </div>
            <div class='icon'>
                <i class='fa fa-database'></i>
            </div>
            <a href='?pages=gl-data-barang' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
        </div>
    </div>
    <div class='col-lg-3 col-xs-6'>
        <div class='small-box bg-green'>
            <div class='inner'>
                <h3>$jenis_barang</h3>
                <p>Jenis Barang</p>
            </div>
            <div class='icon'>
                <i class='fa fa-list'></i>
            </div>
            <a href='?pages=gl-jenis-barang' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
        </div>
    </div>
    <div class='col-lg-3 col-xs-6'>
        <div class='small-box bg-yellow'>
            <div class='inner'>
                <h3>$satuan_barang</h3>
                <p>Satuan Barang</p>
            </div>
            <div class='icon'>
                <i class='fa fa-balance-scale'></i>
            </div>
            <a href='?pages=gl-satuan-barang' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
        </div>
    </div>
</div>";
?>
