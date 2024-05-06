<?php
// https://www.figma.com/proto/aMZnQ8mrDlJntza4xIqTw1/AC-Smart?type=design&node-id=586-2134&scaling=scale-down&page-id=91%3A51&starting-point-node-id=226%3A13

// https://www.w3schools.com/php/php_sessions.asp

// http://18.230.155.48/

// http://localhost/www/pi/index.html

// para criar o ARRAY GLOBAL com as infos do usuario logado no momento
session_start();

// PARA USAR AS SEGUINTES VARIAVEIS GLOBAIS, É NECESSARIO USAR $GLOBALS['x']
$server = "ac-smart-database.cha6yq8iwxxu.sa-east-1.rds.amazonaws.com";
$usuario = "felipe";
$senha = "abcd=1234";   
$banco = "humanitae_db";


function login_aluno(){
    $email = $_POST ['email'];
    $senha = $_POST ['senha'];
    
    // conexão com o banco de dados
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");
    
    // query para verificar se o email esta cadastrado no DB
    $sql = "SELECT * FROM aluno WHERE email_aluno = '".$email."'";
    $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
    
    // validação para ver se encontrou o email inserido
    if ($result -> num_rows == 0) {
        // se não achar, vai retornar para a página de login
        header("Location: ../src/login.html");

    } else {
        // fazer a comparação das senhas, se estiver errado, ir para login.html, senão ir para dashboard
        $linha = mysqli_fetch_array($result);
        $verify = password_verify($senha, $linha["senha_aluno"]); 
        if ($verify == 0) {
            header("Location: ../src/login.html");
        } else {
            // se achar, vai salvar as infos dele no ARRAY GLOBAL SESSION e vai entrar no app
            $_SESSION['ra_aluno'] = $linha['RA_aluno'];
            $_SESSION['nome_aluno'] = $linha['nome_aluno'];
            $_SESSION['sobrenome_aluno'] = $linha['sobrenome_aluno'];
            $_SESSION['email_aluno'] = $linha['email_aluno'];
            $_SESSION['curso'] = $linha['cod_curso'];

            header("Location: ..\src\dashboard.php");
        }        
    }
}

function login_coordenador(){
    // $email = $_POST ['email'];
    // $senha = $_POST ['senha'];

    $email = 'carlos.oliveira@humanitae.edu.br';
    // ana.silva@humanitae.edu.br
    // carlos.oliveira@humanitae.edu.br
    // mariana.costa@humanitae.edu.br
    
    // conexão com o banco de dados
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");
    
    // query para verificar se o email esta cadastrado no DB
    $sql = "SELECT * FROM coordenador WHERE email_coordenador = '".$email."'";
    $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar coordenador no banco!");
    
    // validação para ver se encontrou o email inserido
    if ($result -> num_rows == 0) {
        // se não achar, vai retornar para a página de login
        header("Location: index.html");
        
    } else {
        // se achar, vai salvar as infos dele no ARRAY GLOBAL SESSION e vai entrar no app
        session_unset();
        session_destroy();
        while ($row = $result->fetch_assoc()){
            $_SESSION['cod_coordenador'] = $row['cod_coordenador'];
            $_SESSION['nome_coordenador'] = $row['nome_coordenador'];
            $_SESSION['sobrenome_coordenador'] = $row['sobrenome_coordenador'];
            $_SESSION['email_coordenador'] = $row['email_coordenador'];
        }

        header("Location: ");
    }
}

class Aluno{
    // essa classe terá os MÉTODOS VER(atividadesDb()), INSERIR, EDITAR, EXCLUIR, SAIR(logout)
}
function insertDb(){    
    // vai pegar essas infos do INPUTS, apenas o RA do aluno que deve ser pego pelas infos da SESSION de quando fez o login do aluno
    
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    // $anexo = $_POST['anexo'];
    $horas_solicitadas = $_POST['horas_solicitadas'];
    $data_conclusao = $_POST['data_conclusao'];

    $anexo = "teste";

    // FAZER TODAS AS VALIDAÇÕES DOS DADOS ANTES DE ABRIR CONEXÃO COM O DB

    // SE TODOS OS DADOS ESTIVEREM DE ACORDO, FAZER CONEXÃO COM DB E INSERIR

    // conexao com o DB
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

    // query para inserir tais dados no DB, vai pegar as infos dos inputs e o RA da SESSION
    $sql = "INSERT INTO atividade_complementar (titulo, descricao, caminho_anexo, horas_solicitadas, data, horas_aprovadas, RA_aluno) VALUES ('".$titulo."' , '".$descricao."' , '".$anexo."' ,'".$horas_solicitadas."' ,'".$data_conclusao."' , '0', '".$_SESSION['ra_aluno']."' );"; 

    // Executar a query sql
    mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");

    // redirecionar para a página principal
    header("Location: ../src/dashboard.php");
}

// o aluno só pode editar a atividade que estiver como REPROVADA
// quando ele editar ela, o status vai mudar para PENDENTE, e o coordenador pode avaliar ela novamente
function editDb(){
    // redirect
    echo "botão edit";
}

function atividadesDb(){
    // pegar todas as atividades de um certo usuario
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

    $sql = "SELECT * FROM atividade_complementar WHERE RA_aluno = '".$_SESSION['ra_aluno']."'"; 

    $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");

    if ($result -> num_rows > 0) {
        while ($row = $result->fetch_assoc()){
            echo "{$row["titulo"]}, {$row["RA_aluno"]}  <br>";
        }
    }
}

function sair(){
    // função para sair da sessão, ou seja, sair do login e sair do app
    session_unset();
    session_destroy();
    // redirecionar para a página inicial sem os dados do usuario que estava logado
    header("Location: ../src/login.html");

}

// só o aluno pode deletar a atividade dele mesmo, e só pode fazer isso se o status estiver REPROVADA
// no front mostrar o botão de APAGAR SOMENTE SE ELA FOR REPROVADA
function deletar_ativ(){
    // pegar código da atividade pelo frontend
    $cod_atividade = $_POST['cod_atividade'];

    // PRECISA FAZER AS VALIDAÇÕES DOS DADOS DE ENTRADA, PRECISA VERIFICAR SE O VALOR DO $cod_atividade PERTENCE AO USUARIO QUE ESTA LOGADO, O FELIPE FEZ ESSE TIPO DE VALIDAÇÃO NO OUTRO PROJETO INTEGRADOR, BASTA COPIAR A LÓGICA

    // conexão com o DB
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

    // query SQL para deletar da tabela atividade_complementar a linha que tiver o cod_atividade recebida do frontend
    $sql = "DELETE FROM atividade_complementar WHERE cod_atividade = '".$cod_atividade."'";

    // executar query sql
    mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");
    header("Location: ../src/dashboard.php");
}

class Coordenador {
    // está classe terá os MÉTODOS APROVAR, REPROVAR, SAIR(logout)
    // e os atributos de cod, nome, sobrenome, email 
}

// somente o COORDENADOR pode aprovar
function aprovar(){}

// somente o COORDENADOR pode reprovar
function reprovar(){}

// PARA CHAMAR A FUNÇÃO CERTA DE ACORDO COM O BOTÃO CLICADO
// 'inserir' é o name do input:submit do form
if(isset($_POST['inserir'])){
    insertDb();
} else if(isset($_POST['editar'])){
    editDb();
} else if(isset($_POST['sair'])){
    sair();
} else if(isset($_POST['atividades'])){
    atividadesDb();
} else if(isset($_POST['login'])){
    login_aluno();
} else if(isset($_POST['login_coordenador'])){
    login_coordenador();
} else if (isset($_POST['deletar'])){
    deletar_ativ();
} 