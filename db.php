<?php
$dbHost = 'localhost'; 
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'clinica';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//if ($conexao->connect_error) {
  //  echo "Erro na conexão: " . $conexao->connect_error;
//} else {
  //  echo "Conexão realizada com sucesso";
//}
?>
