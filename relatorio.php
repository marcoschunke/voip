<?php 
session_start();

if (!isset($_SESSION['usuario_codigo'])) {
    header("Location: index.php");
    exit;
}

$usuarioNome = $_SESSION['usuario_nome'] ?? 'Usuário';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Relatórios - Sistema VoIP</title>

<link rel="icon" href="img/headset_mic.ico">

<link rel="stylesheet" href="css/materialize.min.css">

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>

    body{
        background: #f4f4f4;
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 0;
    }

    /* ===== TOPO ===== */

    .topo{

        background:
        linear-gradient(
            135deg,
            #1c1c1c,
            #000000
        );

        color: white;

        padding: 28px 20px;

        box-shadow: 0 4px 14px rgba(0,0,0,0.25);
    }

    .topo-conteudo{

        width: 95%;
        max-width: 1200px;

        margin: auto;

        display: flex;

        justify-content: space-between;

        align-items: center;

        flex-wrap: wrap;

        gap: 15px;
    }

    .topo-info{

        display: flex;

        align-items: center;

        gap: 18px;
    }

    .topo-info img{

        width: 70px;

        border-radius: 12px;

        background: white;

        padding: 8px;
    }

    .topo-texto h4{

        margin: 0;

        font-size: 28px;

        font-weight: bold;
    }

    .topo-texto p{

        margin: 6px 0 0;

        color: #d5d5d5;

        font-size: 15px;
    }

    .usuario-logado{

        background: rgba(255,255,255,0.08);

        padding: 12px 18px;

        border-radius: 10px;

        font-size: 14px;
    }

    /* ===== CONTAINER ===== */

    .container-relatorios{

        width: 95%;
        max-width: 1200px;

        margin: 35px auto;
    }

    /* ===== TÍTULOS ===== */

    .titulo-secao{

        margin-bottom: 20px;

        display: flex;

        align-items: center;

        gap: 10px;
    }

    .titulo-secao h5{

        margin: 0;

        font-weight: bold;

        color: #222;
    }

    .titulo-secao i{

        color: #111;
    }

    /* ===== GRID ===== */

    .grid-relatorios{

        display: grid;

        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));

        gap: 25px;

        margin-bottom: 35px;
    }

    /* ===== CARD ===== */

    .card-relatorio{

        background: white;

        border-radius: 18px;

        padding: 28px;

        box-shadow: 0 4px 18px rgba(0,0,0,0.08);

        transition: 0.3s;
    }

    .card-relatorio:hover{

        transform: translateY(-5px);

        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .icone-card{

        width: 75px;
        height: 75px;

        border-radius: 50%;

        display: flex;

        align-items: center;

        justify-content: center;

        margin-bottom: 20px;
    }

    .icone-card i{

        font-size: 38px;

        color: white;
    }

    .bg-excel{
        background: linear-gradient(135deg, #2e7d32, #1b5e20);
    }

    .bg-pdf{
        background: linear-gradient(135deg, #ef6c00, #e65100);
    }

    .card-relatorio h5{

        margin: 0 0 12px;

        font-weight: bold;

        color: #222;
    }

    .card-relatorio p{

        color: #666;

        line-height: 1.6;

        margin-bottom: 25px;
    }

    /* ===== BOTÕES ===== */

    .btn-relatorio{

        width: 100%;

        border-radius: 10px !important;

        text-transform: none !important;

        font-weight: 600;

        height: 45px;

        line-height: 45px;
    }

    .acoes-topo{

        margin-bottom: 25px;

        display: flex;

        justify-content: flex-end;
    }

    .btn-voltar{

        border-radius: 10px !important;

        text-transform: none !important;

        font-weight: 600;
    }

    /* ===== RODAPÉ ===== */

    .rodape{

        margin-top: 45px;

        text-align: center;

        color: #777;

        font-size: 14px;
    }

    /* ===== RESPONSIVO ===== */

    @media screen and (max-width: 768px){

        .topo-conteudo{

            flex-direction: column;

            align-items: flex-start;
        }

        .topo-info{

            flex-direction: column;

            align-items: flex-start;
        }

        .topo-texto h4{
            font-size: 24px;
        }

        .usuario-logado{
            width: 100%;
        }

        .acoes-topo{
            justify-content: center;
        }
    }

</style>

</head>

<body>

<!-- ===== TOPO ===== -->

<div class="topo">

    <div class="topo-conteudo">

        <div class="topo-info">

            <img src="img/telephone-vintage.jpg"
                 alt="VoIP">

            <div class="topo-texto">

                <h4>Central de Relatórios</h4>

                <p>
                    Exportação de dados do sistema VoIP e Usuários
                </p>

            </div>

        </div>

        <div class="usuario-logado">

            <i class="material-icons left">account_circle</i>

            Usuário Logado:
            <strong><?= htmlspecialchars($usuarioNome) ?></strong>

        </div>

    </div>

</div>

<!-- ===== CONTAINER ===== -->

<div class="container-relatorios">

    <!-- BOTÃO VOLTAR -->

    <div class="acoes-topo">

        <a href="principal.php"
           class="waves-effect waves-light btn black btn-voltar">

            <i class="material-icons left">arrow_back</i>

            Voltar ao Painel

        </a>

    </div>

    <!-- ===== RELATÓRIOS VOIP ===== -->

    <div class="titulo-secao">

        <i class="material-icons">dialpad</i>

        <h5>Relatórios Telefones VoIP</h5>

    </div>

    <div class="grid-relatorios">

        <!-- EXCEL VOIP -->

        <div class="card-relatorio">

            <div class="icone-card bg-excel">

                <i class="material-icons">table_view</i>

            </div>

            <h5>Exportar Telefones - Excel</h5>

            <p>
                Gere uma planilha Excel contendo os dados
                completos dos ramais e telefones VoIP cadastrados.
            </p>

            <a href="export/exportar_excel.php"
               class="waves-effect waves-light btn green darken-2 btn-relatorio">

                <i class="material-icons left">download</i>

                Baixar Excel

            </a>

        </div>

        <!-- PDF VOIP -->

        <div class="card-relatorio">

            <div class="icone-card bg-pdf">

                <i class="material-icons">picture_as_pdf</i>

            </div>

            <h5>Exportar Telefones - PDF</h5>

            <p>
                Gere um relatório PDF formatado contendo
                os dados dos telefones VoIP do sistema.
            </p>

            <a href="export/exportar_pdf.php"
               class="waves-effect waves-light btn orange darken-2 btn-relatorio">

                <i class="material-icons left">download</i>

                Baixar PDF

            </a>

        </div>

    </div>

    <!-- ===== RELATÓRIOS USUÁRIOS ===== -->

    <div class="titulo-secao">

        <i class="material-icons">people</i>

        <h5>Relatórios Usuários</h5>

    </div>

    <div class="grid-relatorios">

        <!-- EXCEL USUÁRIOS -->

        <div class="card-relatorio">

            <div class="icone-card bg-excel">

                <i class="material-icons">table_chart</i>

            </div>

            <h5>Exportar Usuários - Excel</h5>

            <p>
                Gere uma planilha Excel contendo os usuários,
                níveis de acesso e dados cadastrais do sistema.
            </p>

            <a href="export/exportar_usuario_excel.php"
               class="waves-effect waves-light btn green darken-2 btn-relatorio">

                <i class="material-icons left">download</i>

                Baixar Excel

            </a>

        </div>

        <!-- PDF USUÁRIOS -->

        <div class="card-relatorio">

            <div class="icone-card bg-pdf">

                <i class="material-icons">description</i>

            </div>

            <h5>Exportar Usuários - PDF</h5>

            <p>
                Gere um relatório PDF contendo informações
                dos usuários cadastrados no sistema.
            </p>

            <a href="export/exportar_usuario_pdf.php"
               class="waves-effect waves-light btn orange darken-2 btn-relatorio">

                <i class="material-icons left">download</i>

                Baixar PDF

            </a>

        </div>

    </div>

    <!-- ===== RODAPÉ ===== -->

    <div class="rodape">

        © <?= date('Y') ?> Sistema VoIP -
        Secretaria da Agricultura, Pecuária,
        Produção Sustentável e Irrigação.

    </div>

</div>

<script src="js/materialize.min.js"></script>

</body>
</html>