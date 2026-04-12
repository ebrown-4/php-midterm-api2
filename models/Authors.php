<?php
class Author
{
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ ALL
    public function read()
    {
        $query = "SELECT id, author FROM " . $this->table . " ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // READ SINGLE
    public function read_single()
    {
        $query = "SELECT id, author 
                  FROM " . $this->table . " 
                  WHERE id = :id 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt;
    }

    // CREATE
    public function create()
    {
        $query = "INSERT INTO " . $this->table . " (author)
                  VALUES (:author)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author', $this->author);

        return $stmt->execute();
    }

    // UPDATE
    public function update()
    {
        $query = "UPDATE " . $this->table . "
                  SET author = :author
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // DELETE
    public function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
