<?php 
session_start();

if (!isset($_SESSION['usuario_codigo'])) {
    header("Location: index.php");
    exit;
}

$pagina = $_GET['pagina'] ?? '';

$usuarioNome = isset($_SESSION['usuario_nome']) ? htmlspecialchars($_SESSION['usuario_nome']) : 'Usuário';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Sistema VoIP</title>

<link rel="icon" href="img/headset_mic.ico">

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<link rel="stylesheet" href="css/materialize.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
body { min-height: 100vh; }

nav { background-color: #424242; }

main { padding: 20px 0; }

#app-card {
  border-radius: 12px;
}

/* Loader */
.loader {
  display: none;
  height: 4px;
  background: #e0e0e0;
}
.loader.active { display: block; }
.loader .indeterminate { background: #212121; }

/* Conteúdo */
.view-wrapper {
  padding: 20px;
}

/* Cards dashboard */
.card.hoverable {
  border-radius: 12px;
  transition: 0.2s;
}
.card.hoverable:hover {
  transform: translateY(-4px);
}

.card-content i {
  margin-bottom: 10px;
}

/* Tabelas */
table thead {
  background: #424242;
  color: white;
}
</style>
</head>

<body class="grey lighten-4">

<!-- NAVBAR -->
<nav>
  <div class="nav-wrapper container">
    <a href="#" class="brand-logo">Sistema VoIP</a>

    <a href="#" data-target="mobile-menu" class="sidenav-trigger">
      <i class="material-icons">menu</i>
    </a>

    <ul class="right hide-on-med-and-down">

      <li>
        <a class="dropdown-trigger" href="#!" data-target="dropdown-cadastros">
          <i class="material-icons left">add_circle</i>Cadastros
        </a>
      </li>

      <li>
        <a class="dropdown-trigger" href="#!" data-target="dropdown-listagens">
          <i class="material-icons left">assignment</i>Listagens
        </a>
      </li>

      <li>
        <a href="logout.php">
          <i class="material-icons left">exit_to_app</i>Sair
        </a>
      </li>

    </ul>
  </div>
</nav>

<!-- DROPDOWNS -->
<ul id="dropdown-cadastros" class="dropdown-content">
  <li><a href="#!" data-load data-title="Cadastrar Usuário" data-url="view/cadastrarUsuario.php">Usuário</a></li>
  <li><a href="#!" data-load data-title="Cadastrar VoIP" data-url="view/cadastrarVoip.php">VoIP</a></li>
</ul>

<ul id="dropdown-listagens" class="dropdown-content">
  
  <li>
    <a href="#!" data-load data-title="Listar Usuários" data-url="view/listarUsuarios.php">
      <i class="material-icons left">people</i>Usuários
    </a>
  </li>

  <li>
    <a href="#!" data-load data-title="Listar VoIP" data-url="view/listarVoip.php">
      <i class="material-icons left">phone</i>VoIP
    </a>
  </li>

  <li class="divider"></li>

  <!-- EXPORTAÇÕES -->
  <li>
    <a href="export/voip_csv.php" target="_blank">
      <i class="material-icons left">table_view</i>Exportar CSV
    </a>
  </li>

  <li>
    <a href="export/voip_pdf.php" target="_blank">
      <i class="material-icons left">picture_as_pdf</i>Exportar PDF
    </a>
  </li>
</ul>

<!-- MOBILE -->
<ul class="sidenav" id="mobile-menu">
  <li class="subheader">Bem-vindo, <?= $usuarioNome; ?></li>

  <li class="divider"></li>
  <li><a href="#!" data-load data-title="Cadastrar Usuário" data-url="view/cadastrarUsuario.php">Usuário</a></li>
  <li><a href="#!" data-load data-title="Cadastrar VoIP" data-url="view/cadastrarVoip.php">VoIP</a></li>

  <li class="divider"></li>
  <li><a href="#!" data-load data-title="Listar Usuários" data-url="view/listarUsuarios.php">Usuários</a></li>
  <li><a href="#!" data-load data-title="Listar VoIP" data-url="view/listarVoip.php">VoIP</a></li>

  <li class="divider"></li>
  <li><a href="logout.php">Sair</a></li>
</ul>

<!-- CONTEÚDO -->
<main>
<div class="container">
<div id="app-card" class="card">

<!-- HEADER -->
<div class="card-content">
<h5 id="view-title">
  <i class="material-icons">dashboard</i>
  <span>Painel Inicial</span>
</h5>
</div>

<!-- LOADER -->
<div class="loader" id="app-loader">
  <div class="indeterminate"></div>
</div>

<!-- CONTEÚDO DINÂMICO -->
<div id="app-content">

<div class="view-wrapper">

<h5>Bem-vindo, <strong><?= $usuarioNome; ?></strong></h5>
<p class="grey-text">Escolha uma opção abaixo:</p>

<div class="row">

<!-- USUÁRIOS -->
<div class="col s12 m6 l3">
  <div class="card hoverable">
    <div class="card-content center">
      <i class="material-icons large grey-text">person</i>
      <h6>Usuários</h6>
    </div>
    <div class="card-action center">
      <a href="#!" data-load data-title="Listar Usuários" data-url="view/listarUsuarios.php">Listar</a>
      <a href="#!" data-load data-title="Cadastrar Usuário" data-url="view/cadastrarUsuario.php">Cadastrar</a>
    </div>
  </div>
</div>

<!-- VOIP -->
<div class="col s12 m6 l3">
  <div class="card hoverable">
    <div class="card-content center">
      <i class="material-icons large grey-text">phone</i>
      <h6>Ramais VoIP</h6>
    </div>
    <div class="card-action center">
      <a href="#!" data-load data-title="Listar VoIP" data-url="view/listarVoip.php">Listar</a>
      <a href="#!" data-load data-title="Cadastrar VoIP" data-url="view/cadastrarVoip.php">Cadastrar</a>
    </div>
  </div>
</div>

</div>

</div>

</div>
</div>
</div>
</main>

<!-- JS -->
<script src="js/materialize.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

  M.Sidenav.init(document.querySelectorAll('.sidenav'));

  M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'), {
    coverTrigger: false
  });

  // Clique dinâmico
  document.body.addEventListener('click', function(e) {
    const el = e.target.closest('[data-load]');
    if (!el) return;

    e.preventDefault();

    const url = el.getAttribute('data-url');
    const title = el.getAttribute('data-title');

    carregarView(url, title);
  });

});

// Loader
function setLoading(flag) {
  document.getElementById('app-loader').classList.toggle('active', flag);
}

// Carregar conteúdo
async function carregarView(url, title) {

  setLoading(true);

  try {
    const resp = await fetch(url);
    const html = await resp.text();

    document.getElementById('app-content').innerHTML =
      `<div class="view-wrapper">${html}</div>`;

    document.querySelector('#view-title span').textContent = title;

  } catch (e) {
    document.getElementById('app-content').innerHTML = `
      <div class="view-wrapper">
        <div class="card-panel red lighten-4">
          Erro ao carregar conteúdo
        </div>
      </div>`;
  }

  setLoading(false);
}
</script>

</body>
</html>