<!DOCTYPE html>
<?php 
include('../konekdb.php');
session_start();

$username = $_SESSION['username'] ?? null;
$idpegawai = $_SESSION['idpegawai'] ?? null;

if (!$username || !$idpegawai) {
    header("location:../index.php");
    exit;
}

$cekuser = mysqli_query($mysqli, "SELECT count(username) as jmluser FROM authorization WHERE username = '$username' AND modul = 'Warehouse'");
$user = mysqli_fetch_assoc($cekuser);

$getpegawai = mysqli_query($mysqli, "SELECT * FROM pegawai WHERE id_pegawai='$idpegawai'");
$pegawai = mysqli_fetch_array($getpegawai);

if ($user['jmluser'] == "0") {
    header("location:../index.php");
    exit;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Warehouse Cabang Blitar</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="../css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <link href="../css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <link href="../css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <link href="../css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="skin-blue">
        <header class="header">
            <a href="index.html" class="logo">PSN</a>
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
                                <span><?php echo htmlspecialchars($username); ?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header bg-light-blue">
                                    <img src="img/<?php echo htmlspecialchars($pegawai['foto']); ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php 
                                        echo htmlspecialchars($pegawai['Nama']) . " - " . htmlspecialchars($pegawai['Jabatan']) . " " . htmlspecialchars($pegawai['Departemen']); ?>
                                        <small>Member since <?php echo htmlspecialchars($pegawai['Tanggal_Masuk']); ?></small>
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
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/<?php echo htmlspecialchars($pegawai['foto']); ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo htmlspecialchars($username); ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="index.php">
                                <i class="fa fa-dashboard"></i> <span>Statistical</span>
                            </a>
                        </li>
                        <li>
                            <a href="kategori.php">
                                <i class="fa fa-list-alt"></i> <span>Category</span>
                            </a>
                        </li>
                        <li>
                            <a href="order.php">
                                <i class="fa fa-th"></i> <span>Order</span>
                            </a>
                        </li>
                        <li>
                            <a href="history_order.php">
                                <i class="fa fa-history"></i> <span>History Order</span>
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
<html>
    <head>
        <meta charset="UTF-8">
        <title>History Pemesanan - Cabang Blitar</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <style>
            .status-1 { background-color: #dff0d8; }
            .status-2 { background-color: #f2dede; }
            .status-pending { background-color: #fcf8e3; }
        </style>
    </head>
    <body class="skin-blue">
        <!-- Header dan Sidebar tetap sama seperti sebelumnya -->
        <!-- ... -->
        
        <aside class="right-side">
            <section class="content-header">
                <h1>
                    History Pemesanan
                    <small>Cabang Blitar</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">History Pemesanan</li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Riwayat Pemesanan Barang</h3>
                                <div class="box-tools">
                                    <form method="get" action="history_pemesanan.php" class="form-inline">
                                        <div class="input-group">
                                            <select name="status" class="form-control">
                                                <option value="">Semua Status</option>
                                                <option value="pending" <?php echo (isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                                <option value="1" <?php echo (isset($_GET['status']) && $_GET['status'] == '1' ? 'selected' : ''); ?>>Accepted</option>
                                                <option value="2" <?php echo (isset($_GET['status']) && $_GET['status'] == '2' ? 'selected' : ''); ?>>Declined</option>
                                            </select>
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="box-body table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>No</th>
                                            <th>ID Pemesanan</th>
                                            <th>Tanggal Pemesanan</th>
                                            <th>Nama Barang</th>
                                            <th>Kategori</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Supplier</th>
                                            <th>Status</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query untuk mengambil data pemesanan dengan JOIN ke tabel supplier
                                        $query = "SELECT p.*, s.Nama as Nama 
                                                FROM pemesanan p
                                                LEFT JOIN supplier s ON p.id_supplier = s.id_supplier
                                                WHERE p.cabang = 'Blitar'";
                                        
                                        // Filter berdasarkan status jika ada
                                        if (isset($_GET['status']) && $_GET['status'] != '') {
                                            $status = mysqli_real_escape_string($mysqli, $_GET['status']);
                                            $query .= " AND p.status = '$status'";
                                        } else {
                                            // Tampilkan hanya yang sudah direspon (1/2)
                                            $query .= " AND p.status IN ('1', '2')";
                                        }
                                        
                                        $query .= " ORDER BY p.tanggal DESC";
                                        
                                        $result = mysqli_query($mysqli, $query);
                                        $no = 1;
                                        
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                // Tentukan class CSS berdasarkan status
                                                $rowClass = '';
                                                if ($row['status'] == '1') {
                                                    $rowClass = 'status-1';
                                                } elseif ($row['status'] == '2') {
                                                    $rowClass = 'status-2';
                                                } elseif ($row['status'] == 'pending') {
                                                    $rowClass = 'status-pending';
                                                }
                                                
                                                echo "<tr class='$rowClass'>
                                                    <td>$no</td>
                                                    <td>{$row['id_pemesanan']}</td>
                                                    <td>".date('d/m/Y H:i', strtotime($row['tanggal']))."</td>
                                                    <td>{$row['namabarang']}</td>
                                                    <td>{$row['kategori']}</td>
                                                    <td>{$row['jumlah']}</td>
                                                    <td>{$row['satuan']}</td>
                                                    <td>".(!empty($row['id_supplier']) ? $row['id_supplier'] : 'Supplier tidak ditemukan')."</td>
                                                    <td>";
                                                
                                                // Tampilkan status dengan label yang sesuai
                                                if ($row['status'] == '1') {
                                                    echo "<span class='label label-success'>Accepted</span>";
                                                } elseif ($row['status'] == '2') {
                                                    echo "<span class='label label-danger'>Declined</span>";
                                                } elseif ($row['status'] == 'pending') {
                                                    echo "<span class='label label-warning'>Pending</span>";
                                                }   
                                                
                                                echo "</td>
                                                    
                                                </tr>";
                                                $no++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='10' class='text-center'>Tidak ada data pemesanan</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                                <!-- Pagination bisa ditambahkan di sini jika diperlukan -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </aside>
        
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>