<?php
include "konekdb.php";

$id = $_GET['id'];
$categoryName = "";

// Fetch the current category name
if ($stmt = $mysqli->prepare("SELECT nama_kategori FROM kategori WHERE id = ?")) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($categoryName);
    $stmt->fetch();
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['nama'];
    if ($stmt = $mysqli->prepare("UPDATE kategori SET nama_kategori = ? WHERE id = ?")) {
        $stmt->bind_param("si", $newName, $id);
        $stmt->execute();
        $stmt->close();
    }
    header("location:kategori.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
</head>
<body>
    <h1>Edit Kategori</h1>
    <form method="POST">
        <label for="nama">Nama Kategori:</label>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($categoryName); ?>" required>
        <button type="submit">Save</button>
    </form>
</body>
</html>