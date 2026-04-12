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

    // READ ALL (with optional filters)
    public function read()
    {
        $query = '
            SELECT 
                q.id,
                q.quote,
                a.author,
                c.category
            FROM quotes q
            LEFT JOIN authors a ON q.author_id = a.id
            LEFT JOIN categories c ON q.category_id = c.id
        ';

        $conditions = [];
        $params = [];

        // IMPORTANT FIX: use isset() instead of empty()
        if (isset($this->author_id)) {
            $conditions[] = 'q.author_id = :author_id';
            $params[':author_id'] = $this->author_id;
        }

        if (isset($this->category_id)) {
            $conditions[] = 'q.category_id = :category_id';
            $params[':category_id'] = $this->category_id;
        }

        if ($conditions) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        // Prevent HTML warnings if SQL fails
        if (!$stmt->execute()) {
            return [];
        }

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows ?: [];
    }

    // READ SINGLE
    public function read_single()
    {
        $query = '
            SELECT 
                q.id,
                q.quote,
                a.author,
                c.category
            FROM quotes q
            LEFT JOIN authors a ON q.author_id = a.id
            LEFT JOIN categories c ON q.category_id = c.id
            WHERE q.id = :id
            LIMIT 1
        ';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // CREATE
    public function create()
    {
        $query = '
            INSERT INTO quotes (quote, author_id, category_id)
            VALUES (:quote, :author_id, :category_id)
        ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return [
                "id" => $this->conn->lastInsertId(),
                "quote" => $this->quote,
                "author_id" => $this->author_id,
                "category_id" => $this->category_id
            ];
        }

        return ["message" => "Quote Not Created"];
    }

    // UPDATE
    public function update()
    {
        $query = '
            UPDATE quotes
            SET quote = :quote,
                author_id = :author_id,
                category_id = :category_id
            WHERE id = :id
        ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return [
                "id" => $this->id,
                "quote" => $this->quote,
                "author_id" => $this->author_id,
                "category_id" => $this->category_id
            ];
        }

        return ["message" => "Quote Not Updated"];
    }

    // DELETE
    public function delete()
    {
        $query = '
            DELETE FROM quotes
            WHERE id = :id
        ';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return ["message" => "Quote Deleted"];
        }

        return ["message" => "Quote Not Deleted"];
    }
}
