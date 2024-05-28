<?php
  session_start();
  // CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
  if(!($_SESSION['ra_aluno']))
    header("Location: login.php");
  
  $strcon = mysqli_connect ("137.184.66.198", "felipe", "abcd=1234", "humanitae_db") or die ("Erro ao conectar com o banco");

  // para buscar as atividades daquele usuario logado e printar o titulo de todas as atividades que ele possui
  // da para fazer ifs para mostrar coisas que quiser, exemplo abaixo
  $sql = "SELECT * FROM atividade_complementar WHERE RA_aluno = '".$_SESSION['ra_aluno']."'";
  $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");


  // $_SESSION['aprovadas'] = 0;
  // $_SESSION['arquivadas'] = 0;
  // $_SESSION['reprovadas'] = 0;
  // $_SESSION['pendentes'] = 0;

  // // contagem para saber quantas atividades de cada status o usuário tem
  // foreach($result as $row){

  //   if($row['status'] == "Aprovado"){
  //     $_SESSION['aprovadas'] +=1;
  //   } else if($row['status'] == "Reprovado"){
  //     $_SESSION['reprovadas'] += 1;
  //   }else if($row['status'] == "Pendente"){
  //     $_SESSION['pendentes'] += 1;
  //   } else if($row['status'] == "Arquivado"){
  //     $_SESSION['aprovadas'] += 1;
  //   }
  // }  

  // buscar no banco as informações do curso que o aluno faz, como coordenador, email dele, horas complementares necessarias, nome do curso
  $sql = "SELECT nome_curso, horas_complementares, nome_coordenador, sobrenome_coordenador, email_coordenador FROM curso JOIN coordenador ON curso.coordenador_curso = coordenador.cod_coordenador WHERE cod_curso = '".$_SESSION['curso']."'";
  $result2 = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
  $linha = mysqli_fetch_array($result2);
  
  $_SESSION["nome_curso"] = $linha["nome_curso"];
  $_SESSION["horas_complementares"] = $linha["horas_complementares"];
  $_SESSION["nome_coordenador"] = $linha["nome_coordenador"];
  $_SESSION["sobrenome_coordenador"] = $linha['sobrenome_coordenador'];
  $_SESSION["email_coordenador"] = $linha['email_coordenador'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <link rel="stylesheet" href="styles/atividades.css">
  <link rel="stylesheet" href="styles/global.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>


  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atividades</title>
</head>
<body>
  <?php include './components/sidebar.php' ?>


<div class="dashboard-content">
  <div class="breadcrumb">
    <a href="dashboard.php">Voltar para dashboard</a>
  </div>
  
  <div class="abas-atividades" id="abas-atividades">
    <!-- <button class="aba ativo" onclick="mostrarAprovadas()">Aprovadas</button>
    <button class="aba" onclick="mostrarPendentes()">Pendentes</button>
    <button class="aba" onclick="mostrarReprovadas()">Reprovadas</button> -->
    <button id="aba-aprovadas" class="aba ativo" onclick="">Aprovadas</button>
    <button id="aba-pendentes" class="aba" onclick="">Pendentes</button>
    <button id="aba-reprovadas" class="aba novas-reprovadas" onclick="">Reprovadas</button>
  </div>  
  
  <div class="lista-atividades" id="aprovadas">
    <h2>
      Atividades Aprovadas:
      <?php echo $_SESSION['aprovadas'] ?>
    </h2>
    
    <div class="legenda-lista-atividades">
      <div class="legenda">
        <strong>Título</strong>
      </div>
      <div class="legenda">
        <strong>Horas Aprovadas</strong>
      </div>
    </div>

      <?php
      foreach($result as $row){
        if($row['status'] == "Aprovado"){
          echo '
          <form class="'.$row['status'].'" action="detalhes.php" method="get">
            <button type="submit" class="container-atividade">
              <input type="hidden" value="'.$row["cod_atividade"].'" name="cod_atividade" id="cod_atividade">
              <input type="hidden" value="'.$row["titulo"].'" name="titulo" id="titulo">
              <input type="hidden" value="'.$row["descricao"].'" name="descricao" id="descricao">
              <input type="hidden" value="'.$row["caminho_anexo"].'" name="caminho_anexo" id="caminho_anexo">
              <input type="hidden" value="'.$row["horas_solicitadas"].'" name="horas_solicitadas" id="horas_solicitadas">
              <input type="hidden" value="'.$row["data"].'" name="data" id="data">
              <input type="hidden" value="'.$row["status"].'" name="status" id="status">
              <input type="hidden" value="'.$row["horas_aprovadas"].'" name="horas_aprovadas" id="horas_aprovadas">
                <span>'.$row["titulo"].'</span>
                <strong>'.$row["horas_aprovadas"].'H</strong>
              </button>
            </form>';      
        }
      }
      ?>

    </div>    
    
    <div class="lista-atividades lista-nao-aprovadas" id="pendentes">
      <h2>
        Atividades Pendentes: 
        <?php echo $_SESSION['pendentes'] ?>
      </h2>
      <div class="legenda-lista-atividades">
        <div class="legenda">
          <strong>Título</strong>
        </div>
        <div class="legenda">
          <strong>Horas Solicitadas</strong>
        </div>
      </div>

      <?php
      foreach($result as $row){
        if($row['status'] == "Pendente"){
          echo '
          <div class="row">

            <form class="'.$row['status'].' atividade-pendente full" action="detalhes.php" method="get">
            
              <button type="submit" class="container-atividade">
                <input type="hidden" value="'.$row["cod_atividade"].'" name="cod_atividade" id="cod_atividade">
                <input type="hidden" value="'.$row["titulo"].'" name="titulo" id="titulo">
                <input type="hidden" value="'.$row["descricao"].'" name="descricao" id="descricao">
                <input type="hidden" value="'.$row["caminho_anexo"].'" name="caminho_anexo" id="caminho_anexo">
                <input type="hidden" value="'.$row["horas_solicitadas"].'" name="horas_solicitadas" id="horas_solicitadas">
                <input type="hidden" value="'.$row["data"].'" name="data" id="data">
                <input type="hidden" value="'.$row["status"].'" name="status" id="status">
                <input type="hidden" value="'.$row["horas_aprovadas"].'" name="horas_aprovadas" id="horas_aprovadas">
                <span>'.$row["titulo"].'</span>
                <strong class="">'.$row["horas_solicitadas"].'H</strong>
              </button>
            
            </form>
            <button class="more" onclick="abrirOpcoes()">
              <img src="assets/icons/more-vertical.svg" alt="">
            </button>
          </div>';
      }}?>
    </div>

    <div class="lista-atividades lista-nao-aprovadas" id="reprovadas">
      <h2>
        Atividades Reprovadas: 
        <?php echo $_SESSION['reprovadas'] ?>
      </h2>
      <div class="legenda-lista-atividades">
        <div class="legenda">
          <strong>Título</strong>
        </div>
        <div class="legenda">
          <strong>Horas Solicitadas</strong>
        </div>
      </div>

      <?php
      foreach($result as $row){
        if($row['status'] == "Reprovado"){
          echo '
          <div class="row">

            <form class="'.$row['status'].' atividade-pendente full" action="detalhes.php" method="get">
            
              <button type="submit" class="container-atividade">
                <input type="hidden" value="'.$row["cod_atividade"].'" name="cod_atividade" id="cod_atividade">
                <input type="hidden" value="'.$row["titulo"].'" name="titulo" id="titulo">
                <input type="hidden" value="'.$row["descricao"].'" name="descricao" id="descricao">
                <input type="hidden" value="'.$row["caminho_anexo"].'" name="caminho_anexo" id="caminho_anexo">
                <input type="hidden" value="'.$row["horas_solicitadas"].'" name="horas_solicitadas" id="horas_solicitadas">
                <input type="hidden" value="'.$row["data"].'" name="data" id="data">
                <input type="hidden" value="'.$row["status"].'" name="status" id="status">
                <span class="texto-reprovada">'.$row["titulo"].'</span>
                <strong class="texto-reprovada">'.$row["horas_solicitadas"].'H</strong>
              </button>
            
            </form>
            <button class="more" onclick="abrirOpcoes()">
              <img src="assets/icons/more-vertical.svg" alt="">
            </button>
          </div>';
      }}?>
    </div>


  </div>
</body>

<script>
  // Aplicando a classe ativa na aba de atividade
  var header = document.getElementById("abas-atividades");
  var btns = header.getElementsByClassName("aba");
  for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", async function() {
      var current = document.getElementsByClassName("ativo");
      current[0].className = current[0].className.replace(" ativo", "");
      this.className += " ativo";
      switch(current[0].id) {
        case "aba-aprovadas":
          await mostrarAprovadas();
          break;
        case "aba-pendentes":
          await mostrarPendentes();
          break;
        case "aba-reprovadas":
          await mostrarReprovadas();
          break;
      }
    });
  var pendentes = document.getElementById("pendentes");
  var aprovadas = document.getElementById("aprovadas");
  var reprovadas = document.getElementById("reprovadas");

  function esconderOutros(lista1, lista2) {
    document.getElementById(lista1).style.display = "none";
    document.getElementById(lista2).style.display = "none";
  }

  function mostrarAprovadas() {
    esconderOutros("pendentes", "reprovadas");
    aprovadas.style.display = "flex";
  }
  function mostrarPendentes() {
    esconderOutros("aprovadas", "reprovadas");
    pendentes.style.display = "flex";

  }
  function mostrarReprovadas() {
    esconderOutros("pendentes", "aprovadas");
    reprovadas.style.display = "flex";

  }


  function abrirOpcoes(){
    // Abrir as opções de editar ou excluir
    console.log("Editar/Excluir")
  }
}
</script>
</html>
