<?php

class Reset
{
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $db = "budget-manager";

    public function resetSpendings()
    {
        try {

            $conn = new PDO("mysql:host=$this->servername;dbname=" . $this->db, $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $rawSql = 'UPDATE spending SET is_paid = 0 WHERE is_fixed_cost = 1';

            $conn->exec($rawSql);

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
