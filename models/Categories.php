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
        $query = "SELECT id, category FROM " . $this->table . " ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // READ SINGLE
    public function read_single()
    {
        $query = "SELECT id, category 
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
        $query = "INSERT INTO " . $this->table . " (category)
                  VALUES (:category)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $this->category);

        return $stmt->execute();
    }

    // UPDATE
    public function update()
    {
        $query = "UPDATE " . $this->table . "
                  SET category = :category
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':category', $this->category);
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
