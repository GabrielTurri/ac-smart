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
  $sql = "SELECT * FROM coordenador JOIN curso ON coordenador.cod_coordenador = curso.coordenador_curso WHERE cod_coordenador = '".$_SESSION['cod_coordenador']."'";
  $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");

  // query para fazer o contador de quantas atividades pendentes de cada curso o coordenador tem
  $sql2 = "SELECT * FROM coordenador JOIN curso ON coordenador.cod_coordenador = curso.coordenador_curso JOIN aluno ON curso.cod_curso = aluno.cod_curso JOIN atividade_complementar ON atividade_complementar.RA_aluno = aluno.RA_aluno WHERE cod_coordenador = '".$_SESSION['cod_coordenador']."'";
  $result2 = mysqli_query($strcon, $sql2) or die ("Erro ao tentar encontrar o aluno no banco!");
  
 
  // foreach para salvar no array associativo $_SESSION['cursos'] a quantidade de atividades pendentes o coordenador tem que avaliar daquele tal curso
  foreach($_SESSION['cursos'] as $curso => $quantidade){
    $quantidade = 0;
    foreach($result2 as $row){

      if($row['status'] == "Pendente" AND $row['nome_curso'] == $curso) {
        $quantidade +=1;
      }
    }
    $_SESSION['cursos'][$curso] = $quantidade;
    // $cuso[$quantidade] = ;
    // echo $curso . ": " . $quantidade . "<br>";
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <link rel="stylesheet" href="styles/global.css">

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
        <div class="dashboard-container">
          <div class="chart-container">
            
            <h2>Cursos ministrados:</h2>
            
            <!-- foreach para imprimir todos os cursos que o coordenador ministra, e as quantidades de atividades a serem avaliadas naquele curso -->
            <?php

              foreach($_SESSION['cursos'] as $curso =>$quantidade){
                echo '
                <form class="activityContainer button" action="../server/server.php" method="post">
                  <input type="hidden" value="'.$curso.'" name="nome_curso" id="cod_atividade">
                  <button type="submit" name="atividades_coord">
                   <p>'.$curso.': '.$quantidade.'</p>
                  </button>
                </form>'; 
                // echo $curso . ": " . $quantidade . "<br>";
              }
              ?>   
              
            </div>
        </div>
    </div>
    
  </body>
  </html>

  