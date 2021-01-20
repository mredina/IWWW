<?php

class Thread{

    private $conn = null;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

   
    public function insertThread($name, $category)
    {
        $locked = 0;
        $user = Authentication::getInstance()->getIdentity()['id'];
        $stmt = $this->conn->prepare("INSERT INTO threads (name, categoryId, userId,locked) VALUES (:name, :category, :user,:locked)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":category", $category);
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":locked", $locked);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

  
    public function getThreadById($id)
    {
        $stmt = $this->conn->prepare("SELECT name FROM threads WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllThreadById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM threads WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateThread($id)
    {
        $locked = 1;
        $stmt = $this->conn->prepare("Update threads set locked = :locked  WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":locked", $locked);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function updateThreadUnlocked($id)
    {
        $locked = 0;
        $stmt = $this->conn->prepare("Update threads set locked = :locked  WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":locked", $locked);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function deleteThread($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM threads WHERE id = :id");
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
    
    public function getOwnerOfThread($id)
    {
        $stmt = $this->conn->prepare("SELECT userId FROM threads WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}       
?>
