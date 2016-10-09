<?php


require dirname(__FILE__). '/../src/connectionDB.php';

class ItemOrderTest extends PHPUnit_Extensions_Database_TestCase
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
    
    public function testGetAllItemsInOrder(){
        $result = ItemOrder::GetAllItemsOfOrder($this->conn, 31);
        $this->assertInternalType('array', $result);
    }
    
    public function testLoadFromDb(){
        $itemOrder = new ItemOrder();
        $result = $itemOrder->loadFromDb($this->conn, 15);
        $this->assertTrue($result);
    }
    
    public function testSaveToDb(){
        $itemOrder = new ItemOrder();
        $result = $itemOrder->saveToDb($this->conn);
        $this->assertTrue($result);
    }
    
    

}
