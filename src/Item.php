<?php

/**
 * Created by PhpStorm.
 * User: pekowal
 * Date: 17.08.16
 * Time: 21:15
 */
class Item
{

    private $id;
    private $idGroup;
    private $name;
    private $desc;
    private $price;
    private $quantity;

    public static function GetFourRandomProducts(mysqli $conn)
    {
        $toReturn = [];

        $sql = "SELECT * FROM Items ORDER BY RAND() LIMIT 4";
        $result = $conn->query($sql);

        if ($result != false) {
            foreach ($result as $row) {
                $item = new Item();
                $item->id = $row['id'];
                $item->idGroup = $row['id_group'];
                $item->name = $row['name'];
                $item->desc = $row['description'];
                $item->price = $row['price'];
                $item->quantity = $row['quantity'];

                $toReturn[] = $item;
            }
        }
        return $toReturn;
    }

    public static function GetAllProductsOfGroup(mysqli $conn, $idGroup)
    {
        $toReturn = [];

        $sql = "SELECT * FROM Items WHERE id_group=" . $idGroup;

        $result = $conn->query($sql);

        if ($result != false) {
            foreach ($result as $row) {
                $item = new Item();
                $item->id = $row['id'];
                $item->idGroup = $row['id_group'];
                $item->name = $row['name'];
                $item->desc = $row['description'];
                $item->price = $row['price'];
                $item->quantity = $row['quantity'];

                $toReturn[] = $item;
            }
        }

        return $toReturn;
    }

    public static function GetAllProducts(mysqli $conn)
    {
        $toReturn = [];
        $sql = "SELECT * FROM Items";
        $result = $conn->query($sql);
        if ($result != false) {
            foreach ($result as $row) {
                $item = new Item();
                $item->id = $row['id'];
                $item->idGroup = $row['id_group'];
                $item->name = $row['name'];
                $item->desc = $row['description'];
                $item->price = $row['price'];
                $item->quantity = $row['quantity'];

                $toReturn[] = $item;
            }
        }

        return $toReturn;
    }

    public function loadFromDB(mysqli $conn, $id)
    {
        $sql = 'SELECT * FROM Items WHERE id=' . $id;
        $result = $conn->query($sql);

        if ($result != false) {
            foreach ($result as $row) {
                $this->id = $row['id'];
                $this->idGroup = $row['id_group'];
                $this->name = $row['name'];
                $this->desc = $row['description'];
                $this->price = $row['price'];
                $this->quantity = $row['quantity'];
            }
            return true;
        }
        return false;
    }

    public function saveToDB(mysqli $conn)
    {
        if ($this->id == -1) {
            $sql = "INSERT INTO Items(id_group,name,description,price,quantity)
                    VALUES ('{$this->idGroup}' , '{$this->name}','{$this->desc}','{$this->price}','{$this->quantity}')";
            $result = $conn->query($sql);

            if ($result != false) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = "UPDATE Items SET id_group='{$this->idGroup}', name='{$this->name}',
                    description='{$this->desc}', price='{$this->price}', quantity='{$this->quantity}' WHERE id=".$this->id;

            $result = $conn->query($sql);

            return $result;
        }
    }

    public function getAllPhotos(mysqli $conn)
    {
        $toReturn = [];
        $sql = "SELECT * FROM Items_photos WHERE id_item=" . $this->getId();
        $result = $conn->query($sql);
        if ($result != false) {
            foreach ($result as $row) {
                $itemPhoto = new ItemPhoto();
                $itemPhoto->setIdItem($row['id_item']);
                $itemPhoto->setSrc($row['src']);
                $toReturn[] = $itemPhoto;
            }
            return $toReturn;
        }
        return false;
    }

    public function deleteFromDB(mysqli $conn)
    {
        $sql = "DELETE FROM Items WHERE id=" . $this->id;
        $result = $conn->query($sql);

        return $result;

    }


    public function __construct()
    {
        $this->id = -1;
        $this->desc = '';
        $this->idGroup = -1;
        $this->name = '';
        $this->price = 0;
        $this->quantity = 0;
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

    /**
     * @return string
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @return int
     */
    public function getIdGroup()
    {
        return $this->idGroup;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @param int $idGroup
     */
    public function setIdGroup($idGroup)
    {
        $this->idGroup = $idGroup;
    }

}