<?php

class Thread{

    private $conn = null;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    public function getAllThreads($id) {
        $stmt = $this->conn->prepare("SELECT t.* , u.name AS users_name, u.surname AS users_surname FROM threads t JOIN users u ON u.id = t.userId WHERE t.categoryId = :id ORDER BY t.created DESC");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $threads = $stmt->fetchAll();
        $stmt2 = $this->conn->prepare("SELECT c.*, u.name AS user_name, u.surname AS user_surname FROM comments c JOIN threads t ON t.id = c.threadId JOIN users u ON u.id = c.userId WHERE t.categoryId = :id ORDER BY created DESC");
        $stmt2->bindParam(":id", $id);
        $stmt2->execute();
        $comments = $stmt2->fetchAll();
        foreach ($threads as $key => $thread) {
          $count = 0;
          foreach ($comments as $comment) {
            if ($comment['threadId'] == $thread['id']) {
              if ($count == 0) {
                $threads[$key]['last_comment_date'] = $comment['created'];
                $threads[$key]['last_comment'] = $comment['user_name'] . ' ' . $comment['user_surname'];
              }
              $count++;
            }
          }
          $threads[$key]['number_of_comments'] = $count;
        }
        return $threads;
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