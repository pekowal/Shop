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

    public function __construct()
    {
        $this->id = -1;
        $this->idUser = -1;
        $this->status = '';
        $this->orderDate = '';
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

}