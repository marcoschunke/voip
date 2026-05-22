<?php 
require_once 'model/Conexao.php';

$filtro = $_GET['filtro'] ?? '';
?>

<link rel="icon" href="img/headset_mic.ico">
<link rel="stylesheet" href="css/materialize.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="container">

  <h5>Pesquisa de Ramais</h5>

  <!-- 🔎 BUSCA -->
  <form method="GET">
    <div class="row">
      
      <div class="input-field col s12 m10">        
        <input type="text" name="filtro" id="filtro" value="<?= htmlspecialchars($filtro) ?>">
        <label for="filtro" class="active">Digite para pesquisar</label>
      </div>

      <div class="col s12 m2">
        <button type="submit" class="btn waves-effect waves-light">
          <i class="material-icons">search</i>
        </button>
      </div>

    </div>
  </form>

<?php
try {
    $pdo = getConexao();

    $sql = "SELECT * FROM ramais";
    $params = [];

    if (!empty($filtro)) {
        $sql .= "
        WHERE 
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

    $sql .= " ORDER BY nome ASC";

    $consulta = $pdo->prepare($sql);
    $consulta->execute($params);

    if ($consulta->rowCount() == 0) {

        echo '<div class="card-panel yellow lighten-4">
                Nenhum resultado encontrado.
              </div>';

    } else {

        echo '<table class="highlight striped responsive-table">';
        echo '<thead class="grey darken-2 white-text">
                <tr>
                  <th>Raiz</th>
                  <th>Departamento</th>
                  <th>Divisão</th>
                  <th>Setor</th>
                  <th>Local</th>
                  <th>Ramal</th>
                  <th>Equipamento</th>
                </tr>
              </thead>
              <tbody>';

        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($linha['raiz']) . '</td>';
            echo '<td>' . htmlspecialchars($linha['departamento']) . '</td>';
            echo '<td>' . htmlspecialchars($linha['divisao']) . '</td>';
            echo '<td>' . htmlspecialchars($linha['setor_sala']) . '</td>';
            echo '<td>' . htmlspecialchars($linha['nome']) . '</td>';
            echo '<td><strong>' . htmlspecialchars($linha['ramal']) . '</strong></td>';
            echo '<td>' . htmlspecialchars($linha['equipamento']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    }

} catch (PDOException $e) {

    echo '<div class="card-panel red lighten-4">
            Erro: ' . htmlspecialchars($e->getMessage()) . '
          </div>';
}
?>

</div>