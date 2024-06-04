<?php
  include("../server/server.php");

  // CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
  if(!($_SESSION['ra_aluno']))
    header("Location: login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="styles/global.css">
  <link rel="stylesheet" href="styles/entrega.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>

  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entrega de AC's</title>
</head>
<body>
  <?php include './components/sidebar.php'; ?>
  <div id="preloader"></div>
  <div class="dashboard-content">
    <div class="breadcrumb">
      <a href="dashboard.php">Voltar para dashboard</a>
    </div>

  <h2 class="text-center">Enviar nova AC</h2>
  <?php
        flash();?>
  <div class="form-container">
    <form action="../server/server.php" method="post" class="full" enctype="multipart/form-data">
      <div class="column">
        <label for="titulo">Título</label>
        <input name="titulo" id="titulo" type="text" autofocus>
      </div>

      <div class="column">
        <label for="descricao">Descrição</label>
        <textarea name="descricao" itemid="descricao" id="descricao" cols="30" rows="5"></textarea>
      </div>

      <div class="column">
        <label for="anexo">Anexo</label>
        <input name="anexo" id="anexo" type="file">
      </div>


      <div class="row gap-8 full">
        <div class="column full">
          <label for="horas_solicitadas">Horas solicitadas</label>
          <input name="horas_solicitadas" id="horas_solicitadas" type="number" min="1" value="1">
        </div>
  
        <div class="column full">
          <label for="data_conclusao">Data da atividade</label>
          <input name="data_conclusao" id="data_conclusao" type="date">
        </div>
      </div>
      <div class="enviar-container column">
        <strong>
          Atenção: As informações serão enviadas para o 
          professor/orientador responsável. Preencha com responsabilidade.
        </strong>
        <button class="btn enviar" type="submit" name="inserir">ENVIAR</button>
      </div>
      
    </form>
  </div>
  </div>

</body>
<script src="preloader.js"></script>
</html>