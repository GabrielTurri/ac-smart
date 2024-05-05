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