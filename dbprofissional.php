<?php
include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $data_contratacao = trim($_POST['data_contratacao']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);
    $especialidade = trim($_POST['especialidade']);

    if (isset($_POST['update'])) {
        // UPDATE
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            $id = intval($_POST['id']);

            $stmt = $conexao->prepare("UPDATE profissionais SET nome=?, data_contratacao=?, telefone=?, email=?, especialidade=? WHERE id=?");

            if (!$stmt) {
                echo "Erro na preparação da query: " . $conexao->error;
                exit;
            }

            $stmt->bind_param("ssssi", $nome, $data_contratacao, $telefone, $email, $especialidade, $id);

            if ($stmt->execute()) {
                echo "<script>alert('Profissional atualizado com sucesso!'); window.location.href='profissional.php';</script>";
            } else {
                echo "Erro ao atualizar profissional: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "ID inválido para atualização.";
        }
    } else {
        // INSERT
        $stmt = $conexao->prepare("INSERT INTO profissionais (nome, data_contratacao, telefone, email, especialidade) VALUES (?, ?, ?, ?, ?)");

        if (!$stmt) {
            echo "Erro na preparação da query: " . $conexao->error;
            exit;
        }

        $stmt->bind_param("sssss", $nome, $data_contratacao, $telefone, $email, $especialidade);

        if ($stmt->execute()) {
            echo "<script>alert('Profissional incluído com sucesso!'); window.location.href='profissional.php';</script>";
        } else {
            echo "Erro ao incluir profissional: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
