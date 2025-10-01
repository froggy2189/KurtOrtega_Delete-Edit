<?php

require_once "database.php";

class Library extends Database
{
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication_year = "";
    public $publisher = "";
    public $copies = "";

    public function addBook()
    {
        $sql = "INSERT INTO book(title, author, genre, publication_year, publisher, copies) 
                VALUES(:title, :author, :genre, :publication_year, :publisher, :copies)";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        $query->bindParam(":publisher", $this->publisher);
        $query->bindParam(":copies", $this->copies);

        return $query->execute();
    }

    public function viewBook($genre ="", $search = "")
    {
        $sql = "SELECT * FROM book 
                WHERE title LIKE CONCAT('%', :search, '%') 
                AND genre LIKE CONCAT('%', :genre, '%') 
                ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":search", $search);
        $query->bindParam(":genre", $genre);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC); 
        } else {
            return [];
        }
    }

    // ✅ fetch single book by ID
    public function fetchBook($id)
    {
        $sql = "SELECT * FROM book WHERE id = :id LIMIT 1";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ delete book by ID
    public function deleteBook($id)
    {
        $sql = "DELETE FROM book WHERE id = :id";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        return $query->execute();
    }

    // ✅ edit book by ID
    public function editBook($id)
    {
        $sql = "UPDATE book 
                SET title = :title, author = :author, genre = :genre, 
                    publication_year = :publication_year, publisher = :publisher, copies = :copies
                WHERE id = :id";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        $query->bindParam(":publisher", $this->publisher);
        $query->bindParam(":copies", $this->copies);
        $query->bindParam(":id", $id, PDO::PARAM_INT);

        return $query->execute();
    }
}
