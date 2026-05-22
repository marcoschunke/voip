<?php 
session_start();

if (!isset($_SESSION['usuario_codigo'])) {
    header("Location: index.php");
    exit;
}

$pagina = $_GET['pagina'] ?? '';

$usuarioNome = isset($_SESSION['usuario_nome']) ? htmlspecialchars($_SESSION['usuario_nome']) : 'Usuário';

require_once 'model/Conexao.php';

$pdo = getConexao();

$id = $_GET['id'] ?? '';

if (empty($id)) {
    die('ID não informado.');
}

/* ===== EXCLUIR ===== */

if (isset($_POST['excluir'])) {

    $sqlExcluir = "DELETE FROM ramais WHERE id = ?";

    $consultaExcluir = $pdo->prepare($sqlExcluir);

    $consultaExcluir->execute([$id]);

    header("Location: listar.php");
    exit;
}

/* ===== ALTERAR ===== */

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['excluir'])) {

    $raiz         = $_POST['raiz'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $divisao      = $_POST['divisao'] ?? '';
    $setor_sala   = $_POST['setor_sala'] ?? '';
    $nome         = $_POST['nome'] ?? '';
    $ramal        = $_POST['ramal'] ?? '';
    $equipamento  = $_POST['equipamento'] ?? '';
    $faixa        = $_POST['faixa'] ?? '';

    $sql = "
        UPDATE ramais
        SET
            raiz = ?,
            departamento = ?,
            divisao = ?,
            setor_sala = ?,
            nome = ?,
            ramal = ?,
            equipamento = ?,
            faixa = ?,
            data_atualizacao = NOW()
        WHERE id = ?
    ";

    $consulta = $pdo->prepare($sql);

    $consulta->execute([
        $raiz,
        $departamento,
        $divisao,
        $setor_sala,
        $nome,
        $ramal,
        $equipamento,
        $faixa,
        $id
    ]);

    header("Location: listar.php");
    exit;
}

/* ===== BUSCAR DADOS ===== */

$sql = "SELECT * FROM ramais WHERE id = ?";

$consulta = $pdo->prepare($sql);

$consulta->execute([$id]);

$linha = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$linha) {
    die('Registro não encontrado.');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Excluir Ramal</title>
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

    .select-wrapper input.select-dropdown:focus{
        border-bottom: 1px solid #000 !important;
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

    .btn-voltar{

        background: #fff !important;

        color: #111 !important;

        border: 1px solid #dcdcdc;
    }

    .btn-excluir{

        background: #d32f2f !important;
    }

    .datas{

        margin-top: 10px;

        background: #fafafa;

        border: 1px solid #ececec;

        border-radius: 10px;

        padding: 15px;
    }

    .datas strong{

        color: #111;
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

                <h4>Excluir Ramal</h4>

            </div>

            <div class="info-id">

                Registro <?= htmlspecialchars($linha['id']) ?>

            </div>

        </div>

        <div class="subtitulo">

            Excluir as informações do ramal abaixo.

        </div>

        <form method="POST">

            <input type="hidden"
                   name="id"
                   value="<?= htmlspecialchars($linha['id']) ?>">

            <!-- LINHA 1 -->

            <div class="row">

                <div class="input-field col s12 m4">

                    <input type="text"
                           name="raiz"
                           id="raiz"
                           value="<?= htmlspecialchars($linha['raiz']) ?>">

                    <label for="raiz" class="active">
                        Raiz
                    </label>

                </div>

                <div class="input-field col s12 m4">

                    <input type="text"
                           name="ramal"
                           id="ramal"
                           value="<?= htmlspecialchars($linha['ramal']) ?>">

                    <label for="ramal" class="active">
                        Ramal
                    </label>

                </div>

                <div class="input-field col s12 m4">

                    <input type="text"
                           name="faixa"
                           id="faixa"
                           value="<?= htmlspecialchars($linha['faixa']) ?>">

                    <label for="faixa" class="active">
                        Faixa
                    </label>

                </div>

            </div>

            <!-- LINHA 2 -->

            <div class="row">

                <div class="input-field col s12 m6">

                    <input type="text"
                           name="departamento"
                           id="departamento"
                           value="<?= htmlspecialchars($linha['departamento']) ?>">

                    <label for="departamento" class="active">
                        Departamento
                    </label>

                </div>

                <div class="input-field col s12 m6">

                    <input type="text"
                           name="divisao"
                           id="divisao"
                           value="<?= htmlspecialchars($linha['divisao']) ?>">

                    <label for="divisao" class="active">
                        Divisão
                    </label>

                </div>

            </div>

            <!-- LINHA 3 -->

            <div class="row">

                <div class="input-field col s12 m6">

                    <input type="text"
                           name="setor_sala"
                           id="setor_sala"
                           value="<?= htmlspecialchars($linha['setor_sala']) ?>">

                    <label for="setor_sala" class="active">
                        Setor / Sala
                    </label>

                </div>

                <div class="input-field col s12 m6">

                    <input type="text"
                           name="nome"
                           id="nome"
                           value="<?= htmlspecialchars($linha['nome']) ?>">

                    <label for="nome" class="active">
                        Nome
                    </label>

                </div>

            </div>

            <!-- LINHA 4 -->

            <div class="row">

                <div class="input-field col s12 m6">

                    <select name="equipamento" id="equipamento">

                        <option value="Aparelho Voip"
                            <?= ($linha['equipamento'] == 'Aparelho Voip') ? 'selected' : '' ?>>
                            Aparelho Voip
                        </option>

                        <option value="Via Fone"
                            <?= ($linha['equipamento'] == 'Via Fone') ? 'selected' : '' ?>>
                            Via Fone
                        </option>

                    </select>

                    <label>Equipamento</label>

                </div>

                <div class="input-field col s12 m6">
                
                <input type="text"
                name="servidores"
                id="servidores"
                value="<?= htmlspecialchars($linha['servidores']) ?>">

                    <label for="servidores">
                    Servidores
                    </label>

                </div>

            </div>

            <div class="status">

                <div class="row" style="margin-bottom:0;">

                    <div class="col s12 m6">

                    <label>
                        <input type="checkbox"
                               name="status" value="1"
                               <?= ($linha['status'] == 1) ? 'checked' : '' ?> />
                        <span>Status</span>
                    </label>
                    
                    </div>
                </div>
            </div>
            
            <!-- DATAS -->

            <div class="datas">

                <div class="row" style="margin-bottom:0;">

                    <div class="col s12 m6">

                        <strong>Data de Criação:</strong><br>

                        <?= htmlspecialchars($linha['data_criacao']) ?>

                    </div>

                    <div class="col s12 m6">

                        <strong>Última Atualização:</strong><br>

                        <?= htmlspecialchars($linha['data_atualizacao']) ?>

                    </div>

                </div>

            </div>

            <!-- BOTÕES -->

            <div class="btn-acoes">

                <button type="submit"
                        name="excluir"
                        value="1"
                        class="btn-excluir waves-effect waves-light btn-small"
                        onclick="return confirm('Deseja realmente excluir este registro?')" style="                    
                    height:40px;
                    line-height:40px;
                    border-radius:8px;
                    text-transform:none;
                    font-size:13px;
                    font-weight:500;
                ">

                    <i class="material-icons left">delete</i>

                    Excluir

                </button>

                <a href="listar.php" class="waves-effect waves-light btn-small black" style="                    
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

<script>

document.addEventListener('DOMContentLoaded', function() {

    var elems = document.querySelectorAll('select');

    M.FormSelect.init(elems);

});

</script>

</body>
</html>
```
