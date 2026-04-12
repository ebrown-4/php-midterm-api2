<?php
class Database
{
    private $host = "dpg-d767oavfte5s73ee9gig-a.ohio-postgres.render.com";
    private $db_name = "php_midterm_db";
    private $username = "php_midterm_db_user";
    private $password = "G1CoEANjeRpgdxmY3klDEMFUnVpW72Fo";
    private $port = "5432";
    public $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name};";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // DO NOT echo anything — return null instead
            return null;
        }

        return $this->conn;
    }
}
