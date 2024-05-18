<?php
  session_start();
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

  // somar horas entregues pelo aluno e as aprovadas
  foreach($result as $row){
    $horas_totais_entregues += $row["horas_solicitadas"];
    $horas_totais_aprovadas += $row["horas_aprovadas"];
    array_push($_SESSION['atividades_aluno'], $row["cod_atividade"]);
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

  <link rel="stylesheet" href="styles/global.css">
  <link rel="stylesheet" href="styles/styles-dashboard.css">
  <link rel="stylesheet" href="styles/atividades.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>

  <title>Dashboard</title>
</head>
<body>
  <aside class="sidebar">
    <div class="user-data text-center">
      <div class="user-photo"></div>
      <h3>Boas Vindas, <?php echo ucfirst($_SESSION['nome_aluno'])?></h3>
      <h4>RA: <?php echo $_SESSION['ra_aluno']?></h4>
    </div>
      <!-- para imprimir as informações do curso do aluno cadastrado -->
    <div class="user-info">
      <h3>Nome do curso:</h3>
      <?php echo "<span>{$_SESSION['nome_curso']}</span>";
        echo "<p><b>Nome do coordenador (a):</b></p> <p>".ucfirst($_SESSION['nome_coordenador'])." " .ucfirst($_SESSION['sobrenome_coordenador']). "</p>";
        echo "<p><b>Email do coordenador (a):</b></p> <p> {$_SESSION['email_coordenador']}</p>"
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
    
            <div class="chart-content">
              <div class="chartImg"></div>
              <h1><?php echo "{$horas_totais_aprovadas}/{$_SESSION['horas_complementares']}";?> Horas</h1>
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
        
        
        <!-- IF para mostrar as atividades do aluno caso ele tenha alguma atividade entregue, SENÃO VAI MOSTRAR UMA FRASE E O BOTÃO PARA ENTREGAR ATIVIDADE-->
        <div class='lista-atividades'>
        <?php
            if ($result ->num_rows > 0){
              echo "<h2>Atividades Recentes</h2>";
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
        <table>
        <div class="lista-atividades">
          <?php
            if ($result ->num_rows > 0){
              echo "
              <tr>
              <th>Atividade</th>
              <th>Descrição</th>
              <th>Anexo</th>
              <th>Data de conclusão</th>
              <th>Horas Solicitadas</th>
              <th>Status</th>
              <th>Deletar</th>
              <th>Editar</th>
              </tr>";
              
              foreach($result as $row){
                // criar o caminho para baixar o arquivo
                $caminho = '../server'.$row["caminho_anexo"];
                echo "
                <tr>
                <td>{$row["titulo"]}</td>
                <td>{$row["descricao"]}</td>
                <td><a href=".$caminho." download>Arquivo</a></td>
                <td>{$row["data"]}</td>
                <td>{$row["horas_solicitadas"]}</td>
                <td>{$row["status"]}</td>
                ";
                echo '
                  <div id="aprovadas">
                    <form class="'.$row['status'].'" action="detalhes.php" method="get">
                      <button type="submit" class="container-atividade">
                        <input type="hidden" value='.$row["cod_atividade"].' name="cod_atividade" id="cod_atividade">
                        <input type="hidden" value='.$row["titulo"].' name="titulo" id="titulo">
                        <input type="hidden" value='.$row["descricao"].' name="descricao" id="descricao">
                        <input type="hidden" value='.$row["caminho_anexo"].' name="caminho_anexo" id="caminho_anexo">
                        <input type="hidden" value='.$row["horas_solicitadas"].' name="horas_solicitadas" id="horas_solicitadas">
                        <input type="hidden" value='.$row["data"].' name="data" id="data">
                        <input type="hidden" value='.$row["status"].' name="status" id="status">
                        <input type="hidden" value='.$row["horas_aprovadas"].' name="horas_aprovadas" id="horas_aprovadas">
                          <span>'.$row["titulo"].'</span>
                          <strong>'.$row["horas_aprovadas"].'H</strong>
                        </button>
                      </form>
                    </div>
                      ';  
                
                if($row['status'] == 'Pendente' or $row['status'] == 'Reprovado'){
                  echo '
        
                  <td>
                  <form action="../server/server.php" method="post">
                  <input type="hidden" value='.$row["cod_atividade"].' name="cod_atividade" id="cod_atividade">
                  <button 
                  type="submit" 
                  name="deletar" 
                  id="deletar" 
                  title="Cancelar Envio"
                  class="botao-cancelar"
                  >
                  <img src="assets/icons/x.svg" alt="Cancelar Envio">
                  </button>
                  </form>
                  </td>
                  
                        <td>
                        <form action="edicao.php" method="get">
                        <input type="hidden" value="'.$row["cod_atividade"].'" name="cod_atividade" id="cod_atividade">
                        <input type="hidden" value="'.$row["titulo"].'" name="titulo" id="titulo">
                        <input type="hidden" value="'.$row["descricao"].'" name="descricao" id="descricao">
                        <input type="hidden" value="'.$row["caminho_anexo"].'" name="caminho_anexo" id="caminho_anexo">
                        <input type="hidden" value="'.$row["horas_solicitadas"].'" name="horas_solicitadas" id="horas_solicitadas">
                        <input type="hidden" value="'.$row["data"].'" name="data" id="data">
                        <button 
                        type="submit" 
                        name="deletar" 
                        id="deletar" 
                        title="Cancelar Envio"
                        class="botao-cancelar"
                        >
                        <img src="assets/icons/pencil-square.svg" alt="Cancelar Envio">
                        </button>
                        </form>
                        </td>
                        
                        </tr>';
                        
                        echo '
                        <div id="pendentes">
                        <div class="row">
                        
                        <form class="'.$row['status'].' full" action="detalhes.php" method="get">
                        
                        <button type="submit" class="container-atividade">
                        <input type="hidden" value='.$row["cod_atividade"].' name="cod_atividade" id="cod_atividade">
                        <input type="hidden" value='.$row["titulo"].' name="titulo" id="titulo">
                        <input type="hidden" value='.$row["descricao"].' name="descricao" id="descricao">
                        <input type="hidden" value='.$row["caminho_anexo"].' name="caminho_anexo" id="caminho_anexo">
                        <input type="hidden" value='.$row["horas_solicitadas"].' name="horas_solicitadas" id="horas_solicitadas">
                        <input type="hidden" value='.$row["data"].' name="data" id="data">
                        <input type="hidden" value='.$row["status"].' name="status" id="status">
                        <input type="hidden" value='.$row["horas_aprovadas"].' name="horas_aprovadas" id="horas_aprovadas">
                        <span>'.$row["titulo"].'</span>
                        <strong title="Pendente">'.$row["horas_solicitadas"].'H</strong>
                        </button>
                        
                        </form>
                        <button class="more" onclick="abrirOpcoes()">
                        <img src="assets/icons/more-vertical.svg" alt="">
                        </button>
                        </div>
                        </div>';
                        // $_SESSION['atividade_atual'] = $row["cod_atividade"];
                } else {
                  echo '</tr>';
                }
                
              }
            }
            ?>
        </div>
        </table>
        <hr>
      </div>
    </div>
    
  </body>
  </html>