<?php
  require_once("../server/server.php");

    // CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
  if(!($_SESSION['cod_coordenador']))
    header("Location: login.php");

  // conexao com o banco de dados usando as credenciais do Felipe, qualquer integrante do grupo pode usar seu primeiro nome em minusculo como usuario, o resto mantém

  $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

  // para buscar as atividades daquele usuario logado e printar o titulo de todas as atividades que ele possui
  // da para fazer ifs para mostrar coisas que quiser, exemplo abaixo
  $sql = "SELECT * FROM coordenador JOIN curso ON coordenador.cod_coordenador = curso.coordenador_curso WHERE cod_coordenador = '".$_SESSION['cod_coordenador']."'";
  $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");


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
  <link rel="stylesheet" href="styles/atividades.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>

  <title>Dashboard Coordenador</title>
</head>
<body>
  <?php include "./components/sidebar.php" ?>
  <div id="preloader"></div>

  <div class="dashboard-content">
    <div class="breadcrumb">
      <a href="dash_coordenador.php">Cursos</a>
    </div>

    <div class="lista-atividades" id="aprovadas">
    
      <h2><?php echo $_SESSION['nome_curso']; ?></h2>
      <h3>Atividades aguardando avaliação:</h3>
      <?php
        echo '<div class="flash_message">';
        flash();
        echo '</div>'
      ?>
      <div class="legenda-lista-atividades">
        <div class="legenda">
          <strong>Título</strong>
        </div>
        <div class="legenda">
          <strong>Horas Solicitadas</strong>
        </div>
      </div>
      <?php
        // vai mostrar uma mensagem caso não tenha atividades para avaliar
        if($result->num_rows < 1){
          echo "Sem atividades para avaliar";
        } else {
          foreach($result as $row){
            if($row['status'] == "Pendente"){
              echo '
              
              <form action="detalhes.php" method="get">  
              <input type="hidden" value="'.$row["nome_aluno"].'" name="nome_aluno" id="nome_aluno">
              <input type="hidden" value="'.$row["RA_aluno"].'" name="RA_aluno" id="RA_aluno">
              <input type="hidden" value="'.$row["cod_atividade"].'" name="cod_atividade" id="cod_atividade">
              <input type="hidden" value="'.$row["titulo"].'" name="titulo" id="titulo">
              <input type="hidden" value="'.$row["descricao"].'" name="descricao" id="descricao">
              <input type="hidden" value="'.$row["caminho_anexo"].'" name="caminho_anexo" id="caminho_anexo">
              <input type="hidden" value="'.$row["horas_solicitadas"].'" name="horas_solicitadas" id="horas_solicitadas">
              <input type="hidden" value="'.$row["data"].'" name="data" id="data">
              <input type="hidden" value="'.$row["status"].'" name="status" id="status">
                  
                <button class="container-atividade" type="submit">
                  <span>'.$row["titulo"].'</span>
                  <strong>'.$row["horas_solicitadas"].'H</strong>
                  </button>
                </form>';               
            }
          }  
        }
      ?>
    </div>
  </div>    
</body>
<script src="preloader.js"></script>
</html>
