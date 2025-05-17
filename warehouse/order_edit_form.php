<?php
include('../konekdb.php');

if (isset($_GET['id'])) {
    $orderId = mysqli_real_escape_string($mysqli, $_GET['id']);
    $query = mysqli_query($mysqli, "SELECT * FROM dariwarehouse WHERE no = '$orderId'");
    
    if ($order = mysqli_fetch_assoc($query)) {
        // Get categories for dropdown
        $categories = mysqli_query($mysqli, "SELECT nama_kategori FROM kategori");
        $suppliers = mysqli_query($mysqli, "SELECT Nama FROM supplier");
        
        echo '<div class="form-group">';
        echo '<label>Product Code</label>';
        echo '<input type="text" class="form-control" name="code" value="'.$order['code'].'" required>';
        echo '</div>';
        
        echo '<div class="form-group">';
        echo '<label>Product Name</label>';
        echo '<input type="text" class="form-control" name="nama" value="'.$order['nama'].'" required>';
        echo '</div>';
        
        echo '<div class="form-group">';
        echo '<label>Category</label>';
        echo '<select name="kategori" class="form-control" required>';
        echo '<option value="">Select Category</option>';
        while ($cat = mysqli_fetch_assoc($categories)) {
            $selected = ($cat['nama_kategori'] == $order['kategori']) ? 'selected' : '';
            echo '<option value="'.$cat['nama_kategori'].'" '.$selected.'>'.$cat['nama_kategori'].'</option>';
        }
        echo '</select>';
        echo '</div>';
        
        echo '<div class="form-group">';
        echo '<label>Quantity</label>';
        echo '<input type="number" class="form-control" name="jumlah" value="'.$order['jumlah'].'" min="1" required>';
        echo '</div>';
        
        echo '<div class="form-group">';
        echo '<label>Unit</label>';
        echo '<input type="text" class="form-control" name="satuan" value="'.$order['satuan'].'" required>';
        echo '</div>';
        
        echo '<div class="form-group">';
        echo '<label>Reorder Level</label>';
        echo '<input type="number" class="form-control" name="reorder-level" value="'.$order['reorder'].'" min="1" required>';
        echo '</div>';
        
        echo '<div class="form-group">';
        echo '<label>Supplier</label>';
        echo '<select name="supplier" class="form-control" required>';
        echo '<option value="">Select Supplier</option>';
        while ($sup = mysqli_fetch_assoc($suppliers)) {
            $selected = ($sup['Nama'] == $order['supplier']) ? 'selected' : '';
            echo '<option value="'.$sup['Nama'].'" '.$selected.'>'.$sup['Nama'].'</option>';
        }
        echo '</select>';
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">Order not found</div>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid request</div>';
}
?>