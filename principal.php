<?php 
session_start();

if (!isset($_SESSION['usuario_codigo'])) {
    header("Location: index.php");
    exit;
}

/* ===== DADOS USUÁRIO LOGADO ===== */

$usuarioNome = $_SESSION['usuario_nome'] ?? 'Usuário';

$usuarioEmail = $_SESSION['usuario_email'] ?? '';

$usuarioNivel = $_SESSION['usuario_nivel'] ?? 'Administrador';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Painel Administrativo - VoIP</title>

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

        padding: 30px 20px;

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

        gap: 20px;
    }

    .topo-info{

        display: flex;

        align-items: center;

        gap: 18px;
    }

    .topo-info img{

        width: 75px;

        border-radius: 12px;

        background: white;

        padding: 8px;
    }

    .topo-texto h4{

        margin: 0;

        font-size: 30px;

        font-weight: bold;
    }

    .topo-texto p{

        margin: 5px 0 0;

        color: #d5d5d5;

        font-size: 15px;
    }

    /* ===== USUÁRIO ===== */

    .usuario-box{

        background: rgba(255,255,255,0.08);

        border: 1px solid rgba(255,255,255,0.08);

        padding: 16px 18px;

        border-radius: 14px;

        min-width: 290px;

        backdrop-filter: blur(4px);
    }

    .usuario-topo{

        display: flex;

        align-items: center;

        gap: 12px;

        margin-bottom: 10px;
    }

    .avatar-usuario{

        width: 52px;

        height: 52px;

        border-radius: 50%;

        background: rgba(255,255,255,0.12);

        display: flex;

        align-items: center;

        justify-content: center;
    }

    .avatar-usuario i{

        font-size: 34px;

        color: #fff;
    }

    .usuario-info h6{

        margin: 0;

        font-size: 16px;

        font-weight: bold;

        color: #fff;
    }

    .usuario-info span{

        font-size: 13px;

        color: #d7d7d7;
    }

    .usuario-email{

        font-size: 13px;

        color: #e0e0e0;

        margin-top: 4px;

        word-break: break-word;
    }

    .usuario-acoes{

        margin-top: 15px;

        display: flex;

        gap: 10px;

        flex-wrap: wrap;
    }

    .btn-topo{

        border-radius: 8px !important;

        text-transform: none !important;

        font-size: 13px;

        font-weight: 600;
    }

    /* ===== CONTAINER ===== */

    .container-dashboard{

        width: 95%;
        max-width: 1200px;

        margin: 35px auto;
    }

    /* ===== CARDS ===== */

    .grid-cards{

        display: grid;

        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));

        gap: 25px;
    }

    .card-menu{

        background: white;

        border-radius: 18px;

        padding: 30px;

        box-shadow: 0 4px 18px rgba(0,0,0,0.08);

        transition: 0.3s;
    }

    .card-menu:hover{

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

        font-size: 40px;

        color: white;
    }

    .bg-voip{
        background: linear-gradient(135deg, #1565c0, #0d47a1);
    }

    .bg-user{
        background: linear-gradient(135deg, #2e7d32, #1b5e20);
    }

    .bg-relatorio{
        background: linear-gradient(135deg, #ef6c00, #e65100);
    }

    .card-menu h5{

        margin: 0 0 10px;

        font-weight: bold;

        color: #222;
    }

    .card-menu p{

        color: #666;

        line-height: 1.6;

        margin-bottom: 25px;
    }

    .btn-dashboard{

        width: 100%;

        border-radius: 10px !important;

        text-transform: none !important;

        font-weight: 600;

        height: 45px;

        line-height: 45px;
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

        .usuario-box{
            width: 100%;
        }

        .usuario-acoes{
            flex-direction: column;
        }

        .usuario-acoes .btn{
            width: 100%;
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

                <h4>Painel Administrativo</h4>

                <p>
                    Sistema de Gerenciamento de Telefones VoIP e Usuários
                </p>

                <p>
                    DTIC - Divisão de Tecnologia da Informação e Comunicação
                </p>

            </div>

        </div>

        <!-- ===== USUÁRIO LOGADO ===== -->

        <div class="usuario-box">

            <div class="usuario-topo">

                <div class="avatar-usuario">

                    <i class="material-icons">account_circle</i>

                </div>

                <div class="usuario-info">

                    <h6>
                        <?= htmlspecialchars($usuarioNome) ?>
                    </h6>

                    <span>
                        <?= htmlspecialchars($usuarioNivel) ?>
                    </span>

                    <a href="logout.php" class="btn red darken-2 waves-effect waves-light btn-topo">

                    <i class="material-icons left">logout</i>

                    Sair

                </a>

                </div>

            </div>

            <?php if (!empty($usuarioEmail)) : ?>

                <div class="usuario-email">

                    <i class="material-icons tiny">email</i>

                    <?= htmlspecialchars($usuarioEmail) ?>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<!-- ===== DASHBOARD ===== -->

<div class="container-dashboard">

    <div class="grid-cards">

        <!-- CARD TELEFONES -->

        <div class="card-menu">

            <div class="icone-card bg-voip">

                <i class="material-icons">phone</i>

            </div>

            <h5>Telefones VoIP</h5>

            <p>
                Gerencie os ramais telefônicos, equipamentos VoIP,
                departamentos, setores e informações de contato.
            </p>

            <a href="listar.php"
               class="waves-effect waves-light btn blue darken-2 btn-dashboard">

                <i class="material-icons left">dialpad</i>

                Acessar Telefones

            </a>

        </div>

        <!-- CARD USUÁRIOS -->

        <div class="card-menu">

            <div class="icone-card bg-user">

                <i class="material-icons">people</i>

            </div>

            <h5>Usuários</h5>

            <p>
                Controle os usuários do sistema, permissões de acesso,
                níveis administrativos e autenticação.
            </p>

            <a href="listarUsuario.php"
               class="waves-effect waves-light btn green darken-2 btn-dashboard">

                <i class="material-icons left">manage_accounts</i>

                Gerenciar Usuários

            </a>

        </div>

        <!-- CARD RELATÓRIOS -->

        <div class="card-menu">

            <div class="icone-card bg-relatorio">

                <i class="material-icons">assessment</i>

            </div>

            <h5>Relatórios</h5>

            <p>
                Exporte relatórios em PDF e Excel contendo dados
                de usuários e telefones VoIP do sistema.
            </p>

            <a href="relatorio.php"
               class="waves-effect waves-light btn orange darken-2 btn-dashboard">

                <i class="material-icons left">picture_as_pdf</i>

                Acessar Relatórios

            </a>

        </div>

    </div>

    <!-- RODAPÉ -->

    <div class="rodape">

        © <?= date('Y') ?> Sistema VoIP -
        Secretaria da Agricultura, Pecuária,
        Produção Sustentável e Irrigação.

    </div>

</div>

<script src="js/materialize.min.js"></script>

</body>
</html>