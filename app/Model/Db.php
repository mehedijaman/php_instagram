<?php 
namespace App\Model;

use Exception;

class Db{
    private static $instance = null;
    private $connection;

    private $host  = 'localhost';
    private $db    = 'instagram';
    private $user  = 'phpmyadmin';
    private $pass  = 'Q1w2e3r4t5!';

    private $num_of_rows;

    private function __construct(){
        $this->connection = mysqli_connect($this->host, $this->user, $this->pass, $this->db);

        if($this->connection->connect_error){
            throw new Exception("Failed to connect to DB".$this->connection->connect_error);
        }
    }

    public static function getInstance(){
        if(static::$instance == null){
            static::$instance = new self();
        }

        return static::$instance;
    }

    // Restrict from object cloning
    private function __clone(){}

    public function execute($sql){
        $result = $this->connection->query($sql);

        if(!$result){
            throw new Exception("Failed to execute the query".$this->connection->error);
        }
        
        return true;
    }

    public function fetchData($sql){
        $result = $this->connection->query($sql);

        if($result){
            while($row = mysqli_fetch_assoc($result)){
                $data[] = $row;
            }

            return $data;
        }
        else{
            return [];
        }
    }

    public function close(){
        $this->connection->close();
    }
}