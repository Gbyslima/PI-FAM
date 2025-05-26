<?php 
if (!empty($_GET['id'])) {
    include_once('db.php');

    $id = (int) $_GET['id']; 

    $sqlSelect = "SELECT * FROM servico WHERE id=$id";

    $result = $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {
      while($user_data = $result->fetch_assoc()) {
        $id = $user_data['id'];
        $nome = $user_data['nome'] ?? '';
        $descricao = $user_data['descricao'] ?? null;
        $preco = $user_data['preco'] ?? '';
        $duracao_min = $user_data['duracao_min'];
        $categoria = $user_data['categoria'];
      } 
    } else {
        header('Location: servicos.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Serviços - Editar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }
    body {
      display: flex;
      background: #f9f9f9;
      color: #333;
      min-height: 100vh;
    }
    aside {
      position: fixed;
      top: 0;
      left: 0;
      width: 220px;
      background: #b7deed;
      color: #fff;
      height: 100vh;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      border-right: 1px solid #eee;
    }
    aside img {
      width: 120px;
      margin-bottom: 20px;
    }
    aside h4 {
      margin-bottom: 30px;
      color: #000;
    }
    aside nav {
      width: 100%;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      gap: 8px;
      overflow-y: auto;
    }
    aside nav a {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px;
      border-radius: 10px;
      text-decoration: none;
      color: #000;
      font-weight: 600;
      font-size: 15px;
      transition: 0.3s;
    }
    aside nav a.active, aside nav a:hover {
      background: #6cb9ed;
      color: #fff;
    }
    main {
      flex: 1;
      margin-left: 220px;
      padding: 30px;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    header h1 {
      font-size: 18px;
      font-weight: 600;
    }
    header h1 span {
      color: #555;
      font-weight: 400;
    }
    .actions {
      margin-bottom: 20px;
    }
    .actions button {
      background: #6cb9ed;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }
    .actions button:hover {
      background: #5aa7d9;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      font-size: 14px;
    }
    th, td {
      padding: 12px 16px;
      border-bottom: 1px solid #eee;
      text-align: left;
      vertical-align: middle;
    }
    th {
      background: #f5f5f5;
    }
    th:last-child, td:last-child {
      text-align: center;
      width: 100px;
    }
    /* Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1001;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0,0,0,0.4);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: #fff;
      padding: 25px 30px;
      border-radius: 12px;
      width: 420px;
      position: relative;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .modal-content h2 {
      margin-bottom: 20px;
      font-weight: 700;
      font-size: 22px;
      color: #333;
    }
    .modal-content input, 
    .modal-content textarea {
      width: 100%;
      padding: 10px 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      resize: vertical;
    }
    .modal-content button {
      background: #6cb9ed;
      color: #fff;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    .modal-content button:hover {
      background: #5a9bd8;
    }
    .close-btn {
      position: absolute;
      top: 12px;
      right: 12px;
      font-size: 22px;
      border: none;
      background: transparent;
      cursor: pointer;
      color: #999;
      transition: color 0.3s ease;
    }
    .close-btn:hover {
      color: #333;
    }
    #clock {
      font-size: 14px;
      margin-bottom: 20px;
      color: #666;
    }
    <style>
  .form-container {
    background: white;
    padding: 20px 25px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    max-width: 600px;
  }
  .form-container h2 {
    margin-bottom: 15px;
    font-size: 18px;
    font-weight: 600;
    color: #333;
  }
  .form-container input,
  .form-container textarea {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
  }
  .form-container textarea {
    resize: vertical;
  }
  .form-container button {
    background: #6cb9ed;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s ease;
  }
  .form-container button:hover {
    background: #5aa7d9;
  }
    .button {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 12px;
  border-radius: 6px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  text-decoration: none;
  transition: background-color 0.3s ease, color 0.3s ease;
  user-select: none;
}

.button.edit {
  background-color: #b7deed; 
  color: #fff;
  border: none;
}

.button.edit:hover {
  background-color: #5aa7d9;
}

.button.delete {
  background-color: #f44336; /* vermelho */
  color: #fff;
  border: none;
}

.button.delete:hover {
  background-color: #d73727;
}

.button i {
  stroke-width: 2.5;
  width: 18px;
  height: 18px;
}
table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 12px 16px;
  border-bottom: 1px solid #eee;
  text-align: left;
  vertical-align: middle;
}
  </style>
</head>
<body>
  <aside>
    <img src="imagens/Doutora.png" alt="Dra. Ana" />
    <h4>Dra. Ana Pereira Melo</h4>
    <nav>
      <a href="dashboard.html"><i data-lucide="layout-dashboard"></i>Dashboard</a>
      <a href="insumos.php"><i data-lucide="package"></i>Insumos</a>
      <a href="pacientes.php"><i data-lucide="users"></i>Pacientes</a>
      <a href="agenda.php" class="active"><i data-lucide="calendar-days"></i>Agenda</a>
      <a href="servicos.php"><i data-lucide="list-collapse"></i>Serviços</a>
      <a href="ordemdeservico.html"><i data-lucide="clipboard-list"></i>Ordem de Serviço</a>
      <a href="profissional.html"><i data-lucide="user-check"></i>Profissional</a>
    </nav>
    <img src="imagens/clinica.png" alt="logo clínica" style="width: 70px; margin-top: 20px;" />
  </aside>

  <main>
    <header>
      <h1><strong>Editar</strong> <span></span></h1>
      <a href="login.html" class="close-button" title="Fechar página"><i data-lucide="x"></i></a>
    </header>

    <div id="clock"></div>

<div class="form-container">
  <h2>Editar</h2>
  <form action="dbservicos.php" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

    <input type="text" name="nome" placeholder="nome" value="<?php echo htmlspecialchars($nome); ?>" required>

    <input type="text" name="descricao" placeholder="descricao" value="<?php echo htmlspecialchars($descricao); ?>" required>

    <input type="number" name="preco" placeholder="preco" value="<?php echo htmlspecialchars($preco); ?>" required>

    <input type="number" name="duracao_min" id="duracao_min" value="<?php echo htmlspecialchars($duracao_min); ?>" required>

    <input type="text" name="categoria" id="categoria" value="<?php echo htmlspecialchars($categoria); ?>" required>


    <button type="submit" name="update">Salvar</button>
    <button type="button" onclick="window.location.href='servicos.php'">Voltar</button>
  </form>
</div>


<script>
  function updateClock() {
    const clockElement = document.getElementById('clock');
    const now = new Date();
    const formattedTime = now.toLocaleString('pt-BR');
    clockElement.textContent = formattedTime;
  }
  setInterval(updateClock, 1000);
  updateClock();

  lucide.createIcons();

</script>
</body>
</html>
