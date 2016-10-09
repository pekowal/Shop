<?php

require dirname(__FILE__). '/../src/connectionDB.php';

class ItemGroupTest extends PHPUnit_Extensions_Database_TestCase
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
    
    public function testGetCountOfGroup(){
        $result = ItemGroup::GetCountOfGroups();
        $this->assertInternalType('int',$result );
    }

    public function testGetAllGroups(){
        $result = ItemGroup::GetAllGroups();
        $this->assertInternalType('array',$result );
    }

    public function testLoadFromDB(){
        $itemGroup = new ItemGroup();
        $result = $itemGroup->loadFoupromDB($this->conn, 7);
        $this->assertTrue($result);
    }

    public function testSaveToDB(){
        $itemGroup = new ItemGroup();
        $result = $itemGroup->saveToDB($this->conn);
        $this->assertTrue($result);
    }

    public function testDeleteFromDb(){
        $itemGroup = new ItemGroup();
        $itemGroup->loadFromDB($this->conn, 2);
        $result = $itemGroup->deleteFromDB($this->conn);
        $this->assertTrue($result);

    }
}
