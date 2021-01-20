<?php

class Comment{

    private $conn = null;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    public function updateLike($commentId, $userID)
    {
        $like = 1;
        $stmt = $this->conn->prepare("Update commentsLike set likeState = :likeState where commentId = :comment AND userId = :user");

        $stmt->bindParam(":likeState", $like);
        $stmt->bindParam(":comment", $commentId);
        $stmt->bindParam(":user", $userID);
        $stmt_update = $this->conn->prepare("UPDATE comments SET likes = likes + 1 WHERE id = :id");
        $stmt_update->bindParam(":id", $commentId);
        try {
            $stmt->execute();
            $stmt_update->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function insertDisLike($commentId, $userID)
    {
        $like = 2;
        $stmt = $this->conn->prepare("Update commentsLike set likeState = :likeState where commentId = :comment AND userId = :user");

        $stmt->bindParam(":likeState", $like);
        $stmt->bindParam(":comment", $commentId);
        $stmt->bindParam(":user", $userID);
        $stmt_update = $this->conn->prepare("UPDATE comments SET likes = likes - 1 WHERE id = :id");
        $stmt_update->bindParam(":id", $commentId);
        try {
            $stmt->execute();
            $stmt_update->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }


    public function insertLike($commentId, $userID)
    {
        $like = 1;
        $stmt = $this->conn->prepare("INSERT INTO commentsLike (commentId, userID,likeState) VALUES (:comment,:user,:likeState)");
        $stmt->bindParam(":comment", $commentId);
        $stmt->bindParam(":user", $userID);
        $stmt->bindParam(":likeState", $like);
        $stmt_update = $this->conn->prepare("UPDATE comments SET likes = likes + 1 WHERE id = :id");
        $stmt_update->bindParam(":id", $commentId);
        try {
            $stmt->execute();
            $stmt_update->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function selectLike($id,$idComment)
    {

        $stmt = $this->conn->prepare("SELECT likeState FROM commentsLike WHERE userId = :id AND commentId = :likeState");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":likeState", $idComment);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllComments($id)
    {
        $stmt = $this->conn->prepare("SELECT c.id, c.text, c.created, u.name, u.surname, c.userId, c.likes FROM comments c JOIN users u ON u.id = c.userId WHERE c.threadId = :id ORDER BY c.created DESC");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertComment($text, $thread)
    {
        $user = Authentication::getInstance()->getIdentity()['id'];
        $stmt = $this->conn->prepare("INSERT INTO comments (text, threadId, userId) VALUES (:text, :thread, :user)");
        $stmt->bindParam(":text", $text);
        $stmt->bindParam(":thread", $thread);
        $stmt->bindParam(":user", $user);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function getAllCommentsByUser($id){
        $stmt = $this->conn->prepare("SELECT * from comments where user_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCommentById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM comments WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllCommentById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM comments WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function deleteComment($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->bindParam(":id", $id);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function updateComment($id, $text)
    {
        $stmt = $this->conn->prepare("UPDATE comments SET text = :text WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":text", $text);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function getOwnerOfComment($id)
    {
    $stmt = $this->conn->prepare("SELECT userId FROM comments WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt->fetch();
    }
}
?>