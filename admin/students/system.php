<?php

class System
{
    public ?mysqli $connection;
    public function __construct()
    {
        $this->connection = mysqli_connect(hostname: '127.0.0.1', username: 'root', password: '', database: 'test');
    }
    public function insert($data)
    {
        $key = array_keys($data);
        $key = implode(",", $key);

        $value = [];
        foreach ($data as $val) {
            if (is_string($val)) {
                $value[] = "'" . $val . "'"; 
            } else {
                $value[] = $val; 
            }
        }
        $value = implode(",", $value);
        $sql = "INSERT INTO `users` ($key) VALUES ($value);";
        mysqli_query($this->connection, $sql);
        if (mysqli_affected_rows($this->connection)) {
            echo "done add a student";
            return true;
        } else {
            echo "feild student";
            return false;
        }
    }

    public function selcetAll()
    {
        $sql = "SELECT * FROM `users`;";
        $reslt =  mysqli_query($this->connection, $sql);
        return mysqli_fetch_all($reslt, 1);
        
    }
    public function serche($id)
    {
        $sql = "SELECT * FROM `users` WHERE `users`.`id`=$id;";
        $reslt =  mysqli_query($this->connection, $sql);
        $user = mysqli_fetch_assoc($reslt);
        return $user;
    }

    public function edit($data , $id){
        $row = "";
        foreach($data as $key => $val){
            if(is_string($val)){
                $row .= "$key='$val',";
            }else{
                $row .= "$key=$val,";
            }
        }
        $row = substr($row, 0, -1);
        $sql = "UPDATE `users` SET $row WHERE `users`.`id` = $id;";
        mysqli_query($this->connection, $sql);
    }
    public function delet($id){
        $sql = "DELETE FROM `users` WHERE `id` = $id ;";
        mysqli_query($this->connection, $sql);
        if (mysqli_affected_rows($this->connection)) {
            return true;
        }else{
            return false;
        }
    }
}
class cl{
    public $reslt = 0;

    public function add($num1 , $num2){
        $this->reslt += $num1 + $num2;
        return $this;
    }
    public function div($num1 , $num2){
        $this->reslt += $num1 - $num2;
        return $this;
    }
    public function mlit($num1 , $num2){
        $this->reslt += $num1 * $num2;
        return $this;
    }
    public function sub($num1 , $num2){
        $this->reslt += $num1 / $num2;
        return $this;
    }
    public function print(){
        echo $this->reslt;
    }
}

$clu = new cl();
$clu->add(3,4)->mlit(2,3)->print();

