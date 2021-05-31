<?php

    class Database{
        const USERNAME = "kareemyomi91@gmail.com";
        const PASSWORD = '18081995';
        private $dsn = "mysql:host=localhost;dbname=user_system";
        private $dbuser = "root";
        private $dbpass = "";

        public $conn;

        public function __construct(){
            try {
                $this->conn = new PDO($this->dsn,$this->dbuser,$this->dbpass);
                
            } catch (PDOException $e) {
                echo "Error: ".$e->getMessage();
            }

            return $this->conn;
        }

        // Test input
        public function testInput($data){
            $data = trim($data);
            $data = stripslashes($data); 
            $data = htmlspecialchars($data);
            return $data;
        }

        // Message 
        public function displayMessage($type,$msg){
            return '<div class="alert alert-'.$type.' alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong class="text-center">'.$msg.'</strong>
            </div>';
        }
    }

?>