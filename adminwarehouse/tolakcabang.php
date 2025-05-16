<?php
include "../konekdb.php";
session_start();

// Validasi sesi pengguna
if (!isset($_SESSION['username']) || !isset($_SESSION['idpegawai'])) {
    header("Location: ../index.php");
    exit;
}

$username = $_SESSION['username'];
$idpegawai = $_SESSION['idpegawai'];

// Validasi pengguna dan modul
$cekuser = mysqli_query($mysqli, "SELECT count(username) as jmluser FROM authorization WHERE username = '$username' AND modul = 'Adminwarehouse'");
$user = mysqli_fetch_array($cekuser);
$getpegawai = mysqli_query($mysqli, "SELECT * FROM pegawai WHERE id_pegawai='$idpegawai'");
$pegawai = mysqli_fetch_array($getpegawai);

if ($user['jmluser'] == "0") {
    header("Location: ../index.php");
    exit;
}

// Validasi koneksi database
if (!$mysqli || $mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Validasi parameter 'No'
if (isset($_GET['No']) && is_numeric($_GET['No'])) {
    $No = (int)$_GET['No'];

    // Mulai transaksi untuk memastikan konsistensi data
    if (!$mysqli->begin_transaction()) {
        die("Failed to start transaction: " . $mysqli->error);
    }

    try {
        // Update status menjadi '2' di tabel pemesanan
        $stmt = $mysqli->prepare("UPDATE pemesanan SET status = '2' WHERE No = ?");
        if ($stmt) {
            $stmt->bind_param("i", $No);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception("Error preparing update query: " . $mysqli->error);
        }

        // Commit transaksi
        $mysqli->commit();

        // Redirect setelah selesai
        header("Location: daftarACC.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        $mysqli->rollback();
        die("Transaction failed: " . $e->getMessage());
    }
} else {
    // Jika parameter 'No' tidak valid
    header("Location: daftarACC.php?error=invalid_parameter");
    exit;
}
?>
