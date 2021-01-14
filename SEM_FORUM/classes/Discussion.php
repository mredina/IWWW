<?php

class Discussion
{
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

    public function updateLike($commentId, $userID)
    {
        $like = 1;
        $stmt = $this->conn->prepare("Update commentsLike set libiSe = :libiSe where commentId = :comment AND userId = :user");

        $stmt->bindParam(":libiSe", $like);
        $stmt->bindParam(":comment", $commentId);
        $stmt->bindParam(":user", $userID);
        $stmt_update = $this->conn->prepare("UPDATE comments SET pocetLike = pocetLike + 1 WHERE id = :id");
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
        $stmt = $this->conn->prepare("Update commentsLike set libiSe = :libiSe where commentId = :comment AND userId = :user");

        $stmt->bindParam(":libiSe", $like);
        $stmt->bindParam(":comment", $commentId);
        $stmt->bindParam(":user", $userID);
        $stmt_update = $this->conn->prepare("UPDATE comments SET pocetLike = pocetLike - 1 WHERE id = :id");
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
        $stmt = $this->conn->prepare("INSERT INTO commentsLike (commentId, userID,libiSe) VALUES (:comment,:user,:libiSe)");
        $stmt->bindParam(":comment", $commentId);
        $stmt->bindParam(":user", $userID);
        $stmt->bindParam(":libiSe", $like);
        $stmt_update = $this->conn->prepare("UPDATE comments SET pocetLike = pocetLike + 1 WHERE id = :id");
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

        $stmt = $this->conn->prepare("SELECT libiSe FROM commentsLike WHERE userId = :id AND commentId = :libiSe");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":libiSe", $idComment);
        $stmt->execute();
        return $stmt->fetch();
    }

  

    public function getAllCategoryById($id)
    {

        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getCategoryById($id)
    {

        $stmt = $this->conn->prepare("SELECT name FROM categories WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }



    public function getAllThreads($id)
    {
        $stmt = $this->conn->prepare("SELECT t.id, t.name, t.created, t.number_of_comments, t.last_comment, t.last_comment_date, t.locked, u.name AS users_name, u.surname AS users_surname FROM threads t JOIN users u ON u.id = t.users_id WHERE t.categories_id = :id ORDER BY t.created DESC");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

   
    public function insertThread($name, $category)
    {
        $locked = 0;
        $user = Authentication::getInstance()->getIdentity()['id'];
        $stmt = $this->conn->prepare("INSERT INTO threads (name, categories_id, users_id,locked) VALUES (:name, :category, :user,:locked)");
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



    
    public function getAllComments($id)
    {
        $stmt = $this->conn->prepare("SELECT c.id, c.text, c.created, u.name, u.surname, c.users_id, c.pocetLike FROM comments c JOIN users u ON u.id = c.users_id WHERE c.threads_id = :id ORDER BY c.created DESC");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllUsers(){
        $stmt = $this->conn->prepare("SELECT * from users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllReportedComments(){
        $stmt = $this->conn->prepare("SELECT * from reportedcomments");
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getAllCommentsByUser($id){
        $stmt = $this->conn->prepare("SELECT * from comments where user_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }


   
    public function insertReason($idComment,$text,$textComment,$category,$thread)
    {

        $user_name = Authentication::getInstance()->getIdentity()['username'];


        $stmt = $this->conn->prepare("INSERT INTO reportedcomments (commentId,username, reason,text,threadId, categoryId) VALUES (:commentId, :username, :reason,:textComment,:threadId, :categoryId)");
        $stmt->bindParam(":commentId", $idComment);
        $stmt->bindParam(":username", $user_name);
        $stmt->bindParam(":reason", $text);
        $stmt->bindParam(":textComment", $textComment);
        $stmt->bindParam(":threadId", $category);
        $stmt->bindParam(":categoryId", $thread);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function insertComment($text, $thread)
    {
        $user = Authentication::getInstance()->getIdentity()['id'];
        $user_name = Authentication::getInstance()->getIdentity()['name'];
        $user_surname = Authentication::getInstance()->getIdentity()['surname'];
        $user_fullname = $user_name . ' ' . $user_surname;
        $stmt = $this->conn->prepare("INSERT INTO comments (text, threads_id, users_id) VALUES (:text, :thread, :user)");
        $stmt->bindParam(":text", $text);
        $stmt->bindParam(":thread", $thread);
        $stmt->bindParam(":user", $user);
        $stmt_update = $this->conn->prepare("UPDATE threads SET number_of_comments = number_of_comments + 1, last_comment = :user_fullname, last_comment_date = CURRENT_TIMESTAMP WHERE id = :id");
        $stmt_update->bindParam(":user_fullname", $user_fullname);
        $stmt_update->bindParam(":id", $thread);
        try {
            $stmt->execute();
            $stmt_update->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
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

    public function deleteReason($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM reportedcomments WHERE id = :id");
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
        return true;
    }



   
    public function deleteComment($id, $thread)
    {
        $stmt = $this->conn->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt_update = $this->conn->prepare("UPDATE threads SET number_of_comments = number_of_comments - 1 WHERE id = :id");
        $stmt_update->bindParam(":id", $thread);
        try {
            $stmt->execute();
            $stmt_update->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
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

    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
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
    $stmt = $this->conn->prepare("SELECT users_id FROM comments WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt->fetch();
}


    public function getOwnerOfThread($id)
    {
        $stmt = $this->conn->prepare("SELECT users_id FROM threads WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
