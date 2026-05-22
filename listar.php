<?php 
session_start();

if (!isset($_SESSION['usuario_codigo'])) {
    header("Location: index.php");
    exit;
}

$pagina = $_GET['pagina'] ?? '';

$usuarioNome = isset($_SESSION['usuario_nome']) ? htmlspecialchars($_SESSION['usuario_nome']) : 'Usuário';

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
        min-width: 650px;
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

        .ramal-numero{

        font-size: 14px;

        color: #111;

        font-weight: normal;
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

        /* BOTÃO MAIS FINO */

        .btn-busca{

        height: 38px !important;

        line-height: 38px !important;

        padding: 0 14px !important;

        border-radius: 6px !important;

        margin-top: 12px;
        }

        .btn-busca i{

        font-size: 20px !important;

        line-height: 38px !important;
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
                <h5>Pesquisa de Ramais.</h5>
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

                <a href="cadastrar.php" title="Clique aqui para cadastrar"
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

                    <i class="material-icons left">add</i>

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
                        Digite para pesquisar
                    </label>

                </div>

            </div>

            <!-- BOTÃO PESQUISAR -->
            <div style="width:70px;">

                <button type="submit" title="Clique aqui para pesquisar"
                        class="btn waves-effect waves-light white black-text"
                        style="
                            width:100%;
                            height:40px;
                            line-height:40px;
                            border:1px solid #000;
                            border-radius:8px;
                            text-transform:none;
                            font-size:13px;
                            font-weight:500;
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

            <!-- BOTÃO BAIXAR EXCEL -->
            <div style="flex:1; min-width:140px;">

            <a href="export/exportar_excel.php" title="Clique aqui para baixar em excel"
            class="btn waves-effect waves-light green darken-2"
            style="
                    width:100%;
                    height:40px;
                    line-height:40px;
                    border-radius:8px;
                    text-transform:none;
                    font-size:13px;
                    font-weight:500;
            ">

                <i class="material-icons left">table_view</i>Baixar Excel</a>

            </div>

            <!-- BOTÃO BAIXAR PDF -->
            <div style="flex:1; min-width:140px;">

            <a href="export/exportar_pdf.php" title="Clique aqui para baixar pdf"
            class="btn waves-effect waves-light orange darken-2"
            style="
                    width:100%;
                    height:40px;
                    line-height:40px;
                    border-radius:8px;
                    text-transform:none;
                    font-size:13px;
                    font-weight:500;
            ">

                <i class="material-icons left">picture_as_pdf</i>Baixar PDF</a>

            </div>

            <!-- BOTÃO SAIR -->
            <div style="flex:1; min-width:120px;">

                <a href="logout.php" title="Clique aqui para sair"
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

    $sql = "SELECT  ";
    $sql .= "ramal, ";
    $sql .= "status, ";
    $sql .= "MAX(id) AS id, ";
    $sql .= "MAX(raiz) AS raiz, ";
    $sql .= "MAX(departamento) AS departamento, ";
    $sql .= "MAX(divisao) AS divisao, ";
    $sql .= "MAX(setor_sala) AS setor_sala, ";
    $sql .= "MAX(nome) AS nome, ";
    $sql .= "MAX(equipamento) AS equipamento, ";
    $sql .= "MAX(data_criacao) AS data_criacao, ";
    $sql .= "MAX(data_atualizacao) AS data_atualizacao, ";
    $sql .= "MAX(faixa) AS faixa, ";
    $sql .= "MAX(servidores) AS servidores ";    
    $sql .= "FROM ramais ";
    $sql .= "WHERE status IN (0,1) ";

    $params = [];

    if (!empty($filtro)) {

        $sql .= "
        AND
            CAST(id AS CHAR) LIKE ? OR
            raiz LIKE ? OR
            departamento LIKE ? OR
            divisao LIKE ? OR
            setor_sala LIKE ? OR
            nome LIKE ? OR
            CAST(ramal AS CHAR) LIKE ? OR
            equipamento LIKE ?
        
        ";

        $valor = "%{$filtro}%";

        $params = array_fill(0, 8, $valor);
    }
    
    $sql .= " GROUP BY ramal, status ";
    $sql .= " ORDER BY nome ASC ";
    
    //echo $sql;

    $consulta = $pdo->prepare($sql);

    $consulta->execute($params);

    $totalRegistros = $consulta->rowCount();

    if ($totalRegistros == 0) {

        echo '
        <div class="card-panel yellow lighten-4">
            Nenhum resultado encontrado.
        </div>';

    } else {

        echo '

        <div class="card-tabela">

            <table class="highlight responsive-table tabela-ramais">

                <thead>
                    <tr>
                        <th>Setor</th>
                        <th>Telefone / Ramal</th>
                        <th>Equipamento</th>
                        <th>Faixa</th>
                        <th>Status</th>
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
                <strong class="ramal-numero">
                    ' . htmlspecialchars($linha['ramal']) . '
                </strong>
            </td>';

            if ($linha['equipamento'] == "Aparelho Voip") {

                echo '
                <td>
                    <a href="#"
                    onclick="window.open(
                            \'https://voip-seapi.pro.intra.rs.gov.br/\',
                            \'voip\',
                            \'width=1200,height=800,resizable=yes,scrollbars=yes\'
                        ); return false;">
                        <i class="material-icons">local_phone</i>
                        Aparelho Voip
                    </a>
                </td>';

            } else {

                echo '
                <td>
                    <a href="#"
                    onclick="window.open(
                            \'https://voip-seapi.pro.intra.rs.gov.br/\',
                            \'voip\',
                            \'width=1200,height=800,resizable=yes,scrollbars=yes\'
                        ); return false;">
                        <i class="material-icons">headset_mic</i>
                        Fone de ouvido
                    </a>
                </td>';
            }

            echo '
            <td>
                <strong class="ramal-numero">
                    ' . htmlspecialchars($linha['faixa']) . '
                </strong>
            </td>';            

            echo '
            <td>
                <i class="material-icons ' . ($linha['status'] ? 'green-text' : 'red-text') . '">
                    ' . ($linha['status'] ? 'check_circle' : 'cancel') . '
                </i>
            </td>';

            echo '
                <td>

                    <div class="btn-acoes">

                        <!-- BOTÃO ALTERAR -->
                        <a href="alterar.php?id=' . $linha['id'] . '"
                        class="btn-small white waves-effect tooltipped"
                        data-position="top"
                        data-tooltip="Alterar"
                        style="border:1px solid #ccc;">

                            <i class="material-icons black-text">edit</i>

                        </a>

                        <!-- BOTÃO EXCLUIR -->
                        <a href="excluir.php?id=' . $linha['id'] . '"
                        class="btn-small white waves-effect tooltipped"
                        data-position="top"
                        data-tooltip="Excluir"
                        style="border:1px solid #ccc;"
                        onclick="return confirm(\'Deseja realmente excluir este ramal?\')">

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

                <i class="material-icons">dialpad</i>

                Total de ramais encontrados:

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