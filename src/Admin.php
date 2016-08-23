<?php

require_once "connectionDB.php";

/**
 * Created by PhpStorm.
 * User: pekowal
 * Date: 17.08.16
 * Time: 16:14
 */
class Admin
{

    private $id;
    private $email;
    private $hassedPass;

    public function __construct()
    {
        $this->id = -1;
        $this->email = '';
        $this->hassedPass = '';

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmial()
    {
        return $this->email;
    }

    /**
     * @param string $emial
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getHassedPass()
    {
        return $this->hassedPass;
    }


    public function loadFromDB(mysqli $conn, $id)
    {
        $sql = "SELECT * FROM Admins WHERE id = $id";
        $result = $conn->query($sql);

        if ($result != false) {
            foreach ($result as $row) {
                $this->id = $row['id'];
                $this->email = $row['email'];
                $this->hassedPass = $row['hassed_pass'];
                return true;
            }
        }
        return false;
    }

    public function saveToDB(mysqli $conn)
    {
        if ($this->id == -1) {
            $sql = "INSERT INTO Admins(email,hassed_pass) VALUES ('{$this->email}' , '{$this->hassedPass}')";
            $result = $conn->query($sql);

            if ($result != false) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = "UPDATE Admins SET email=$this->email, hassed_pass=$this->hassedPass WHERE id=$this->id";

            $result = $conn->query($sql);

            return $result;
        }

    }

    public function passwordVerify($password)
    {
        return password_verify($password, $this->hassedPass);
    }

    public function setPassword($pass1, $pass2)
    {
        if ($pass1 != $pass2) {
            return false;
        }

        $hassedPassword = password_hash($pass1, PASSWORD_BCRYPT);
        $this->hassedPass = $hassedPassword;

        return true;


    }

}

$admin = new Admin();

$admin->setPassword(123,123);
$admin->setEmail('pekowal@gmail.com');
var_dump($admin->saveToDB($conn));
var_dump($conn);

var_dump($admin);