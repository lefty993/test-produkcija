<?php

class Database {

private $dbhost = 'remotemysql.com';
private $dbname = 'MB9Hk9Ogj0';
private $dbuser = 'MB9Hk9Ogj0';
private $dbpass = 'B3I5t6PQ1g';
private $connection;

public function __construct()
    {
        $dsn = "mysql:host=".$this->dbhost.";dbname=".$this->dbname;

        try{
            // Kreiranje konekcije
            $pdo = new PDO($dsn, $this->dbuser, $this->dbpass);

            // aktivacija iznimki
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->connection = $pdo;

        }catch(Exception $e) {
            echo $e->getMessage();

        }

    }

    public function get_unosi() {

        // $stmt = $this->connection->prepare(....);
        $test = [];

        try {

            $stmt = $this->connection->prepare("SELECT * FROM tablica_01");
            $stmt->execute();

            if($stmt->rowCount()) {
                $test = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $test;

        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insert($params) {
        
        try {
            
            $this->connection->beginTransaction();

            $test = intval($params['test']);

            $stmt = $this->connection->prepare(
                "INSERT INTO tablica_01 (test) VALUES (:test)"
            );

            $stmt->bindParam(':test', $test);

            $stmt->execute();

            $this->connection->commit();

        } catch (PDOException $e) {
            
            $this->connection->rollBack();
            throw $e;
        }

    }
}


?>