<?php
/**
 * Created by PhpStorm.
 * User: pekowal
 * Date: 24.07.16
 * Time: 15:03
 */


class User
{
    private $id;
    private $name;
    private $surname;
    private $email;
    private $hassedPass;
    private $addres;
    private $creationDate;
    private $isActive;

    static public function GetAllUsers(mysqli $conn)
    {
        $sql = 'SELECT * FROM Users';
        $result = $conn->query($sql);
        $toReturn = [];
        if ($result != false) {
            foreach ($result as $row) {
                $newUser = new User();
                $newUser->id = $row['id'];
                $newUser->name = $row['name'];
                $newUser->surname = $row['surname'];
                $newUser->email = $row['email'];
                $newUser->addres = $row['address'];
                $newUser->addres = $row['hassed_pass'];
                $newUser->creationDate = $row['register_date'];
                $toReturn[] = $newUser;
            }
        }
        return $toReturn;
    }


    public function __construct()
    {
        $this->id = -1;
        $this->name = '';
        $this->surname = '';
        $this->email = '';
        $this->hassedPass = '';
        $this->addres = '';
        $this->creationDate = '';
        $this->isActive = 1;
    }

    public function loadFromDB(mysqli $conn, $id)
    {
        $sql = 'SELECT FORM Users WHERE id=' . $id;
        $result = $conn->query($sql);

        if ($result != false) {
            foreach ($result as $row) {
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->surname = $row['surname'];
                $this->email = $row['email'];
                $this->addres = $row['hassed_pass'];
                $this->addres = $row['address'];
                $this->creationDate = $row['register_date'];
                return true;
            }
        }
        return false;
    }

    public function saveToDB(mysqli $conn)
    {
        if ($this->id === -1) {
            $sql = "INSERT INTO Users(name, surname, email, hassed_pass, addres, is_active) VALUES 
                    ('{$this->name}','{$this->surname}','{$this->email}','{$this->hassedPass}','{$this->addres}','{$this->isActive}')";
            $result = $conn->query($sql);
            if ($result === true) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = "UPDATE Users SET name='{$this->name}',
                                      surname='{$this->surname}',
                                      email='{$this->email}',
                                      hassed_pass='$this->$this->hassedPass',
                                      addres='$this->addres',
                                      is_active='$this->isActive' WHERE id='{$this->id}'";
            $result = $conn->query($sql);
            return $result;
            //update row to database
        }
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->hassedPass);
    }

    public function setPassword($newPassword1, $newPassword2)
    {
        if ($newPassword1 != $newPassword2) {
            return false;
        }
        $hassedPassword = password_hash($newPassword1, PASSWORD_BCRYPT);
        $this->hassedPassword = $hassedPassword;
        return true;
    }

    /**
     * @return string
     */
    public function getAddres()
    {
        return $this->addres;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $addres
     */
    public function setAddres($addres)
    {
        $this->addres = $addres;
    }

    /**
     * @return string
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @return int
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function activate()
    {
        $this->isActive = 1;
    }


    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

}
