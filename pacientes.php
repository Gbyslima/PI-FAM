<?php 
include_once('db.php');
$query = "SELECT * FROM paciente ORDER BY nome DESC";
$result = mysqli_query($conexao, $query);

if (!$result) {
    echo "Erro na consulta: " . mysqli_error($conexao);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Pacientes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
    body { display: flex; background: #f9f9f9; color: #333; }
    aside {
  position: fixed;
  top: 0;
  left: 0;
  width: 220px;
  background: #b7deed; /* Azul da identidade visual */
  color: #fff;
  height: 100vh;
  border-right: 1px solid #eee;
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;

}

aside img {
  width: 60px;
  margin-bottom: 10px;
}

aside .profile {
  text-align: center;
  margin-top: 10px;
}

aside .profile img {
  width: 90px;
  border-radius: 50%;
  margin-bottom: 10px;
}

aside nav {
  width: 100%;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  gap: 6px; /* controla o espaçamento entre os links */
  overflow-y: auto;
  padding-top: 20px;
}

aside nav a {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px;
  margin-bottom: 8px;
  border-radius: 10px;
  text-decoration: none;
  color: #000; /* azul */
  font-size: 15px;
  transition: 0.3s;
}

aside nav a.active {
  background: #6cb9ed;
  font-weight: bold;
  color: #fff; /* branco */
}

aside .footer-img {
  width: 70px;
  margin-top: 10px;
}


aside h4 {
  color: #000;
  margin-bottom: 30px;
}

.close-button {
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;
  border: none;
  color: #6cb9ed; /* Cor azul da identidade visual */
  cursor: pointer;
  padding: 6px;
  border-radius: 6px;
  transition: background 0.2s, color 0.2s;
  font-size: 20px;
}

.close-button:hover {
  background: #b7deed; /* Fundo suave no hover */
  color: #fff;
}
    main { flex: 1; padding: 30px; margin-left: 220px; }
    header {
      display: flex; justify-content: space-between;
      align-items: center; margin-bottom: 30px;
    }
    header h1 { font-size: 18px; font-weight: 600; }
    header h1 span { color: #555; font-weight: 400; }
    .filter-bar {
      margin: 20px 0; display: flex; gap: 10px; align-items: center;
    }
    .filter-bar input, .filter-bar select {
      padding: 8px; border-radius: 6px; border: 1px solid #ccc; flex: 1;
    }
    .filter-bar button {
      background: #6cb9ed; border: none; padding: 8px 16px;
      border-radius: 6px; cursor: pointer; font-weight: bold;
      color: #fff;
    }
    table {
      width: 100%; border-collapse: collapse; background: white;
      border-radius: 8px; overflow: hidden; font-size: 14px;
    }
    th, td {
      padding: 12px 16px; text-align: left; border-bottom: 1px solid #f0f0f0;
    }
    th { background: #f5f5f5; }
    .popup {
      position: fixed; top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.5);
      display: flex; align-items: center; justify-content: center;
      z-index: 2000;
    }
    .popup-content {
      background: white; padding: 20px; border-radius: 10px;
      width: 400px; display: flex; flex-direction: column; gap: 10px;
    }
    .popup-content input, .popup-content select {
      padding: 8px; border-radius: 6px; border: 1px solid #ccc;
    }
    .popup-content button {
      padding: 10px; border: none; border-radius: 6px; font-weight: bold;
    }
    .btn-primary { background: #00b894; color: white; }
    .btn-secondary { background: #ccc; color: black; }
    .actions button {
      margin-right: 5px; background: none; border: none; cursor: pointer;
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
  </style>
</head>
<body>
<aside class="sidebar">
  <img src="imagens/Doutora.png" alt="Dra. Ana" style="margin-top: 1px; width: 120px; height: auto;" />
  <h4>Dra. Ana Pereira Melo</h4>

 <nav>
      <a href="dashboard.html"><i data-lucide="layout-dashboard"></i>Dashboard</a>
      <a href="insumos.php"><i data-lucide="package"></i>Insumos</a>
      <a href="pacientes.php"><i data-lucide="users"></i>Pacientes</a>
      <a href="agenda.php" class="active"><i data-lucide="calendar-days"></i>Agenda</a>
      <a href="servicos.php"><i data-lucide="list-collapse"></i>Serviços</a>
      <a href="ordemdeservico.php"><i data-lucide="clipboard-list"></i>Ordem de Serviço</a>
      <a href="profissional.php"><i data-lucide="user-check"></i>Profissional</a>
    </nav>
  
  <img src="imagens/clinica.png" alt="logo" class="footer-img" />
</aside>
  <main>
    <header>
      <h1><span>Pacientes</span></h1>
<a href="login.html" class="close-button" title="Fechar página">
    <i data-lucide="x">Sair</i>
  </a>
    </header>

    <div class="filter-bar">
      <input type="text" id="searchInput" placeholder="Procurar pacientes" onkeyup="filterTable()">
      <select>
        <option>Hoje</option>
        <option>Semana</option>
      </select>
      <button onclick="openPopup()">+ Adicionar Paciente</button>
    </div>

    <table id="pacientesTable">
      <thead>
        <tr>
          <th>Nome</th>
          <th>CPF</th>
          <th>Email</th>
          <th>Data de Nascimento</th>
          <th>Telefone</th>
          <th>Tipo</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
      <?php
    while ($user_data = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($user_data['nome']) . "</td>";
    echo "<td>" . htmlspecialchars($user_data['cpf']) . "</td>";
    echo "<td>" . htmlspecialchars($user_data['email']) . "</td>";
    $dataHoraOriginal = $user_data['data_nascimento'];
    $dataHoraFormatada = date('d/m/Y');

    echo "<td>" . htmlspecialchars($dataHoraFormatada) . "</td>";
    echo "<td>" . htmlspecialchars($user_data['telefone']) . "</td>";
    echo "<td>" . htmlspecialchars($user_data['tipo']) . "</td>";
    echo "<td>
        <a class='button edit' href='editarpaciente.php?id=" . $user_data['id'] . "'><i data-lucide='pencil'></i></a>
        <a class='button delete' href='excluirpaciente.php?id=" . $user_data['id'] . "'><i data-lucide='x'></i></a>
        </td>";
    echo "</tr>";
}
?>
    </tbody>
    </table>
  </main>

  <div class="popup" id="popup" style="display:none;">
    <div class="popup-content">
       <form method="POST" action="dbpacientes.php" style="display: contents;" >
      <input type="text" id="nome" placeholder="Nome">
      <input type="text" id="cpf" placeholder="CPF">
      <input type="email" id="email" placeholder="Email">
      <input type="date" id="data_nascimento" placeholder="nacimento">
      <input type="text" id="tipo" placeholder="Tipo">
      <input type="tel" id="telefone" placeholder="Telefone">
      <div style="display:flex; gap:10px;">
        <button class="btn-primary" onclick="salvarPaciente()">Salvar</button>
        <button type="button" class="btn-secondary" onclick="fecharPopup()">Cancelar</button>

      </div>
    </form>
    </div>
  </div>

  <script>
    let editandoLinha = null;

    function openPopup() {
      document.getElementById('popup').style.display = 'flex';
    }

    function fecharPopup() {
      document.getElementById('popup').style.display = 'none';
      document.querySelectorAll('.popup-content input').forEach(input => input.value = '');
      editandoLinha = null;
    }

    function salvarPaciente() {
      const nome = document.getElementById('nome').value;
      const id = document.getElementById('cpf').value;
      const email = document.getElementById('email').value;
      const idade = document.getElementById('datanasc').value;
      const tipo = document.getElementById('tipo').value;
      const tel = document.getElementById('telefone').value;
      const tabela = document.getElementById('pacientesTable').getElementsByTagName('tbody')[0];

      if (editandoLinha) {
        editandoLinha.cells[1].innerText = nome;
        editandoLinha.cells[2].innerText = cpf;
        editandoLinha.cells[3].innerText = email;
        editandoLinha.cells[4].innerText = datanasc;
        editandoLinha.cells[5].innerText = tel;
         editandoLinha.cells[6].innerText = tipo;
      } else {
        const linha = tabela.insertRow();
        linha.innerHTML = `
          <td>${tabela.rows.length}</td>
          <td>${nome}</td>
          <td>${cpf}</td>
          <td>${email}</td>
          <td>${datanasc}</td>
          <td>${tel}</td>
          <td>${tipo}</td>
          <td class="actions">
            <button onclick="editarPaciente(this)"><i data-lucide='edit'></i></button>
            <button onclick="excluirPaciente(this)"><i data-lucide='trash'></i></button>
          </td>`;
        lucide.createIcons();
      }

      fecharPopup();
    }

    function editarPaciente(botao) {
      const linha = botao.closest('tr');
      editandoLinha = linha;
      document.getElementById('nome').value = linha.cells[1].innerText;
      document.getElementById('cpf').value = linha.cells[2].innerText;
      document.getElementById('emailPaciente').value = linha.cells[3].innerText;
      document.getElementById('idadePaciente').value = linha.cells[4].innerText;
      document.getElementById('telpaciente').value = linha.cells[5].innerText;
      document.getElementById('tipoPaciente').value = linha.cells[6].innerText;
      openPopup();
    }

    function excluirPaciente(botao) {
      const linha = botao.closest('tr');
      linha.remove();
    }

    function filterTable() {
      const filtro = document.getElementById("searchInput").value.toLowerCase();
      const linhas = document.getElementById("pacientesTable").getElementsByTagName("tbody")[0].rows;
      for (let i = 0; i < linhas.length; i++) {
        const nome = linhas[i].cells[1].textContent.toLowerCase();
        linhas[i].style.display = nome.includes(filtro) ? "" : "none";
      }
    }

    lucide.createIcons();
  function mascaraCPF(cpf) {
    cpf.value = cpf.value
      .replace(/\D/g, '')
      .replace(/(\d{3})(\d)/, '$1.$2')
      .replace(/(\d{3})(\d)/, '$1.$2')
      .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
  }

  function mascaraTelefone(tel) {
    tel.value = tel.value
      .replace(/\D/g, '')
      .replace(/^(\d{2})(\d)/g, '($1) $2')
      .replace(/(\d)(\d{4})$/, '$1-$2');
  }

  document.getElementById('cpf').addEventListener('input', function() {
    mascaraCPF(this);
  });

  document.getElementById('telefone').addEventListener('input', function() {
    mascaraTelefone(this);
  });
  </script>
</body>
</html>
