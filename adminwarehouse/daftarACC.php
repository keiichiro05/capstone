<!DOCTYPE html>
<?php include('../konekdb.php');
session_start();
$username = $_SESSION['username'];
$idpegawai = $_SESSION['idpegawai'];
$cekuser = mysqli_query($mysqli, "SELECT count(username) as jmluser FROM authorization WHERE username = '$username' AND modul = 'Adminwarehouse'");
$user = mysqli_fetch_array($cekuser);
$getpegawai = mysqli_query($mysqli, "SELECT * FROM pegawai where id_pegawai='$idpegawai'");
$pegawai = mysqli_fetch_array($getpegawai);
if ($user['jmluser'] == "0") {
    header("location:../index.php");
}; ?>
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
    <!-- DataTables -->
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
        <a href="index.html" class="logo">
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
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span><?php echo $username; ?><i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                <img src="img/<?php echo $pegawai['foto']; ?>" class="img-circle" alt="User Image" />
                                <p>
                                    <?php
                                    echo $pegawai['Nama'] . " - " . $pegawai['Jabatan'] . " " . $pegawai['Departemen']; ?>
                                    <small>Member since <?php echo "$pegawai[Tanggal_Masuk]"; ?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Admin</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Warehouse</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#"></a>
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
                        <img src="img/<?php echo $pegawai['foto']; ?>" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>Hello, <?php echo $username; ?></p>

                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
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

                    <li class="active">
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
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Warehouse
                    <small>Daftar Pesanan Barang</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Daftar Pesanan</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            ' . $_SESSION['message'] . '
                          </div>';
                    unset($_SESSION['message']);
                }
                ?>

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Daftar Pesanan Barang</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-inline" style="margin-bottom: 15px;">
                                    <div class="form-group">
                                        <label for="filterStatus">Filter Status: </label>
                                        <select id="filterStatus" class="form-control input-sm">
                                            <option value="">Semua Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Accepted">Accepted</option>
                                            <option value="Declined">Declined</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-left: 10px;">
                                        <label for="filterCabang">Filter Cabang: </label>
                                        <select id="filterCabang" class="form-control input-sm">
                                            <option value="">Semua Cabang</option>
                                            <?php
                                            $cabangQuery = mysqli_query($mysqli, "SELECT DISTINCT cabang FROM pemesanan WHERE cabang IS NOT NULL AND cabang != ''");
                                            while ($cabang = mysqli_fetch_array($cabangQuery)) {
                                                echo '<option value="' . htmlspecialchars($cabang['cabang']) . '">' . htmlspecialchars($cabang['cabang']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-left: 10px;">
                                        <label for="filterKategori">Filter Kategori: </label>
                                        <select id="filterKategori" class="form-control input-sm">
                                            <option value="">Semua Kategori</option>
                                            <?php
                                            $kategoriQuery = mysqli_query($mysqli, "SELECT DISTINCT kategori FROM pemesanan WHERE kategori IS NOT NULL AND kategori != ''");
                                            while ($kategori = mysqli_fetch_array($kategoriQuery)) {
                                                echo '<option value="' . htmlspecialchars($kategori['kategori']) . '">' . htmlspecialchars($kategori['kategori']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button id="resetFilter" class="btn btn-default btn-sm" style="margin-left: 10px;">
                                        <i class="fa fa-refresh"></i> Reset Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="pesananTable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID Pemesanan</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Kategori</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>ID Supplier</th>
                                            <th>Cabang</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM pemesanan ORDER BY status, tanggal DESC";
                                        $hasil = mysqli_query($mysqli, $sql);

                                        if (mysqli_num_rows($hasil) > 0) {
                                            while ($baris = mysqli_fetch_array($hasil)) {
                                                $statusText = '';
                                                $statusClass = '';
                                                if ($baris['status'] == 0) {
                                                    $statusText = 'Pending';
                                                    $statusClass = 'warning';
                                                } elseif ($baris['status'] == 1) {
                                                    $statusText = 'Accepted';
                                                    $statusClass = 'success';
                                                } elseif ($baris['status'] == 2) {
                                                    $statusText = 'Declined';
                                                    $statusClass = 'danger';
                                                }
                                                
                                                echo "<tr>
                                                    <td>" . $baris['id_pemesanan'] . "</td>
                                                    <td>" . htmlspecialchars($baris['code']) . "</td>
                                                    <td>" . htmlspecialchars($baris['namabarang']) . "</td>
                                                    <td>" . htmlspecialchars($baris['kategori']) . "</td>
                                                    <td class='text-right'>" . number_format($baris['jumlah'], 0, ',', '.') . "</td>
                                                    <td>" . htmlspecialchars($baris['satuan']) . "</td>
                                                    <td>" . htmlspecialchars($baris['id_supplier']) . "</td>
                                                    <td>" . htmlspecialchars($baris['cabang']) . "</td>
                                                    <td>" . date('d/m/Y', strtotime($baris['tanggal'])) . "</td>
                                                    <td><span class='label label-$statusClass'>$statusText</span></td>
                                                    <td>";
                                                
                                                if ($baris['status'] == 0) {
                                                    echo "<div class='btn-group'>
                                                            <a href='proses_pesanan.php?action=accept&id=" . $baris['id_pemesanan'] . "' class='btn btn-success btn-xs' title='Accept'><i class='fa fa-check'></i></a>
                                                            <a href='proses_pesanan.php?action=decline&id=" . $baris['id_pemesanan'] . "' class='btn btn-danger btn-xs' title='Decline'><i class='fa fa-times'></i></a>
                                                          </div>";
                                                } else {
                                                    echo "<span class='text-muted small'>Proses selesai</span>";
                                                }
                                                echo "</td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='11' class='text-center'>Tidak ada data pesanan</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="pesananTable_info" role="status" aria-live="polite"></div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="pesananTable_paginate"></div>
                            </div>
                        </div>
                    </div><!-- /.box-footer -->
                </div><!-- /.box -->
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

    <!-- jQuery 2.0.2 -->
    <script src="../js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DataTables -->
    <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="../js/AdminLTE/app.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with more options
            var table = $('#pesananTable').DataTable({
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                "stateSave": true,
                "responsive": true,
                "autoWidth": false,
                "order": [[8, 'desc']] // Default sort by Tanggal descending
            });

            // Custom filter for Status (using text instead of value)
            $('#filterStatus').on('change', function() {
                var status = $(this).val();
                if (status === '') {
                    table.column(9).search('').draw();
                } else {
                    table.column(9).search('^' + status + '$', true, false).draw();
                }
            });

            // Filter for Cabang
            $('#filterCabang').on('change', function() {
                var cabang = $(this).val();
                table.column(7).search(cabang).draw();
            });

            // Filter for Kategori
            $('#filterKategori').on('change', function() {
                var kategori = $(this).val();
                table.column(3).search(kategori).draw();
            });

            // Reset all filters
            $('#resetFilter').on('click', function() {
                $('#filterStatus, #filterCabang, #filterKategori').val('').trigger('change');
                table.search('').columns().search('').draw();
            });

            // Add margin to DataTable elements
            $('.dataTables_length select').addClass('form-control input-sm');
            $('.dataTables_filter input').addClass('form-control input-sm');
        });
    </script>
</body>

</html>