<?php
// http://15.229.66.111/

// para criar o ARRAY GLOBAL com as infos do usuario logado no momento
session_start();

// PARA USAR AS SEGUINTES VARIAVEIS GLOBAIS, É NECESSARIO USAR $GLOBALS['x']
$server = "ac-smart-database.cha6yq8iwxxu.sa-east-1.rds.amazonaws.com";
$usuario = "felipe";
$senha = "abcd=1234";   
$banco = "humanitae_db";


function login_aluno(){
    // valores pegados dos inputs 'email' e 'senha'
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
        // verificação das senhas digitada pelo usuário e da senha decifrada do banco de dados
        $verify = password_verify($senha, $linha["senha_aluno"]);
        // caso a verificação seja False, ou seja, se as senhas forem diferentes
        if ($verify == False) {
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
    $email = $_POST ['email'];
    $senha = $_POST ['senha'];
    
    // conexão com o banco de dados
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");
    
    // query para verificar se o email esta cadastrado no DB
    $sql = "SELECT * FROM coordenador WHERE email_coordenador = '".$email."'";
    $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
    
    // validação para ver se encontrou o email inserido
    if ($result -> num_rows == 0) {
        // se não achar, vai retornar para a página de login
        header("Location: ../src/login.html");

    } else {
        // fazer a comparação das senhas, se estiver errado, ir para login.html, senão ir para dashboard
        $linha = mysqli_fetch_array($result);
        $verify = password_verify($senha, $linha["senha_coordenador"]); 
        if ($verify == 0) {
            header("Location: ../src/login.html");
        } else {
            $sql2 = "SELECT DISTINCT nome_curso FROM curso JOIN coordenador ON curso.coordenador_curso = coordenador.cod_coordenador WHERE email_coordenador = '".$email."'";
            $result2 = mysqli_query($strcon, $sql2) or die ("Erro ao tentar encontrar o aluno no banco!");
            
            // se achar, vai salvar as infos dele no ARRAY GLOBAL SESSION e vai entrar no app
            $_SESSION['cod_coordenador'] = $linha['cod_coordenador'];
            $_SESSION['nome_coordenador'] = $linha['nome_coordenador'];
            $_SESSION['sobrenome_coordenador'] = $linha['sobrenome_coordenador'];
            $_SESSION['email_coordenador'] = $linha['email_coordenador'];
            $_SESSION['cursos'] = [];

            // salvar todos os cursos do coordenador em um array dentro de $_SESSION
            foreach ($result2 as $row) {
                $_SESSION['cursos'][$row['nome_curso']] = 0;
            }

            header("Location: ../src/dash_coordenador.php");
        }        
    }
}


class Aluno{
    // essa classe terá 
    public $email;
    public $senha;
    public function login(){
        // valores pegados dos inputs 'email' e 'senha'
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
            // verificação das senhas digitada pelo usuário e da senha decifrada do banco de dados
            $verify = password_verify($senha, $linha["senha_aluno"]);
            // caso a verificação seja False, ou seja, se as senhas forem diferentes
            if ($verify == False) {
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

}

function insertDb(){    
    // vai pegar essas infos do INPUTS, apenas o RA do aluno que deve ser pego pelas infos da SESSION de quando fez o login do aluno
    
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $horas_solicitadas = $_POST['horas_solicitadas'];
    $data_conclusao = $_POST['data_conclusao'];

    // Replace any characters not \w- in the original filename
    $pathinfo = pathinfo($_FILES["anexo"]["name"]);
    $base = $pathinfo["filename"];
    $base = preg_replace("/[^\w-]/", "_", $base);
    $filename = $base . "." . $pathinfo["extension"];
    $destination = __DIR__ . "/uploads/" . $filename;
    $caminho_anexo = "/uploads/" . $filename;

    // Add a numeric suffix if the file already exists
    $i = 1;

    while (file_exists($destination)) {
        $filename = $base . "($i)." . $pathinfo["extension"];
        $destination = __DIR__ . "/uploads/" . $filename;
        $i++;
    }

    if ( ! move_uploaded_file($_FILES["anexo"]["tmp_name"], $destination)) {
        exit("Can't move uploaded file");
    }

    // FAZER TODAS AS VALIDAÇÕES DOS DADOS ANTES DE ABRIR CONEXÃO COM O DB

    // SE TODOS OS DADOS ESTIVEREM DE ACORDO, FAZER CONEXÃO COM DB E INSERIR
    
    // conexao com o DB
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

    // // query para inserir tais dados no DB, vai pegar as infos dos inputs e o RA da SESSION
    $sql = "INSERT INTO atividade_complementar (titulo, descricao, caminho_anexo, horas_solicitadas, data, horas_aprovadas, RA_aluno) VALUES ('".$titulo."' , '".$descricao."' , '".$caminho_anexo."' ,'".$horas_solicitadas."' ,'".$data_conclusao."' , '0', '".$_SESSION['ra_aluno']."' );"; 

    // // Executar a query sql
    mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");

    // // redirecionar para a página principal
    header("Location: ../src/dashboard.php");
        
}

// o aluno só pode editar a atividade que estiver como REPROVADA
// quando ele editar ela, o status vai mudar para PENDENTE, e o coordenador pode avaliar ela novamente
function inserir_aluno(){
    // vai pegar essas infos do INPUTS, apenas o RA do aluno que deve ser pego pelas infos da SESSION de quando fez o login do aluno
    
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $cod_curso = $_POST['cod_curso'];
    $password = $_POST['password'];

    $hash = password_hash($password, PASSWORD_DEFAULT);

    // FAZER TODAS AS VALIDAÇÕES DOS DADOS ANTES DE ABRIR CONEXÃO COM O DB

    // SE TODOS OS DADOS ESTIVEREM DE ACORDO, FAZER CONEXÃO COM DB E INSERIR

    // conexao com o DB
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

    // query para inserir tais dados no DB, vai pegar as infos dos inputs e o RA da SESSION
    $sql = "INSERT INTO aluno (nome_aluno, sobrenome_aluno, email_aluno, cod_curso, senha_aluno) VALUES ('".$nome."' , '".$sobrenome."' , '".$email."' ,'".$cod_curso."' ,'".$hash."');"; 

    // Executar a query sql
    mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");

    // redirecionar para a página principal
    header("Location: inserir_aluno.html");
}

function editar_atividade(){
    // vai pegar essas infos do INPUTS, apenas o RA do aluno que deve ser pego pelas infos da SESSION de quando fez o login do aluno
    $cod_atividade = $_POST["cod_atividade"];
    $titulo = ucfirst($_POST['titulo']);
    $descricao = ucfirst($_POST['descricao']);
    $horas_solicitadas = $_POST['horas_solicitadas'];
    $data_conclusao = $_POST['data_conclusao'];


    // validar se a atividade pretence ao aluno logado, se não for dele, vai ser redirecionado para o dashboard novamente
    if(!in_array($cod_atividade, $_SESSION['atividades_aluno']) or !$cod_atividade){
        header("Location: ../src/dashboard.php");
    } else {
        $mudancas = 0;
        // atualizar os campos no banco de dados caso eles existam
        // conexao com o DB
        $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

        if($titulo){
            $sql = "UPDATE atividade_complementar SET titulo = '".$titulo."' WHERE cod_atividade = ".$cod_atividade.";"; 
            mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");
            $mudancas +=1;
        }
        if($descricao){
            $sql = "UPDATE atividade_complementar SET descricao = '".$descricao."' WHERE cod_atividade = '".$cod_atividade."';"; 
            mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");
            $mudancas +=1;
        }
        if($horas_solicitadas){
            $sql = "UPDATE atividade_complementar SET horas_solicitadas = ".$horas_solicitadas." WHERE cod_atividade = '".$cod_atividade."';"; 
            // die($sql);
            mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");
            $mudancas +=1;
        }
        if($data_conclusao){
            $sql = "UPDATE atividade_complementar SET data = '".$data_conclusao."' WHERE cod_atividade = '".$cod_atividade."';"; 
            mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");
            $mudancas +=1;
        }
        
        if($_FILES["anexo"]["name"]){
             // Replace any characters not \w- in the original filename
            $pathinfo = pathinfo($_FILES["anexo"]["name"]);
            $base = $pathinfo["filename"];
            $base = preg_replace("/[^\w-]/", "_", $base);
            $filename = $base . "." . $pathinfo["extension"];
            $destination = __DIR__ . "/uploads/" . $filename;
            $caminho_anexo = "/uploads/" . $filename;

            // Add a numeric suffix if the file already exists
            $i = 1;

            while (file_exists($destination)) {
                $filename = $base . "($i)." . $pathinfo["extension"];
                $destination = __DIR__ . "/uploads/" . $filename;
                $i++;
            }

            if (! move_uploaded_file($_FILES["anexo"]["tmp_name"], $destination)) {
                exit("Can't move uploaded file");
            }

            $sql = "UPDATE atividade_complementar SET caminho_anexo = '".$caminho_anexo."' WHERE cod_atividade = '".$cod_atividade."';";
            mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");
            $mudancas +=1;


        } else {
            echo 'não existe';
        }
        
        

    }
    if($mudancas > 0){
        $sql = "UPDATE atividade_complementar SET status = 'Pendente' WHERE cod_atividade = $cod_atividade;";
        mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");
    }
    header("Location: ../src/dashboard.php");

    

    // Replace any characters not \w- in the original filename
    // $pathinfo = pathinfo($_FILES["anexo"]["name"]);
    // $base = $pathinfo["filename"];
    // $base = preg_replace("/[^\w-]/", "_", $base);
    // $filename = $base . "." . $pathinfo["extension"];
    // $destination = __DIR__ . "/uploads/" . $filename;
    // $caminho_anexo = "/uploads/" . $filename;

    // Add a numeric suffix if the file already exists
    // $i = 1;

    // while (file_exists($destination)) {
    //     $filename = $base . "($i)." . $pathinfo["extension"];
    //     $destination = __DIR__ . "/uploads/" . $filename;
    //     $i++;
    // }

    // if (! move_uploaded_file($_FILES["anexo"]["tmp_name"], $destination)) {
    //     exit("Can't move uploaded file");
    // }

    // FAZER TODAS AS VALIDAÇÕES DOS DADOS ANTES DE ABRIR CONEXÃO COM O DB

    // SE TODOS OS DADOS ESTIVEREM DE ACORDO, FAZER CONEXÃO COM DB E INSERIR
    
    // conexao com o DB
    // $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

    //  query para inserir tais dados no DB, vai pegar as infos dos inputs e o RA da SESSION
    // $sql = "INSERT INTO atividade_complementar (titulo, descricao, caminho_anexo, horas_solicitadas, data, horas_aprovadas, RA_aluno) VALUES ('".$titulo."' , '".$descricao."' , '".$caminho_anexo."' ,'".$horas_solicitadas."' ,'".$data_conclusao."' , '0', '".$_SESSION['ra_aluno']."' );"; 

    // // Executar a query sql
    // mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");

    // // redirecionar para a página principal
    // header("Location: ../src/dashboard.php");
    
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

// somente o COORDENADOR pode aprovar
function aprovar(){
    // pegar código da atividade pelo frontend
    $cod_atividade = $_POST['cod_atividade'];
    $horas_solicitadas = $_POST['horas_solicitadas'];
    
    // conexão com o DB
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

    // query SQL para deletar da tabela atividade_complementar a linha que tiver o cod_atividade recebida do frontend
    $sql = "UPDATE atividade_complementar SET status = 'Aprovado', horas_aprovadas = '".$horas_solicitadas."' WHERE cod_atividade = '".$cod_atividade."'";

    // executar query sql
    mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");

    header("Location: ../src/atividades_coord.php");
}

// somente o COORDENADOR pode reprovar
function reprovar(){
    // pegar observação digitada pelo coordenador
    $observacao = $_POST['observacao'];
    $cod_atividade = $_POST['cod_atividade'];

    // caso o campo esteja preenchido, o status da atividade será alterada para "Reprovado", e a observação será salva na tabela observacao_atividade
    if (strlen($observacao) > 0){
        // conexão com o DB
        $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

        // query SQL para mudar status da atividade para REPROVADO da tabela atividade_complementar
        $sql = "UPDATE atividade_complementar SET status = 'Reprovado' WHERE cod_atividade = '".$cod_atividade."'";

        // executar query sql
        mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");

        // query SQL para adicionar uma observação na tabela observacao_atividade
        $sql = "INSERT INTO observacao_atividade (observacao, cod_atividade) VALUES ('".$observacao."', '".$cod_atividade."');";
           

        // executar query sql
        mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");

        header("Location: ../src/atividades_coord.php");

    } else {
        // será redirecionado para a página de atividades para ele avaliar novamente, já que essa avaliação não deu certo pois não inserir nenhum comentário para o aluno
        header("Location: ../src/atividades_coord.php");        
    }

}


function inserir_coordenador(){
    // vai pegar essas infos do INPUTS, apenas o RA do aluno que deve ser pego pelas infos da SESSION de quando fez o login do aluno
    
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    // $cod_curso = $_POST['cod_curso'];
    $password = $_POST['password'];

    $hash = password_hash($password, PASSWORD_DEFAULT);

    // FAZER TODAS AS VALIDAÇÕES DOS DADOS ANTES DE ABRIR CONEXÃO COM O DB

    // SE TODOS OS DADOS ESTIVEREM DE ACORDO, FAZER CONEXÃO COM DB E INSERIR

    // conexao com o DB
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

    // query para inserir tais dados no DB, vai pegar as infos dos inputs e o RA da SESSION
    $sql = "INSERT INTO coordenador (nome_coordenador, sobrenome_coordenador, email_coordenador, senha_coordenador) VALUES ('".$nome."' , '".$sobrenome."' , '".$email."' ,'".$hash."');"; 

    // Executar a query sql
    mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");

    // redirecionar para a página principal
    header("Location: inserir_coordenador.html");
}

function atualizar(){
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

    // query para inserir tais dados no DB, vai pegar as infos dos inputs e o RA da SESSION
    // $sql = "INSERT INTO curso (nome_curso, horas_complementares, coordenador_curso) VALUES ('Engenharia de Software', 200, 4);"; 
    // $sql = "INSERT INTO curso (nome_curso, horas_complementares, coordenador_curso) VALUES('Análise e Desenvolvimento de Sistemas', 200, 5)"; 
    // $sql = "UPDATE atividade_complementar SET status = 'Aprovado' WHERE cod_atividade = 21;"; 
    $sql = "UPDATE atividade_complementar SET status = 'Pendente' WHERE cod_atividade = 44;"; 


    // Executar a query sql
    mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");

    // redirecionar para a página principal
    header("Location: inserir_coordenador.html");
}
function atividades_coord(){
    $nome_curso = $_POST['nome_curso'];
    $_SESSION['nome_curso'] = $nome_curso;
   
    header("Location: ../src/atividades_coord.php");
}

// PARA CHAMAR A FUNÇÃO CERTA DE ACORDO COM O BOTÃO CLICADO
// 'inserir' é o name do input:submit do form
if(isset($_POST['inserir'])){
    insertDb();
} else if(isset($_POST['editar'])){
    editar_atividade();
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
} else if (isset($_POST['inserir_aluno'])){
    inserir_aluno();
} else if (isset($_POST['inserir_coordenador'])){
    inserir_coordenador();
} else if (isset($_POST['atualizar'])){
    atualizar();
} else if (isset($_POST['atividades_coord'])){
    atividades_coord();
} else if (isset($_POST['aprovar'])){
    aprovar();
} else if (isset($_POST['reprovar'])){
    reprovar();
} else if (isset($_POST['reprovar'])){
    reprovar();
}



