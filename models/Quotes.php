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

    // READ ALL (with optional filters + random)
    public function read($author_id = null, $category_id = null, $random = false)
    {
        $query = "SELECT 
                    q.id, 
                    q.quote, 
                    a.name AS author, 
                    c.name AS category
                  FROM quotes q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id";

        $conditions = [];

        if ($author_id !== null) {
            $conditions[] = "q.author_id = :author_id";
        }

        if ($category_id !== null) {
            $conditions[] = "q.category_id = :category_id";
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        if ($random) {
            $query .= " ORDER BY RAND() LIMIT 1";
        } else {
            $query .= " ORDER BY q.id ASC";
        }

        $stmt = $this->conn->prepare($query);

        if ($author_id !== null) {
            $stmt->bindParam(':author_id', $author_id);
        }

        if ($category_id !== null) {
            $stmt->bindParam(':category_id', $category_id);
        }

        $stmt->execute();
        return $stmt;
    }

    // READ SINGLE QUOTE
    public function read_single()
    {
        $query = "SELECT 
                    q.id, 
                    q.quote, 
                    a.name AS author, 
                    c.name AS category
                  FROM quotes q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];
        }
    }

    // VALIDATE AUTHOR EXISTS
    public function authorExists()
    {
        $query = "SELECT id FROM authors WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->author_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    // VALIDATE CATEGORY EXISTS
    public function categoryExists()
    {
        $query = "SELECT id FROM categories WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->category_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    // CREATE QUOTE
    public function create()
    {
        $query = "INSERT INTO {$this->table} (quote, author_id, category_id)
                  VALUES (:quote, :author_id, :category_id)";

        $stmt = $this->conn->prepare($query);

        $this->quote = htmlspecialchars(strip_tags($this->quote));

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        return $stmt->execute();
    }

    // UPDATE QUOTE
    public function update()
    {
        $query = "UPDATE {$this->table}
                  SET quote = :quote,
                      author_id = :author_id,
                      category_id = :category_id
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->quote = htmlspecialchars(strip_tags($this->quote));

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // DELETE QUOTE
    public function delete()
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}
