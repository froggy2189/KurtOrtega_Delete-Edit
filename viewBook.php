<?php
require_once "library.php";
$bookObj = new Library();

$search = $_GET["search"] ?? "";
$books = $bookObj->viewBooks($search);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
</head>
<body>
    <h1>Books</h1>
    <form action="" method="get">
        <input type="text" name="search" placeholder="Search title or author" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>
    <a href="addBook.php">Add New Book</a>
    <br><br>
    <?php if (count($books) > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th><th>Title</th><th>Author</th><th>Year</th><th>Actions</th>
            </tr>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book["id"] ?></td>
                    <td><?= htmlspecialchars($book["title"]) ?></td>
                    <td><?= htmlspecialchars($book["author"]) ?></td>
                    <td><?= htmlspecialchars($book["year"]) ?></td>
                    <td>
                        <a href="editBook.php?id=<?= $book["id"] ?>">Edit</a> | 
                        <a href="deleteBook.php?id=<?= $book["id"] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No books found.</p>
    <?php endif; ?>
</body>
</html>
