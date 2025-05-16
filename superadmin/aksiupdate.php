<?php
include "konekdb.php";
$id=$_POST['id'];
$username=$_POST['username'];
$password=$_POST['password'];
$modul=$_POST['modul'];

echo $id.$username.$password.$modul;
mysqli_query($mysqli, "UPDATE authorization SET id_pegawai='$id',Password='$password',Modul='$modul' WHERE Username='$username'");
header("location:updatepegawai.php");
?>