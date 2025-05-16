<!DOCTYPE html>
<?php include('../konekdb.php');
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$idpegawai = isset($_SESSION['idpegawai']) ? $_SESSION['idpegawai'] : null;

if (!$username || !$idpegawai) {
    header("location:../index.php");
    exit;
}

$cekuser = mysqli_query($mysqli, "SELECT count(username) as jmluser FROM authorization WHERE username = '" . mysqli_real_escape_string($mysqli, $username) . "' AND modul = 'Purchase'");
if (!$cekuser) {
    die("Database query failed: " . mysqli_error($mysqli));
}
$user = mysqli_fetch_array($cekuser);

$getpegawai = mysqli_query($mysqli, "SELECT * FROM pegawai WHERE id_pegawai='" . mysqli_real_escape_string($mysqli, $idpegawai) . "'");
if (!$getpegawai) {
    die("Database query failed: " . mysqli_error($mysqli));
}
$pegawai = mysqli_fetch_array($getpegawai);

if ($user['jmluser'] == "0") {
    header("location:../index.php");
    exit;
}
?>
<html>
    <head>
         <meta charset="UTF-8">
        <title>E-Pharm | Purhcase</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="../index.html" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
              E-Pharm
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                       <ul class="dropdown-menu">
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo "$username"?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                 <li class="user-header bg-light-blue">
                                    <img src="../img/<?php echo $pegawai['foto']?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php 
										echo $pegawai['Nama']." - ".$pegawai['Jabatan']." ".$pegawai['Departemen'];?>
                                        <small>Member since <?php echo "$pegawai[Tanggal_Masuk]"; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
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
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                              <img src="../img/<?php echo $pegawai['foto']?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo "$username"?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                     <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
					<li >
                            <a href="index.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="pemesanan.php">
                                <i class="fa fa-list-alt"></i> <span>Pemesanan</span>
								<?php 
                                $not1=mysqli_query($mysqli, "SELECT count(id_pemesanan) from pemesanan where status='0'");
								$tot1=mysqli_fetch_array($not1);
                                $not2=mysqli_query($mysqli, "SELECT count(distinct id_transaksi) as jml from transaksi where status='1' group by id_transaksi");
								$tot2=mysqli_fetch_array($not2);
                                $not3=mysqli_query($mysqli, "SELECT count(distinct id_transaksi) as jml from transaksi where status='4' group by id_transaksi");
								$tot3=mysqli_fetch_array($not3);
                                $not4=mysqli_query($mysqli, "SELECT count(id_pegawai) as jml from cuti where aksi='1' and id_pegawai='$idpegawai'");
								$tot4=mysqli_fetch_array($not4);
								if($tot1['count(id_pemesanan)']!=0){
								?>
								 <small class="badge pull-right bg-yellow"><?php echo $tot1['count(id_pemesanan)']?></small>
								 <?php }?>
                            </a>
                        </li>
                        <li >
                            <a href="transaksi.php">
                                <i class="fa fa-check-square"></i> <span>Perijinan Transaksi</span>
								<?php if(isset($tot2['jml']) && $tot2['jml'] != 0){?>
								<small class="badge pull-right bg-green"><?php echo $tot2['jml']?></small>
								<?php }?>
                            </a>
                        </li>
                        <li>
                            <a href="laporan.php">
                               <i class="fa fa-envelope"></i> <span>Laporan</span>
                                <?php if(isset($tot3['jml']) && $tot3['jml'] != 0){?>
                                <small class="badge pull-right bg-red"><?php echo $tot3['jml']?></small>
                                <?php }?>
                            </a>
                        </li>
                      <li>
                            <a href="cuti.php">
                                <i class="fa fa-suitcase"></i> <span>Cuti</span>
								<?php if($tot4['jml']!=0){?>
								<small class="badge pull-right bg-aqua"><?php echo $tot4['jml']?></small>
								<?php }?>
                            </a>
                        </li>
						 <li>
                            <a href="mailbox.php">
                                <i class="fa fa-comments"></i> <span>Mailbox</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Pemesanan
                        <!--<small>Control panel</small>-->
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Purchase</li>
                    </ol>
                </section>


                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                                                     
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Daftar Pembelian Barang</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="bg-navy">NO.</th>
                                                <th class="bg-navy">ID_PEMESANAN</th>
                                                <th class="bg-navy">NAMA BARANG</th>
                                                <th class="bg-navy">SATUAN</th>
                                                <th class="bg-navy">JUMLAH</th>
												<th class="bg-navy">HARGA (Rp.)</th>
												<th class="bg-navy">SUPPLIER</th>
												<th class="bg-navy">STATUS</th>
												<th class="bg-navy">TANGGAL</th>
												<th class="bg-navy">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
                                        $show=mysqli_query($mysqli, "SELECT * from pemesanan where status='0'");
										$i=0;
										while($data=mysqli_fetch_array($show)){
										$i++;
										$id=$data['id_pemesanan'];
										$ids=$data['id_supplier'];
                                        
                                        $show2 = mysqli_query($mysqli, "SELECT Nama_perusahaan FROM supplier WHERE id_supplier='$ids'");
                                        $data2 = mysqli_fetch_array($show2);
                                        $Nama_perusahaan = isset($data2['Nama_perusahaan']) ? $data2['Nama_perusahaan'] : 'Unknown Supplier';

                                        $status = ($data['status'] == '0') ? 
                                            '<span class="label label-warning">Belum ACC</span>' : 
                                            '<span class="label label-success">ACC</span>';
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($data['namabarang'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($data['satuan'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($data['jumlah'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <form action="ijinpesan.php" method="get" class="form-inline">
                                                <input type="text" class="form-control input-sm" name="harga" placeholder="Harga" style="width: 100px;" required>
                                                <input type="hidden" name="a" value="acc">
                                                <input type="hidden" name="p" value="<?= $id ?>">
                                                <input type="hidden" name="ids" value="<?= $ids ?>">
                                        </td>
                                        <td><?php echo htmlspecialchars($Nama_perusahaan, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td><?php echo htmlspecialchars($data['tanggal'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                                <button type="submit" class="btn btn-primary btn-sm">Accept</button>
                                            </form>
                                            <a href="ijinpesan.php?p=<?= $id ?>&a=dc&ids=<?= $ids ?>" class="btn btn-danger btn-sm" style="margin-top: 5px;">Decline</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                        <!-- <tfoot>
                                            <tr>
                                                <th>NO.</th>
                                                <th>ID_PEMESANAN</th>
                                                <th>NAMA BARANG</th>
                                                <th>SATUAN</th>
                                                <th>JUMLAH</th>
												<th>SUPPLIER</th>
												<th>STATUS</th>
												<th>TANGGAL</th>
												<th>AKSI</th>
                                         
                                            </tr>
                                        </tfoot> -->
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>

    </body>
</html>