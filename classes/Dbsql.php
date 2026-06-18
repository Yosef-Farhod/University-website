<?php

// $connection = mysqli_connect(hostname: '127.0.0.1', username: 'root', password: '', database: 'university_lms');

class Dbsql
{
    private $connection;
    private $table;
    private $sql = "";

    public function __construct($host, $user, $pass, $db, $table)
    {
        $this->connection = mysqli_connect(
            $host,
            $user,
            $pass,
            $db
        );

        if (!$this->connection) {
            die("Connection Failed : " . mysqli_connect_error());
        }

        $this->table = $table;
    }

    public function select($columns = "*")
    {
        $this->sql = "SELECT $columns FROM `$this->table`";
        return $this;
    }

    public function insert($data)
    {
        $columns = implode(",", array_keys($data));

        $values = [];

        foreach ($data as $value) {

            if (is_null($value)) {
                $values[] = "NULL";
            } elseif (is_numeric($value)) {
                $values[] = $value;
            } else {
                $values[] = "'" . mysqli_real_escape_string($this->connection, $value) . "'";
            }
        }

        $values = implode(",", $values);

        $this->sql = "INSERT INTO `$this->table`
                      ($columns)
                      VALUES
                      ($values)";

        return $this;
    }

    public function update($data)
    {
        $rows = [];

        foreach ($data as $key => $value) {

            if (is_numeric($value)) {
                $rows[] = "$key = $value";
            } else {
                $value = mysqli_real_escape_string(
                    $this->connection,
                    $value
                );

                $rows[] = "$key = '$value'";
            }
        }

        $rows = implode(",", $rows);

        $this->sql = "UPDATE `$this->table`
                      SET $rows";

        return $this;
    }

    public function delete()
    {
        $this->sql = "DELETE FROM `$this->table`";
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $value = mysqli_real_escape_string($this->connection, $value);
        $this->sql .= " WHERE `$column` $operator '$value'";
        return $this;
    }

    public function AndWhere($column, $operator, $value)
    {
        $value = mysqli_real_escape_string($this->connection, $value);
        $this->sql .= " AND `$column` $operator '$value'";
        return $this;
    }

    public function OrWhere($column, $operator, $value)
    {
        $value = mysqli_real_escape_string($this->connection, $value);
        $this->sql .= " OR `$column` $operator '$value'";
        return $this;
    }

    public function join($type, $table, $pk, $fk)
    {
        $this->sql .= " $type JOIN `$table`
                        ON $pk = $fk";

        return $this;
    }

    public function orderBy($column, $type = "ASC")
    {
        $this->sql .= " ORDER BY $column $type";
        return $this;
    }

    public function limit($number)
    {
        $this->sql .= " LIMIT $number";
        return $this;
    }

    public function execute()
    {
        mysqli_query($this->connection, $this->sql);

        return mysqli_affected_rows($this->connection);
    }

    public function all()
    {
        $result = mysqli_query(
            $this->connection,
            $this->sql
        );

        return mysqli_fetch_all(
            $result,
            MYSQLI_ASSOC
        );
    }

    public function get()
    {
        $result = mysqli_query(
            $this->connection,
            $this->sql
        );

        return mysqli_fetch_assoc($result);
    }

    public function count()
    {
        $result = mysqli_query(
            $this->connection,
            $this->sql
        );

        return mysqli_num_rows($result);
    }

    public function showSql()
    {
        return $this->sql;
    }
}