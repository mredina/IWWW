<?php

class ReportedComment{

    private $conn = null;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }


    public function getAllReportedComments()
    {
        $stmt = $this->conn->prepare("SELECT rc.*, t.id as threadId, c.id as categoryId FROM reportedComments rc JOIN comments com ON rc.commentId = com.id JOIN threads t ON t.id = com.threadId JOIN categories c ON c.id = t.categoryId");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertReason($idComment,$text,$textComment)
    {

        $text = filter_var($text, FILTER_SANITIZE_STRING);
        $textComment = filter_var($textComment, FILTER_SANITIZE_STRING);
        $user_name = Authentication::getInstance()->getIdentity()['email'];
        $stmt = $this->conn->prepare("INSERT INTO reportedComments (commentId,email, reason,text) VALUES (:commentId, :email, :reason,:textComment)");
        $stmt->bindParam(":commentId", $idComment);
        $stmt->bindParam(":email", $user_name);
        $stmt->bindParam(":reason", $text);
        $stmt->bindParam(":textComment", $textComment);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function deleteReason($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM reportedComments WHERE id = :id");
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