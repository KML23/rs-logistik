<?php
if (preg_match("/\bindex.php\b/i", $_SERVER['REQUEST_URI'])) {
    exit;
} else {
    switch ($act2) {
        case 'tambahdata':
            // Proses tambah data pegawai
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nama = $_POST['nama'];
                $jabatan = $_POST['jabatan'];
                $email = $_POST['email'];
                $telepon = $_POST['telepon'];

                // Validasi input
                if (empty($nama) || empty($jabatan) || empty($email) || empty($telepon)) {
                    echo "Semua field harus diisi!";
                } else {
                    // Query untuk menyimpan data
                    $query = "INSERT INTO data_pegawai (nama, jabatan, email, telepon, tgl_insert, user_update)
                              VALUES ('$nama', '$jabatan', '$email', '$telepon', NOW(), 'admin')";
                    
                    if (mysqli_query($conn, $query)) {
                        echo "Data pegawai berhasil ditambahkan.";
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                }
            } else {
                echo "Metode request tidak valid.";
            }
            break;

        default:
            echo "Aksi tidak dikenali.";
            break;
    }
}
?>
