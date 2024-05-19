<?php
  session_start();
  // CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
  if($_SESSION['ra_aluno']){
  } else {
    header("Location: login.html");
  } 
  
  $strcon = mysqli_connect ("ac-smart-database.cha6yq8iwxxu.sa-east-1.rds.amazonaws.com", "felipe", "abcd=1234", "humanitae_db") or die ("Erro ao conectar com o banco");

  
  // $sql = "SELECT DISTINCT(titulo), cod_atividade FROM atividade_complementar JOIN observacao_atividade ON atividade_complementar.cod_atividade = observacao_atividade.cod_atividade WHERE RA_aluno = '".$_SESSION['ra_aluno']."' AND status = 'Reprovado';";
  $sql = "SELECT * FROM atividade_complementar WHERE status = 'Reprovado' AND RA_aluno = '".$_SESSION['ra_aluno']."';";

  $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="styles/atividades.css">
  <link rel="stylesheet" href="styles/global.css">
  <link rel="stylesheet" href="styles/styles-dashboard.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>


  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atividades Reprovadas</title>
</head>

<body>
  <?php include './components/sidebar.php' ?>


<div class="dashboard-content">
  <div class="breadcrumb">
    <a href="dashboard.php">Voltar para dashboard</a>
  </div>
  

  
  <div class="lista-atividades" id="reprovadas">
    <?php
      echo "<h2>Atividades Reprovadas: {$_SESSION['reprovadas']}</h2>";
    ?>
    <div style="display: flex; justify-content: space-between; font-weight: bold;">
      <span>Título</span>
      <span>Horas solicitadas</span>
    </div>

    <?php
      foreach($result as $row){
          echo '
          <form action="detalhes_reprovada.php" method="get">
            <button type="submit" class="container-atividade">
              <input type="hidden" value="'.$row["cod_atividade"].'" name="cod_atividade" id="cod_atividade">
              
              <input type="hidden" value="'.$row["titulo"].'" name="titulo" id="titulo">
              
              <input type="hidden" value="'.$row["descricao"].'" name="descricao" id="descricao">
              
              <input type="hidden" value="'.$row["caminho_anexo"].'" name="caminho_anexo" id="caminho_anexo">
              <input type="hidden" value="'.$row["horas_solicitadas"].'" name="horas_solicitadas" id="horas_solicitadas">
              <input type="hidden" value="'.$row["data"].'" name="data" id="data">
              <input type="hidden" value="'.$row["status"].'" name="status" id="status">
              <input type="hidden" value="'.$row["horas_solicitadas"].'" name="horas_aprovadas" id="horas_aprovadas">
                <span>'.$row["titulo"].'</span>

                <strong>'.$row["horas_solicitadas"].'H</strong>
              </button>
            </form>';      
      }
    ?>

    </div>    
    
    
  </div>
</body>
</html>
