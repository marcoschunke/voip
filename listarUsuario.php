<?php 
session_start();

if (!isset($_SESSION['usuario_codigo'])) {
    header("Location: index.php");
    exit;
}

$pagina = $_GET['pagina'] ?? '';

$usuarioNome = isset($_SESSION['usuario_nome']) 
    ? htmlspecialchars($_SESSION['usuario_nome']) 
    : 'Usuário';

require_once 'model/Conexao.php';

$filtro = $_GET['filtro'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="icon" href="img/headset_mic.ico">

<link rel="stylesheet" href="css/materialize.min.css">

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>

    body{
        background: #f4f4f4;
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
    }

    /* ===== CONTAINER ===== */

    .container-principal{
        width: 95%;
        max-width: 1200px;
        margin: 20px auto;
    }

    /* ===== TOPO ===== */

    .topo-sistema{

        display: flex;

        align-items: center;

        gap: 20px;

        background: white;

        padding: 20px;

        border-radius: 12px;

        box-shadow: 0 3px 12px rgba(0,0,0,0.08);

        margin-bottom: 20px;
    }

    .img-telefone{
        width: 90px;
        height: auto;
        flex-shrink: 0;
    }

    .texto-topo h5{
        margin: 0;
        line-height: 1.5;
        color: #222;
        font-weight: 600;
    }

    .texto-topo h5:last-child{
        color: #444;
        font-size: 1.6rem;
    }

    /* ===== BUSCA ===== */

    .card-busca{

        background: white;

        padding: 20px;

        border-radius: 12px;

        box-shadow: 0 3px 12px rgba(0,0,0,0.08);

        margin-bottom: 20px;
    }

    .btn-busca{

        width: 100%;

        height: 54px;

        border-radius: 8px;

        background: #111 !important;
    }

    .btn-busca:hover{
        background: #000 !important;
    }

    /* ===== TABELA ===== */

    .card-tabela{

        background: white;

        border-radius: 12px;

        overflow-x: auto;

        box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    }

    .tabela-ramais{
        min-width: 1000px;
    }

    /* ===== CABEÇALHO ===== */

    .tabela-ramais thead{

        background:
        linear-gradient(
            180deg,
            #3a3a3a 0%,
            #1f1f1f 20%,
            #111111 45%,
            #050505 70%,
            #2a2a2a 100%
        );

        border-bottom: 2px solid #555;

        box-shadow:
            inset 0 1px 0 rgba(255,255,255,0.18),
            inset 0 -1px 0 rgba(0,0,0,0.9),
            0 3px 10px rgba(0,0,0,0.45);
    }

    .tabela-ramais thead th{

        color: #f2f2f2;

        font-size: 12px;

        font-weight: 600;

        text-transform: uppercase;

        letter-spacing: 0.5px;

        padding: 10px;

        text-align: center;

        border-right: 1px solid rgba(255,255,255,0.05);
    }

    /* ===== LINHAS ===== */

    .tabela-ramais tbody tr:hover{
        background: rgba(0,0,0,0.04);
    }

    .tabela-ramais td{

        vertical-align: middle;

        text-align: center;

        padding: 8px;

        font-size: 12px;
    }

    .tabela-ramais td i.material-icons{
        vertical-align: middle;
    }

    .ramal-numero{

        font-size: 14px;

        color: #111;

        font-weight: normal;
    }

    .senha-mask{
        background:#f5f5f5;
        padding:4px 8px;
        border-radius:6px;
        font-size:12px;
        letter-spacing:1px;
        display:inline-block;
    }

    /* ===== BOTÕES ===== */

    .btn-acoes{

        display: flex;

        justify-content: center;

        gap: 8px;
    }

    .btn-small{

        height: 26px !important;

        line-height: 26px !important;

        padding: 0 8px !important;
    }

    .btn-small i{

        font-size: 16px !important;

        line-height: 26px !important;
    }

    /* ===== CONTADOR ===== */

    .contador-tabela{

        display: flex;

        align-items: center;

        justify-content: flex-end;

        gap: 8px;

        padding: 18px 20px;

        background: #fafafa;

        border-top: 1px solid #ddd;

        font-size: 15px;

        font-weight: 600;

        color: #333;
    }

    .contador-tabela strong{

        color: #000;

        font-size: 20px;
    }

    .contador-tabela i{
        color: #111;
    }

    /* ===== RESPONSIVIDADE ===== */

    @media screen and (max-width: 768px){

        .topo-sistema{

            flex-direction: column;

            text-align: center;
        }

        .img-telefone{
            width: 70px;
        }

        .texto-topo h5{
            font-size: 1.3rem;
        }

        .texto-topo h5:last-child{
            font-size: 1.2rem;
        }

        .card-busca{
            padding: 15px;
        }

        .btn-busca{
            margin-top: 10px;
        }

        .tabela-ramais{
            min-width: 100%;
        }

        .tabela-ramais thead th{

            font-size: 12px;

            padding: 10px;
        }

        .tabela-ramais td{

            font-size: 13px;

            padding: 10px;
        }

        .ramal-numero{
            font-size: 18px;
        }

        .contador-tabela{

            justify-content: center;

            text-align: center;

            font-size: 14px;

            padding: 14px;
        }

        .contador-tabela strong{
            font-size: 18px;
        }
    }

    /* CAMPO MAIS FINO */

    .campo-pesquisa input{

        height: 38px !important;

        margin-bottom: 0 !important;

        font-size: 14px !important;
    }

    .campo-pesquisa label{

        font-size: 14px !important;
    }

</style>

</head>

<body>

<div class="container-principal">

    <!-- TOPO -->

    <div class="topo-sistema">

        <img src="img/telephone-vintage.jpg"
             alt="Telefone Vintage"
             class="img-telefone">

        <div class="texto-topo">
            <h5>Secretaria da Agricultura, Pecuária, Produção Sustentável e Irrigação.</h5>
            <h5>Gerenciamento de Usuários.</h5>
        </div>

    </div>
        
    <div class="card-busca">

        <form method="GET">

            <div class="row" 
                 style="
                    margin-bottom:0;
                    display:flex;
                    align-items:center;
                    gap:10px;
                    flex-wrap:wrap;
                 ">

                <!-- BOTÃO CADASTRAR -->
                <div style="flex:1; min-width:170px;">

                    <a href="cadastrarUsuario.php" title="Cadastrar novo usuário"
                       class="btn waves-effect waves-light blue darken-2"
                       style="
                            width:100%;
                            height:40px;
                            line-height:40px;
                            border-radius:8px;
                            text-transform:none;
                            font-size:13px;
                            font-weight:500;
                       ">

                        <i class="material-icons left">person_add</i>

                        Cadastrar

                    </a>

                </div>

                <!-- CAMPO PESQUISA -->
                <div style="flex:3; min-width:250px;">

                    <div class="input-field campo-pesquisa"
                         style="margin:0;">

                        <input type="text"
                               name="filtro"
                               id="filtro"
                               value="<?= htmlspecialchars($filtro) ?>">

                        <label for="filtro" class="active">
                            Pesquisar usuário
                        </label>

                    </div>

                </div>

                <!-- BOTÃO PESQUISAR -->
                <div style="width:70px;">

                    <button type="submit" title="Pesquisar pelo nome do usuário"
                            class="btn waves-effect waves-light white black-text"
                            style="
                                width:100%;
                                height:40px;
                                line-height:40px;
                                border:1px solid #000;
                                border-radius:8px;
                            ">

                        <i class="material-icons">search</i>

                    </button>

                </div>

                <!-- BOTÃO VOLTAR -->
            <div style="flex:1; min-width:140px;">

                <a href="principal.php" title="Clique aqui para voltar a tela anterior"
                class="btn waves-effect waves-light black darken-2"
                style="
                    width:100%;
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

                <!-- BOTÃO SAIR -->
                <div style="flex:1; min-width:120px;">

                    <a href="logout.php" title="Sair do sistema"
                       class="btn waves-effect waves-light red darken-2"
                       style="
                            width:100%;
                            height:40px;
                            line-height:40px;
                            border-radius:8px;
                            text-transform:none;
                            font-size:13px;
                            font-weight:500;
                       ">

                        <i class="material-icons left">logout</i>

                        Sair

                    </a>

                </div>

            </div>

        </form>

    </div>

<?php

try {

    $pdo = getConexao();

    $sql = "
        SELECT 
            codigo,
            nome,
            usuario,
            senha,
            `create`,
            `read`,
            `update`,
            `delete`
        FROM usuario
    ";

    $params = [];

    if (!empty($filtro)) {

        $sql .= "
        WHERE
            CAST(codigo AS CHAR) LIKE ? OR
            nome LIKE ? OR
            usuario LIKE ?
        ";

        $valor = "%{$filtro}%";

        $params = array_fill(0, 3, $valor);
    }

    $sql .= " ORDER BY nome ASC";

    $consulta = $pdo->prepare($sql);

    $consulta->execute($params);

    $totalRegistros = $consulta->rowCount();

    if ($totalRegistros == 0) {

        echo '
        <div class="card-panel yellow lighten-4">
            Nenhum usuário encontrado.
        </div>';

    } else {

        echo '

        <div class="card-tabela">

            <table class="highlight responsive-table tabela-ramais">

                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Usuário</th>
                        <th>Senha</th>
                        <th>Create</th>
                        <th>Read</th>
                        <th>Update</th>
                        <th>Delete</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
        ';

        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {

            echo '<tr>';

            echo '
            <td>
                <strong class="ramal-numero">
                    ' . htmlspecialchars($linha['nome']) . '
                </strong>
            </td>';

            echo '
            <td>
                ' . htmlspecialchars($linha['usuario']) . '
            </td>';

            echo '
            <td>
                <span class="senha-mask">
                    ••••••••
                </span>
            </td>';

            echo '
            <td>
                <i class="material-icons ' . ($linha['create'] ? 'green-text' : 'red-text') . '">
                    ' . ($linha['create'] ? 'check_circle' : 'cancel') . '
                </i>
            </td>';

            echo '
            <td>
                <i class="material-icons ' . ($linha['read'] ? 'green-text' : 'red-text') . '">
                    ' . ($linha['read'] ? 'check_circle' : 'cancel') . '
                </i>
            </td>';

            echo '
            <td>
                <i class="material-icons ' . ($linha['update'] ? 'green-text' : 'red-text') . '">
                    ' . ($linha['update'] ? 'check_circle' : 'cancel') . '
                </i>
            </td>';

            echo '
            <td>
                <i class="material-icons ' . ($linha['delete'] ? 'green-text' : 'red-text') . '">
                    ' . ($linha['delete'] ? 'check_circle' : 'cancel') . '
                </i>
            </td>';

            echo '
            <td>

                <div class="btn-acoes">

                    <a href="alterarUsuario.php?codigo=' . $linha['codigo'] . '"
                       class="btn-small white waves-effect tooltipped"
                       data-position="top"
                       data-tooltip="Alterar"
                       style="border:1px solid #ccc;">

                        <i class="material-icons black-text">edit</i>

                    </a>

                    <a href="excluirUsuario.php?codigo=' . $linha['codigo'] . '"
                       class="btn-small white waves-effect tooltipped"
                       data-position="top"
                       data-tooltip="Excluir"
                       style="border:1px solid #ccc;"
                       onclick="return confirm(\'Deseja realmente excluir este usuário?\')">

                        <i class="material-icons black-text">delete</i>

                    </a>

                </div>

            </td>';

            echo '</tr>';
        }

        echo '

                </tbody>

            </table>

            <div class="contador-tabela">

                <i class="material-icons">group</i>

                Total de usuários encontrados:

                <strong>' . $totalRegistros . '</strong>

            </div>

        </div>';
    }

} catch (PDOException $e) {

    echo '
    <div class="card-panel red lighten-4">
        Erro: ' . htmlspecialchars($e->getMessage()) . '
    </div>';
}

?>

</div>

<script src="js/materialize.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var elems = document.querySelectorAll('.tooltipped');

    M.Tooltip.init(elems);

});
</script>

</body>
</html>