<?php
include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $data_nascimento = trim($_POST['data_nascimento']);
    $cpf = trim($_POST['cpf']); 
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);
    $tipo = trim($_POST['tipo']);

    if (isset($_POST['update'])) {
        // UPDATE
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            $id = intval($_POST['id']);

            $stmt = $conexao->prepare("UPDATE paciente SET nome=?, data_nascimento=?, cpf=?, telefone=?, email=?, tipo=? WHERE id=?");

            if (!$stmt) {
                echo "Erro na preparação da query: " . $conexao->error;
                exit;
            }

            $stmt->bind_param("ssssssi", $nome, $data_nascimento, $cpf, $telefone, $email, $tipo, $id);

            if ($stmt->execute()) {
                echo "<script>alert('Paciente atualizado com sucesso!'); window.location.href='pacientes.php';</script>";
            } else {
                echo "Erro ao atualizar paciente: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "ID inválido para atualização.";
        }
    } else {
        // INSERT
        $stmt = $conexao->prepare("INSERT INTO paciente (nome, data_nascimento, cpf, telefone, email, tipo) VALUES (?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            echo "Erro na preparação da query: " . $conexao->error;
            exit;
        }

        $stmt->bind_param("ssssss", $nome, $data_nascimento, $cpf, $telefone, $email, $tipo);

        if ($stmt->execute()) {
            echo "<script>alert('Paciente incluído com sucesso!'); window.location.href='pacientes.php';</script>";
        } else {
            echo "Erro ao incluir paciente: " . $stmt->error;
        }

        $stmt->close();
    }
    
}
?>
