<?php

require dirname(__FILE__). '/../src/connectionDB.php';

class ItemPhotoTest extends PHPUnit_Extensions_Database_TestCase
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

    public function testLoadOnePhotoOfItemFromDB(){
        $result = ItemPhoto::LoadOnePhotoOfItemFromDB($this->conn,20 );
        $this->assertInstanceOf('ItemPhoto',$result );
    }
    
    public function testSaveToDb(){
        $itemPhoto = new ItemPhoto();
        $result = $itemPhoto->saveToDB($this->conn);
        $this->assertTrue($result);
    }
    
    public function testLoadFromDb(){
        $itemPhoto = new ItemPhoto();
        $result = $itemPhoto->loadFromDB($this->conn,20);
        $this->assertTrue($result);
    }
    
    public function testLoadAllPhotosFromItem(){
        $itemPhoto = new ItemPhoto();
        $result = $itemPhoto->loadAllPhotosOfItemFromDB($this->conn, 20);
        $this->assertInternalType('array', $result);
    }
}
