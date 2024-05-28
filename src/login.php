<?php
  include("../server/server.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <link rel="stylesheet" href="styles/global.css">
  <link rel="stylesheet" href="styles/login.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>

  <title>Fazer Login</title>
</head>
<body>
  <div class="column-container center-absolute">
    <img class="app-logo" src="assets/main-logo.svg" alt="" />

    <div class="column-container">
      <div id="abas-login">
        <div class="aba aba-aluno ativo" onclick="loginAluno()">Aluno</div>
        <div class="aba aba-professor" onclick="loginProfessor()">Professor</div>
      </div>
      <form action="../server/server.php" method="post" id="aluno" class="column-container"> 
        <h1>Fazer Login</h1>
        <?php
        flash();?>
        <input class="login-input" placeholder='E-mail do aluno' type="text" name="email" autofocus/>
        <input class="login-input" placeholder='Senha' type="password" name="senha"/>
        
        <input type="submit" name="login" class="botao-login" id="login" value="Entrar">       
    
        <div class="login-footer">
          <a class="forget" href="">Esqueci minha senha</a>
          <span class="aviso">Não tem uma conta? Entre em contato com a universidade.</span>
        </div>    
      
      </form>
  
      <form action="../server/server.php" method="post" id="professor" class="column-container">
        <div class="column-container">
          <h1>Fazer Login</h1>
          <input class="login-input" placeholder='E-mail do professor' type="text" name="email" autofocus/>
          <input class="login-input" placeholder='Senha' type="password" name="senha"/>
          
          <input type="submit" name="login_coordenador" class="botao-login" id="login_coordenador" value="Entrar">       
      
          <div class="login-footer">
            <a class="forget" href="">Esqueci minha senha</a>
            <span class="aviso">Não tem uma conta? Entre em contato com a universidade.</span>
          </div>    
        </div>
      </form>
    </div>
  </div>

</body>

<script>
  // Aplicando a classe ativa na aba de login
  var header = document.getElementById("abas-login");
  var btns = header.getElementsByClassName("aba");
  for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
      var current = document.getElementsByClassName("ativo");
      current[0].className = current[0].className.replace(" ativo", "");
      this.className += " ativo";
    });

  function loginAluno() {
    document.getElementById("professor").style.display = "none";
    document.getElementById("aluno").style.display = "flex";
  }
  function loginProfessor() {
    document.getElementById("aluno").style.display = "none";
    document.getElementById("professor").style.display = "flex";
  } 
  }
</script>
</html>