<?php

require dirname(__FILE__). '/../src/connectionDB.php';

class AdminTest extends PHPUnit_Extensions_Database_TestCase
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

    public function testLogIn(){
        $result = Admin::LogIn($this->conn,'pekowal@gmail.com' ,123 );
        $this->assertInstanceOf('Admin',$result );

    }

    public function testLoadFromDB(){
        $admin = new Admin();
        $result = $admin->loadFromDB($this->conn,1 );
        $this->assertTrue($result);
    }

    public function saveToDB(){
        $admin = new Admin();
        $result = $admin->saveToDB($this->conn);
        $this->assertTrue($result);
    }
    



}
