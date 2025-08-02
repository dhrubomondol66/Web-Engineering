<?php
include "db.php";

if (!isset($_GET['id'])) {
    echo "No book ID provided.";
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM newbooks WHERE id = $id";
$result = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($result) == 1) {
    $book = mysqli_fetch_assoc($result);
} else {
    echo "Book not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Book Details</h2>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($book['title']); ?></p>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($book['descreption'])); ?></p>

        <a href="index.php">Back to List</a>
    </div>
</body>
</html>
