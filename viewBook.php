<?php

require_once "library.php";
$bookObj = new Library();

$search = $genre = "";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $search = isset($_GET["search"])? trim(htmlspecialchars($_GET["search"])) : "";
    $genre = isset($_GET["genre"])? trim(htmlspecialchars($_GET["genre"])) : "";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=`device-width`, initial-scale=1.0">
    <title>View Book</title>
    <link rel="stylesheet" href="viewbook.css">
</head>
<body>
    <div class=container>
        <h1>List of Books</h1>
        <form action="" method="get">
            <label for="">Search:</label>
            <input type="search" name="search" id="search" value="<?= $search ?>">
            <select name="genre" id="genre">
                <option value="">All</option>
                <option value="Science" <?= (isset($genre) && $genre == "Science")? "selected":"" ?>>Science</option>
                <option value="Fiction" <?= (isset($genre) && $genre == "Fiction")? "selected":"" ?>>Fiction</option>
                <option value="History" <?= (isset($genre) && $genre == "History")? "selected":"" ?>>History</option>
            </select>
            <input type="submit" value="Search">
        </form>
  
        <table class="table">
            <tr>
                <td>No. </td>
                <td>Title</td>
                <td>Author</td>
                <td>Genre</td>
                <td>Publication Year</td>
                <td>Publisher</td>
                <td>Copies</td>
                <td>Actions</td>
            </tr>
            <?php
                $no_counter = 1;
                $books = $bookObj->viewBook($genre, $search);
                if (is_array($books)) {
                    foreach ($books as $book)
                    {
            ?> 
                        <tr>
                            <td><?= $no_counter++ ?></td>
                            <td><?= $book["title"] ?></td>
                            <td><?= $book["author"] ?></td>
                            <td><?= $book["genre"] ?></td>
                            <td><?= $book["publication_year"] ?></td>
                            <td><?= $book["publisher"] ?></td>
                            <td><?= $book["copies"] ?></td>
                            <td>
                                <a href="edit.php?id=<?= $book['id'] ?>">Edit</a> | 
                                <a href="delete.php?id=<?= $book['id'] ?>" 
                                   onclick="return confirm('Are you sure you want to delete this book?');">
                                   Delete
                                </a>
                            </td>
                        </tr>
            <?php
                    }
                } else {
                    echo '<tr><td colspan="8">No books found.</td></tr>';
                }
            ?>
        </table>
        
        <br>
        <button><a href="addBook.php">Add Book</a></button>
        
    </div>
</body>
</html>
