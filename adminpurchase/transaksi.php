<!DOCTYPE html>
<?php include('../konekdb.php');
session_start();
$username=$_SESSION['username'];
$idpegawai=$_SESSION['idpegawai'];
$cekuser=mysqli_query($mysqli, "SELECT count(username) as jmluser FROM authorization WHERE username = '$username' AND modul = 'Purchase'");
$user=mysqli_fetch_array($cekuser);
$getpegawai=mysqli_query($mysqli, "SELECT * FROM pegawai where id_pegawai='$idpegawai'");
$pegawai=mysqli_fetch_array($getpegawai);
if($user['jmluser']=="0")
{
header("location:../index.php");
};?>
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
                        <li >
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
                        <li >
                            <a href="transaksi.php">
                                <i class="fa fa-check-square"></i> <span>Perijinan Transaksi</span>
								<?php if(isset($tot2['jml']) && $tot2['jml'] != 0){?>
								<small class="badge pull-right bg-green"><?php echo $tot2['jml']?></small>
								<?php }?>
                            </a>
                        </li
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
                        Perijinan Transaksi
                        <!--<small>Control panel</small>-->
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Purchase</li>
                    </ol>
                </section>


                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                                                     
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Daftar Perijinan Belum Disetujui</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="bg-yellow">NO.</th>
                                                <th class="bg-yellow">ID_TRANSAKSI</th>
                                                <th class="bg-yellow">TANGGAL</th>
                                                <th class="bg-yellow">SUPPLIER</th>
												<th class="bg-yellow">RINCIAN</th>
												<th class="bg-yellow">TOTAL HARGA</th>
                                                <th class="bg-yellow">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
                                        $show=mysqli_query($mysqli, "SELECT DISTINCT * from transaksi where status='0' GROUP BY id_supplier");
										$i=0;
										while($data=mysqli_fetch_array($show)){
										$i++;
										$id=$data['id_transaksi'];
										$ids=$data['id_supplier'];
                                        $show2=mysqli_query($mysqli, "SELECT nama_perusahaan from supplier where id_supplier='$ids'");
										$data2=mysqli_fetch_array($show2);
                                        $totharga0=mysqli_query($mysqli, "SELECT SUM(HARGA) as total from pemesanan where id_pemesanan in (select id_pemesanan from transaksi where id_transaksi='$id')");
										$totharga1=mysqli_fetch_array($totharga0);
										$totharga=$totharga1['total'];;
										if($data['status']=='0'){
										$status='<span class="label label-warning">Pending</span>';
										} else if($data['status']=='1'){
										$status='<span class="label label-success">Accpeted</span>';
										} else{
										$status='<span class="label label-danger">Denied</span>';
										}
                                            echo "<tr>
                                                <td>".$i."</td>
                                                <td>".$id."</td>
                                                <td>".$data['tanggal']."</td>
                                                <td>".($data2 ? $data2['nama_perusahaan'] : 'Unknown Supplier')."</td>
												<td><a href=\"detail.php?idt=$id\"><button class=\"btn bg-maroon btn-sm\">view</button></a></td>
												<td>".$totharga."</td>
												<td>".$status."</td>
												
                                            </tr>";
                                             }?>
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
							
							<!-- Tabel ke 2 ACC -->
							<div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Daftar Perijinan Disetujui</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example3" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="bg-green">NO.</th>
                                                <th class="bg-green">ID_TRANSAKSI</th>
                                                <th class="bg-green">TANGGAL</th>
                                                <th class="bg-green">SUPPLIER</th>
												<th class="bg-green">RINCIAN</th>
												<th class="bg-green">TOTAL HARGA</th>
                                                <th class="bg-green">STATUS</th>
												<th class="bg-green">KETERANGAN</th>
												<th class="bg-green">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
                                        $show=mysqli_query($mysqli, "SELECT DISTINCT * from transaksi where status='1' GROUP BY id_supplier");
										$i=0;
										while($data=mysqli_fetch_array($show)){
										$i++;
										$id=$data['id_transaksi'];
										$ids=$data['id_supplier'];
                                        $show2=mysqli_query($mysqli, "SELECT nama_perusahaan from supplier where id_supplier='$ids'");
                                        $data2=mysqli_fetch_array($show2);
                                        $totharga0=mysqli_query($mysqli, "SELECT SUM(HARGA) as total from pemesanan where id_pemesanan in (select id_pemesanan from transaksi where id_transaksi='$id')");
                                        $totharga1=mysqli_fetch_array($totharga0);
										$totharga=$totharga1['total'];;
										if($data['status']=='0'){
										$status='<span class="label label-warning">Pending</span>';
										} else if($data['status']=='1'){
										$status='<span class="label label-success">Accepted</span>';
										} else{
										$status='<span class="label label-danger">Denied</span>';
										}
                                            echo "<tr>
                                                <td>".$i."</td>
                                                <td>".$id."</td>
                                                <td>".$data['tanggal']."</td>
                                                <td>".$data2['nama_perusahaan']."</td>
												<td><a href=\"detail.php?idt=$id\"><button class=\"btn bg-maroon btn-sm\">view</button></a></td>
												<td>".$totharga."</td>
												<td>".$status."</td>";?>
												<td> 
												<form action="ijinpesan.php" method="post">
												<div class="form-group">
                                            <input type="text" class="form-control" name="keterangan" placeholder="Keterangan" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="a" value="siap">
                                        </div>
										<div class="form-group">
                                            <input type="hidden" class="form-control" name="p" value="<?php echo $id;?>">
                                        </div>
                                    </div><!-- /.box-body -->
									</td>
									<td>
									<button type="submit" class="btn btn-primary btn-sm">Done</button>
									</td>
												<!-- <td><a href=\"ijinpesan.php?p=$id&&a=siap\"><button class=\"btn btn-info btn-flat\">Done</button></a></td>-->
                                            <?php echo "</tr>";
                                             }?>
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
							<!-- end tabel 2 -->
							
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
		<script type="text/javascript">
            $(function() {
                $("#example3").dataTable();
                $('#example4').dataTable({
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