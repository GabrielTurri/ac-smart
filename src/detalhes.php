<?php
session_start();
// CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
if($_SESSION['ra_aluno']){
} else {
header("Location: login.html");
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="styles/styles-atividades.css">
  <link rel="stylesheet" href="styles/global.css">
  <link rel="stylesheet" href="styles/styles-dashboard.css">
  <link rel="stylesheet" href="styles/detalhes.css">
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
        <a href="dashboard.php">Dashboard</a>
        <span>/</span>
        <a href="atividades.php" class="button">Atividades</a>
    </div>

    <div class='detalhes-container'>
      <div class='column campo'>
        <strong>Titulo:</strong>
        <input type='text' value='Titulo Teste' disabled>
      </div>
      <div class='column campo'>
        <strong>Descrição:</strong>
        <textarea disabled>Descrição</textarea>
      </div>
      <div class='column campo'>
        <strong>Anexo:</strong>
        <div class='anexo'>
          <span>Link para o anexo</span>
        </div>
      </div>
      <div class='column campo'>
        <div class="row">
          <div class="column">
            <strong>Horas Solicitadas:</strong>
            <input type='text' value='4H' disabled>
          </div>
          <div class="column">
            <strong>Data de conclusão da atividade:</strong>
            <input type='date' value='4H' disabled>
          </div>
        </div>
      </div>
      <div class='column status aprovado'>
        <strong>Status Atividade:</strong>
        <span>Aprovado</span>
      </div>
      <div class='column status pendente'>
        <strong>Status Atividade:</strong>
        <span>Pendente</span>
      </div>
      <div class='column status reprovado'>
        <strong>Status Atividade:</strong>
        <span>Reprovado</span>
      </div>
      <h2>Em caso pendente (Coordenador):</h2>
      <div class="column gap-8">
        <strong class='aviso'>
          ATENÇÃO: Para reprovar a entrega da atividade, será necessário informar o que precisa ser corrigido
        </strong>
        <textarea placeholder='Informe aqui o que precisa ser corrigido'></textarea>
        <div class="row btn-row">
          <button class='btn azul'>Aprovar</button>
          <button class='btn vermelho'>Reprovar</button>
        </div>
      </div>
      <h2>Em caso pendente (Aluno):</h2>
      <div class="row center">
        <button class='btn laranja'>Editar</button>
        <button class='btn vermelho'>Cancelar Envio</button>
      </div>

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
            // se precisar ver quais infos estão no get, basta descomentar a linha abaixo
            // print_r($_GET);

        ?>

        
    </div>
</body>
</html>

