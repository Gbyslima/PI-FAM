<?php
include_once('db.php');
$inserido_com_sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $mensagem = mysqli_real_escape_string($conexao, $_POST['mensagem']);

    $result = mysqli_query($conexao, "
        INSERT INTO contato (nome, email, observacoes) 
        VALUES ('$nome', '$email', '$mensagem')
    ");

    if ($result) {
        $inserido_com_sucesso = true;
    }
}
?>
