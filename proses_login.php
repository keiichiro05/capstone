<?php

session_start();
$username = $_POST['userid'];
$password = $_POST['password'];
//$password_md5   = md5($password);

include 'config.php';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = $conn->prepare("SELECT username, password, modul, id_pegawai FROM authorization WHERE username = ? AND password = ?");
$sql->bind_param("ss", $username, $password);
$sql->execute();
$result = $sql->get_result();
$record = $result->fetch_assoc();


if($record['username'] == ""){
	
	header("location:index.php?status=Maaf, username dan password tidak valid");
	exit();
	}

if($record['username']){
if($record['modul']=="Finance"){
	$_SESSION['username'] = $username;
	$_SESSION['idpegawai'] = $record['id_pegawai'];
	header ("location:Finance/");
	}else if($record['modul']=="Sales"){
	$_SESSION['username'] = $username;
	$_SESSION['idpegawai'] = $record['id_pegawai'];
	header ("location:Sales/");
	}else if($record['modul']=="Warehouse"){
	$_SESSION['username'] = $username;
	$_SESSION['idpegawai'] = $record['id_pegawai'];
	header ("location:warehouse/");
	}else if($record['modul']=="Adminwarehouse"){
	$_SESSION['username'] = $username;
	$_SESSION['idpegawai'] = $record['id_pegawai'];
	header ("location:adminwarehouse/dashboard.php");
	}else if($record['modul']=="Purchase"){
	$_SESSION['username'] = $username;
	$_SESSION['idpegawai'] = $record['id_pegawai'];
	header ("location:adminpurchase/");
	}else if($record['modul']=="HR"){
	$_SESSION['username'] = $username;
	$_SESSION['idpegawai'] = $record['id_pegawai'];
	header ("location:hr/");
	} else if($record['modul']=="superadmin"){
	$_SESSION['username'] = $username;
	header ("location:superadmin/");
	}
	}

?>