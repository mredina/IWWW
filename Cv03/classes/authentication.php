<?php

class Authentication
{
    private static $instance = null;
    private static $identity = null;
    private $conn = null;

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
        return self::$identity['role'] === "1" ? true : false;
    }
}
