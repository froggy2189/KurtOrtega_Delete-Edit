<?php
require_once "library.php";
$bookObj = new Library();

$book = [];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book["title"] = trim(htmlspecialchars($_POST["title"]));
    $book["author"] = trim(htmlspecialchars($_POST["author"]));
    $book["year"] = trim(htmlspecialchars($_POST["year"]));

    // Validation
    if (empty($book["title"])) {
        $errors["title"] = "Book title is required";
    } else if ($bookObj->doesBookExist($book["title"])) {
        $errors["title"] = "This book title already exists";
    }

    if (empty($book["author"])) {
        $errors["author"] = "Author is required";
    }

    if (empty($book["year"])) {
        $errors["year"] = "Year is required";
    } else if (!is_numeric($book["year"]) || $book["year"] <= 0) {
        $errors["year"] = "Year must be a valid number greater than zero";
    }

    if (empty(array_filter($errors))) {
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->year = $book["year"];

        if ($bookObj->addBook()) {
            header("Location: viewBook.php");
            exit;
        } else {
            echo "An error occurred while adding the book.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        label { display: block; }
        .error { color: red; margin: 0; }
    </style>
</head>
<body>
    <h1>Add Book</h1>
    <form action="" method="post">
        <label for="title">Title</label>
        <input type="text" name="title" value="<?= $book["title"] ?? "" ?>">
        <p class="error"><?= $errors["title"] ?? "" ?></p>

        <label for="author">Author</label>
        <input type="text" name="author" value="<?= $book["author"] ?? "" ?>">
        <p class="error"><?= $errors["author"] ?? "" ?></p>

        <label for="year">Year</label>
        <input type="text" name="year" value="<?= $book["year"] ?? "" ?>">
        <p class="error"><?= $errors["year"] ?? "" ?></p>

        <br>
        <input type="submit" value="Add Book">
    </form>
</body>
</html>
