<?php

/**
 * Created by PhpStorm.
 * User: pekowal
 * Date: 22.08.16
 * Time: 11:10
 */
class ItemGroup
{

    private $id;

    private $name;

    public static function GetCountOfGroups(mysqli $conn){
        $sql = "SELECT COUNT(*) FROM Items_group";

        $result = $conn->query($sql);

        if($result != false){
            $count = $result->fetch_assoc();
        }
        return $count;
    }

    public static function GetAllGroups(Mysqli $conn){

        $sql = "SELECT * FROM Items_group";

        $result = $conn->query($sql);

        $toReturn = [];

        if($result != false){
            foreach ($result as $row){
                $newGroup = new ItemGroup();
                $newGroup->id = $row['id'];
                $newGroup->name = $row['name'];
                $toReturn[] = $newGroup;
            }
        }

        return $toReturn;

    }


    public function __construct()
    {
        $this->id = -1;
        $this->name = '';
    }


    public function loadFromDB(mysqli $conn, $id){
        $sql = "SELECT * FROM Items_group WHERE id=".$id;
        $result = $conn->query($sql);

        if ($result != false){
            foreach ($result as $row){
                $this->id = $row['id'];
                $this->name = $row['name'];
            }
            return true;
        }
        
        return false;
    }

    public function saveToDB(mysqli $conn){
        if($this->id === -1){
            $sql = "INSERT INTO Items_group(name) VALUE ('{$this->name}')";
            $result = $conn->query($sql);

            if ($result != false){
                $this->id = $conn->insert_id;
                return true;
            }
            return false;            
        }else {
            $sql = "UPDATE Items_group SET name='{$this->name}' WHERE id=$this->id";

            $result = $conn->query($sql);

            return $result;
        }

    }
    
    public function deleteFromDB(mysqli $conn){
        $sql = "DELETE FROM Items_group WHERE id=".$this->id;
        
        $result = $conn->query($sql);
        
        return $result;
    }


    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getName()
    {
        return $this->name;
    }

}