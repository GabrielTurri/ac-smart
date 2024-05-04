<?php
  session_start();
    // CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
  if($_SESSION['ra_aluno'] or $_SESSION['cod_coordenador']){
  } else {
    header("Location: login.html");
  } 

// conexao com o banco de dados usando as credenciais do Felipe, qualquer integrante do grupo pode usar seu primeiro nome em minusculo como usuario, o resto mantém
  $strcon = mysqli_connect ("ac-smart-database.cha6yq8iwxxu.sa-east-1.rds.amazonaws.com", "felipe", "abcd=1234", "humanitae_db") or die ("Erro ao conectar com o banco");

  // para buscar as atividades daquele usuario logado e printar o titulo de todas as atividades que ele possui
  // da para fazer ifs para mostrar coisas que quiser, exemplo abaixo
  $sql = "SELECT * FROM atividade_complementar WHERE RA_aluno = '".$_SESSION['ra_aluno']."'";
  $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
  
  foreach($result as $row){
    if($row["horas_aprovadas"] == 0) {  
      echo "{$row["titulo"]}<br>";
    }
  }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <link rel="stylesheet" href="styles/global.css">
  <link rel="stylesheet" href="styles/styles-dashboard.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>

  <title>Dashboard</title>
</head>
<body>
    <div class="appHeader">
      <img src="assets/icons/menu.svg" alt="">
      <form action="../server/server.php" method="post">
        <input type="submit" value="sair" name="sair" id="sair">
      </form>
    </div>

    <div class="dashboardContainer">
      <div class="chartContainer">

        <div class="chartContent">
          <div class="chartImg"></div>
          <h1>45/200 Horas</h1>
          <div>
            <div>
              <div class="chartLegendOrange"></div>
              <span>Entregues</span>
            </div>

            <div>
              <div class="chartLegend"></div>
              <span>Restantes</span>
            </div>
          </div>
        </div>
      </div>

      <div class="chartContainer">
        <a href="activities.html" class="button">
          <button>
            <img 
              src="assets/icons/file-text.svg" 
              alt="Atividades Complementares"
            >
            Minhas AC'S
          </button>
        </a>

        <a href="entrega.html" class="button">
          <button class="button">
            <img 
              src="assets/icons/file-plus.svg" 
              alt="Atividades Complementares"
            >
            Entregar AC'S
          </button>
        </a>

        <a href="" class="button">
          <button class="button">
            <img 
              src="assets/icons/corner-down-left.svg" 
              alt="Atividades Complementares"
            >
            AC'S Reprovadas
          </button>
        </a>
      </div>
    </div>
    
    
</body>
</html>