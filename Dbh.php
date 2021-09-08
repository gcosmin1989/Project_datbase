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
    public $sales=[];
    public $likes=[];
    public $visits=[];

    public function top_sales(){
        $sql = "SELECT prod, sum(value) FROM actions WHERE type=1 group by prod ORDER BY `sum(value)` DESC LIMIT 100;";
        $result = mysqli_query($this->connect(), $sql);
        foreach ($result as $value) {
            $this->sales[] = $value;
        }
            return $this->sales;
    }

    public function top_visits(){
        $sql = "SELECT prod, sum(value) FROM actions WHERE type=2 group by prod ORDER BY `sum(value)` DESC LIMIT 100;";
        $result = mysqli_query($this->connect(), $sql);
        foreach ($result as $value) {
            $this->visits[] = $value;
        }
        return $this->visits;
    }
    public function top_likes(){
        $sql = "SELECT prod, sum(value) FROM actions WHERE type=2 group by prod ORDER BY `sum(value)` DESC LIMIT 100;";
        $result = mysqli_query($this->connect(), $sql);
        foreach ($result as $value) {
            $this->likes[] = $value;
        }
        return $this->likes;
    }
}

$new = new Tops();



