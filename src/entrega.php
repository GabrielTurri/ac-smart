<?php
  session_start();
  // CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
  if($_SESSION['ra_aluno'] or $_SESSION['cod_coordenador']){
  } else {
    header("Location: login.html");
  } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="styles/styles-entrega.css">
  <link rel="stylesheet" href="styles/global.css">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entrega de AC's</title>
</head>
<body>
  <div class="headerContainer">
    <a href="dashboard.php">
      <img src="assets/icons/arrow-left.svg" alt="">
    </a>
    <div>
      <h2>Entregar AC</h2>
    </div>
    <div></div>
  </div>
  
  <div class="formContainer column">
    <form action="../server/server.php" method="post">
      <div class="column">
        <label for="titulo">Título</label>
        <input name="titulo" id="titulo" type="text">
      </div>

      <div class="column">
        <label for="descricao">Descrição</label>
        <textarea name="descricao" itemid="descricao" id="descricao" cols="30" rows="10"></textarea>
      </div>

      <div class="column">
        <label for="anexo">Anexos</label>
        <input name="anexo" id="anexo" type="text">
      </div>


      <div class="dataHorasContainer ">
        <div class="horasInput column">
          <label for="horas_solicitadas">Horas solicitadas</label>
          <input name="horas_solicitadas" id="horas_solicitadas" type="number">
        </div>
  
        <div class="dataInput column">
          <label for="data_conclusao">Data da atividade</label>
          <input name="data_conclusao" id="data_conclusao" type="date">
        </div>
      </div>
      <div class="enviar-container column">
        <strong>
          Atenção: As informações serão enviadas para o 
          professor/orientador responsável. Preencha com responsabilidade.
        </strong>
        <button class="enviar" type="submit" name="inserir">ENVIAR</button>
      </div>
      
    </form>
  </div>
</body>
</html>