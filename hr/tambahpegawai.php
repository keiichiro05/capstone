<?php 
include('../konekdb.php');
$a=$_GET['aksi'];
$Nama=$_GET['Nama'];
$Departemen=$_GET['Departemen'];
$gaji=$_GET['gaji'];
$id=$_GET['id'];
if($a=="Diterima"){

$show=mysqli_query("insert into pegawai (Nama, Departemen, gaji) values ('$Nama','$Departemen', '$gaji')"); 
if($show){
header("location:index.php");
}
} else {

if($show){
header("location:index.php");
}
if($a=="Ditolak"){
$del=mysqli_query("delete from recruitment where id_pendaftaran='$id'"); 
if($del){
header("location:index.php");
}
}
};

?>