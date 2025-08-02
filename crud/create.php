<?php
include "db.php";

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $descreption = $_POST['descreption'];

    $sql = "INSERT INTO newbooks(title, author, descreption) VALUES('$title', '$author', '$descreption')";
    if (!mysqli_query($mysqli, $sql)) {
        die("Do it again: " . mysqli_error($mysqli));
    } else {
        header("Location: create.php");
        exit();
    }
}

$books = mysqli_query($mysqli, "SELECT * FROM newbooks ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <link rel="stylesheet" href="style.css">
    <style>

    </style>
</head>
<body>

    <div class="form-container">
        <h2>Add a New Book</h2>
        <form action="create.php" method="POST">
            <label for="title">Book Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>

            <label for="descreption">Description:</label>
            <textarea id="descreption" name="descreption" rows="5" required></textarea>

            <input type="submit" name="submit" value="Add Book">
        </form>
    </div>

    <?php if (mysqli_num_rows($books) > 0): ?>
    <div class="form-container">
        <h2>All Books</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($book = mysqli_fetch_assoc($books)): ?>
                <tr>
                    <td><?php echo $book['id']; ?></td>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['descreption']); ?></td>
                    <td>
                        <a href="read.php?id=<?php echo $book['id']; ?>">View</a>
                        <a href="update.php?id=<?php echo $book['id']; ?>">Edit</a>
                        <a href="delete.php?id=<?php echo $book['id']; ?>" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

</body>
</html>
