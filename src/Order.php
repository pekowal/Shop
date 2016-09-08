<?php

/**
 * Created by PhpStorm.
 * User: pekowal
 * Date: 18.08.16
 * Time: 10:25
 */
class Order
{

    private $id;
    private $idUser;
    private $status;
    private $orderDate;
    private $paymentType;

    public static function GetAllOrdersFromUser(mysqli $conn, $userid){
        $sql = "SELECT * FROM Orders WHERE id_user=".$userid;
        $result = $conn->query($sql);
        $toReturn = [];
        if ($result != false){
            foreach ($result as $row){
                $order = new Order();
                $order->id = $row['id'];
                $order->idUser = $row['id_user'];
                $order->status = $row['status'];
                $order->paymentType = $row['payment_type'];
                $order->orderDate = $row['order_date'];
                $toReturn[] = $order;
            }
            return $toReturn;
        }
        return false;
    }

    public function __construct()
    {
        $this->id = -1;
        $this->idUser = -1;
        $this->status = 'Oczekujący';
        $this->orderDate = '';
    }

    public function loadFromDb(mysqli $conn, $id)
    {
        $sql = "SELECT * FROM Orders WHERE id=" . $id;
        $result = $conn->query($sql);
        if ($result != false) {
            foreach ($result as $row) {
                $this->id = $row['id'];
                $this->idUser = $row['id_user'];
                $this->status = $row['status'];
                $this->orderDate = $row['order_date'];
                
            }
            return true;
        }
        return false;
    }
    public function saveToDb(mysqli $conn)
    {
        if ($this->id == -1) {

            $sql = "INSERT INTO Orders(id_user,status,payment_type) 
                VALUES ('{$this->idUser}','{$this->status}','{$this->paymentType}')";
            $result = $conn->query($sql);
            if ($result != false) {
                $this->id = $conn->insert_id;
                return true;
            }
        }else{
            $sql = "UPDATE Orders SET status='{$this->status}', payment_type='{$this->paymentType}' WHERE id=".$this->id;
            $result = $conn->query($sql);
            
            return $result;
        }


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
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @return string
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @param string $orderDate
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $paymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

}