<?php
require_once "library.php";
$bookObj = new Library();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = trim(htmlspecialchars($_GET["id"]));
        $book = $bookObj->fetchBook($id);

        if (!$book) {
            echo "<a href='viewBook.php'>View Books</a>";
            exit("Book Not Found");
        } else {
            if ($bookObj->deleteBook($id)) {
                header("Location: viewBook.php");
                exit;
            } else {
                echo "<a href='viewBook.php'>View Books</a>";
                exit("Failed to delete book");
            }
        }
    } else {
        echo "<a href='viewBook.php'>View Books</a>";
        exit("Book Not Found");
    }
}
?>
