<?php

class User{

    private $conn = null;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    public function updateUser($email, $password,$id)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE users SET email = :email, password=:password WHERE id = :id");
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":id", $id);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public function getAllUsers(){
        $stmt = $this->conn->prepare("SELECT * from users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteUser($id)
    {
        $stmtUser = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmtUser->bindParam(":id", $id);
        $stmtUser->execute();
        $user = $stmtUser->fetch();
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt2 = $this->conn->prepare("DELETE FROM reportedComments WHERE email = :email");
        $stmt->bindParam(":id", $id);
        $stmt2->bindParam(":email", $user['email']);

        try {
            $stmt->execute();
            $stmt2->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

}

?>