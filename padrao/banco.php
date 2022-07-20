<?php

require ("lib/banco.class.php");
$sql = new database;

$dbservidor='desenvolvimento.vaplink.com.br';
$dbusuario='a_projetos';
$dbsenha  ='nfe';
//$dbbanco  ='a_dashboard';
$dbbanco  ='a_temp2';

$sql->_connect($dbservidor, false, $dbusuario, $dbsenha, $dbbanco, $dbconect);  
 
?>
