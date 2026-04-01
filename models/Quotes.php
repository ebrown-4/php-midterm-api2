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

    public function read($author_id = null, $category_id = null, $random = false)
    {
        $query = "SELECT q.id, q.quote, a.author, c.category
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
            $query .= " ORDER BY RANDOM() LIMIT 1";
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
}
