<?php
include "konekdb.php";

$id = $_GET['id'];
if ($stmt = $mysqli->prepare("DELETE FROM kategori WHERE id = ?")) { // Replace 'correct_table_name' with the actual table name
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();
}

header("location:kategori.php");
?>