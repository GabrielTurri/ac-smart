<?php
 $user = "felipe";
 $password = "abcd=1234";
 $database = "humanitae_db";
 
 try {
   $db = new PDO("mysql:host=137.184.66.198;dbname=$database", $user, $password);
   echo "Conectado com sucesso";
 } catch (PDOException $e) {
   echo "Conexão falhou: ". $e->getMessage();
 }
?>