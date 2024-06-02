<?php
session_start();
// CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
if(isset($_SESSION['ra_aluno']) || isset($_SESSION['cod_coordenador'])){
} else {
header("Location: login.php");
} 

$strcon = mysqli_connect ("137.184.66.198", "felipe", "abcd=1234", "humanitae_db") or die ("Erro ao conectar com o banco");

// pegar a ultima observação feita pelo professor 
$sql = "SELECT * FROM observacao_atividade WHERE cod_atividade = ".$_GET['cod_atividade']." ORDER BY cod_observacao DESC
LIMIT 1;";

$result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
$observacao = '';
foreach($result as $row){
  $observacao = $row['observacao'];
}

$nome_arquivo = preg_split("/\//", $_GET["caminho_anexo"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="styles/atividades.css">
  <link rel="stylesheet" href="styles/global.css">
  <link rel="stylesheet" href="styles/detalhes.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>


  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalhes Atividades</title>
</head>

<body>
  <?php include('components/sidebar.php') ?>

  <div class="dashboard-content">
    <div class="breadcrumb">
    <?php 
      echo isset($_SESSION['ra_aluno']) ? '<a href="dashboard.php">Dashboard</a>' : '<a href="dash_coordenador.php">Cursos</a>';
      echo '<span>/</span>';
      echo isset($_SESSION['ra_aluno']) ? '<a href="atividades.php">Atividades</a>': '<a href="atividades_coord.php">'.$_SESSION['nome_curso'].'</a>';
      ?>
    </div>

    <div class='detalhes-container'>
      <h2 class="text-center">Detalhes da Atividade</h2>
      <div class='column campo'>
        <strong>Título:</strong>
        <?php echo "
          <input type='text' value='{$_GET["titulo"]}' disabled>
        ";?>
        
      </div>
      <div class='column campo'>
        <strong>Descrição:</strong>
        <textarea disabled rows='5'><?php echo $_GET["descricao"];?></textarea>
      </div>
      <div class='column campo'>
        <strong>Anexo:</strong>
        <div class='anexo'>
          <?php echo "<a href='../server{$_GET["caminho_anexo"]}' download>{$nome_arquivo[2]}</a>"; ?>
        </div>
      </div>
      <div class='column campo'>
        <div class="row">
          <div class="column">
            <strong>Horas 
              <?php 
                echo $_GET["status"] == "Aprovado" ?  'Aprovadas:' : 'Solicitadas:';
              ?>
            </strong>
            <?php 
              echo "
                <input type='text' value='{$_GET["horas_solicitadas"]}H' disabled>
              ";
            ?>
          </div>
          <div class="column">
            <strong>Data de conclusão da atividade:</strong>
            <?php 
            $date = date_create($_GET["data"]);
            $newDate = date_format($date, "d/m/Y");
            
            echo "
              <input type='text' value='{$newDate}' disabled>
            ";?>
          </div>
        </div>
      </div>
      <?php
      if ($_GET["status"] == "Aprovado") {
        echo "
          <div class='column status aprovado'>
            <strong>Status Atividade:</strong>
            <span>Aprovado</span>
          </div>
        ";
      } else if (isset($_SESSION['ra_aluno'])) {
        if ($_GET["status"] == "Pendente") {
          echo '
            <div class="column status pendente">
              <strong>Status Atividade:</strong>
              <span>Pendente</span>
            </div>
            ';
          }
          else if ($_GET["status"] == "Reprovado") {
            echo "
            <div class='column status reprovado'>
            <strong>Status Atividade:</strong>
            <span>Reprovado</span>
            </div>
            <label for='obs-coord'>Observação do coordenador ".ucfirst($_SESSION['nome_coordenador']).":</label>
            
            <textarea name='obs-coord' disabled style='resize:none'>{$observacao}</textarea>
            ";
          }
          echo '
          <!-- BOTÃO EDITAR -->
          
          <div class="row center"> 
            <form action="edicao.php" method="get">
              <input type="hidden" value="'.$_GET["cod_atividade"].'" name="cod_atividade" id="cod_atividade">
              <input type="hidden" value="'.$_GET["titulo"].'" name="titulo" id="titulo">
              <input type="hidden" value="'.$_GET["descricao"].'" name="descricao" id="descricao">
              <input type="hidden" value="'.$_GET["caminho_anexo"].'" name="caminho_anexo" id="caminho_anexo">
              <input type="hidden" value="'.$_GET["horas_solicitadas"].'" name="horas_solicitadas" id="horas_solicitadas">
              <input type="hidden" value="'.$_GET["data"].'" name="data" id="data">
              <input type="hidden" value="'.$_GET["status"].'" name="status" id="status">
              <input type="hidden" value="'.$observacao.'" name="observacao" id="observacao">
              <button type="submit" name="editar" id="editar" class="btn laranja">
                Editar
              </button>
            </form>

            
            <button class="btn vermelho delete" value="'.$_GET["cod_atividade"].'">Excluir</button>

          </div>
        ';
      } else if (isset($_SESSION['cod_coordenador'])){
        echo '
          <form action="../server/server.php" method="post" enctype="multipart/form-data">
            <div class="column gap-8">
              <strong class="aviso">
                ATENÇÃO: Para reprovar a entrega da atividade, será necessário informar o que precisa ser corrigido
              </strong>
              <textarea name="observacao" id="observacao" cols="30" rows="10" placeholder="Informe aqui o que precisa ser corrigido"></textarea>
              <div class="row-reverse btn-row gap-8">
                <button type="submit" name="reprovar" id="reprovar" class="btn vermelho">Reprovar</button>
                <input type="hidden" name="cod_atividade" value="'.$_GET["cod_atividade"].'">
                <input type="hidden" value="'.$_GET["RA_aluno"].'" id="RA_aluno" name="RA_aluno">
                <input type="hidden" value="'.$_GET["titulo"].'" id="titulo" name="titulo">
                <input type="hidden" value="'.$_GET["caminho_anexo"].'" id="caminho_anexo" name="caminho_anexo">
                <input type="hidden" value="'.$_GET["horas_solicitadas"].'" id="horas_solicitadas" name="horas_solicitadas">
                <input type="hidden" value="'.$_GET["data"].'" id="data" name="data">

          </form>
          
          </div>
          </div>
          <button class="btn azul delete" value="'.$_GET["cod_atividade"].'">Aprovar</button>

        
        ';
      }


      ?>
    </div>        
  </div>
  <dialog>
    <h2>Tem certeza que deseja <?php if (isset($_SESSION['ra_aluno'])) {echo "excluir";} else {echo "aprovar";}?>  a atividade?</h2>
    <div>
      <div class="row gap-8 full">
        <button class="dl-btn close" id="close">Cancelar</button>
          <form action="../server/server.php" method="post" class="full">
            <input name="modal_id" type="hidden" value="0" id="modal_id">
            <?php if (isset($_SESSION['cod_coordenador'])) {echo '
              <input type="hidden" value="'.$_GET["RA_aluno"].'" id="RA_aluno" name="RA_aluno">
              <input type="hidden" value="'.$_GET["titulo"].'" id="titulo" name="titulo">
              <input type="hidden" value="'.$_GET["caminho_anexo"].'" id="caminho_anexo" name="caminho_anexo">
              <input type="hidden" value="'.$_GET["horas_solicitadas"].'" id="horas_solicitadas" name="horas_solicitadas">
              <input type="hidden" value="'.$_GET["data"].'" id="data" name="data">

              ';}?>
            <button class="dl-btn vermelho" type="submit" <?php if (isset($_SESSION['ra_aluno'])) {echo 'name="deletar" id="deletar"';} else {echo 'name="aprovar" id="aprovar"';}?>>Confirmar!</button>
          </div>
        </form>
        
    </div>
  </dialog>
</body>
<script src="main.js"></script>
</html>
