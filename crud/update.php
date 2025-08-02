<?php
include "db.php";

// Check if ID is set and form not submitted yet (GET request to load data)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM newbooks WHERE id = $id";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) == 1) {
        $book = mysqli_fetch_assoc($result);
        $title = $book['title'];
        $author = $book['author'];
        $descreption = $book['descreption'];
    } else {
        echo "Book not found.";
        exit();
    }
}

// If the form is submitted
if (isset($_POST['submit'])) {
    $id = $_POST['id']; // Hidden input
    $title = $_POST['title'];
    $author = $_POST['author'];
    $descreption = $_POST['descreption'];

    $sql = "UPDATE newbooks SET title='$title', author='$author', descreption='$descreption' WHERE id=$id";
    
    if (mysqli_query($mysqli, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($mysqli);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <h2>Update Book Info</h2>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label for="title">Book Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>" required>

        <label for="descreption">Description:</label>
        <textarea id="descreption" name="descreption" rows="5" required><?php echo htmlspecialchars($descreption); ?></textarea>

        <input type="submit" name="submit" value="Update Book">
    </form>
</div>

</body>
</html>
