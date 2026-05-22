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

$id = $_GET['codigo'] ?? '';

if (empty($id)) {
    die('ID não informado.');
}

/* ===== EXCLUIR USUÁRIO ===== */

if (isset($_POST['excluir'])) {

    $sqlExcluir = "DELETE FROM usuario WHERE codigo = ?";

    $consultaExcluir = $pdo->prepare($sqlExcluir);

    $consultaExcluir->execute([$id]);

    header("Location: listarUsuario.php");
    exit;
}

/* ===== BUSCAR DADOS ===== */

$sql = "SELECT * FROM usuario WHERE codigo = ?";

$consulta = $pdo->prepare($sql);

$consulta->execute([$id]);

$linha = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$linha) {
    die('Usuário não encontrado.');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Excluir Usuário</title>

<link rel="icon" href="img/headset_mic.ico">

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

        color: #d32f2f;
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

    .btn-excluir{

        background: #d32f2f !important;
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

    .alerta-exclusao{

        background:#ffebee;

        border:1px solid #ef9a9a;

        color:#c62828;

        padding:15px;

        border-radius:10px;

        margin-bottom:25px;

        font-size:14px;
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

                <i class="material-icons">delete</i>

                <h4>Excluir Usuário</h4>

            </div>

            <div class="info-id">

                Usuário #<?= htmlspecialchars($linha['codigo']) ?>

            </div>

        </div>

        <div class="alerta-exclusao">

            <strong>Atenção:</strong>
            esta ação removerá permanentemente o usuário do sistema.

        </div>

        <div class="subtitulo">

            Confira os dados abaixo antes de realizar a exclusão.

        </div>

        <form method="POST">

            <input type="hidden"
                   name="id"
                   value="<?= htmlspecialchars($linha['codigo']) ?>">

            <!-- LINHA 1 -->

            <div class="row">

                <div class="input-field col s12 m6">

                    <input type="text"
                           value="<?= htmlspecialchars($linha['nome']) ?>"
                           disabled>

                    <label class="active">
                        Nome Completo
                    </label>

                </div>

                <div class="input-field col s12 m6">

                    <input type="text"
                           value="<?= htmlspecialchars($linha['usuario']) ?>"
                           disabled>

                    <label class="active">
                        Usuário
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
                        <input type="checkbox"
                               <?= ($linha['create'] == 1) ? 'checked' : '' ?>
                               disabled />
                        <span>Create</span>
                    </label>
                </p>

                <p>
                    <label>
                        <input type="checkbox"
                               <?= ($linha['read'] == 1) ? 'checked' : '' ?>
                               disabled />
                        <span>Read</span>
                    </label>
                </p>

                <p>
                    <label>
                        <input type="checkbox"
                               <?= ($linha['update'] == 1) ? 'checked' : '' ?>
                               disabled />
                        <span>Update</span>
                    </label>
                </p>

                <p>
                    <label>
                        <input type="checkbox"
                               <?= ($linha['delete'] == 1) ? 'checked' : '' ?>
                               disabled />
                        <span>Delete</span>
                    </label>
                </p>

            </div>

            <!-- BOTÕES -->

            <div class="btn-acoes">

                <button type="submit"
                        name="excluir"
                        value="1"
                        class="btn-excluir waves-effect waves-light btn-small"
                        onclick="return confirm('Deseja realmente excluir este usuário?')" style="                    
                    height:40px;
                    line-height:40px;
                    border-radius:8px;
                    text-transform:none;
                    font-size:13px;
                    font-weight:500;
                ">

                    <i class="material-icons left">delete</i>

                    Excluir Usuário

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