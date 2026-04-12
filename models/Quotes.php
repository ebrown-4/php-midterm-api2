<?php
class Quote
{
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $author_id;
    public $category_id;
    public $author;
    public $category;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ ALL (with optional filters)
    public function read()
    {
        $query = 'SELECT 
                    q.id, q.quote, 
                    a.author, 
                    c.category 
                  FROM ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id';

        // Optional filters
        $conditions = [];
        $params = [];

        if (!empty($_GET['author_id'])) {
            $conditions[] = 'q.author_id = :author_id';
            $params[':author_id'] = $_GET['author_id'];
        }

        if (!empty($_GET['category_id'])) {
            $conditions[] = 'q.category_id = :category_id';
            $params[':category_id'] = $_GET['category_id'];
        }

        if (!empty($conditions)) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt;
    }

    // READ SINGLE
    public function read_single()
    {
        $query = 'SELECT 
                    q.id, q.quote, 
                    a.author, 
                    c.category 
                  FROM ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.id = :id
                  LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt;
    }

    // CREATE
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' 
                  (quote, author_id, category_id)
                  VALUES (:quote, :author_id, :category_id)';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        return $stmt->execute();
    }

    // UPDATE
    public function update()
    {
        $query = 'UPDATE ' . $this->table . '
                  SET quote = :quote,
                      author_id = :author_id,
                      category_id = :category_id
                  WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // DELETE
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
