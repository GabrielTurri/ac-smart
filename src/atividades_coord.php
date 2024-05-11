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
  // $rows = mysqli_fetch_array($result);


  // query para buscar as atividades que o coordenador deve avaliar
  $sql2 = "SELECT * FROM atividade_complementar INNER JOIN aluno ON atividade_complementar.RA_aluno = aluno.RA_aluno INNER JOIN curso ON aluno.cod_curso = curso.cod_curso WHERE nome_curso = '".$_SESSION['nome_curso']."' AND status = 'Pendente';"; 

  // Executar a query sql2
  mysqli_query($strcon, $sql2) or die ("Erro ao tentar inserir atividade");
  $result = mysqli_query($strcon, $sql2) or die ("Erro ao tentar inserir atividade");

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
      <?php echo "<p><b>Seu email:</b></p> <p> {$_SESSION['email_coordenador']}</p>"
      ?>
    </div>
    <form action="../server/server.php" method="post">
      
      <a href="dash_coordenador.php" class="button">Voltar para cursos</a>
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
            
            <h2>Atividades disponíveis para avaliação:</h2>
            
            <?php
              // vai mostrar uma mensagem caso não tenha atividades para avaliar
              if($result->num_rows < 1){
                echo "Sem atividades para avaliar";
              } else {
                foreach($result as $row){
                  if($row['status'] == "Pendente"){
                    echo '
                    <div class="activityContainer">
                      <form class="'.$row['status'].'" action="detalhe_atividade_coord.php" method="get">

                        <input type="hidden" value="'.$row["nome_aluno"].'" name="nome_aluno" id="nome_aluno">
                        <input type="hidden" value="'.$row["RA_aluno"].'" name="RA_aluno" id="RA_aluno">
                        <input type="hidden" value="'.$row["cod_atividade"].'" name="cod_atividade" id="cod_atividade">
                        <input type="hidden" value="'.$row["titulo"].'" name="titulo" id="titulo">
                        <input type="hidden" value="'.$row["descricao"].'" name="descricao" id="descricao">
                        <input type="hidden" value="'.$row["caminho_anexo"].'" name="caminho_anexo" id="caminho_anexo">
                        <input type="hidden" value="'.$row["horas_solicitadas"].'" name="horas_solicitadas" id="horas_solicitadas">
                        <input type="hidden" value="'.$row["data"].'" name="data" id="data">
                        
                        <button type="submit">
                          <p>'.$row["titulo"].'</p>
                          <span>'.$row["horas_solicitadas"].'H</span>
                          <span>'.$row["status"].'</span>
                        </button>
                      </form>
                    </div>';      
                  }
                }
                  
              }
              ?>  
    <?php
      
    ?> 
              
            </div>

        
          
        </div>
        
        
        
    </div>
    
</body>
</html>

<!-- foreach($result as $row){
                      if($row['status'] == "Pendente"){
                          echo "nome da atividade: {$row['titulo']} <br>";
                      }
                  } -->