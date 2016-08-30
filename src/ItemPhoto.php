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

    public function saveToDB(mysqli $conn){

        $sql = "INSERT INTO Items_photos(id_item, src) VALUES ('{$this->idItem}','{$this->src}')";
        $result = $conn->query($sql);

        if ($result === true) {
            $this->id = $conn->insert_id;
            return true;
        }
        return false;
    }
    public function loadFromDB(mysqli $conn, $id){
        $sql = "SELECT * FROM Items_photos WHERE id=".$id;
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

    public function loadOnePhotoOfItemFromDB(mysqli $conn, $idItem){
        $sql = "SELECT * FROM Items_photos WHERE id_item=".$idItem;
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            foreach($result as $row){
                $photo = new ItemPhoto();
                $photo->id = $row['id'];
                $photo->idItem = $row['id_item'];
                $photo->src = $row['src'];
            }
            return $photo;
        }
        return false;
    }

    public function loadAllPhotosOfItemFromDB(mysqli $conn, $idItem){
        $toReturn = [];
        $sql = "SELECT * FROM Items_photos WHERE id_item=$idItem";
        $result = $conn->query($sql);
        if($result != false){
            foreach($result as $row){
                $photo = new ItemPhoto();
                $photo->id = $row['id'];
                $photo->idItem = $row['id_item'];
                $photo->src = $row['src'];
                $toReturn[] = $photo;
            }
            return $toReturn;
        }
        return false;
    }

    public function deleteFromDB(mysqli $conn)
    {
        $sql = "DELETE FROM Items_photos WHERE id=" . $this->id;
        $result = $conn->query($sql);

        return $result;

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