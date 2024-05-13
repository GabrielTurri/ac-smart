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

  // $sql2 = "SELECT * FROM atividade_complementar INNER JOIN aluno ON atividade_complementar.RA_aluno = aluno.RA_aluno INNER JOIN curso ON aluno.cod_curso = curso.cod_curso WHERE nome_curso = '".$_SESSION['nome_curso']."' AND status = 'Pendente';"; 

  // // Executar a query sql2
  // mysqli_query($strcon, $sql2) or die ("Erro ao tentar inserir atividade");
  // $result = mysqli_query($strcon, $sql2) or die ("Erro ao tentar inserir atividade");

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
      <br>
      <a href="atividades_coord.php" class="button">Voltar para atividades a serem avaliadas</a>
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
            
            <h2>Detalhes da atividade:</h2>
            
            <?php
            $descricao = ucfirst($_GET["descricao"]);
            $caminho = '../server/'.$_GET['caminho_anexo'];
            
              echo "
                <p>Nome do aluno (a): ".ucfirst($_GET['nome_aluno'])."</p>
                <p>RA do aluno (a): {$_GET["RA_aluno"]}</p>

                <p>Título da atividade: ".ucfirst($_GET["titulo"])."</p>
                <p>Descrição da atividade: ".ucfirst($_GET["descricao"])."</p>
                <a href=".$caminho." download>Arquivo enviado</a>
                <p>Horas Solicitadas: {$_GET["horas_solicitadas"]}</p>
                <p>Data de conclusão da atividade: {$_GET["data"]}</p>
              ";  
            ?>

            <form action="../server/server.php" method="post">
              <?php
                echo '<input type="hidden" name="cod_atividade" value="'.$_GET["cod_atividade"].'">';  
                echo '<input type="hidden" name="horas_solicitadas" value="'.$_GET["horas_solicitadas"].'">';  
              ?>
              <button type="submit" name="aprovar" id="aprovar">Aprovar</button>
            </form>

            <form action="../server/server.php" method="post">
              <?php
              echo '<input type="hidden" name="cod_atividade" value="'.$_GET["cod_atividade"].'">'; 
                
              ?>
              <p>ATENÇÃO: Para reprovar a atividade, deixe seu comentário para o aluno poder corrigir a atividade e reenviar.</p>
              <textarea name="observacao" id="observacao" cols="30" rows="10"></textarea>
              <button type="submit" name="reprovar" id="reprovar">Reprovar</button>
            </form>
              
          </div>

        
          
        </div>
        
        
        
    </div>
    
  </body>
  </html>