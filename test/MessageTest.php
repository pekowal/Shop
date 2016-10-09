<?php


require dirname(__FILE__). '/../src/connectionDB.php';

class MessageTest extends PHPUnit_Extensions_Database_TestCase
{

    public function getConnection()
    {
        $conn = new PDO(
            "mysql:dbname=ShopTDD;host=localhost",
            "root",
            "268722qw"
        );
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, 'ShopTDD');
    }

    public function getDataSet()
    {
        $dataMysql = $this->createMySQLXMLDataSet(dirname(__FILE__) . '/file.xml');

        return $dataMysql;
    }

    protected function setUp()
    {

        $this->conn = new mysqli('localhost', 'root', '268722qw', 'testTDD');

    }
    
    public function testGetAllMessagesFromUser(){
        $result = Message::GetAllMessageForUser($this->conn,12 );
        $this->assertInternalType('array',$result );
    }
    
    public function testSaveToDb(){
        $message = new Message();
        $result = $message->saveToDb($this->conn);
        $this->assertTrue($result);
    }
    
    public function testLoadFromDb(){
        $message = new Message();
        $result = $message->loadFromDb($this->conn,1 );
        $this->assertTrue($result);
    }

}
