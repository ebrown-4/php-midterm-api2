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

    // READ (all or single)
    public function read($id = null)
    {
        $query = "SELECT id, category FROM categories";

        $params = [];

        if ($id !== null) {
            $query .= " WHERE id = :id";
            $params[':id'] = $id;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        // Return ONE object if ID is provided
        if ($id !== null) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row : null;
        }

        // Otherwise return full result set
        return $stmt;
    }

    // CREATE
    public function create()
    {
        $query = "INSERT INTO categories (category)
                  VALUES (:category)
                  RETURNING id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $this->category);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    // UPDATE
    public function update()
    {
        $query = "UPDATE categories
                  SET category = :category
                  WHERE id = :id
                  RETURNING id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':category', $this->category);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    // DELETE
    public function delete()
    {
        $query = "DELETE FROM categories WHERE id = :id RETURNING id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }
}
