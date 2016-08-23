<?php

/**
 * Created by PhpStorm.
 * User: pekowal
 * Date: 18.08.16
 * Time: 09:54
 */
class ItemPhoto
{
    private $id;
    private $idItem;
    private $src;

    public function __construct()
    {
        $this->id = -1;
        $this->idItem = -1;
        $this->src = '';

    }

    public function loadFromDB(mysqli $conn, $id){
        $sql = "SELECT * FROM Items_photos WHERE id=$id";
        $result = $conn->query($sql);
        if($result != false){
            foreach($result as $row){
                $this->id = $row['id'];
                $this->idItem = $row['id_item'];
                $this->src = $row['src'];
            }
            return true;
        }
        return false;
    }

    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getIdItem()
    {
        return $this->idItem;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param int $idItem
     */
    public function setIdItem($idItem)
    {
        $this->idItem = $idItem;
    }

    /**
     * @param string $src
     */
    public function setSrc($src)
    {
        $this->src = $src;
    }



}