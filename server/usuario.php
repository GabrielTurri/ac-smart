<?php
class Usuario{
    public $codigo;
    public $nome;
    public $sobrenome;
    public $email;
    public $senha;

    public function __construct($email, $senha){
        $this->setEmail($email);
        $this->setSenha($senha);
    }

    // getEmail é para retornar o atributo email para algum lugar
    public function getEmail(){
        return $this->email;
    }

    // setEmail é onde vamos colocar um valor como parametro quando for usar o objeto
    public function setEmail($e){
        // $email = filter_var($e, FILTER_SANITIZE_EMAIL);
        $this->email = $e;
    }

    // getEmail é para retornar o atributo senha para algum lugar
    public function getSenha(){
        return $this->senha;
    }
    public function setSenha($s){
        $this->senha = $s;
    }

    public function ver_atividades(){
        // consultar no banco as atividades do usuario
        // se for aluno são as que ele enviou
        // se for coordenador, mostrar as que ele tem para avaliar
    }
    public function sair(){
        // deslogar do sistema
        // função para sair da sessão, ou seja, sair do login e sair do app
        session_unset();
        session_destroy();

        // redirecionar para a página inicial sem os dados do usuario que estava logado    
        header("Location: ../src/login.php");
    }
}

class Aluno extends Usuario{
    public $cod_curso;

    public function login(){
        // conexão com o banco de dados
        $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");
        
        // query para verificar se o email esta cadastrado no DB
        $sql = "SELECT * FROM aluno WHERE email_aluno = '".$this->email."';";
        $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
        
        // validação para ver se encontrou o email inserido
        if ($result -> num_rows == 0) {
            // se não achar, vai retornar para a página de login
            $_SESSION['message'] = 'E-mail incorreto, tente novamente!';
            $_SESSION['message_type'] = 'warning';

            header("Location: ../src/login.php");

        } else {
            // fazer a comparação das senhas, se estiver errado, ir para login.php, senão ir para dashboard
            $linha = mysqli_fetch_array($result);
            // verificação das senhas digitada pelo usuário e da senha decifrada do banco de dados
            $verify = password_verify($this->senha, $linha["senha_aluno"]);
            // caso a verificação seja False, ou seja, se as senhas forem diferentes
            if ($verify == False) {
                $_SESSION['message'] = 'Senha incorreta, tente novamente!';
                $_SESSION['message_type'] = 'warning';

                header("Location: ../src/login.php");
            } else {
                // se achar, vai salvar as infos dele no ARRAY GLOBAL SESSION e vai entrar no app
                $_SESSION['ra_aluno'] = $linha['RA_aluno'];
                $_SESSION['nome_aluno'] = $linha['nome_aluno'];
                $_SESSION['sobrenome_aluno'] = $linha['sobrenome_aluno'];
                $_SESSION['email_aluno'] = $linha['email_aluno'];
                $_SESSION['curso'] = $linha['cod_curso'];
                header("Location: ..\src\dashboard.php");
                
                $this->codigo = $linha['RA_aluno'];
                $this->nome = $linha['nome_aluno'];
                $this->sobrenome = $linha['sobrenome_aluno'];
                $this->email = $linha['email_aluno'];
                $this->cod_curso = $linha['cod_curso'];
            }        
        }
    }
    public function inserir_atividade(){
        // função para enviar ativiade para o coordenador
    }
    public function editar_atividade(){}
    // editar atividade em questão
    public function arquivar_ativiadade(){}
    // arquivar ativiadde em questão, ou seja, 'deletar' ela
}

class Coordenador extends Usuario{
    public function login(){        
        // conexão com o banco de dados
        $strcon = mysqli_connect ($GLOBALS['server'], $GLOBALS['usuario'], $GLOBALS['senha'], $GLOBALS['banco']) or die ("Erro ao conectar com o banco");
        
        // query para verificar se o email esta cadastrado no DB
        $sql = "SELECT * FROM coordenador WHERE email_coordenador = '".$this->email."';";
        $result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");
        
        // validação para ver se encontrou o email inserido
        if ($result -> num_rows == 0) {
            // se não achar, vai retornar para a página de login
            $_SESSION['message'] = 'E-mail incorreto, tente novamente!';
            $_SESSION['message_type'] = 'warning';
    
            header("Location: ../src/login.php");
    
        } else {
            // fazer a comparação das senhas, se estiver errado, ir para login.php, senão ir para dashboard
            $linha = mysqli_fetch_array($result);
            $verify = password_verify($this->senha, $linha["senha_coordenador"]); 
            if ($verify == 0) {
                $_SESSION['message'] = 'Senha incorreta, tente novamente!';
                $_SESSION['message_type'] = 'warning';
    
                header("Location: ../src/login.php");
            } else {
                $sql2 = "SELECT DISTINCT nome_curso FROM curso JOIN coordenador ON curso.coordenador_curso = coordenador.cod_coordenador WHERE email_coordenador = '".$this->email."'";
                $result2 = mysqli_query($strcon, $sql2) or die ("Erro ao tentar encontrar o aluno no banco!");
                
                // se achar, vai salvar as infos dele no ARRAY GLOBAL SESSION e vai entrar no app
                $_SESSION['cod_coordenador'] = $linha['cod_coordenador'];
                $_SESSION['nome_coordenador'] = $linha['nome_coordenador'];
                $_SESSION['sobrenome_coordenador'] = $linha['sobrenome_coordenador'];
                $_SESSION['email_coordenador'] = $linha['email_coordenador'];
                $_SESSION['cursos'] = [];

                $this->codigo = $linha['cod_coordenador'];
                $this->nome = $linha['nome_coordenador'];
                $this->sobrenome = $linha['sobrenome_coordenador'];
                $this->email = $linha['email_coordenador'];
    
                // salvar todos os cursos do coordenador em um array dentro de $_SESSION
                foreach ($result2 as $row) {
                    $_SESSION['cursos'][$row['nome_curso']] = 0;
                }
    
                header("Location: ../src/dash_coordenador.php");
            }        
        }
    }
    public function aprovar_atividade(){
        // aprovar atividade
    }
    public function reprovar_atividade(){
        // reprovar atividade
    }

}

// $usuario = new Usuario(trim($_POST ['email']), $_POST ['senha']);