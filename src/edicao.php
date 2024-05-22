<?php
  session_start();
  // CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
  if($_SESSION['ra_aluno']){
    $caminho = '../server/'.$_GET["caminho_anexo"];
  } else {
    header("Location: login.html");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="styles/entrega.css">
  <link rel="stylesheet" href="styles/global.css">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Atividade</title>
</head>
<body>
<?php include './components/sidebar.php';  ?>
  <div class="dashboard-content">
    <div class="breadcrumb">
      <a href="dashboard.php">Voltar para dashboard</a>
    </div>
    <h2 class="text-center">Editar AC</h2>

    <div class="form-container column">
      <form action="../server/server.php" method="post" enctype="multipart/form-data">
        <div class="column">
          <label for="titulo">Título</label>
          <input name="titulo" id="titulo" type="text" autofocus value="<?php echo $_GET["titulo"];?>">
        </div>

        <div class="column">
          <label for="descricao">Descrição</label>
          <textarea name="descricao" itemid="descricao" id="descricao" cols="30" rows="10"><?php echo $_GET["descricao"];?></textarea>
        </div>  

        

        <div class="column">
          <label for="file-upload" class="custom-file-upload"><?php echo $_GET["caminho_anexo"] ?></label>
          <input id="file-upload" type="file" value="<?php echo $caminho ?>" />
          <!-- <label for="anexo">Novo anexo</label>
          <input name="anexo" id="anexo" type="file" value="<?php echo $caminho ?>" download> -->
        </div>


        <div class="data-horas-container">
          <div class="column">
            <label for="horas_solicitadas">Horas solicitadas</label>
            <input name="horas_solicitadas" id="horas_solicitadas" type="number" placeholder="<?php echo $_GET["horas_solicitadas"];?>">
          </div>
    
          <div class="column">
            <label for="data_conclusao">Data da atividade:</label>
            <input name="data_conclusao" id="data_conclusao" type="date" value="<?php echo $_GET['data'];?>">
          </div>
        </div>
        <input type="hidden" id="cod_atividade" name="cod_atividade" value="<?php echo $_GET["cod_atividade"];?>">
        <?php 
        if ($_GET["status"] == "Reprovado") {
          echo "
            <label for='obs-coord'>Observação do coordenador ".ucfirst($_SESSION['nome_coordenador']).":</label>
            <textarea name='obs-coord' disabled>{$observacao}</textarea>
          ";
        }?>
        <div class="enviar-container column">
          <strong>
            Atenção: As informações serão enviadas para o 
            professor/orientador responsável. Preencha com responsabilidade.
          </strong>
          <button class="btn editar" type="submit" name="editar">EDITAR</button>
        </div>

  </div>
    </form>
  </div>
</body>
</html>