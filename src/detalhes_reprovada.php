<?php
session_start();
// CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
if($_SESSION['ra_aluno']){
} else {
header("Location: login.html");
} 

$strcon = mysqli_connect ("ac-smart-database.cha6yq8iwxxu.sa-east-1.rds.amazonaws.com", "felipe", "abcd=1234", "humanitae_db") or die ("Erro ao conectar com o banco");

// pegar a ultima observação feita pelo professor 
$sql = "SELECT * FROM observacao_atividade WHERE cod_atividade = ".$_GET['cod_atividade']." ORDER BY observacao DESC
LIMIT 1;";

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
  <title>Detalhes Atividades</title>
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
    <div class="breadcrumb">
        <a href="dashboard.php">Voltar para dashboard</a>
        <span>/</span>
        <a href="reprovadas.php" class="button">Voltar para atividades reprovadas</a>
    </div>
    <?php
            echo"
                <p>Título da atividade: {$_GET["titulo"]}</p>
                <p>Descrição da ativdade: {$_GET["descricao"]}</p>
                <p>Anexo: {$_GET["caminho_anexo"]}</p>
                <p>Horas Solicitadas: {$_GET["horas_solicitadas"]}</p>
                <p>Horas Aprovadas: {$_GET["horas_aprovadas"]}</p>
                <p>Data de conclusão da atividade: {$_GET["data"]}</p>
                <p>Status da Atividade: {$_GET["status"]}</p>
            ";

            foreach($result as $row){
              echo "<p>Observação do coordenador: {$row['observacao']}</p>";
            }

            // se precisar ver quais infos estão no get, basta descomentar a linha abaixo
            // print_r($_GET);

        ?>

        
    </div>
</body>
</html>

