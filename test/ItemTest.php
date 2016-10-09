<?php

require dirname(__FILE__). '/../src/connectionDB.php';

class ItemTest extends PHPUnit_Extensions_Database_TestCase
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
    
    public function testGetFourItems(){
        $result = Item::GetFourRandomProducts($this->conn);
        $this->assertInternalType('array', $result );
    }
    
    public function testGetAllProducts(){
        $result = Item::GetAllProducts($this->conn);
        $this->assertInternalType('array', $result );
    }
    
    public function testGetAllProductsOfGroup(){
        $result = Item::GetAllProductsOfGroup($this->conn,1 );
        $this->assertInternalType('array', $result );
    }

    public function testLoadFromDB(){
        $item = new Item();
        $result = $item->loadFromDB($this->conn, 7);
        $this->assertTrue($result);
    }

    public function testSaveToDB(){
        $item = new Item();
        $result = $item->saveToDB($this->conn);
        $this->assertTrue($result);
    }

    public function testGetAllPhotos(){
        $item = new Item();
        $result = $item->getAllPhotos($this->conn);
        $this->assertInternalType('array', $result );

    }
    
    public function testDeleteFromDb(){
        $item = new Item();
        $item->loadFromDB($this->conn, 7);
        $result = $item->deleteFromDB($this->conn);
        $this->assertTrue($result);
        
    }
    
    
}
