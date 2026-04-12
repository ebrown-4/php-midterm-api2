<?php
class Categories
{

    private $conn;
    private $table = 'categories';

    public $id;
    public $category;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ ALL
    public function read()
    {
        $query = "SELECT id, category FROM {$this->table} ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ SINGLE
    public function read_single()
    {
        $query = "SELECT id, category
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
        $query = "INSERT INTO {$this->table} (category)
                  VALUES (:category)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $this->category);

        if ($stmt->execute()) {
            return [
                "id" => $this->conn->lastInsertId(),
                "category" => $this->category
            ];
        }

        return ["message" => "Category Not Created"];
    }

    // UPDATE
    public function update()
    {
        $query = "UPDATE {$this->table}
                  SET category = :category
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return [
                "id" => $this->id,
                "category" => $this->category
            ];
        }

        return ["message" => "Category Not Updated"];
    }

    // DELETE
    public function delete()
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return ["message" => "Category Deleted"];
        }

        return ["message" => "Category Not Deleted"];
    }
}
