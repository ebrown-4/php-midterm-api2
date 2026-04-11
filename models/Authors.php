<?php
class Author
{
    private $conn;
    private $table = 'authors';

    public $id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ ALL AUTHORS
    public function read()
    {
        $query = "SELECT id, name FROM {$this->table} ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // READ SINGLE AUTHOR
    public function read_single()
    {
        $query = "SELECT id, name FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->name = $row['name'];
        }
    }

    // CREATE AUTHOR
    public function create()
    {
        $query = "INSERT INTO {$this->table} (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(':name', $this->name);

        return $stmt->execute();
    }

    // UPDATE AUTHOR
    public function update()
    {
        $query = "UPDATE {$this->table}
                  SET name = :name
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // DELETE AUTHOR
    public function delete()
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}
