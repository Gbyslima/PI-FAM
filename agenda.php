<?php 
include_once('db.php');
$query = "SELECT * FROM agendamentos2 ORDER BY data DESC, hora DESC";
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
  <title>Agenda</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css">
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
    }
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
    .modal {
      display: none;
      position: fixed;
      z-index: 1001;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      position: relative;
    }
    .modal-content h2 {
      margin-bottom: 15px;
    }
    .modal-content input, .modal-content textarea {
      width: 100%;
      margin-bottom: 10px;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    .modal-content button {
      background: #6cb9ed;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 6px;
      cursor: pointer;
    }
    .close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background: none;
      border: none;
      font-size: 18px;
      cursor: pointer;
      color: #aaa;
    }
    #clock {
      font-size: 14px;
      margin-bottom: 10px;
    }
    #calendar {
      background: white;
      padding: 10px;
      border-radius: 10px;
      width: 100%;
      max-width: 400px;
      font-size: 12px;
    }
    .carousel-container {
      width: 100%;
      margin-bottom: 20px;
      border-radius: 20px;
    }
    .carousel {
      display: flex;
      transition: transform 0.6s ease-in-out;
      gap: 40px;
    }
    .card-agendamento {
      min-width: 520px;
      background: #b7deed;
      color: #000;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      gap: 6px;
      font-size: 14px;
      animation: fadeIn 0.5s ease;
    }
    .card-agendamento strong {
      font-size: 16px;
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

th:last-child,
td:last-child {
  text-align: center;
  width: 100px; /* coluna de ação mais estreita */
}
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
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
      <h1><strong>Especialista</strong> > <span>Agenda</span></h1>
<a href="login.html" class="close-button" title="Fechar página">
    <i data-lucide="x"></i>
  </a>
    </header>
    <div id="clock"></div>
    <div class="actions">
      <button onclick="openModal()">+ Adicionar Agendamento</button>
    </div>
    <div class="carousel-container">

    </div>
    <h2 style="margin-bottom: 10px;">Próximos Agendamentos</h2>
      <div class="carousel" id="carouselAgendamentos"></div>

    <div style="margin-top: 20px;; display: flex; gap: 20px; align-items: flex-start; flex-wrap: wrap;">
      <table id="agendaTable" style="flex: 2; min-width: 300px;">
         <thead>
          <thead>
            <tr>
              <th>Paciente</th>
              <th>Serviço</th>
              <th>Profissional</th>
              <th>Data/Hora</th>
              <th>Observação</th>
              <th>Ação</th>
            </tr>
          </thead>
    <tbody>
      <?php
    while ($user_data = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($user_data['paciente']) . "</td>";
    echo "<td>" . htmlspecialchars($user_data['servico']) . "</td>";
    echo "<td>" . htmlspecialchars($user_data['profissional']) . "</td>";
    $dataHoraOriginal = $user_data['data'] . ' ' . $user_data['hora'];
    $dataHoraFormatada = date('d/m/Y H:i', strtotime($dataHoraOriginal));

    echo "<td>" . htmlspecialchars($dataHoraFormatada) . "</td>";
    echo "<td>" . htmlspecialchars($user_data['observacao']) . "</td>";
    echo "<td>
        <a class='button edit' href='editaragenda.php?id=" . $user_data['id'] . "'><i data-lucide='pencil'></i></a>
        <a class='button delete' href='excluiragenda.php?id=" . $user_data['id'] . "'><i data-lucide='x'></i></a>
        </td>";
    echo "</tr>";
}
?>
    </tbody>
          
      </table>
      
    </div>
  </main>
  <div class="modal" id="agendaModal" role="dialog" aria-modal="true">
  <div class="modal-content">
    <button class="close-btn" onclick="fecharModal()">&times;</button>
    <h2>Novo Agendamento</h2>

    <form method="POST" action="agendamento.php">
      <input type="text" name="servico" id="servico" placeholder="Serviço" required>
      <input type="text" name="profissional" id="profissional" placeholder="Profissional" required>
      <input type="text" name="paciente" id="paciente" placeholder="Nome do paciente" required>
      <input type="date" name="data" id="data" required>
      <input type="time" name="horario" id="horario" required>
      <textarea name="observacao" id="observacao" rows="3" placeholder="Observações..."></textarea>
      
      <button type="submit">Salvar</button>
    </form>
  </div>
</div>

  </div>
  <script>
    lucide.createIcons();

    function atualizarRelogio() {
      const clock = document.getElementById('clock');
      const data = new Date().toLocaleString("pt-BR", { timeZone: "America/Sao_Paulo" });
      clock.innerHTML = "Horário de Brasília: " + data;
    }
    setInterval(atualizarRelogio, 1000);
    atualizarRelogio();

    const modal = document.getElementById("agendaModal");
    function openModal() {
      modal.style.display = "flex";
      document.getElementById("paciente").focus();
    }
    function fecharModal() {
      modal.style.display = "none";
    }
    window.onclick = function(event) {
      if (event.target == modal) fecharModal();
    }

    //const agendaTable = document.querySelector("#agendaTable tbody");
    //const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
     // initialView: 'dayGridMonth',
      //locale: 'pt-br',
     // timeZone: 'America/Sao_Paulo',
      //events: []
    //});
    //calendar.render();


    agendamentosIniciais.forEach(({ paciente, data, horario, observacao }) => {
      const novaLinha = agendaTable.insertRow();
      novaLinha.innerHTML = `<td>${paciente}</td><td>${data}</td><td>${horario}</td><td>${observacao}</td>`;
      calendar.addEvent({ title: paciente, start: data + 'T' + horario });
    });

    function adicionarAgendamento() {
      const paciente = document.getElementById("paciente").value;
      const data = document.getElementById("data").value;
      const horario = document.getElementById("horario").value;
      const observacao = document.getElementById("observacao").value;

      if (!paciente || !data || !horario) return alert("Preencha todos os campos obrigatórios.");

      const novaLinha = agendaTable.insertRow();
      novaLinha.innerHTML = `<td>${paciente}</td><td>${data}</td><td>${horario}</td><td>${observacao}</td>`;

      calendar.addEvent({ title: paciente, start: data + 'T' + horario });

      fecharModal();
      document.getElementById("paciente").value = "";
      document.getElementById("data").value = "";
      document.getElementById("horario").value = "";
      document.getElementById("observacao").value = "";
    }

    function obterProximosAgendamentos(lista) {
      const hoje = new Date();
      return lista
        .filter(a => new Date(a.data + 'T' + a.horario) >= hoje)
        .sort((a, b) => new Date(a.data + 'T' + a.horario) - new Date(b.data + 'T' + b.horario))
        .slice(0, 3);
    }

    function renderizarCarrossel(agendamentos) {
      const carousel = document.getElementById("carouselAgendamentos");
      carousel.innerHTML = "";

      agendamentos.forEach(({ Paciente, data, horario, observacao }) => {
        const card = document.createElement("div");
        card.className = "card-agendamento";
        card.innerHTML = `
          <strong>${Paciente}</strong>
          <span>🗓 ${data}</span>
          <span>⏰ ${horario}</span>
          <span>📋 ${observacao}</span>
        `;
        carousel.appendChild(card);
      });
    }

    const proximos3 = obterProximosAgendamentos(agendamentosIniciais);
    renderizarCarrossel(proximos3);

 
  </script>
</body>
</html>
