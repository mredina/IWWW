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


    public function login($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT id, username, password, name, surname, role FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $result = $stmt->fetch();
        if (password_verify($password, $result['password'])) {

            $_SESSION['identity'] = array('id' => $result['id'], 'username' => $result['username'], 'name' => $result['name'], 'surname' => $result['surname'], 'role' => $result['role']);
            self::$identity = $_SESSION['identity'];
            return true;
        } else {
            return false;
        }
    }


    public function register($username, $password, $name, $surname)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, name, surname) VALUES (:username, :password, :name, :surname)");
        $stmt->bindParam(":username", $username);
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
}
