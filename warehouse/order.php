<!DOCTYPE html>
<?php 
include('../konekdb.php');
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['idpegawai'])) {
    header("location:../index.php");
    exit();
}

$username = $_SESSION['username'];
$idpegawai = $_SESSION['idpegawai'];

$cekuser = mysqli_query($mysqli, "SELECT count(username) as jmluser FROM authorization WHERE username = '$username' AND modul = 'Warehouse'");
if (!$cekuser) {
    die("Error checking user authorization: " . mysqli_error($mysqli));
}
$user = mysqli_fetch_array($cekuser);

$getpegawai = mysqli_query($mysqli, "SELECT * FROM pegawai WHERE id_pegawai='$idpegawai'");
if (!$getpegawai) {
    die("Error fetching employee data: " . mysqli_error($mysqli));
}
$pegawai = mysqli_fetch_array($getpegawai);

if ($user['jmluser'] == "0") {
    header("location:../index.php");
    exit();
}

// Handle delete operation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = mysqli_real_escape_string($mysqli, $_POST['delete_id']);
    $deleteQuery = "DELETE FROM dariwarehouse WHERE no = '$delete_id'";
    if (mysqli_query($mysqli, $deleteQuery)) {
        $_SESSION['message'] = "<div class='alert alert-success'>Data berhasil dihapus!</div>";
    } else {
        $_SESSION['message'] = "<div class='alert alert-danger'>Gagal menghapus data. Silakan coba lagi.</div>";
    }
    header("Location: order.php");
    exit();
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
            <a href="index.html" class="logo">
                E-Pharm
            </a>
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
                                        <small>Member since <?php echo "$pegawai[Tanggal_Masuk]"; ?></small>
                                    </p>
                                </li>
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Warehouse</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Cabang</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Blitar</a>
                                    </div>
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
                            <img src="img/<?php echo $pegawai['foto'];?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $username;?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li>
                            <a href="index.php">
                                <i class="fa fa-dashboard"></i> <span>Statistical</span>
                            </a>
                        </li>
                        <li>
                            <a href="kategori.php">
                                <i class="fa fa-list-alt"></i> <span>Category</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="order.php">
                                <i class="fa fa-th"></i> <span>Order</span>
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

            <aside class="right-side">
                <section class="content-header">
                    <h1>
                        Warehouse
                        <small>Blitar</small>
                    </h1>
                </section>

                <section class="content">
                    <?php 
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                    ?>
                    
                    <h1>Order Barang</h1>
                    <form method="post" onsubmit="'Success Create!'; this.style.border = '2px solid green';">
                        <div class="row">
                            <div class="col-md-2">
                                <strong>Product Id</strong>
                                <input type="number" class="form-control" placeholder="Input Prod ID..." name="code" required>
                            </div>
                            <div class="col-md-2">
                                <strong>Nama Barang</strong>
                                <input type="text" class="form-control" placeholder="Input Nama Barang..." name="nama" required>
                            </div>
                            <div class="col-md-2">
                                <strong>Category</strong>
                                <select name="kategori" class="form-control" required>
                                    <option value="">---Pilih Category---</option>
                                    <?php
                                    $query = mysqli_query($mysqli, "SELECT nama_kategori FROM kategori");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo "<option value=\"{$row['nama_kategori']}\">{$row['nama_kategori']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">  
                                <strong>Jumlah</strong>
                                <input type="number" class="form-control" placeholder="Input Minimum Barang..." name="jumlah" min="5" required oninvalid="this.setCustomValidity('Jumlah minimum adalah 5')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="col-md-2">
                                <strong>Satuan</strong>
                                <input type="text" class="form-control" placeholder="Input Satuan Barang..." name="satuan" required>
                            </div>
                            <div class="col-md-2">
                                <strong>Reorder-Level</strong>
                                <input type="number" class="form-control" placeholder="Input Minimum Barang..." name="reorder-level" min="5" required oninvalid="this.setCustomValidity('Jumlah minimum adalah 5')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="col-md-2">
                                <strong>Supplier</strong>
                                <select name="supplier" class="form-control" required>
                                    <option value="">---Pilih Supplier---</option>
                                    <?php
                                    $query = mysqli_query($mysqli, "SELECT Nama FROM supplier");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo "<option value=\"{$row['Nama']}\">{$row['Nama']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_id'])) {
                        $code         = mysqli_real_escape_string($mysqli, $_POST['code']);
                        $nama         = mysqli_real_escape_string($mysqli, $_POST['nama']);
                        $kategori     = mysqli_real_escape_string($mysqli, $_POST['kategori']);
                        $jumlah       = mysqli_real_escape_string($mysqli, $_POST['jumlah']);
                        $satuan       = mysqli_real_escape_string($mysqli, $_POST['satuan']);
                        $reorder      = mysqli_real_escape_string($mysqli, $_POST['reorder-level']);
                        $supplier     = mysqli_real_escape_string($mysqli, $_POST['supplier']);

                        $barcode      = "https://barcode.tec-it.com/barcode.ashx?data=$code&code=Code128&dpi=96";
                        $status       = "Order Sent";

                        $insertQuery = "INSERT INTO dariwarehouse (code, nama, kategori, jumlah, satuan, reorder, supplier, cabang, status)
                                        VALUES ('$code', '$nama', '$kategori', '$jumlah', '$satuan', '$reorder', '$supplier', 'Blitar', '$status')";
                        $result = mysqli_query($mysqli, $insertQuery);
                        
                        if ($result) {
                            echo "<div class='alert alert-success'>Order Barang Berhasil Ditambahkan!</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Gagal Menambahkan Order Barang. Coba Lagi.</div>";
                        }
                    }
                    ?>
                </section>

                <section class="content">
                    <h2>Order Barang Terkini</h2>
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Product Code</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Supplier</th>
                            <th>Barcode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        <?php
                        $orders = mysqli_query($mysqli, "SELECT * FROM dariwarehouse ORDER BY no DESC");
                        $counter = 1;
                        while ($order = mysqli_fetch_assoc($orders)) {
                            echo "<tr>
                                <td>".$counter++."</td>
                                <td>{$order['code']}</td>
                                <td>{$order['nama']}</td>
                                <td>{$order['kategori']}</td>
                                <td>{$order['jumlah']}</td>
                                <td>{$order['satuan']}</td>
                                <td>{$order['supplier']}</td>
                                <td><img src='https://barcode.tec-it.com/barcode.ashx?data={$order['code']}&code=Code128&dpi=96' alt='Barcode' style='height:50px;'></td>
                                <td>";
                                if ($order['status'] === "0") {
                                    echo "<button class='btn btn-warning'>Pending</button>";
                                } elseif ($order['status'] === "1") {
                                    echo "<button class='btn btn-success'>Accept</button>";
                                } elseif ($order['status'] === "2") {
                                    echo "<button class='btn btn-danger'>Reject</button>";
                                }
                                echo "</td>
                                <td>
                                    <form method='post' style='display:inline;'>
                                        <input type='hidden' name='delete_id' value='{$order['no']}'>
                                        <button type='submit' class='btn btn-danger' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Hapus</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                        ?>
                    </table>
                </section>
            </aside>
        </div>
        
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>