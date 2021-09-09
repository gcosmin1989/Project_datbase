<?php

class Dbh
{
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
}




class Tops extends Dbh
{

    public function getTop($type=[1,2,3], $period=['year','month','week']){
        $sql = "select prod, $period(time),sum(value) from actions WHERE type=$type group by prod, $period(time) ORDER by sum(value) DESC LIMIT 100;";
        mysqli_query($this->connect(), $sql);
        $sql ="DROP TABLE IF EXISTS tops";
        mysqli_query($this->connect(),$sql);
        $sql= "CREATE TABLE tops(prod int(3) not null, $period int(4) not null, sum int(10) not null)";
        mysqli_query($this->connect(),$sql);
        $sql="INSERT INTO tops(prod, $period, sum) Select prod, $period(time),sum(value) from actions WHERE type=$type group by prod, $period(time) ORDER by sum(value) DESC LIMIT 100 ";
        $result = mysqli_query($this->connect(),$sql);
        return $result;
    }


}

$new = new Tops();
$new->getTop(3,'week');



