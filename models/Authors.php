<?php
class Authors
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
        $query = "SELECT id, author FROM {$this->table} ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ SINGLE
    public function read_single()
    {
        $query = "SELECT id, author 
                  FROM {$this->table}
                  WHERE id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // CREATE
    public function create()
    {
        $query = "INSERT INTO {$this->table} (author)
                  VALUES (:author)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author', $this->author);

        if ($stmt->execute()) {
            return [
                "id" => $this->conn->lastInsertId(),
                "author" => $this->author
            ];
        }

        return ["message" => "Author Not Created"];
    }

    // UPDATE
    public function update()
    {
        $query = "UPDATE {$this->table}
                  SET author = :author
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return [
                "id" => $this->id,
                "author" => $this->author
            ];
        }

        return ["message" => "Author Not Updated"];
    }

    // DELETE
    public function delete()
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return ["message" => "Author Deleted"];
        }

        return ["message" => "Author Not Deleted"];
    }
}
