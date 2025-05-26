<?php
include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $tipo = trim($_POST['tipo']);
    $validade = trim($_POST['validade']);
    $quantidade_estoque = trim($_POST['quantidade_estoque']);
    $unidade_medida = trim($_POST['unidade_medida']);
    $status = trim($_POST['status']);

    if (isset($_POST['update'])) {
        // Atualização
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            $id = intval($_POST['id']);

            $stmt = $conexao->prepare("UPDATE insumo SET nome=?, tipo=?, status=?, quantidade_estoque=?, unidade_medida=?, validade=? WHERE id=?");

            if (!$stmt) {
                echo "Erro na preparação da query: " . $conexao->error;
                exit;
            }

            $stmt->bind_param("ssssssi", $nome, $tipo, $status, $quantidade_estoque, $unidade_medida, $validade, $id);

            if ($stmt->execute()) {
                echo "<script>alert('Insumo atualizado com sucesso!'); window.location.href='insumos.php';</script>";
            } else {
                echo "Erro ao atualizar insumo: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "ID inválido para atualização.";
        }

    } else {
        // Inserção
        $stmt = $conexao->prepare("INSERT INTO insumo (nome, tipo, status, quantidade_estoque, unidade_medida, validade) VALUES (?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            echo "Erro na preparação da query: " . $conexao->error;
            exit;
        }

        $stmt->bind_param("ssssss", $nome, $tipo, $status, $quantidade_estoque, $unidade_medida, $validade);

        if ($stmt->execute()) {
            echo "<script>alert('Insumo incluído com sucesso!'); window.location.href='insumos.php';</script>";
        } else {
            echo "Erro ao incluir insumo: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
