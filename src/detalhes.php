<?php
session_start();
// CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
if($_SESSION['ra_aluno']){
} else {
header("Location: login.html");
} 

$strcon = mysqli_connect ("ac-smart-database.cha6yq8iwxxu.sa-east-1.rds.amazonaws.com", "felipe", "abcd=1234", "humanitae_db") or die ("Erro ao conectar com o banco");

// pegar a ultima observação feita pelo professor 
$sql = "SELECT * FROM observacao_atividade WHERE cod_atividade = ".$_GET['cod_atividade']." ORDER BY observacao DESC
LIMIT 1;";

$result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
$observacao = '';
foreach($result as $row){
  $observacao = $row['observacao'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="styles/atividades.css">
  <link rel="stylesheet" href="styles/global.css">
  <link rel="stylesheet" href="styles/styles-dashboard.css">
  <link rel="stylesheet" href="styles/detalhes.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>


  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalhes Atividades</title>
</head>

<body>
  <?php include('components/sidebar.php') ?>

    <div class="dashboard-content">
    <div class="breadcrumb">
        <a href="dashboard.php">Dashboard</a>
        <span>/</span>
        <a href="atividades.php" class="button">Atividades</a>
    </div>

    <div class='detalhes-container'>
      <h2 class="text-center">Detalhes da Atividade</h2>
      <div class='column campo'>
        <strong>Título:</strong>
        <?php echo "
          <input type='text' value='{$_GET["titulo"]}' disabled>
        ";?>
        
      </div>
      <div class='column campo'>
        <strong>Descrição:</strong>
        <textarea disabled><?php echo $_GET["descricao"];?></textarea>
      </div>
      <div class='column campo'>
        <strong>Anexo:</strong>
        <div class='anexo'>
          <?php echo "<a href='../server{$_GET["caminho_anexo"]}' download>Link para o anexo</a>"; ?>
        </div>
      </div>
      <div class='column campo'>
        <div class="row">
          <div class="column">
            <strong>Horas 
              <?php 
                echo $_GET["status"] == "Aprovado" ?  'Aprovadas:' : 'Solicitadas:';
              ?>
            </strong>
            <?php 
              echo "
                <input type='text' value='{$_GET["horas_solicitadas"]}H' disabled>
              ";
            ?>
          </div>
          <div class="column">
            <strong>Data de conclusão da atividade:</strong>
            <?php echo "
              <input type='text' value='{$_GET["data"]}' disabled>
            ";?>
          </div>
        </div>
      </div>
      <?php
      if ($_GET["status"] == "Aprovado") {
        echo "
          <div class='column status aprovado'>
            <strong>Status Atividade:</strong>
            <span>Aprovado</span>
          </div>
        ";
      } else {
        if ($_GET["status"] == "Pendente") {
          echo '
            <div class="column status pendente">
              <strong>Status Atividade:</strong>
              <span>Pendente</span>
            </div>
            ';
          }
          else if ($_GET["status"] == "Reprovado") {
            echo "
            <div class='column status reprovado'>
            <strong>Status Atividade:</strong>
            <span>Reprovado</span>
            </div>
            <label for='obs-coord'>Observação do coordenador ".ucfirst($_SESSION['nome_coordenador']).":</label>
            
            <textarea name='obs-coord' disabled>{$observacao}</textarea>
            ";
          }
          echo '
          <!-- BOTÃO EDITAR -->
          
          <div class="row center"> 
            <form action="edicao.php" method="get">
              <input type="hidden" value="'.$_GET["cod_atividade"].'" name="cod_atividade" id="cod_atividade">
              <input type="hidden" value="'.$_GET["titulo"].'" name="titulo" id="titulo">
              <input type="hidden" value="'.$_GET["descricao"].'" name="descricao" id="descricao">
              <input type="hidden" value="'.$_GET["caminho_anexo"].'" name="caminho_anexo" id="caminho_anexo">
              <input type="hidden" value="'.$_GET["horas_solicitadas"].'" name="horas_solicitadas" id="horas_solicitadas">
              <input type="hidden" value="'.$_GET["data"].'" name="data" id="data">
              <button type="submit" name="editar" id="editar" class="btn laranja">
                Editar
              </button>
            </form>
              <button class="btn vermelho">Cancelar Entrega</button>
          </div>
        ';
      } ?>
      


    </div>

   

        
    </div>
</body>
</html>

