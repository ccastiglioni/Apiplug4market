<?php

require ("lib/banco.class.php");
$sql = new database;

$dbservidor='localhost';
$dbusuario='root';
$dbsenha  ='120521';
$dbbanco  ='loja_local';

$sql->_connect($dbservidor, false, $dbusuario, $dbsenha, $dbbanco, $dbconect);  
 
?>
