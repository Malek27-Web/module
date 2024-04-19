<?php
$host ='localhost';
$dbname='montre';
$username='root';
$password='';

try{

$conn =new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
} catch(PDOException $e){
    die("Impossible de se connecter à ala base de donnée $dbname :" .$e->getMessage());
}