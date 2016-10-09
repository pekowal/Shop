<?php

require dirname(__FILE__). '/../src/connectionDB.php';

class UserTest extends PHPUnit_Extensions_Database_TestCase
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

    public function testGetAllUsers()
    {
        $result = User::GetAllUsers($this->conn);
        $this->assertInternalType('array',$result);
    }

    public function testLogIn(){
        $result = User::LogIn($this->conn, 'kajrokolo@gmail.com', '123' );
        $this->assertInstanceOf('User',$result );
            
    }

    public function testLoadFromDB(){
        $user = new User();
        $result = $user->loadFromDB($this->conn, 12);
        $this->assertTrue($result);
    }
    
    public function testDeleteFromDb(){
        $user = new User();
        $user->loadFromDB($this->conn,12 );
        $result = $user->deleteFromDB($this->conn);
        $this->assertTrue($result);
    }
    

}
