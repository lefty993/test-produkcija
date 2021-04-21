<?php

include 'DotEnv.php';

class Database {

private $dbhost;
private $dbname;
private $dbuser;
private $dbpass;
private $connection;

public function __construct()
    {

        if(file_exists(__DIR__.'/../.env')) {
            $dotenv = new DotEnv(__DIR__.'/../.env');
            $dotenv->load();
        }
        
        $this->dbhost = getenv('DB_HOST');
        $this->dbname = getenv('DB_NAME');
        $this->dbuser = getenv('DB_USER');
        $this->dbpass = getenv('DB_PASS');

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

            header('Location: index.php');

        } catch (PDOException $e) {
            
            $this->connection->rollBack();
            throw $e;
        }

    }

    public function delete_text($params) {

        try {

            $id = $params['id'];

            $stmt = $this->connection->prepare(
                "DELETE FROM tekst WHERE id = :id"
            );

            $stmt->bindParam(':id', $id);

            $stmt->execute();

            header('Location: index.php');

        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    public function get_tekst($id) {

        $tekst = [];

            $stmt = $this->connection->prepare(
                "SELECT * FROM tekst WHERE id = :id"
            );

            $stmt->bindParam(':id', $id);

            $result = $stmt->execute();

            if($stmt->rowCount()) {
                $tekst = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            return $tekst;

    }

    public function update_text($params) {

        try {

            $id = $params['id'];
            $tekst = $params['tekst'];

            $stmt = $this->connection->prepare(
                "UPDATE tekst SET tekst = :tekst WHERE id = :id"
            );

            $stmt->bindParam('id', $id);
            $stmt->bindParam('tekst', $tekst);

            $stmt->execute();

            header('Location: edit.php?id=' . $id);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}


?>