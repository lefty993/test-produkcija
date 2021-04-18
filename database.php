<?php

class Database {

private $dbhost = 'remotemysql.com';
private $dbname = 'iiBZV2KW0H';
private $dbuser = 'iiBZV2KW0H';
private $dbpass = 'RJJrJRzBZ5';
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

        $unosi = [];

        try {

            $stmt = $this->connection->prepare("SELECT * FROM tekst");
            $stmt->execute();

            if($stmt->rowCount()) {
                $unosi = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $unosi;

        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insert($params) {
        
        try {

            $id = $params['id'];
            $tekst = $params['tekst'];

            $stmt = $this->connection->prepare(
                "INSERT INTO tekst (id, tekst) VALUES (:id, :tekst)"
            );

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':tekst', $tekst);

            $stmt->execute();

        } catch (PDOException $e) {
            
            $this->connection->rollBack();
            throw $e;
        }

    }

    public function delete($params) {

        try {

            $id = $params['id'];

            $stmt = $this->connection->prepare(
                "DELETE FROM tekst WHERE id = :id"
            );

            $stmt->bindParam(':id', $id);

            $stmt->execute();

        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }
}


?>