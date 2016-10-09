<?php


require dirname(__FILE__). '/../src/connectionDB.php';


class OrderTest extends PHPUnit_Framework_TestCase
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
    
    public function testGetAllOrders(){
        $result = Order::GetAllOrders($this->conn);
        $this->assertInternalType('array',$result );
    }
    
    public function testGetAllOrdersOfUser(){
        $result = Order::GetAllOrdersFromUser($this->conn,12 );
        $this->assertInternalType('array',$result );
    }
    
    public function testLoadFromDb(){
        $order = new Order();
        $result = $order->loadFromDb($this->conn,31 );
        $this->assertTrue($result);
    }

    public function testSaveToDb(){
        $order = new Order();
        $result = $order->saveToDb($this->conn);
        $this->assertTrue($result);
    }



}
