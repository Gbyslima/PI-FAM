<?php
include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $paciente = trim($_POST['paciente']);
    $data = trim($_POST['data']);   
    $horario = trim($_POST['horario']); 
    $observacao = trim($_POST['observacao']);
    $servico = trim($_POST['servico']);
    $profissional = trim($_POST['profissional']);

    if (empty($paciente) || empty($data) || empty($horario) || empty($servico) || empty($profissional)) {
        echo "<script>alert('Todos os campos são obrigatórios.'); history.back();</script>";
        exit;
    }

    if (isset($_POST['update'])) {
        // UPDATE
        $stmt = $conexao->prepare("UPDATE agendamentos2 SET paciente=?, data=?, hora=?, servico=?, profissional=?, observacao=? WHERE id=?");

        if (!$stmt) {
            echo "Erro na preparação da query: " . $conexao->error;
            exit;
        }

        $stmt->bind_param(" ", $paciente, $data, $horario, $servico, $profissional, $observacao, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Agendamento atualizado com sucesso!'); window.location.href='agenda.php';</script>";
        } else {
            echo "Erro ao atualizar agendamento: " . $stmt->error;
        }

        $stmt->close();

    } else {
        // INSERT
        $stmt = $conexao->prepare("INSERT INTO agendamentos2 (paciente, servico, profissional, data, hora, observacao) VALUES (?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            echo "Erro na preparação da query: " . $conexao->error;
            exit;
        }

        $stmt->bind_param("ssssss", $paciente, $servico, $profissional, $data, $horario, $observacao);

        if ($stmt->execute()) {
            echo "<script>alert('Agendamento salvo com sucesso!'); window.location.href='agenda.php';</script>";
        } else {
            echo "Erro ao salvar agendamento: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
