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

  <link rel="stylesheet" href="styles/styles-entrega.css">
  <link rel="stylesheet" href="styles/global.css">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Atividade</title>
</head>
<body>
  <div class="headerContainer">
    <a href="dashboard.php">
      <img src="assets/icons/arrow-left.svg" alt="">
    </a>
    <div>
      <h2>Editar AC</h2>
      <!-- <?php
      print_r($_SESSION['atividades_aluno']);
      ?> -->
    </div>
    <div></div>
  </div>
  
  <div class="formContainer column">
    <form action="../server/server.php" method="post" enctype="multipart/form-data">
      <div class="column">
        <label for="titulo">Título</label>
                <input name="titulo" id="titulo" type="text" autofocus placeholder="<?php echo $_GET["titulo"];?>">
      </div>

      <div class="column">
        <label for="descricao">Descrição</label>
        <textarea name="descricao" itemid="descricao" id="descricao" cols="30" rows="10" placeholder="<?php echo $_GET["descricao"];?>"></textarea>
      </div>
      
      <td></td>
      

      <?php
        $caminho = '../server/'.$_GET["caminho_anexo"];
        echo "<a href=".$caminho." download>Seu arquivo</a>";
      ?>

      <div class="column">
        <label for="anexo">Novo anexo</label>
        <input name="anexo" id="anexo" type="file">
      </div>


      <div class="dataHorasContainer ">
        <div class="horasInput column">
          <label for="horas_solicitadas">Horas solicitadas</label>
          <input name="horas_solicitadas" id="horas_solicitadas" type="number" placeholder="<?php echo $_GET["horas_solicitadas"];?>">
        </div>
  
        <div class="dataInput column">
          <label for="data_conclusao">Data da atividade: <?php echo $_GET["data"];?></label>
          <input name="data_conclusao" id="data_conclusao" type="date">
        </div>
      </div>
      <input type="hidden" id="cod_atividade" name="cod_atividade" value="<?php echo $_GET["cod_atividade"];?>">
      <div class="enviar-container column">
        <strong>
          Atenção: As informações serão enviadas para o 
          professor/orientador responsável. Preencha com responsabilidade.
        </strong>
        <button class="enviar" type="submit" name="editar">ENVIAR</button>
      </div>
      
    </form>
  </div>
</body>
</html>