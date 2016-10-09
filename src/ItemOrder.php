<?php

/**
 * Created by PhpStorm.
 * User: pekowal
 * Date: 06.09.16
 * Time: 15:53
 */
class ItemOrder
{
    private $id;
    private $idItem;
    private $idOrder;
    private $quantity;

    public function __construct()
    {
        $this->id = -1;
        $this->idItem = -1;
        $this->idOrder = -1;
        $this->quantity = 0;
    }

    public static function GetAllItemsOfOrder(mysqli $conn,$orderid){
        $sql = "SELECT * FROM Product_Orders WHERE id_order=".$orderid;
        $result = $conn->query($sql);
        $toReturn = [];
        if ($result != false){
            foreach ($result as $row){
                $productOrder = new ItemOrder();
                $productOrder->id = $row['id'];
                $productOrder->idItem = $row['id_item'];
                $productOrder->idOrder = $row['id_order'];
                $productOrder->quantity = $row['quantity'];
                $toReturn[] = $productOrder;
            }
            return $toReturn;
        }
        return false;
    }

    public function loadFromDb(mysqli $conn, $id){
        $sql = "SELECT * FROM Product_Orders WHERE id=".$id;
        $result = $conn->query($sql);
        if ($result != false){
            foreach ($result as $row){
                $this->id = $row['id'];
                $this->idItem = $row['id_item'];
                $this->idOrder = $row['id_order'];
                $this->quantity = $row['quantity'];
            }
            return true;
        }
        return false;
    }

    public function saveToDb(mysqli $conn)
    {
        if ($this->id == -1) {

            $sql = "INSERT INTO Product_Orders(id_item,id_order,quantity) 
                VALUES ('{$this->idItem}','{$this->idOrder}','{$this->quantity}')";
            $result = $conn->query($sql);
            if ($result != false) {
                $this->id = $conn->insert_id;
                return true;
            }
        }

        return true;


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
     * @return int
     */
    public function getIdOrder()
    {
        return $this->idOrder;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $idItem
     */
    public function setIdItem($idItem)
    {
        $this->idItem = $idItem;
    }

    /**
     * @param int $idOrder
     */
    public function setIdOrder($idOrder)
    {
        $this->idOrder = $idOrder;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

}