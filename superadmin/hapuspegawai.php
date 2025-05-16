<?php
	include "konekdb.php";
	$id=$_GET['id'];
	echo $id;
	mysqli_query("DELETE FROM authorization WHERE id_pegawai='$id'");
	header("location:deletepegawai.php")
?>