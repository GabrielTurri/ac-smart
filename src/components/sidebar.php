<aside class="sidebar">
  <div class="user-data">
    <!-- <div class="user-photo-container">
      <img class="user-photo" src="https://avatars.githubusercontent.com/u/90584577?v=4" alt="">
      <div class="overlay">
        <a href="alterar-imagem.html">
          <img src="./assets/icons/edit-3-blue.svg" alt="">
        </a>
      </div>
    </div> -->
    <div class="user-info">
      <div class="info-container">
        <h3>
          Boas Vindas, 
          <?php 
          // Se existir o RA do aluno, exibe o nome dele, senão, o nome completo do coordenador
          echo isset($_SESSION['ra_aluno']) ? ucfirst($_SESSION['nome_aluno']) : ucfirst($_SESSION['nome_coordenador']). " " .ucfirst($_SESSION['sobrenome_coordenador']);
          ?>
        </h3>
        
        <?php 
          // Se existir o RA do aluno, exibe o RA dele
          if (isset($_SESSION['ra_aluno']))
          echo "<h4>RA: ".$_SESSION['ra_aluno']."</h4>";
        ?>
      </div>
      <?php 
      if (isset($_SESSION['ra_aluno'])){
        echo "<p><b>Nome do curso:</b></p>";
        echo "<span>{$_SESSION['nome_curso']}</span>";
        echo "<p><b>Nome do coordenador (a):</b></p> <p>".ucfirst($_SESSION['nome_coordenador'])." " .ucfirst($_SESSION['sobrenome_coordenador']). "</p>";
        echo "<p><b>Email do coordenador (a):</b></p>";        
      } else {
        echo "<p><b>Seu email:</b></p>" ;
      }       
      echo "<p> {$_SESSION['email_coordenador']}</p>";
      ?>
    </div>
    <hr>
    <div class="column menu-buttons">
      
    <?php 
  if (isset($_SESSION['ra_aluno'])){
    echo '<a href="dashboard.php" class="row">
            <button >
              <img src=".\assets\icons\pie-chart.svg" alt="">
             Meu DashBoard
            </button>
        </a>

        <a href="atividades.php" class="row">
          <button >
            <img src=".\assets\icons\file-text.svg" alt="">
            Minhas Atividades
          </button>
        </a>
      
        <a href="entrega.php" class="row">
            <button>
            <img src="./assets/icons/file-plus.svg" alt="">
            Entregar nova Atividade
          </button>
        </a>

        
        <a href="../server/print_pdf.php" class="row" target="_blank">
            <button>
            <img src="./assets/icons/download.svg" alt="">
            Baixar seu histórico de atividades
          </button>
        </a>

        ' ;       
  } else {
    echo '
      <a href="dash_coordenador.php" class="row">
            <button >
              <img src=".\assets\icons\list.svg" alt="">
             Meu DashBoard
            </button>
        </a>
      <div class="cursos">

        <p class="seus-cursos"><b>Seus cursos:</b></p>';
        foreach($_SESSION['cursos'] as $curso =>$quantidade){
          echo '
          <form class="activityContainer" action="../server/server.php" method="post">
            <input type="hidden" value="'.$curso.'" name="nome_curso" id="cod_atividade">
            <button type="submit" name="atividades_coord">';
              if ($quantidade == 0 ) 
                echo '<p>'.$curso.': Nenhuma atividade pendente</p>';
              else if ($quantidade == 1)
                echo '<p>'.$curso.': '.$quantidade.' atividade pendente</p>';
              else 
                echo '<p>'.$curso.': '.$quantidade.' atividades pendentes</p>';
            echo '
            </button>
          </form>'; 
        };
    echo"</div>";
  }       
?>
    </div>

  </div>
    <!-- para imprimir as informações do curso do aluno cadastrado -->
  <form action="../server/server.php" method="post">
    <button type="submit" class="btn-logoff" name="sair" id="sair">
      <!-- <img src="assets/icons/log-out-red.svg" alt=""> -->
      Encerrar Sessão
    </button>
  </form>
</aside>



