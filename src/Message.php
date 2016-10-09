<?php

/**
 * Created by PhpStorm.
 * User: pekowal
 * Date: 08.10.16
 * Time: 13:01
 */
class Message
{
    private $id;
    private $text;
    private $senderId;
    private $reciverId;
    private $sendDate;

    public static function GetAllMessageForUser(mysqli $conn, $userId){
        $sql = "SELECT * FROM Messages WHERE id_reciver=".$userId;
        $result = $conn->query($sql);
        $toReturn = [];
        if ($result != false){
            foreach ($result as $row){
                $message = new Message();
                $message->id = $row['id'];
                $message->text = $row['text_message'];
                $message->senderId = $row['id_sender'];
                $message->reciverId = $row['id_reciver'];
                $message->sendDate = $row['creation_date'];
                $toReturn[] = $message;
            }
            return $toReturn;
        }
        return false;
    }

    public function __construct()
    {
        $this->id = -1;
        $this->text = '';
        $this->senderId = -1;
        $this->reciverId = -1;
    }

    public function saveToDb(mysqli $conn){
        $sql = "INSERT INTO Messages(text_message,id_sender,id_reciver) VALUES ('{$this->text}','{$this->senderId}','{$this->reciverId}')";
        $result = $conn->query($sql);

        return $result;
    }

    public function loadFromDb(mysqli $conn, $id){
        $sql = "SELECT * FROM Messages WHERE id=".$id;
        $result = $conn->query($sql);

       if ($result != false){
           foreach ($result as $row){
               $this->id = $id;
               $this->text = $row['text_message'];
               $this->senderId = $row['id_sender'];
               $this->reciverId = $row['id_reciver'];
               $this->sendDate = $row['creation_date'];
           }
           return true;
       }
        return false;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
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
    public function getReciverId()
    {
        return $this->reciverId;
    }

    /**
     * @return int
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @param int $reciverId
     */
    public function setReciverId($reciverId)
    {
        $this->reciverId = $reciverId;
    }

    /**
     * @param int $senderId
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    /**
     * @return mixed
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * @param mixed $sendDate
     */
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;
    }
}