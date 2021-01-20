<?php

class Authentication
{
    private $conn = null;
    private static $instance = null;
    private static $identity = null;

    private function __construct()
    {
        if (isset($_SESSION['identity'])) {
            self::$identity = $_SESSION['identity'];
        }
        $this->conn = Connection::getConnection();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Authentication();
        }
        return self::$instance;
    }

    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT id, email, password, name, surname, role FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch();
        if (password_verify($password, $result['password'])) {
            $_SESSION['identity'] = array('id' => $result['id'], 'email' => $result['email'], 'name' => $result['name'], 'surname' => $result['surname'], 'role' => $result['role']);
            self::$identity = $_SESSION['identity'];
            return true;
        } else {
            return false;
        }
    }

    public function register($email, $password, $name, $surname)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (email, password, name, surname) VALUES (:email, :password, :name, :surname)");
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":surname", $surname);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }


    public function logout()
    {
        unset($_SESSION['identity']);
        self::$identity = null;
    }


    public function hasIdentity()
    {
        return self::$identity ? true : false;
    }


    public function getIdentity()
    {
        return self::$identity ? self::$identity : null;
    }


    public function isAdmin()
    {
        return self::$identity['role'] == 0 ? true : false;
    }
}
