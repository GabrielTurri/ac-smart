<aside class="sidebar">
  <div class="user-data text-center">
    <div class="user-photo-container">
      <img class="user-photo" src="https://avatars.githubusercontent.com/u/90584577?v=4" alt="">
      <div class="overlay">
        <a href="alterar-imagem.html">
          <img src="./assets/icons/edit-3-blue.svg" alt="">
        </a>
      </div>
    </div>
    <h3>Boas Vindas, <?php echo ucfirst($_SESSION['nome_aluno'])?></h3>
    <h4>RA: <?php echo $_SESSION['ra_aluno']?></h4>
    <div class="user-info">
      <h3>Nome do curso:</h3>
      <?php echo "<span>{$_SESSION['nome_curso']}</span>";
        echo "<p><b>Nome do coordenador (a):</b></p> <p>".ucfirst($_SESSION['nome_coordenador'])." " .ucfirst($_SESSION['sobrenome_coordenador']). "</p>";
        echo "<p><b>Email do coordenador (a):</b></p> <p> {$_SESSION['email_coordenador']}</p>"
      ?>
    </div>
  </div>
    <!-- para imprimir as informações do curso do aluno cadastrado -->
  <form action="../server/server.php" method="post">
    <button type="submit" value="Encerrar Sessão" name="sair" id="sair">
      <!-- <img src="assets/icons/log-out-red.svg" alt=""> -->
      Encerrar Sessão
    </button>
  </form>
</aside>