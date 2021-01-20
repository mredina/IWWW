<?php

class Category{

    private $conn = null;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    public function getAllCategories()
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertCategory($name)
    {
        $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->bindParam(":name", $name);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function getCategoryById($id)
    {

        $stmt = $this->conn->prepare("SELECT name FROM categories WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function deleteCategory($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
}
?>