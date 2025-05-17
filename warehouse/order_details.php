<?php
include('../konekdb.php');

if (isset($_GET['id'])) {
    $orderId = mysqli_real_escape_string($mysqli, $_GET['id']);
    $query = mysqli_query($mysqli, "SELECT * FROM dariwarehouse WHERE no = '$orderId'");
    
    if ($order = mysqli_fetch_assoc($query)) {
        echo '<div class="row">';
        echo '<div class="col-md-6">';
        echo '<h4>Product Information</h4>';
        echo '<table class="table table-bordered">';
        echo '<tr><th>Product Code</th><td>'.$order['code'].'</td></tr>';
        echo '<tr><th>Product Name</th><td>'.$order['nama'].'</td></tr>';
        echo '<tr><th>Category</th><td>'.$order['kategori'].'</td></tr>';
        echo '<tr><th>Quantity</th><td>'.$order['jumlah'].'</td></tr>';
        echo '<tr><th>Unit</th><td>'.$order['satuan'].'</td></tr>';
        echo '</table>';
        echo '</div>';
        
        echo '<div class="col-md-6">';
        echo '<h4>Order Information</h4>';
        echo '<table class="table table-bordered">';
        echo '<tr><th>Reorder Level</th><td>'.$order['reorder'].'</td></tr>';
        echo '<tr><th>Supplier</th><td>'.$order['supplier'].'</td></tr>';
        echo '<tr><th>Branch</th><td>'.$order['cabang'].'</td></tr>';
        echo '<tr><th>Status</th><td>';
        
        if ($order['status'] === "0") {
            echo '<span class="status-badge status-pending">Pending</span>';
        } elseif ($order['status'] === "1") {
            echo '<span class="status-badge status-accepted">Accepted</span>';
        } elseif ($order['status'] === "2") {
            echo '<span class="status-badge status-rejected">Rejected</span>';
        }
        
        echo '</td></tr>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center">';
        echo '<img src="https://barcode.tec-it.com/barcode.ashx?data='.$order['code'].'&code=Code128&dpi=96" style="height:80px;">';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">Order not found</div>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid request</div>';
}
?>