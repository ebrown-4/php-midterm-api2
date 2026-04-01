<?php
class Database
{
    private $host = "dpg-d767oavfte5s73ee9gig-a.ohio-postgres.render.com";
    private $db_name = "php_midterm_db";
    private $username = "php_midterm_db_user";
    private $password = "G1CoEANjeRpgdxmY3klDEMFUnVpW72Fo";
    public $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "pgsql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
