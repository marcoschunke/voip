<?php 
session_start();

if (!isset($_SESSION['usuario_codigo'])) {
    header("Location: index.php");
    exit;
}

$usuarioNome = isset($_SESSION['usuario_nome']) 
    ? htmlspecialchars($_SESSION['usuario_nome']) 
    : 'Usuário';

require_once 'model/Conexao.php';

$pdo = getConexao();

/* ===== CADASTRAR USUÁRIO ===== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome    = trim($_POST['nome'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $senha   = trim($_POST['senha'] ?? '');

    $create  = isset($_POST['create']) ? 1 : 0;
    $read    = isset($_POST['read']) ? 1 : 0;
    $update  = isset($_POST['update']) ? 1 : 0;
    $delete  = isset($_POST['delete']) ? 1 : 0;

    if (!empty($nome) && !empty($usuario) && !empty($senha)) {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "
            INSERT INTO usuario (
                nome,
                usuario,
                senha,
                `create`,
                `read`,
                `update`,
                `delete`
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?
            )
        ";

        $consulta = $pdo->prepare($sql);

        $consulta->execute([
            $nome,
            $usuario,
            $senhaHash,
            $create,
            $read,
            $update,
            $delete
        ]);

        header("Location: listarUsuario.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<link rel="icon" href="img/headset_mic.ico">

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Cadastrar Usuário</title>

<link rel="stylesheet" href="css/materialize.min.css">

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>

    body{
        background: #f5f5f5;
        font-family: Arial, Helvetica, sans-serif;
    }

    .container-form{

        width: 95%;
        max-width: 950px;

        margin: 35px auto;
    }

    .card-form{

        background: #fff;

        padding: 30px;

        border-radius: 14px;

        box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    }

    .topo-form{

        display: flex;

        align-items: center;

        justify-content: space-between;

        margin-bottom: 25px;

        border-bottom: 1px solid #ececec;

        padding-bottom: 15px;
    }

    .titulo{

        display: flex;

        align-items: center;

        gap: 10px;
    }

    .titulo h4{

        margin: 0;

        font-size: 28px;

        color: #222;
    }

    .titulo i{

        font-size: 32px;

        color: #000;
    }

    .info-id{

        background: #111;

        color: #fff;

        padding: 6px 14px;

        border-radius: 30px;

        font-size: 13px;

        font-weight: bold;
    }

    .subtitulo{

        margin-bottom: 25px;

        color: #666;

        font-size: 15px;
    }

    .input-field input:focus{

        border-bottom: 1px solid #000 !important;

        box-shadow: 0 1px 0 0 #000 !important;
    }

    .btn-acoes{

        margin-top: 30px;

        display: flex;

        gap: 12px;

        flex-wrap: wrap;
    }

    .btn{

        border-radius: 8px;

        text-transform: none;

        font-weight: 600;
    }

    .permissoes-box{

        background:#fafafa;

        border:1px solid #e0e0e0;

        border-radius:10px;

        padding:20px;

        margin-top:10px;
    }

    .permissoes-titulo{

        font-size:15px;

        font-weight:600;

        margin-bottom:15px;

        color:#333;
    }

    @media screen and (max-width: 768px){

        .card-form{
            padding: 20px;
        }

        .topo-form{

            flex-direction: column;

            align-items: flex-start;

            gap: 10px;
        }

        .titulo h4{
            font-size: 22px;
        }
    }

</style>

</head>

<body>

<div class="container-form">

    <div class="card-form">

        <!-- TOPO -->

        <div class="topo-form">

            <div class="titulo">

                <i class="material-icons">person_add</i>

                <h4>Cadastrar Usuário</h4>

            </div>

            <div class="info-id">

                Novo Usuário

            </div>

        </div>

        <div class="subtitulo">

            Preencha as informações abaixo para cadastrar um novo usuário do sistema.

        </div>

        <form method="POST">

            <!-- LINHA 1 -->

            <div class="row">

                <div class="input-field col s12 m6">

                    <input type="text"
                           name="nome"
                           id="nome"
                           required>

                    <label for="nome">
                        Nome Completo
                    </label>

                </div>

                <div class="input-field col s12 m6">

                    <input type="text"
                           name="usuario"
                           id="usuario"
                           required>

                    <label for="usuario">
                        Usuário
                    </label>

                </div>

            </div>

            <!-- LINHA 2 -->

            <div class="row">

                <div class="input-field col s12">

                    <input type="password"
                           name="senha"
                           id="senha"
                           required>

                    <label for="senha">
                        Senha
                    </label>

                </div>

            </div>

            <!-- PERMISSÕES -->

            <div class="permissoes-box">

                <div class="permissoes-titulo">

                    Permissões do Usuário

                </div>

                <p>
                    <label>
                        <input type="checkbox" name="create" />
                        <span>Create</span>
                    </label>
                </p>

                <p>
                    <label>
                        <input type="checkbox" name="read" checked />
                        <span>Read</span>
                    </label>
                </p>

                <p>
                    <label>
                        <input type="checkbox" name="update" />
                        <span>Update</span>
                    </label>
                </p>

                <p>
                    <label>
                        <input type="checkbox" name="delete" />
                        <span>Delete</span>
                    </label>
                </p>

            </div>

            <!-- BOTÕES -->

            <div class="btn-acoes">

                <button type="submit"
                        class="waves-effect waves-light btn-small blue darken-2" style="                    
                    height:40px;
                    line-height:40px;
                    border-radius:8px;
                    text-transform:none;
                    font-size:13px;
                    font-weight:500;
                ">

                    <i class="material-icons left">save</i>

                    Cadastrar

                </button>

                <a href="listarUsuario.php"
                   class="waves-effect waves-light btn-small black" style="                    
                    height:40px;
                    line-height:40px;
                    border-radius:8px;
                    text-transform:none;
                    font-size:13px;
                    font-weight:500;
                ">

                    <i class="material-icons left">arrow_back</i>

                    Voltar

                </a>

            </div>

        </form>

    </div>

</div>

<script src="js/materialize.min.js"></script>

</body>
</html>