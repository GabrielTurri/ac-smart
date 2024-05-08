<?php
  session_start();
    // CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
  if($_SESSION['cod_coordenador']){
  } else {
    header("Location: login.html");
  } 

  // conexao com o banco de dados usando as credenciais do Felipe, qualquer integrante do grupo pode usar seu primeiro nome em minusculo como usuario, o resto mantém
  $strcon = mysqli_connect ("ac-smart-database.cha6yq8iwxxu.sa-east-1.rds.amazonaws.com", "felipe", "abcd=1234", "humanitae_db") or die ("Erro ao conectar com o banco");

  // para buscar as atividades daquele usuario logado e printar o titulo de todas as atividades que ele possui
  // da para fazer ifs para mostrar coisas que quiser, exemplo abaixo
  $sql = "SELECT * FROM curso JOIN disciplina ON curso.cod_curso = disciplina.cod_curso WHERE coordenador_curso = '".$_SESSION['cod_coordenador']."'";
  $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
  $rows = mysqli_fetch_array($result);

  print_r($rows);

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

  <title>Dashboard Coordenador</title>
</head>
<body>
  <aside class="sidebar">
    <div class="user-data text-center">
      <div class="user-photo"></div>
      <h3>Boas Vindas, <?php echo ucfirst($_SESSION['nome_coordenador']). " " .ucfirst($_SESSION['sobrenome_coordenador']) ?></h3>
    </div>
    <!-- para imprimir as informações do curso do aluno cadastrado -->
    <div class="user-info">
      <h3>Seus cursos:</h3>
      <?php echo "<p><b>Seu email:</b></p> <p> {$_SESSION['email_coordenador']}</p>"
      ?>
    </div>
    <form action="../server/server.php" method="post">
      <button type="submit" value="Encerrar Sessão" name="sair" id="sair">
        <!-- <img src="assets/icons/log-out-red.svg" alt=""> -->
        Encerrar Sessão
      </button>
    </form>
  </aside>
    <div class="dashboard-content">
      <div class="column">
        <div class="dashboardContainer">
          
    
          <div class="chartContainer">
            <a href="atividades.php" class="button">
              <button>
                <img 
                  src="assets/icons/file-text.svg" 
                  alt="Atividades Complementares"
                >
                Minhas AC'S
              </button>
            </a>
    
            <a href="entrega.php" class="button">
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
        
        
        
    </div>
    
  </body>
  </html>