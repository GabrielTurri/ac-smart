<?php
  // session_start();
  include("../server/server.php");
    // CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
  if($_SESSION['ra_aluno']){
  } else {
    header("Location: login.html");
  } 

  $_SESSION['atividades_aluno'] = [];

  // conexao com o banco de dados usando as credenciais do Felipe, qualquer integrante do grupo pode usar seu primeiro nome em minusculo como usuario, o resto mantém
  $strcon = mysqli_connect ("ac-smart-database.cha6yq8iwxxu.sa-east-1.rds.amazonaws.com", "felipe", "abcd=1234", "humanitae_db") or die ("Erro ao conectar com o banco");

  // para buscar as atividades daquele usuario logado e printar o titulo de todas as atividades que ele possui
  // da para fazer ifs para mostrar coisas que quiser, exemplo abaixo
  $sql = "SELECT * FROM atividade_complementar WHERE RA_aluno = '".$_SESSION['ra_aluno']."'";
  $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
  $horas_totais_entregues = 0;
  $horas_totais_aprovadas = 0;

  
  $_SESSION['aprovadas'] = 0;
  $_SESSION['arquivadas'] = 0;
  $_SESSION['reprovadas'] = 0;
  $_SESSION['pendentes'] = 0;

  // contagem para saber quantas atividades de cada status o usuário tem
  // somar horas entregues pelo aluno e as aprovadas
  foreach($result as $row){
    $horas_totais_entregues += $row["horas_solicitadas"];
    $horas_totais_aprovadas += $row["horas_aprovadas"];
    array_push($_SESSION['atividades_aluno'], $row["cod_atividade"]);

    if($row['status'] == "Aprovado"){
      $_SESSION['aprovadas'] +=1;
    } else if($row['status'] == "Reprovado"){
      $_SESSION['reprovadas'] += 1;
    }else if($row['status'] == "Pendente"){
      $_SESSION['pendentes'] += 1;
    } else if($row['status'] == "Arquivado"){
      $_SESSION['aprovadas'] += 1;
    }
  }  

  // buscar no banco as informações do curso que o aluno faz, como coordenador, email dele, horas complementares necessarias, nome do curso
  $sql = "SELECT nome_curso, horas_complementares, nome_coordenador, sobrenome_coordenador, email_coordenador FROM curso JOIN coordenador ON curso.coordenador_curso = coordenador.cod_coordenador WHERE cod_curso = '".$_SESSION['curso']."'";
  $result2 = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
  $linha = mysqli_fetch_array($result2);
  
  $_SESSION["nome_curso"] = $linha["nome_curso"];
  $_SESSION["horas_complementares"] = $linha["horas_complementares"];
  $_SESSION["nome_coordenador"] = $linha["nome_coordenador"];
  $_SESSION["sobrenome_coordenador"] = $linha['sobrenome_coordenador'];
  $_SESSION["email_coordenador"] = $linha['email_coordenador'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <link rel="stylesheet" href="styles/atividades.css">
  <link rel="stylesheet" href="styles/global.css">
  

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>

  <title>Dashboard</title>
</head>
<body>
  <?php include './components/sidebar.php' ?>
  
    <div class="dashboard-content">
      <div class="column">
        <div class="dashboard-container">
          <div class="chart-container">
    
            <div class="chart-content">
              <div class="chartImg"></div>
              <h1><?php 
                if($horas_totais_aprovadas > 200){$horas_totais_aprovadas = 200;};
                echo "{$horas_totais_aprovadas}/{$_SESSION['horas_complementares']}";
              ?> Horas</h1>
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
    
          <div class="chart-container">
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
    
            <a href="reprovadas.php" class="button">
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
        
        
        <!-- IF para mostrar as atividades do aluno caso ele tenha alguma atividade entregue, SENÃO VAI MOSTRAR UMA FRASE E O BOTÃO PARA ENTREGAR ATIVIDADE-->
        <?php
        flash();?>
        <div class='lista-atividades full'>
          <?php
            if ($result ->num_rows > 0){
              echo "<h2>Atividades Recentes</h2>
                <div class='legenda-lista-atividades'>
                  <div class='legenda'>
                    <strong>Título</strong>
                  </div>
                  <div class='legenda'>
                    <strong>Horas Aprovadas</strong>
                  </div>
                </div>";
            } else {
              echo "<h2>Você não possui atividades entregues</h2>";
              echo "<a href='entrega.php' class='button'>
              <button class= 'button'>
                <img 
                  src='assets/icons/file-plus.svg'
                  alt='Atividades Complementares'
                >
                Entregar AC'S
              </button>
              </a>";
            }
          ?>

          <?php
            if ($result ->num_rows > 0) {
              foreach($result as $row){
                if ($row['status'] == 'Aprovado'){ 
                echo '
                  <div id="aprovadas" class="full">
                    <form class="'.$row['status'].'" action="detalhes.php" method="get">
                      <input type="hidden" value='.$row["cod_atividade"].' name="cod_atividade" id="cod_atividade">
                      <input type="hidden" value='.$row["titulo"].' name="titulo" id="titulo">
                      <input type="hidden" value='.$row["descricao"].' name="descricao" id="descricao">
                      <input type="hidden" value='.$row["caminho_anexo"].' name="caminho_anexo" id="caminho_anexo">
                      <input type="hidden" value='.$row["horas_solicitadas"].' name="horas_solicitadas" id="horas_solicitadas">
                      <input type="hidden" value='.$row["data"].' name="data" id="data">
                      <input type="hidden" value='.$row["status"].' name="status" id="status">
                      <input type="hidden" value='.$row["horas_aprovadas"].' name="horas_aprovadas" id="horas_aprovadas">
                      <button type="submit" class="container-atividade">
                        <span>'.$row["titulo"].'</span>
                        <strong>'.$row["horas_aprovadas"].'H</strong>
                      </button>
                    </form>
                  </div>';
                }
                else if($row['status'] == 'Pendente' or $row['status'] == 'Reprovado'){                        
                  echo '
                    <div class="row atividades-pendentes">
                      <form class="'.$row["status"].' full" action="detalhes.php" method="get">
                        <input type="hidden" value='.$row["cod_atividade"].' name="cod_atividade" id="cod_atividade">
                        <input type="hidden" value='.$row["titulo"].' name="titulo" id="titulo">
                        <input type="hidden" value='.$row["descricao"].' name="descricao" id="descricao">
                        <input type="hidden" value='.$row["caminho_anexo"].' name="caminho_anexo" id="caminho_anexo">
                        <input type="hidden" value='.$row["horas_solicitadas"].' name="horas_solicitadas" id="horas_solicitadas">
                        <input type="hidden" value='.$row["data"].' name="data" id="data">
                        <input type="hidden" value='.$row["status"].' name="status" id="status">
                        <input type="hidden" value='.$row["horas_aprovadas"].' name="horas_aprovadas" id="horas_aprovadas">
                        <button type="submit" class="container-atividade">
                          <div>
                            <span>'.$row["titulo"].'</span>';
                            if ($row['status'] == 'Pendente')
                              echo '<span class="texto-laranja"> ('.$row["status"].')</span>';
                            else
                              echo '<span class="texto-vermelho"> ('.$row["status"].')</span>';
                          echo '</div>
                          <strong></strong>
                        </button>
                      </form>
                      <button class="more" onclick="abrirOpcoes()">
                        <img src="assets/icons/more-vertical.svg" alt="">
                      </button>
                    </div>
                  ';
                  // $_SESSION['atividade_atual'] = $row["cod_atividade"];
                }
              }
            }
            ?>
        </div>
      </div>
    </div>
  </body>
</html>