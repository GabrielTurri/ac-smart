<?php
  session_start();
  // CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
  if($_SESSION['ra_aluno']){
  } else {
    header("Location: login.html");
  } 
  $strcon = mysqli_connect ("ac-smart-database.cha6yq8iwxxu.sa-east-1.rds.amazonaws.com", "felipe", "abcd=1234", "humanitae_db") or die ("Erro ao conectar com o banco");

  // para buscar as atividades daquele usuario logado e printar o titulo de todas as atividades que ele possui
  // da para fazer ifs para mostrar coisas que quiser, exemplo abaixo
  $sql = "SELECT * FROM atividade_complementar WHERE RA_aluno = '".$_SESSION['ra_aluno']."'";
  $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
  $horas_totais_entregues = 0;
  $horas_totais_aprovadas = 0;

  $pendentes = 0;
  $aprovadas = 0;
  $arquivadas = 0;
  $reprovadas = 0;

  // somar horas entregues pelo aluno e as aprovadas
  foreach($result as $row){
    $horas_totais_entregues += $row["horas_solicitadas"];
    $horas_totais_aprovadas += $row["horas_aprovadas"];

    // contagem para saber quantas atividades de cada status o usuário tem
    if($row['status'] == "Aprovado"){
      $aprovadas += 1;
    } else if($row['status'] == "Reprovado"){
      $reprovadas += 1;
    }else if($row['status'] == "Pendente"){
      $pendentes += 1;
    } else if($row['status'] == "Arquivado"){
      $arquivadas += 1;
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

  <link rel="stylesheet" href="styles/styles-atividades.css">
  <link rel="stylesheet" href="styles/global.css">
  <link rel="stylesheet" href="styles/styles-dashboard.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>


  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atividades</title>
</head>
<script>

  function showApproved() {
    document.getElementById("pendentes").style.display = "none";
    document.getElementById("aprovadas").style.display = "flex";
  }
  function showPendent() {
    document.getElementById("aprovadas").style.display = "none";
    document.getElementById("pendentes").style.display = "flex";
  } 

  function abrirOpcoes(){
    // Abrir as opções de editar ou excluir
    console.log("Editar/Excluir")
  }
</script>
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
  <div class="breadcrumb">
    <a href="dashboard.php">Voltar para dashboard</a>
  </div>
  
  <div class="abas-atividades">
    <button class="aba-btn" onclick="showApproved()">Aprovadas</button>
    <button class="aba-btn" onclick="showPendent()">Pendentes</button>
  </div>
  
  <!-- fazer o cartão da atividade INTEIRA ser clicavel, e direcionar ou abrir mais informações sobre aquela atividade -->
  
  
  <div class="lista-atividades" id="aprovadas">
    <?php
    echo "<h2>Atividades Aprovadas: {$aprovadas}</h2>"?>
    <div class="legenda-lista-atividades">
      <div class="legenda">
        <strong>Título</strong>
      </div>
      <div class="legenda">
        <strong>Horas Aprovadas</strong>
      </div>
    </div>

      <?php
      foreach($result as $row){
        if($row['status'] == "Aprovado"){
          echo '
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
            </form>';      
        }
      }
      ?>
      
      <!-- <div class="container-atividade">
        <span>Certificado: Python Básico</span>
        <strong>4H</strong>
      </div> -->
    </div>    
    
    <div class="lista-atividades" id="pendentes">
      <h2>
        Atividades Pendentes: 
        <?php echo $pendentes ?>
      </h2>
      <div class="legenda-lista-atividades">
      <div class="legenda">
        <strong>Título</strong>
      </div>
      <div class="legenda">
        <strong>Horas Solicitadas</strong>
      </div>
    </div>

      <?php
      foreach($result as $row){
        if($row['status'] == "Pendente"){
          echo '
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
                <strong class="">'.$row["horas_solicitadas"].'H</strong>
              </button>
            
            </form>
            <button class="more" onclick="abrirOpcoes()">
              <img src="assets/icons/more-vertical.svg" alt="">
            </button>
          </div>';
      }}?>
    </div>
  </div>
</body>
</html>


<!-- <?php
      if ($result ->num_rows > 0){
        foreach($result as $row){
          echo "
          <div class='container-atividade'>
            <span>{$row["titulo"]}</span>
            <div class='row'>
              <strong>{$row["horas_aprovadas"]}H</strong>
          ";

          if($row['status'] == 'Aprovado'){
            echo '
            <form action="../server/server.php" method="post">
              <input type="hidden" value='.$row["cod_atividade"].' name="cod_atividade" id="cod_atividade">
              <button 
                type="submit" 
                name="deletar" 
                id="deletar" 
                title="Cancelar Envio"
              >
                <img src="assets/icons/x.svg" alt="Cancelar Envio" title="Cancelar envio">
              </button>
            </form>
          </div>
        </div>';
          }
        }
      }
    ?>  -->