
<?php
session_start();
// CÓDIGO PARA PREVINIR ENTRAR NESSA PÁGINA SEM ESTAR LOGADO
if($_SESSION['ra_aluno'] or $_SESSION['cod_coordenador']){
// if(!$_SESSION['ra_aluno']){
} else {
    header("Location: index.html");
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h1>DENTRO DO APP</h1>
        <?php
            echo "<h3>{$_SESSION['nome_aluno']}</h3><br>";
            echo "<h3>{$_SESSION['email_aluno']}</h3><br>";
        ?>

        <form action="server.php" method="post">
            
            <p>Botão 'INSERIR' vai inserir no banco de dados os dados dos inputs (que não estão criados ainda), ESTÁ SEM VALIDAÇÃO, porem já esta funcionando se alterar as variaveis dentro da função. Esta pegando valores fixos, mas basta alterar para os valores vindos do input</p>
            <!-- <input type="submit" value="Inserir" name="inserir"> -->
            <a href="inserir.html">Página inserir</a>
            <p>Editar não tem nada feito ainda, vai pegar o id da atividade (que vai estar atrelada ao botão) e vai fazer um EDIT no banco.</p>
            <input type="submit" value="editar" name="editar">

            <p>Botão 'ATIVIDADES' vai fazer um SELECT no DB com o id do aluno logado (pegar id pelo $_SESSION)</p>
            <input type="submit" value="atividades" name="atividades">
            
            <p>Botão de 'Deletar' vai executar o comando sql para deletar a linha do banco que tiver o 'cod_atividade' inserido</p>
            <input type="submit" value="Deletar" name="deletar">



            <p>Botão SAIR para deletar todas as infos do array SESSION, e redirecionar o usuario para a tela de login.
            </p>
            <input type="submit" value="sair" name="sair">
        </form>
    </div>
</body>
</html>
