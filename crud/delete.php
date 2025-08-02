<?php
include "db.php";

if (!isset($_GET['id'])) {
    echo "No book ID provided.";
    exit();
}

$id = $_GET['id'];

// Optional: Confirm before deletion
$sql = "DELETE FROM newbooks WHERE id = $id";

if (mysqli_query($mysqli, $sql)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error deleting book: " . mysqli_error($mysqli);
}
?>
