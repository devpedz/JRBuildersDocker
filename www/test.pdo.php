<?php
        class DBConnect{
            private $host      = 'localhost';
            private $user      = 'user';
            private $pass      = 'test';
            private $dbname    = 'myDb';
            private $port      = '3308';
            private $dbh;
            private $error;
            private $stmt;
            public function __construct(){
                    //error_reporting(0);
                    // Set DSN
                    $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname.';port='.$this->port.';charset=utf8';
                    // Set options
                    $options = array(
                        PDO::ATTR_PERSISTENT    => true,
                        PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
                    );
                    // Create a new PDO instanace
                    try{
                        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
                    }
                    // Catch any errors
                    catch(PDOException $e){
                        echo 'Cannot connect to your database server.';
                    }
                }
            
            public function query($query){
                    $this->stmt = $this->dbh->prepare($query);
                }
                    
            public function execute(){
                    return $this->stmt->execute();
                }
            
            public function bind($param, $value, $type = null){
                if (is_null($type)) {
                    switch (true) {
                        case is_int($value):
                            $type = PDO::PARAM_INT;
                            break;
                        case is_bool($value):
                            $type = PDO::PARAM_BOOL;
                            break;
                        case is_null($value):
                            $type = PDO::PARAM_NULL;
                            break;
                        default:
                            $type = PDO::PARAM_STR;
                    }
                }
                $this->stmt->bindValue($param, $value, $type);
                }

            public function set(){
                    $this->execute();
                    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            
            public function single(){
                    $this->execute();
                    return $this->stmt->fetch(PDO::FETCH_ASSOC);
                }
            
            public function count(){
                    return $this->stmt->rowCount();
                }
            
            public function lastinsertid(){
                    return $this->dbh->lastInsertId();
                }
            
            
            public function begintransaction(){
                    return $this->dbh->beginTransaction();
                }
            
            public function endtransaction(){
                    return $this->dbh->commit();
                }
            
            public function canceltransaction(){
                    return $this->dbh->rollBack();
                }
            
            public function debugdumpparams(){
                    return $this->stmt->debugDumpParams();
                }
            
            public function close(){
                 try{
                    $this->dbh=null;
                }  catch(PDOException $e){
                        echo 'Cannot close your database connection.';
                    }
                }
        }
