<?php
include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nome = trim($_POST['nome']);
    $preco = trim($_POST['preco']);
    $servico = trim($_POST['servico']);
    $status = trim($_POST['status']);
    $data = trim($_POST['data']);
    $responsavel = trim($_POST['responsavel']);
    $hora = trim($_POST['hora']);

    if (isset($_POST['update'])) {
        // UPDATE usando prepared statement
        $stmt = $conexao->prepare("UPDATE ordemdeservico SET nome=?, preco=?, servico=?, status=?, data=?, responsavel=?, hora=? WHERE id=?");

        if (!$stmt) {
            echo "Erro na preparação da query: " . $conexao->error;
            exit;
        }

        $stmt->bind_param("sssssssi", $nome, $preco, $servico, $status, $data, $responsavel, $hora, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Ordem de serviço atualizada com sucesso!'); window.location.href='ordemdeservico.php';</script>";
        } else {
            echo "Erro ao atualizar ordem de serviço: " . $stmt->error;
        }

        $stmt->close();

    } else {
        // INSERT 
        $stmt = $conexao->prepare("INSERT INTO ordemdeservico (nome, preco, servico, status, data, responsavel, hora) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            echo "Erro na preparação da query: " . $conexao->error;
            exit;
        }

        $stmt->bind_param("sssssss", $nome, $preco, $servico, $status, $data, $responsavel, $hora);

        if ($stmt->execute()) {
            echo "<script>alert('Ordem de serviço salva com sucesso!'); window.location.href='ordemdeservico.php';</script>";
        } else {
            echo "Erro ao salvar ordem de serviço: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
