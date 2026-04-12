<?php
class Quotes
{
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ (supports: all, id, author_id, category_id, both, random)
    public function read($id = null, $author_id = null, $category_id = null, $random = false)
    {
        $query = "SELECT 
                    q.id,
                    q.quote,
                    a.author,
                    c.category
                  FROM quotes q
                  JOIN authors a ON q.author_id = a.id
                  JOIN categories c ON q.category_id = c.id";

        $conditions = [];
        $params = [];

        if ($id !== null) {
            $conditions[] = "q.id = :id";
            $params[':id'] = $id;
        }

        if ($author_id !== null) {
            $conditions[] = "q.author_id = :author_id";
            $params[':author_id'] = $author_id;
        }

        if ($category_id !== null) {
            $conditions[] = "q.category_id = :category_id";
            $params[':category_id'] = $category_id;
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        if ($random) {
            $query .= " ORDER BY RANDOM() LIMIT 1";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        // Return ONE object if ID or random=true
        if ($id !== null || $random) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row : null;
        }

        // Otherwise return full result set
        return $stmt;
    }

    // CREATE
    public function create()
    {
        $query = "INSERT INTO quotes (quote, author_id, category_id)
                  VALUES (:quote, :author_id, :category_id)
                  RETURNING id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    // UPDATE
    public function update()
    {
        $query = "UPDATE quotes
                  SET quote = :quote,
                      author_id = :author_id,
                      category_id = :category_id
                  WHERE id = :id
                  RETURNING id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    // DELETE
    public function delete()
    {
        $query = "DELETE FROM quotes WHERE id = :id RETURNING id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }
}
