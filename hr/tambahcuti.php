<?php 
include('../konekdb.php');
$a=$_GET['aksi'];
$id=$_GET['id_pegawai'];
$Nama=$_GET['Nama'];
$Departemen=$_GET['Departemen'];
$Detail_cuti=$_GET['Detail_cuti'];

if($a=="Diterima"){

$show=mysqli_query("update cuti set aksi='1' where id_pegawai='$id'"); 
if($show){
header("location:cuti.php");
}
} else if($a=="Ditolak"){
$del=mysqli_query("update cuti set aksi='2' where id_pegawai='$id'"); 
if($del){
header("location:cuti.php");
}
}

?>