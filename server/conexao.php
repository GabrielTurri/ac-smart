<?php
 $user = "root";
 $password = "";
 $database = "humanitae_db";
 
 try {
   $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
   echo "Conectado com sucesso";
 } catch (PDOException $e) {
   echo "Conexão falhou: ". $e->getMessage();
 }
?>