<?php

$to = $_POST['nama'];
$from = $_POST['username'];
$pesan = $_POST['message'];

include '../config.php';

$stmt1 = $conn->prepare("SELECT id_pegawai FROM pegawai WHERE nama=?");
$stmt1->bind_param("s", $to);
$stmt1->execute();
$nama1_result = $stmt1->get_result();
$nama1 = $nama1_result->fetch_array();

$stmt2 = $conn->prepare("SELECT id_pegawai FROM authorization WHERE username=?");
$stmt2->bind_param("s", $from);
$stmt2->execute();
$nama2_result = $stmt2->get_result();
$nama2 = $nama2_result->fetch_array();

if (isset($_POST['send'])) {
	$stmt3 = $conn->prepare("INSERT INTO pesan VALUES (NULL, ?, ?, ?, NOW(), 0, 0)");
} else {
	$stmt3 = $conn->prepare("INSERT INTO pesan VALUES (NULL, ?, ?, ?, NOW(), 1, 0)");
}
$stmt3->bind_param("iis", $nama2[0], $nama1[0], $pesan);
$hasil = $stmt3->execute();


if($hasil){
	print "<script>location = 'mailbox.php'; </script>";
}else{
	echo "Data gagal diubah.";
}
?>