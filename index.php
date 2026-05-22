<?php
session_start();

// Se já estiver logado
if (isset($_SESSION['usuario_codigo'])) {
    header("Location: principal.php");
    exit;
}

// Mensagem de erro
$erro = $_GET['erro'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Autenticação — Sistema de Gerenciamento de Extensões VoIP</title>
<link rel="icon" href="img/headset_mic.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<!-- Materialize -->
<link rel="stylesheet" href="css/materialize.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    background: #f5f5f5;
}

.auth-wrapper { width: 100%; }

.auth-card {
    border-radius: 14px;
    overflow: hidden;
}

.brand {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: center;
    margin-bottom: 10px;
}

.brand .material-icons {
    font-size: 2.2rem;
}

.w-100 { width: 100%; }

.card-panel {
    border-radius: 10px;
}

.card.z-depth-3 {
    transition: transform .2s ease, box-shadow .2s ease;
}

.card.z-depth-3:hover {
    transform: translateY(-2px);
}

/* Botão */
.btn-dark {
    background: linear-gradient(135deg, #424242, #212121);
    border-radius: 8px;
}

.btn-dark:hover {
    background: #000;
}

/* Texto */
.text-black {
    color: #000 !important;
}

/* Inputs foco */
.input-field input:focus + label {
    color: #000 !important;
}

.input-field input:focus {
    border-bottom: 1px solid #000 !important;
    box-shadow: 0 1px 0 0 #000 !important;
}

/* Mostrar senha */
.show-toggle {
    cursor: pointer;
    user-select: none;
}

/* Erro */
.erro-box {
    background: #ffebee;
    color: #c62828;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}
</style>
</head>

<body>

<div class="container auth-wrapper">
    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3">

            <!-- CARD LOGIN -->
            <div class="card z-depth-3 auth-card">

                <div class="card-content">

                    <!-- LOGO / TÍTULO -->
                    <div class="brand">
                        <i class="material-icons text-black">lock</i>
                        <span class="card-title text-black">Autenticação</span>
                    </div>

                    <!-- ERRO -->
                    <?php if ($erro): ?>
                        <div class="erro-box">
                            Usuário ou senha inválidos
                        </div>
                    <?php endif; ?>

                    <!-- FORMULÁRIO -->
                    <form method="POST"
                          action="controller/LoginController.php"
                          autocomplete="off">

                        <!-- USUÁRIO -->
                        <div class="input-field">
                            <i class="material-icons prefix">account_circle</i>

                            <input id="usuario"
                                   type="text"
                                   name="usuario"
                                   required>

                            <label for="usuario">Usuário</label>
                        </div>

                        <!-- SENHA -->
                        <div class="input-field">
                            <i class="material-icons prefix">vpn_key</i>

                            <input id="senha"
                                   type="password"
                                   name="senha"
                                   required>

                            <label for="senha">Senha</label>

                            <!-- TOGGLE SENHA -->
                            <span class="helper-text show-toggle"
                                  onclick="
                                    const f = document.getElementById('senha');
                                    f.type = (f.type === 'password') ? 'text' : 'password';
                                  ">
                                <i class="material-icons tiny">visibility</i>
                                mostrar/ocultar
                            </span>

                        </div>

                        <!-- BOTÃO LOGIN -->
                        <button type="submit"
                                class="btn waves-effect waves-light btn-dark w-100"
                                id="btn-login">

                            Entrar
                            <i class="material-icons right">login</i>

                        </button>

                    </form>

                </div>
            </div>

            <!-- RODAPÉ -->
            <p class="center-align grey-text text-footer">
                <small>Sistema de Gerenciamento de Extensões VoIP</small>
            </p>

        </div>
    </div>
</div>

<script src="js/materialize.min.js"></script>

<script>
const form = document.querySelector('form');
const btn = document.getElementById('btn-login');

form.addEventListener('submit', function () {

    if (!form.checkValidity()) {
        return;
    }

});
</script>

</body>
</html>