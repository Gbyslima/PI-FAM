<?php
include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);   
    $preco = trim($_POST['preco']); 
    $duracao_min = trim($_POST['duracao_min']);
    $categoria = trim($_POST['categoria']);

    if (isset($_POST['update'])) {
        // UPDATE
        $stmt = $conexao->prepare("UPDATE servico SET nome=?, descricao=?, preco=?, duracao_min=?, categoria=? WHERE id=?");

        if (!$stmt) {
            echo "Erro na preparação da query: " . $conexao->error;
            exit;
        }

        $stmt->bind_param("ssdisi", $nome, $descricao, $preco, $duracao_min, $categoria, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Serviço atualizado com sucesso!'); window.location.href='servicos.php';</script>";
        } else {
            echo "Erro ao atualizar serviço: " . $stmt->error;
        }

        $stmt->close();

    } else {
       // INSERT
$stmt = $conexao->prepare("INSERT INTO servico (nome, descricao, preco, duracao_min, categoria) VALUES (?, ?, ?, ?, ?)");

if (!$stmt) {
    echo "Erro na preparação da query: " . $conexao->error;
    exit;
}

$stmt->bind_param("sssss", $nome, $descricao, $preco, $duracao_min, $categoria);

if ($stmt->execute()) {
    echo "<script>alert('Serviço salvo com sucesso!'); window.location.href='servicos.php';</script>";
} else {
    echo "Erro ao salvar serviço: " . $stmt->error;
}

$stmt->close();

    }
}
?>
