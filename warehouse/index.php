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
            <aside class="right-side">
                <section class="content-header">
                    <h1>Warehouse <small>Blitar</small></h1>
                </section>
                <section class="content">
                    <div class="container">
                        <h1>Statistik Stok Barang</h1>
                        <form method="post">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Nama Barang</strong>
                                    <input type="text" class="form-control" placeholder="Input Nama Barang..." name="nama">
                                </div>
                                <div class="col-md-3">
                                    <strong>Kategori</strong>
                                    <input type="text" class="form-control" placeholder="Input Kategori Barang..." name="kategori">
                                </div>
                                <div class="col-md-3">
                                    <strong>Jumlah</strong>
                                    <input type="number" class="form-control" placeholder="Input Jumlah Barang..." name="stok">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-1">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </form><br>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $nama = mysqli_real_escape_string($mysqli, $_POST['nama'] ?? '');
                            $stok = mysqli_real_escape_string($mysqli, $_POST['stok'] ?? '');
                            $kategori = mysqli_real_escape_string($mysqli, $_POST['kategori'] ?? '');
                            $edit_id = mysqli_real_escape_string($mysqli, $_POST['edit_id'] ?? '');
                            $delete_id = mysqli_real_escape_string($mysqli, $_POST['delete_id'] ?? '');

                            if (!empty($delete_id)) {
                                $stmt = $mysqli->prepare("DELETE FROM warehouse WHERE id_barang=?");
                                $stmt->bind_param("i", $delete_id);
                                if ($stmt->execute()) {
                                    echo "Record deleted successfully!;</script>";
                                } else {
                                    echo "Error deleting record: " . htmlspecialchars($stmt->error);
                                }
                                $stmt->close();
                            } elseif (!empty($edit_id) && !empty($stok)) {
                                $stmt = $mysqli->prepare("UPDATE warehouse SET Stok=? WHERE id_barang=?");
                                $stmt->bind_param("ii", $stok, $edit_id);
                                if ($stmt->execute()) {
                                    echo "Stock updated successfully!";
                                } else {
                                    echo "Error updating record: " . htmlspecialchars($stmt->error);
                                }
                                $stmt->close();
                            } elseif (!empty($nama) && !empty($stok)) {
                                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM warehouse WHERE Nama=?");
                                $stmt->bind_param("s", $nama);
                                $stmt->execute();
                                $stmt->bind_result($count);
                                $stmt->fetch();
                                $stmt->close();

                                if ($count > 0) {
                                    $stmt = $mysqli->prepare("UPDATE warehouse SET Stok=?, Kategori=? WHERE Nama=?");
                                    $stmt->bind_param("iss", $stok, $kategori, $nama);
                                    if ($stmt->execute()) {
                                        echo "Data updated successfully!;";
                                    } else {
                                        echo "Error updating record: " . htmlspecialchars($stmt->error);
                                    }
                                    $stmt->close();
                                } else {
                                    $stmt = $mysqli->prepare("INSERT INTO warehouse (Nama, Stok, Kategori) VALUES (?, ?, ?)");
                                    $stmt->bind_param("sis", $nama, $stok, $kategori);
                                    if ($stmt->execute()) {
                                        echo "Data inserted successfully!";
                                    } else {
                                        echo "Error inserting record: " . htmlspecialchars($stmt->error);
                                    }
                                    $stmt->close();
                                }
                            }
                        }

                        $sql = "SELECT * FROM warehouse";
                        $hasil = mysqli_query($mysqli, $sql);

                        if ($hasil) {
                            echo "<table class='table table-bordered table-striped'>";
                            echo "<thead class='thead-dark'><tr><th>ID Barang</th><th>Nama</th><th>Stok</th><th>Kategori</th><th>Action</th></tr></thead>";
                            echo "<tbody>";
                            while ($baris = mysqli_fetch_assoc($hasil)) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($baris['id_barang']) . "</td>
                                    <td>" . htmlspecialchars($baris['Nama']) . "</td>
                                    <td>" . htmlspecialchars($baris['Stok']) . "</td>
                                    <td>" . htmlspecialchars($baris['Kategori']) . "</td>
                                    <td>
                                        <div class='btn-group'>
                                            <form method='post' style='display:inline-block;'>
                                                <input type='hidden' name='edit_id' value='" . htmlspecialchars($baris['id_barang']) . "'>
                                                <input type='number' name='stok' class='form-control' placeholder='New Stock' required style='width: 100px; display: inline-block;'>
                                                <button type='submit' class='btn btn-success btn-sm'>Edit</button>
                                            </form>
                                            <form method='post' style='display:inline-block;'>
                                                <input type='hidden' name='delete_id' value='" . htmlspecialchars($baris['id_barang']) . "'>
                                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            mysqli_free_result($hasil);
                        } else {
                            echo "Error fetching data: " . mysqli_error($mysqli);
                        }
                        ?>
                    </div>
                </section>
            </aside>
        </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="../js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="../js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="../js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="../js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="../js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <script src="../js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="../js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <script src="../js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>
