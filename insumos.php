<?php 
include_once('db.php');
$query = "SELECT * FROM insumo ORDER BY validade DESC";
$result = mysqli_query($conexao, $query);

if (!$result) {
    echo "Erro na consulta: " . mysqli_error($conexao);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Insumos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }
    body {
      display: flex;
      background: #f9f9f9;
      color: #333;
    }
    aside {
      position: fixed;
      top: 0;
      left: 0;
      width: 220px;
      background: #b7deed;
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
      gap: 6px;
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
      color: #000;
      font-size: 15px;
      transition: 0.3s;
    }
    aside nav a.active {
      background: #6cb9ed;
      font-weight: bold;
      color: #fff;
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
      color: #6cb9ed;
      cursor: pointer;
      padding: 6px;
      border-radius: 6px;
      transition: background 0.2s, color 0.2s;
      font-size: 20px;
    }
    .close-button:hover {
      background: #b7deed;
      color: #fff;
    }
    main {
      flex: 1;
      padding: 30px;
      margin-left: 220px;
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
    .filter-bar {
      margin: 20px 0;
      display: flex;
      gap: 10px;
      align-items: center;
    }
    .filter-bar input, .filter-bar select {
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      flex: 1;
    }
    .filter-bar button {
      background: #6cb9ed;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      color: #fff;
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
      text-align: left;
      border-bottom: 1px solid #f0f0f0;
    }
    th {
      background: #f5f5f5;
    }
    .status-vazio { color: red; font-weight: bold; }
    .status-alerta { color: #f5a623; font-weight: bold; }
    .status-cheio { color: #00b894; font-weight: bold; }
    .popup {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 2000;
    }
    .popup-content {
      background: white;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .popup-content input, .popup-content select {
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    .popup-content button {
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
    }
    .btn-primary { background: #00b894; color: white; }
    .btn-secondary { background: #ccc; color: black; }
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
      <h1><span>Insumos</span></h1>
        <a href="login.html" class="close-button" title="Fechar página">
      <i data-lucide="x"></i>
  </a>
    </header>

    <div class="filter-bar">
      <input type="text" id="searchInput" placeholder="Procurar insumos" onkeyup="filterTable()" />
      <select>
        <option>Hoje</option>
        <option>Semana</option>
      </select>
      <button onclick="openPopup()">+ Adicionar Insumo</button>
    </div>

    <table id="insumosTable">
      <thead>
        <tr>
          <th>Insumos</th>
          <th>Tipo</th>
          <th>Validade</th>
          <th>Quantidade</th>
          <th>Unidade de medida</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
     <tbody>
      <?php
    while ($user_data = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($user_data['nome']) . "</td>";
    echo "<td>" . htmlspecialchars($user_data['tipo']) . "</td>";
    $dataHoraOriginal = $user_data['validade'];
    $dataHoraFormatada = date('d/m/Y', strtotime($dataHoraOriginal));

    echo "<td>" . htmlspecialchars($dataHoraFormatada) . "</td>";
    echo "<td>" . htmlspecialchars($user_data['quantidade_estoque']) . "</td>";
    echo "<td>" . htmlspecialchars($user_data['unidade_medida']) . "</td>";
     echo "<td>" . htmlspecialchars($user_data['status']) . "</td>";
     echo "<td>
        <a class='button edit' href='editarinsumo.php?id=" . $user_data['id'] . "'><i data-lucide='pencil'></i></a>
        <a class='button delete' href='excluirinsumo.php?id=" . $user_data['id'] . "'><i data-lucide='x'></i></a>
        </td>";
    echo "</tr>";
}
?>
    </tbody>

    </table>
  </main>

  <div class="popup" id="popup" style="display:none;">
  <div class="popup-content">
    <form method="POST" action="dbinsumos.php" style="display: contents;">
      <input type="text" id="nome" name="nome" placeholder="Nome do insumo" required />
      <input type="text" id="tipo" name="tipo" placeholder="Tipo" required />
        <input type="text" id="quantidade_estoque" name="quantidade_estoque" placeholder="Quantidade" required />
        <input type="date" id="validade" name="validade" required />
        <input type="text" id="unidade_medida" name="unidade_medida" placeholder="Unidade de Medida" required />

        <select id="status" name="status" required>
          <option value="">Selecione</option>
          <option value="Vazio">Vazio</option>
          <option value="Alerta">Alerta</option>
          <option value="Cheio">Cheio</option>
        </select>


      <div style="display:flex; gap:10px; margin-top:10px;">
        <button type="submit" class="btn-primary">Salvar</button>
        <button type="button" class="btn-secondary" onclick="fecharPopup()">Cancelar</button>
      </div>
    </form>
  </div>
</div>

  <script>
    let editandoLinha = null;
    firebase.auth().onAuthStateChanged(user => {
    if (!user) {
        window.location.href = "../../login.html";
    }
})

    function filterTable() {
      const input = document.getElementById("searchInput");
      const filter = input.value.toLowerCase();
      const table = document.getElementById("insumosTable");
      const tr = table.getElementsByTagName("tr");
      for (let i = 1; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          const txtValue = td.textContent || td.innerText;
          tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
        }
      }
    }

    function openPopup() {
      document.getElementById('popup').style.display = 'flex';
    }

    function closePopup() {
      document.getElementById('popup').style.display = 'none';
      editandoLinha = null;
      document.getElementById("nomeInsumo").value = "";
      document.getElementById("tipoInsumo").value = "";
      document.getElementById("validadeInsumo").value = "";
      document.getElementById("quantidade").value = "";
      document.getElementById("unidademedida").value = "";
      document.getElementById("statusInsumo").value = "status-vazio";
    }

    function saveInsumo() {
      const nome = document.getElementById("nomeInsumo").value;
      const tipo = document.getElementById("tipoInsumo").value;
      const validade = document.getElementById("validadeInsumo").value;
      const quantidade = document.getElementById("quantidadeInsumo").value;
      const unidademedida = document.getElementById("unidademedida").value;
      const statusSelect = document.getElementById("statusInsumo");
      const statusValue = statusSelect.value;
      const statusText = statusSelect.options[statusSelect.selectedIndex].text;
      const validadeFormatada = new Date(validade).toLocaleDateString('pt-BR');

      if (editandoLinha) {
        editandoLinha.cells[1].textContent = nome;
        editandoLinha.cells[2].textContent = tipo;
        editandoLinha.cells[3].textContent = validadeFormatada;
        editandoLinha.cells[4].textContent = quantidadeInsumo;
        editandoLinha.cells[5].textContent = unidademedida;
        editandoLinha.cells[6].className = statusValue;
        editandoLinha.cells[6].textContent = statusText;
      } else {
        const table = document.getElementById("insumosTable").getElementsByTagName('tbody')[0];
        const rowIndex = table.rows.length + 1;
        const row = table.insertRow();
        row.innerHTML = `
          <td>${rowIndex}</td>
          <td>${nome}</td>
          <td>${tipo}</td>
          <td>${validadeFormatada}</td>
           <td>${quantidadeInsumo}</td>
            <td>${unidademedida}</td>
          <td class="${statusValue}">${statusText}</td>
          <td>
            <button onclick="editRow(this)">Editar</button>
            <button onclick="deleteRow(this)">Excluir</button>
          </td>
        `;
      }

      closePopup();
    }

    function editRow(button) {
      const row = button.closest("tr");
      editandoLinha = row;

      document.getElementById("nomeInsumo").value = row.cells[1].textContent;
      document.getElementById("tipoInsumo").value = row.cells[2].textContent;

      const [dia, mes, ano] = row.cells[3].textContent.split('/');
      const validadeISO = `${ano}-${mes.padStart(2, '0')}-${dia.padStart(2, '0')}`;
      document.getElementById("validadeInsumo").value = validadeISO;

      document.getElementById("quantidadeInsumo").value = row.cells[4].textContent;
      document.getElementById("unidademedida").value = row.cells[5].textContent;

      document.getElementById("statusInsumo").value = row.cells[6].className;

      openPopup();
    }

    function deleteRow(button) {
      const row = button.closest("tr");
      row.remove();
    }

    
  lucide.createIcons();

  </script>
</body>
</html>