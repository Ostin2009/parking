<?php

class Car {

    private $conn;
    private $table_name = "cars";

    public $id;

    public function __construct($db){
        $this->conn = $db;
    }

    // метод read() - получение id машин на парковке
    function read(){

        $query = "SELECT id FROM". " " . $this->table_name;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // метод read() - подсчет машин на парковке
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM" . " " . $this->table_name;

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

    // метод create() - добавляем машину на парковку
    function create(){

        $query = "INSERT INTO". " " . $this->table_name;

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // метод delete() - удаление машины
    function delete(){

        $query = "DELETE FROM" . " " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
