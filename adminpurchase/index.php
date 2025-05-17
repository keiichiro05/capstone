<!DOCTYPE html>
<?php include('../konekdb.php');
session_start();
$username=$_SESSION['username'];
$idpegawai=$_SESSION['idpegawai'];
$cekuser=mysqli_query($mysqli, "SELECT count(username) as jmluser FROM authorization WHERE username = '$username' AND modul = 'Purchase'");
$user=mysqli_fetch_array($cekuser);
$getpegawai=mysqli_query($mysqli, "SELECT * FROM pegawai where id_pegawai='$idpegawai'");
$pegawai=mysqli_fetch_array($getpegawai);
if($user['jmluser']=="0") {
  header("location:../index.php");
};?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>E-Pharm | Purchase</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <!-- Bootstrap 3.0.2 -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- Custom Styles -->
        <link href="../css/modern-purchase.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="skin-blue">
        <header class="header">
            <a href="../index.html" class="logo">
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
                                <span><?php echo $username?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header bg-light-blue">
                                    <img src="../img/<?php echo $pegawai['foto']?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $pegawai['Nama']." - ".$pegawai['Jabatan']." ".$pegawai['Departemen'];?>
                                        <small>Member since <?php echo $pegawai['Tanggal_Masuk']; ?></small>
                                    </p>
                                </li>
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Profile</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Settings</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Help</a>
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
                            <img src="../img/<?php echo $pegawai['foto']?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $username?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="index.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="pemesanan.php">
                                <i class="fa fa-list-alt"></i> <span>Orders</span>
                                <?php 
                                $not1=mysqli_query($mysqli, "SELECT count(id_pemesanan) from pemesanan where status='0'");
                                $tot1=mysqli_fetch_array($not1);
                                if($tot1['count(id_pemesanan)']!=0){
                                ?>
                                <small class="badge pull-right"><?php echo $tot1['count(id_pemesanan)']?></small>
                                <?php }?>
                            </a>
                        </li>
                        <li>
                            <a href="transaksi.php">
                                <i class="fa fa-check-square"></i> <span>Transaction Approval</span>
                                <?php 
                                $not2=mysqli_query($mysqli, "SELECT count(distinct id_transaksi) as jml from transaksi where status='1' group by id_transaksi");
                                $tot2=mysqli_fetch_array($not2);
                                if(isset($tot2['jml']) && $tot2['jml'] != 0){?>
                                <small class="badge pull-right"><?php echo $tot2['jml']?></small>
                                <?php }?>
                            </a>
                        </li>
                        <li>
                            <a href="laporan.php">
                               <i class="fa fa-envelope"></i> <span>Reports</span>
                                <?php 
                                $not3=mysqli_query($mysqli, "SELECT count(distinct id_transaksi) as jml from transaksi where status='4' group by id_transaksi");
                                $tot3=mysqli_fetch_array($not3);
                                if(isset($tot3['jml']) && $tot3['jml']!=0){?>
                                <small class="badge pull-right"><?php echo $tot3['jml']?></small>
                                <?php }?>
                            </a>
                        </li>
                        <li>
                            <a href="cuti.php">
                                <i class="fa fa-suitcase"></i> <span>Leave</span>
                                <?php 
                                $not4=mysqli_query($mysqli, "SELECT count(id_pegawai) as jml from cuti where aksi='1' and id_pegawai='$idpegawai'");
                                $tot4=mysqli_fetch_array($not4);
                                if($tot4['jml']!=0){?>
                                <small class="badge pull-right"><?php echo $tot4['jml']?></small>
                                <?php }?>
                            </a>
                        </li>
                        <li>
                            <a href="mailbox.php">
                                <i class="fa fa-comments"></i> <span>Mailbox</span>
                                <?php 
                                $not5=mysqli_query($mysqli, "SELECT count(id_pesan) as jml from pesan where ke='$idpegawai' and status='0'");
                                $tot5=mysqli_fetch_array($not5);
                                if($tot5['jml']!=0){?>
                                <small class="badge pull-right"><?php echo $tot5['jml']?></small>
                                <?php }?>
                            </a>
                        </li>
                    </ul>
                </section>
            </aside>

            <aside class="right-side">                
                <section class="content-header">
                    <h1>
                        Purchase Dashboard
                       <small>Overview & Statistics</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        <?php echo !empty($tot1['count(id_pemesanan)']) ? $tot1['count(id_pemesanan)'] : "0"; ?>
                                    </h3>
                                    <p>
                                        New Orders
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="pemesanan.php" class="small-box-footer">
                                    View Details <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                      <?php echo !empty($tot2['jml']) ? $tot2['jml'] : "0"; ?>
                                    </h3>
                                    <p>
                                        Transactions Pending Approval
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-cart-outline"></i>
                                </div>
                                <a href="transaksi.php" class="small-box-footer">
                                    View Details <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                       <?php echo !empty($tot3['jml']) ? $tot3['jml'] : "0"; ?>
                                    </h3>
                                    <p>
                                        Reports
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-checkmark"></i>
                                </div>
                                <a href="laporan.php" class="small-box-footer">
                                    View Details <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                       <?php echo !empty($tot4['jml']) ? $tot4['jml'] : "0"; ?>
                                    </h3>
                                    <p>
                                       Leave Requests
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-briefcase-outline"></i>
                                </div>
                                <a href="cuti.php" class="small-box-footer">
                                    View Details <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3>
                                       <?php echo !empty($tot5['jml']) ? $tot5['jml'] : "0"; ?>
                                    </h3>
                                    <p>
                                       Unread Messages
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-mail"></i>
                                </div>
                                <a href="mailbox.php" class="small-box-footer">
                                    View Details <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
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