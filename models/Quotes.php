<?php
class Quotes
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

    // READ ALL
    public function read()
    {
        $query = 'SELECT 
                    q.id, q.quote, 
                    a.author, 
                    c.category 
                  FROM ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id';

        $stmt = $this->conn->prepare($query);
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
