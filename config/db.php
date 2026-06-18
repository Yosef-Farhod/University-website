<?php 



class Dbsql 
{
    private $sql;
    private $connection;
    private $table;

    public function __construct($host, $user, $pass, $db , $table)
    {
    $this->connection = mysqli_connect(hostname: $host, username: $user, password: $pass, database: $db);
    $this->table = $table;
        }
    public function insert($date){
        $columns = array_keys($date);
        $columns = implode(", ", $columns);
        $values = [];
        foreach($date as $val){
            if(is_string($val)){
                $values[] = "'" . $val . "'";
            }else{
                $values[] = $val;
            }
        }
        $values = implode(", ", $values);
        $this->sql = "INSERT INTO `$this->table` ($columns) VALUES ($values) ";
        return $this;
    }

    public function update($date){
        $row = "";
        foreach($date as $key => $val){
            if(is_string($val)){
                $row .= "$key='$val',";
            }else{
                $row .= "$key=$val,";
            }
        }
        $row = rtrim($row, ",");
        $this->sql = "UPDATE $this->table SET $row ";
        return $this;
        
    }

    public function delete(){
        $this->sql = "DELETE FROM `$this->table`";
        return $this;
    }

    public function select($columns = " * "){
        $this->sql = "SELECT $columns FROM `$this->table` ";
        return $this;
    }

    public function where($column ,$condetion,$value,){
        $this->sql .= " WHERE " . "`$column`" . $condetion . "'$value'";
        return $this;
    }

    public function AndWhere($column ,$condetion,$value,){
        $this->sql .= " AND  " . "`$column`" . $condetion . "'$value'";
        return $this;
    }

    public function OrWhere($column ,$condetion,$value,){
        $this->sql .= " OR " . "`$column`" . $condetion . "'$value'";
        return $this;
    }
    public function exqut(){
        mysqli_query($this->connection, $this->sql);
        return(mysqli_affected_rows($this->connection));
    }

    public function all(){
        $reslt = mysqli_query($this->connection, $this->sql);
        return mysqli_fetch_all($reslt, 1);
    }

    public function get(){
        $reslt = mysqli_query($this->connection,$this->sql);
        return mysqli_fetch_assoc($reslt);
    }

    public function join($type,$table,$pk,$fk){
        $this->sql .= " $type JOIN `$table` ON $pk = $fk";
        echo $this->sql;
        return $this;
    }
}


?> 









// trait filelogon{
//     public function log() {
//         echo "\nlog in file";
//     }
// }

// trait dblogon{
//     public function log() {
//         echo "\nlog in db";
//     }
// }

// class Pay{
//     use filelogon,dblogon {

//         filelogon::log insteadof dblogon;
//         dblogon::log as dblog;
//     }

// }
// $payment = new Pay();
// $payment->dblog();
// $payment->log();





// abstract class Test{
//     abstract $count ;
//     function __construct()
//     {
//         self::$count++;
//     }

//     function __destruct()
//     {
//         echo "number = ",self::$count;
//     }
// }



// include "Test.php";

// spl_autoload_register(function($name) {
//     include $name .".php";
// });

// $te = new Test("ali");
// $te->myName();


// spl_autoload_register(function($name) {
//     if (file_exists("mode/$name.php")) {
//         include "mode/$name.php";
//     }elseif(file_exists("tt/$name.php")){
//         include "tt/$name.php";
//     }else{
//         echo "not found";
//     }
// });

// $tl = new Test("ali");
// $tl->myName();

// $abdo = new User("abdo",33);
// $abdo->hello();



