<!DOCTYPE html>
<?php 
include('../konekdb.php');
session_start();
$username = $_SESSION['username'];
$idpegawai = $_SESSION['idpegawai'];
$cekuser = mysqli_query($mysqli, "SELECT count(username) as jmluser FROM authorization WHERE username = '$username' AND modul = 'Adminwarehouse'");
$user = mysqli_fetch_array($cekuser);
$getpegawai = mysqli_query($mysqli, "SELECT * FROM pegawai where id_pegawai='$idpegawai'");
$pegawai = mysqli_fetch_array($getpegawai);

if($user['jmluser'] == "0") {
    header("location:../index.php");
    exit();
}

// Handle reject action
if(isset($_GET['reject']) && isset($_GET['no'])) {
    $no = intval($_GET['no']);
    
    // Get the order data first
    $getOrder = $mysqli->prepare("SELECT * FROM dariwarehouse WHERE no = ?");
    $getOrder->bind_param("i", $no);
    $getOrder->execute();
    $order = $getOrder->get_result()->fetch_assoc();
    
    if($order) {
        $currentDate = date('Y-m-d H:i:s');
        
        // Insert into pemesanan table with status=2 (rejected)
        $stmt = $mysqli->prepare("INSERT INTO pemesanan 
                        (code, namabarang, kategori, jumlah, satuan, id_supplier, tanggal, status, cabang) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, '2', ?)");
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
                $_SESSION['message'] = '<div class="alert alert-success">Pesanan telah ditolak dan dipindahkan ke database pemesanan.</div>';
            } else {
                $_SESSION['message'] = '<div class="alert alert-danger">Gagal menghapus pesanan dari daftar.</div>';
            }
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger">Gagal memindahkan pesanan ke database pemesanan.</div>';
        }
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger">Pesanan tidak ditemukan.</div>';
    }
    
    header("Location: index.php");
    exit();
}

// Handle accept action
if(isset($_GET['accept']) && isset($_GET['no'])) {
    $no = intval($_GET['no']);
    
    // Get the order data first
    $getOrder = $mysqli->prepare("SELECT * FROM dariwarehouse WHERE no = ?");
    $getOrder->bind_param("i", $no);
    $getOrder->execute();
    $order = $getOrder->get_result()->fetch_assoc();
    
    if($order) {
        $currentDate = date('Y-m-d H:i:s');
        
        // Insert into pemesanan table with status=1 (accepted)
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
    
    header("Location: index.php");
    exit();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Warehouse</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.html" class="logo">E-Pharm</a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $username;?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header bg-light-blue">
                                    <img src="img/<?php echo $pegawai['foto'];?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $pegawai['Nama']." - ".$pegawai['Jabatan']." ".$pegawai['Departemen'];?>
                                        <small>Member since <?php echo $pegawai['Tanggal_Masuk']; ?></small>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="profil.php" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/<?php echo $pegawai['foto'];?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $username;?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="dashboard.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="index.php">
                                <i class="fa fa-list"></i> <span>Daftar Pesanan</span>
                            </a>
                        </li>
                        <li>
                            <a href="daftarACC.php">
                                <i class="fa fa-th"></i> <span>Daftar ACC</span>
                            </a>
                        </li>
                        <li>
                            <a href="cuti.php">
                                <i class="fa fa-suitcase"></i> <span>Cuti</span>
                            </a>
                        </li>
                        <li>
                            <a href="mailbox.php">
                                <i class="fa fa-comments"></i> <span>Mailbox</span>
                            </a>
                        </li>
                    </ul>
                </section>
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <section class="content-header">
                    <h1>
                        Warehouse
                        <small>Admin</small>
                    </h1>
                    <ol class="breadcrumb">
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <?php 
                    if(isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                    ?>
                    <h1>Daftar Pesanan Barang dari Cabang</h1>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>code</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Cabang</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM dariwarehouse WHERE status = 0";
                            $hasil = mysqli_query($mysqli, $sql);

                            if (mysqli_num_rows($hasil) > 0) {
                                while ($baris = mysqli_fetch_array($hasil)) {
                                    echo "<tr>
                                            <td>{$baris['no']}</td>
                                            <td>".htmlspecialchars($baris['code'])."</td>
                                            <td>".htmlspecialchars($baris['nama'])."</td>
                                            <td>{$baris['jumlah']}</td>
                                            <td>".htmlspecialchars($baris['satuan'])."</td>
                                            <td>".htmlspecialchars($baris['supplier'])."</td>
                                            <td><button class='btn btn-warning'>Pending</button></td>
                                            <td>".htmlspecialchars($baris['cabang'])."</td>
                                            <td>".htmlspecialchars($baris['kategori'])."</td>
                                            <td>
                                                <a href='index.php?accept=true&no={$baris['no']}' class='btn btn-primary'>Accept</a>
                                                <a href='index.php?reject=true&no={$baris['no']}' onclick='return confirm(\"Apakah Anda yakin ingin menolak pesanan ini?\")' class='btn btn-danger'>Reject</a>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10' style='text-align:center;'>Tidak ada pesanan yang perlu diproses</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </section>
            </aside>
        </div>

        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->  
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>