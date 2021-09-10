<?php

class Dbh
{
    public $type;
    public $period;
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "test_juniorphp";

    public function connect()
    {
        $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            return $conn;
        }
    }

    public function getTop()
    {
        $sql = "select prod, $this->period(time),sum(value) from actions WHERE type=$this->type group by prod, $this->period(time) ORDER by sum(value) DESC LIMIT 100;";
        mysqli_query($this->connect(), $sql);
    }

    public function dropTable()
    {
        $sql = "DROP TABLE IF EXISTS tops";
        mysqli_query($this->connect(), $sql);
    }

    public function createTable()
    {
        $sql = "CREATE TABLE tops(prod int(3) not null, $this->period int(4) not null, value int(10) not null)";
        mysqli_query($this->connect(), $sql);
    }

    public function populateTable()
    {
        $sql = "INSERT INTO tops(prod, $this->period, value) Select prod, $this->period(time),sum(value) from actions WHERE type=$this->type group by prod, $this->period(time) ORDER by sum(value) DESC LIMIT 100 ";
        mysqli_query($this->connect(), $sql);

    }
    public function createTops(){
        $sql = "SELECT * FROM `tops` ORDER BY `tops`.`prod` ,`tops`.`$this->period` ASC;";
        $results= mysqli_query($this->connect(), $sql);
        return $results;
    }

    public function __construct($type=[1,2,3],$period=['week','month','year']){
        $this->type=$type;
        $this->period=$period;
        $this->getTop();
        $this->dropTable();
        $this->createTable();
        $this->populateTable();
        $this->createTops();


    }
}









