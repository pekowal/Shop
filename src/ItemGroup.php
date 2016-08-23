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