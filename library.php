<?php
require_once "database.php";

class Library extends Database
{
    public $title;
    public $author;
    public $year;

    // Add new book
    public function addBook()
    {
        $sql = "INSERT INTO books (title, author, year) VALUES (:title, :author, :year)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":year", $this->year);
        return $stmt->execute();
    }

    // View all books with optional search
    public function viewBooks($search = "")
    {
        $sql = "SELECT * FROM books";
        if (!empty($search)) {
            $sql .= " WHERE title LIKE :search OR author LIKE :search";
        }
        $stmt = $this->connect()->prepare($sql);
        if (!empty($search)) {
            $likeSearch = "%" . $search . "%";
            $stmt->bindParam(":search", $likeSearch);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch one book by ID
    public function fetchBook($id)
    {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Check if book already exists (for duplicates)
    public function doesBookExist($title, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM books WHERE title = :title";
        if ($excludeId) {
            $sql .= " AND id != :id";
        }
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":title", $title);
        if ($excludeId) {
            $stmt->bindParam(":id", $excludeId);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Edit book
    public function editBook($id)
    {
        $sql = "UPDATE books SET title = :title, author = :author, year = :year WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Delete book
    public function deleteBook($id)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
