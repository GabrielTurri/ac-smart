<!-- export function Activities() {
  const aprovadas = document.getElementById("aprovadas");
  const pendentes = document.getElementById("pendentes");

  function showApproved() {
    pendentes.style.display = "none";
    aprovadas.style.display = "block";
  }
  function showPendent() {
    aprovadas.style.display = "none";
    pendentes.style.display = "block";
  } -->
<?php
  session_start();
  // CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
  if($_SESSION['ra_aluno'] or $_SESSION['cod_coordenador']){
  } else {
    header("Location: login.html");
  } 

  // conexao com o banco de dados usando as credenciais do Felipe, qualquer integrante do grupo pode usar seu primeiro nome em minusculo como usuario, o resto mantém
  $strcon = mysqli_connect ("ac-smart-database.cha6yq8iwxxu.sa-east-1.rds.amazonaws.com", "felipe", "abcd=1234", "humanitae_db") or die ("Erro ao conectar com o banco");

  // para buscar as atividades daquele usuario logado e printar o titulo de todas as atividades que ele possui
  // da para fazer ifs para mostrar coisas que quiser, exemplo abaixo
  $sql = "SELECT * FROM atividade_complementar WHERE RA_aluno = '".$_SESSION['ra_aluno']."'";
  $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
  $horas_totais_entregues = 0;
  $horas_totais_aprovadas = 0;

  // somar horas entregues pelo aluno e as aprovadas
  foreach($result as $row){
    $horas_totais_entregues += $row["horas_solicitadas"];
    $horas_totais_aprovadas += $row["horas_aprovadas"];
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
  // print_r($_SESSION);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="styles/styles-activities.css">
  <link rel="stylesheet" href="styles/global.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Activities</title>
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
</script>
<body>


  <div class="headerContainer">
    <a href="dashboard.php">
      <img src="assets/icons/arrow-left.svg" alt="">
    </a>
    <div>
      <h2>Minhas AC'S</h2>
    </div>
    <div></div>
  </div>
  
  <div class="activityTabs">
    <button onclick="showApproved()">Aprovadas</button>
    <button onclick="showPendent()">Pendentes</button>
  </div>

  <!-- fazer o cartão da atividade INTEIRA ser clicavel, e direcionar ou abrir mais informações sobre aquela atividade -->
  <?php
    foreach($result as $row){
      
      echo '
        <form class="activityContainer '.$row['status'].'" action="detalhes.php" method="get">
          <input type="hidden" value='.$row["cod_atividade"].' name="cod_atividade" id="cod_atividade">
          <input type="hidden" value='.$row["titulo"].' name="titulo" id="titulo">
          <input type="hidden" value='.$row["descricao"].' name="descricao" id="descricao">
          <input type="hidden" value='.$row["caminho_anexo"].' name="caminho_anexo" id="caminho_anexo">
          <input type="hidden" value='.$row["horas_solicitadas"].' name="horas_solicitadas" id="horas_solicitadas">
          <input type="hidden" value='.$row["data"].' name="data" id="data">
          <input type="hidden" value='.$row["status"].' name="status" id="status">
          <input type="hidden" value='.$row["horas_aprovadas"].' name="horas_aprovadas" id="horas_aprovadas">
          <button type="submit">
            <p>'.$row["titulo"].'</p>
            <span>'.$row["horas_aprovadas"].'H</span>
            <span>'.$row["status"].'</span>
          </button>
        </form>';      
      }
  ?>

  <div class="activityList" id="aprovadas">
    <h2>Atividades Aprovadas</h2>
    <div class="activityContainer">
      <span>Certificado: Python Básico</span>
      <strong>4H</strong>
    </div>
  
    <div class="activityContainer">
      <span>Certificado: Python Básico</span>
      <strong>4H</strong>
    </div>
    
    <div class="activityContainer">
      <span>Certificado: Python Básico</span>
      <strong>4H</strong>
    </div>
    
    <div class="activityContainer">
      <span>Certificado: Python Básico</span>
      <strong>4H</strong>
    </div>
    
    <div class="activityContainer">
      <span>Certificado: Python Básico</span>
      <strong>4H</strong>
    </div>
    
    <div class="activityContainer">
      <span>Certificado: Python Básico</span>
      <strong>4H</strong>
    </div>
  </div>    
  
  <div class="activityList" id="pendentes">
    <h2>Atividades Pendentes</h2>
    <div class="activityContainer">
      <span>Certificado: Python Básico</span>
      <strong>4H</strong>
    </div>
  
    <div class="activityContainer">
      <span>Certificado: Python Básico</span>
      <strong>4H</strong>
    </div>
    
    <div class="activityContainer">
      <span>Certificado: Python Básico</span>
      <strong>4H</strong>
    </div>
    
  </div>
 
</body>
</html>