<?php
include "../konekdb.php";

$total = $_GET['total'];
$tgl=date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));

$sql = mysqli_query("insert into gajibulan values ('', '$total','$tgl','')");
if($sql){
header ("location:penggajian.php");
}

?>