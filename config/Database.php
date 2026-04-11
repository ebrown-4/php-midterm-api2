<?php
class Database
{
    private $host = "localhost";
    private $db_name = "phpmidterm";
    private $username = "root";
    private $password = "";
    public $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8";

            $this->conn = new PDO($dsn, $this->username, $this->password);

            // Throw exceptions on errors
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode(["message" => "Connection Error: " . $e->getMessage()]);
            exit();
        }

        return $this->conn;
    }
}
