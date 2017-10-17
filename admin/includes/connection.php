<?php
function database_connect(){
     //creating func. to conn. to db

        //varibles with db details
         $db_user = "root";
         $db_pass = "";
         $db_host = "localhost";
         $db_name = "vidhyalaya";
         $db_type = "mysql";

         $options = array(PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8');

         // preparing data structure DSN
         $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";


         try{
                 $pdo = new PDO($dsn, $db_user, $db_pass, $options);

                  //some error handling
                 $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                 $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

          }catch(PDOException $e){
             die("Error ;(".$e->getMessage());
          }

          return $pdo;
      }
        session_start();
        header('Content-Type: text/html; charset=utf-8');
?>


