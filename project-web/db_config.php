<?php
$host = 'localhost'; 
$login= ''; 
$mdp = ''; 
$db = '';

$db = new PDO("mysql:host=$host;dbname=$db", $login, $mdp);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
?>

