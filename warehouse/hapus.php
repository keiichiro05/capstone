<?php
include "konekdb.php";
$no=$_GET['no'];
mysqli_query($mysqli,"DELETE FROM dariwarehouse WHERE No='$no'");
header("location:order.php");
?>