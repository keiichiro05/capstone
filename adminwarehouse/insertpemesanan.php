<?php
include "konekdb.php";
session_start();

if(isset($_GET['no'])) {
    $no = intval($_GET['no']);
    
    // Get the order data first
    $getOrder = mysqli_query($mysqli, "SELECT * FROM dariwarehouse WHERE no = $no");
    $order = mysqli_fetch_assoc($getOrder);
    
    if($order) {
        $currentDate = date('Y-m-d H:i:s');
        
        // Prepare statement for pemesanan table
        $stmt = $mysqli->prepare("INSERT INTO pemesanan 
                        (code, namabarang, kategori, jumlah, satuan, id_supplier, tanggal, status, cabang) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, '1', ?)");
        $stmt->bind_param("sssissis", 
            $order['code'],
            $order['nama'],
            $order['kategori'],
            $order['jumlah'],
            $order['satuan'],
            $order['supplier'],
            $currentDate,
            $order['cabang']
        );
        
        if($stmt->execute()) {
            // Delete from dariwarehouse table
            $stmt2 = $mysqli->prepare("DELETE FROM dariwarehouse WHERE no = ?");
            $stmt2->bind_param("i", $no);
            
            if($stmt2->execute()) {
                $_SESSION['message'] = '<div class="alert alert-success">Pesanan telah diterima dan dipindahkan ke database pemesanan.</div>';
            } else {
                $_SESSION['message'] = '<div class="alert alert-danger">Gagal menghapus pesanan dari daftar.</div>';
            }
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger">Gagal memindahkan pesanan ke database pemesanan.</div>';
        }
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger">Pesanan tidak ditemukan.</div>';
    }
} else {
    $_SESSION['message'] = '<div class="alert alert-danger">Parameter tidak valid.</div>';
}

header("Location: daftarpermintaan.php");
exit();
?>