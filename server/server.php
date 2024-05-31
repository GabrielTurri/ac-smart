<?php
// http://15.229.66.111/

// para criar o ARRAY GLOBAL com as infos do usuario logado no momento
session_start();
include_once("usuario.php");

// PARA USAR AS SEGUINTES VARIAVEIS GLOBAIS, É NECESSARIO USAR $GLOBALS['x']
$server = "137.184.66.198";
$usuario = "felipe";
$senha = "abcd=1234";   
$banco = "humanitae_db";

// definição dos tipos de flash messages
function flash() {
    if(isset($_SESSION["message"])){
        echo "<span class={$_SESSION['message_type']}>{$_SESSION['message']}</span>";
        unset($_SESSION["message"]);
        unset($_SESSION["message_type"]);
      }
}


function login($tipo_usuario){
    // se for aluno (1), então criar um objeto aluno e fazer o login nele
    if($tipo_usuario == 1){
        $aluno = new Aluno(trim($_POST ['email']), $_POST ['senha']);
        $aluno->login();
        
    // se for coordenador (2), criar objeto coordenador e fazer login nele
    } else if($tipo_usuario == 2){
        $coordenador = new Coordenador(trim($_POST ['email']), $_POST ['senha']);
        $coordenador->login();
    }
    
}

function insertDb(){    
    // vai pegar essas infos do INPUTS, apenas o RA do aluno que deve ser pego pelas infos da SESSION de quando fez o login do aluno
    
    $titulo = ucfirst(trim($_POST['titulo']));
    $descricao = ucfirst(trim($_POST['descricao']));
    $horas_solicitadas = $_POST['horas_solicitadas'];
    $data_conclusao = $_POST['data_conclusao'];

    // validação para checar se tem algum arquivo enviado
    if($_FILES["anexo"]["size"] == 0){
        // mostrar mensagem de erro caso não tenha arquivo
        $_SESSION['message'] = 'Campo "anexo" obrigatório!';
        $_SESSION['message_type'] = 'warning';

        header("Location: ../src/entrega.php");      
    } 
    
    else {
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

        // conexao com o DB
        $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

        // // query para inserir tais dados no DB, vai pegar as infos dos inputs e o RA da SESSION
        $sql = "INSERT INTO atividade_complementar (titulo, descricao, caminho_anexo, horas_solicitadas, data, horas_aprovadas, RA_aluno) VALUES ('".$titulo."' , '".$descricao."' , '".$caminho_anexo."' ,'".$horas_solicitadas."' ,'".$data_conclusao."' , '0', '".$_SESSION['ra_aluno']."' );"; 

        // // Executar a query sql
        mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir atividade");
        $_SESSION['message'] = 'Atividade enviada com sucesso!';
        $_SESSION['message_type'] = 'success';

        // // redirecionar para a página principal
        header("Location: ../src/dashboard.php");
        }

        
}

// o aluno só pode editar a atividade que estiver como REPROVADA ou PENDENTE
// quando ele editar ela, o status vai mudar para PENDENTE, e o coordenador pode avaliar ela novamente
function editar_atividade(){
    // vai pegar essas infos do INPUTS, apenas o RA do aluno que deve ser pego pelas infos da SESSION de quando fez o login do aluno
    $cod_atividade = $_POST["cod_atividade"];
    $titulo = ucfirst(trim($_POST['titulo']));
    $descricao = ucfirst(trim($_POST['descricao']));
    $horas_solicitadas = $_POST['horas_solicitadas'];
    $data_conclusao = $_POST['data_conclusao'];


    // validar se a atividade pretence ao aluno logado, se não for dele, vai ser redirecionado para o dashboard novamente
    if(!$cod_atividade or !is_numeric($cod_atividade) or !in_array($cod_atividade, $_SESSION['atividades_aluno']))
    {
        $_SESSION['message'] = "Error!";
        $_SESSION['message_type'] = 'danger';
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
        $_SESSION['message'] = 'Edição feita com sucesso!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Nenhuma alteração realizada!';
        $_SESSION['message_type'] = 'secondary';
    }
    header("Location: ../src/dashboard.php");

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

// está criando um novo objeto com classe Usuario para fazer o logout do sistema
function sair(){
    // função para sair da sessão, ou seja, sair do login e sair do app
    $usuario = new Usuario($_SESSION['email_aluno'], $_SESSION['senha']);
    $usuario->sair();
}

function deletar_ativ(){
    // pegar código da atividade pelo frontend
    $cod_atividade = $_POST['modal_id'];

    // PRECISA FAZER AS VALIDAÇÕES DOS DADOS DE ENTRADA, PRECISA VERIFICAR SE O VALOR DO $cod_atividade PERTENCE AO USUARIO QUE ESTA LOGADO, O FELIPE FEZ ESSE TIPO DE VALIDAÇÃO NO OUTRO PROJETO INTEGRADOR, BASTA COPIAR A LÓGICA
    if(!$cod_atividade or !is_numeric($cod_atividade) or !in_array($cod_atividade, $_SESSION['atividades_aluno'])) {
        $_SESSION['message'] = 'Erro!';
        $_SESSION['message_type'] = 'danger';
        header("Location: ../src/dashboard.php");
    } else {
        // conexão com o DB
        $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

        // arquivar atividade, não deletar do banco
        $sql = "UPDATE atividade_complementar SET status = 'Arquivado', horas_aprovadas = 0 WHERE cod_atividade = '".$cod_atividade."';"; 


        // executar query sql
        mysqli_query($strcon, $sql) or die ("Erro ao tentar deletar atividade");
        $_SESSION['message'] = 'Atividade excluída com sucesso!';
        $_SESSION['message_type'] = 'secondary';
        header("Location: ../src/dashboard.php");
    }

    
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
    mysqli_query($strcon, $sql) or die ("Erro ao tentar aprovar atividade");
    $_SESSION['message'] = 'Atividade aprovada com sucesso!';
    $_SESSION['message_type'] = 'success';

    header("Location: ../src/atividades_coord.php");
}

// somente o COORDENADOR pode reprovar
function reprovar(){
    // pegar observação digitada pelo coordenador
    $observacao = ucfirst(trim($_POST['observacao']));
    $cod_atividade = $_POST['cod_atividade'];

    $min_ob = 15;
    // caso o campo esteja preenchido, o status da atividade será alterada para "Reprovado", e a observação será salva na tabela observacao_atividade
    if (strlen($observacao) > $min_ob){
        // conexão com o DB
        $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

        // query SQL para mudar status da atividade para REPROVADO da tabela atividade_complementar
        $sql = "UPDATE atividade_complementar SET status = 'Reprovado' WHERE cod_atividade = '".$cod_atividade."'";

        // executar query sql
        mysqli_query($strcon, $sql) or die ("Erro ao tentar reprovar atividade");

        // query SQL para adicionar uma observação na tabela observacao_atividade
        $sql = "INSERT INTO observacao_atividade (observacao, cod_atividade) VALUES ('".$observacao."', '".$cod_atividade."');";
           

        // executar query sql
        mysqli_query($strcon, $sql) or die ("Erro ao tentar inserir observação");
        $_SESSION['message'] = 'Atividade reprovada com sucesso!';
        $_SESSION['message_type'] = 'success';


        header("Location: ../src/atividades_coord.php");

    } else {
        // será redirecionado para a página de atividades para ele avaliar novamente, já que essa avaliação não deu certo pois não inserir nenhum comentário para o aluno
        $_SESSION['message'] = "Campo 'Observação' deve ter ao menos ".$min_ob." caracteres!";
        $_SESSION['message_type'] = 'warning';

        header("Location: ../src/atividades_coord.php");        
    }

}

function atualizar(){
    $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");

    // query para inserir tais dados no DB, vai pegar as infos dos inputs e o RA da SESSION
    // $sql = "INSERT INTO curso (nome_curso, horas_complementares, coordenador_curso) VALUES ('Engenharia de Software', 200, 4);"; 
    // $sql = "INSERT INTO curso (nome_curso, horas_complementares, coordenador_curso) VALUES('Análise e Desenvolvimento de Sistemas', 200, 5)"; 
    // $sql = "UPDATE atividade_complementar SET status = 'Aprovado' WHERE cod_atividade = 21;"; 
    // $sql = "UPDATE atividade_complementar SET status = 'Pendente' WHERE cod_atividade = 44;"; 
    // $sql = "UPDATE atividade_complementar SET status = 'Pendente';"; 
    $sql = "UPDATE atividade_complementar SET status = 'Arquivado', horas_aprovadas = 0 WHERE cod_atividade = 42;"; 
    // $sql = "UPDATE atividade_complementar SET horas_aprovadas = 0;"; 


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
    login(1);
} else if(isset($_POST['login_coordenador'])){
    login(2);
} else if (isset($_POST['deletar'])){
    deletar_ativ();
} else if (isset($_POST['atualizar'])){
    atualizar();
} else if (isset($_POST['atividades_coord'])){
    atividades_coord();
} else if (isset($_POST['aprovar'])){
    aprovar();
} else if (isset($_POST['reprovar'])){
    reprovar();
}