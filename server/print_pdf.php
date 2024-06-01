<?php

include_once("../dompdf/autoload.inc.php");
include_once("server.php");

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options;
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);

// configurar para tamanho A4 em pé
$dompdf->setPaper("A4", "portriat");

$html = "<style>
table {
  font-family: arial, sans-serif;
  table-layout: fixed;
  border-collapse: collapse;
  width: 100%;

}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
  word-wrap: break-word;
}


</style>

<div class='info_aluno'>
    <h3>Informações do aluno (a):</h3>
    <p>Nome: {$_SESSION['nome_aluno']} {$_SESSION['sobrenome_aluno']}</p>
    <p>E-mail: {$_SESSION['email_aluno']}</p>
    <p>RA: {$_SESSION['ra_aluno']}</p>
    <p>Horas complementares atuais REPROVADAS: {$_SESSION['horas_reprovadas']}</p>
    <p>Horas complementares atuais EXCLUÍDAS: {$_SESSION['horas_arquivadas']}</p>
    <p>Horas complementares atuais PENDENTES DE AVALIAÇÃO: {$_SESSION['horas_pendentes']}</p>
</div>

<hr>

<div class='info_curso'>
<h3>Informações do curso:</h3>
    <h4>Nome do curso: {$_SESSION['nome_curso']}</h4>
    <h4>Nome do coordenador (a): {$_SESSION['nome_coordenador']} {$_SESSION['sobrenome_coordenador']}</h4>
    <p>E-mail do coordenador (a): {$_SESSION['email_coordenador']}</p>
    <p>Horas complementares atuais APROVADAS: {$_SESSION['horas_aprovadas']}</p>
    <p>Horas complementares NECESSÁRIAS: {$_SESSION['horas_complementares']}</p>
    
    <h4>Disciplinas:</h4>
";

// conexao com o banco de dados usando as credenciais do Felipe, qualquer integrante do grupo pode usar seu primeiro nome em minusculo como usuario, o resto mantém
$strcon = mysqli_connect ("137.184.66.198", "felipe", "abcd=1234", "humanitae_db") or die ("Erro ao conectar com o banco");

// buscar todas as disciplinas do curso da pessoa
$sql = "SELECT * FROM disciplina WHERE cod_curso = '".$_SESSION['curso']."'";
$result = mysqli_query($strcon, $sql) or die ("Erro ao tentar encontrar o aluno no banco!");

// impprimir no pdf todas as disciplinas encontradas
foreach($result as $row){
    $html .= "<p>{$row['nome']}: {$row['descricao']}</p>";
}

$html .= "</div><hr>";

// mostrar atividades aprovadas se tiver alguma
if($_SESSION['aprovadas'] > 0) {
    $html .= "
    <h3>Atividades Aprovadas</h3>
    <table>
        <tr>
            <th>Código</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Caminho do anexo</th>
            <th>Horas Aprovadas</th>
            <th>Data de conclusão</th>
            <th>Data e hora de envio</th>
        </tr>
    ";

    $sql2 = "SELECT * FROM atividade_complementar WHERE RA_aluno = '".$_SESSION['ra_aluno']."'";
    $result2 = mysqli_query($strcon, $sql2) or die ("Erro ao tentar encontrar o aluno no banco!");
    // impprimir no pdf todas as atividades encontradas
    foreach($result2 as $row){
        if($row['status'] == "Aprovado")
        $html .= "
        <tr>
            <td>{$row['cod_atividade']}</td>
            <td>{$row['titulo']}</td>
            <td>{$row['descricao']}</td>
            <td>{$row['caminho_anexo']}</td>
            <td>{$row['horas_aprovadas']}</td>
            <td>{$row['data']}</td>
            <td>{$row['atividade_complementar_timestamp']}</td>
        </tr>";
    }
    $html .= "</table>";
}

// mostrar atividades pendentes se ele tiver alguma
if($_SESSION['pendentes'] >0) {
    $html .= "
        <hr>
        <h3>Atividades Pendentes</h3>
        <table>
            <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Caminho do anexo</th>
                <th>Horas Solicitadas</th>
                <th>Data de conclusão</th>
                <th>Data e hora de envio</th>
            </tr>";

    foreach($result2 as $row){
        if($row['status'] == "Pendente")
        $html .= "
        <tr>
            <td>{$row['cod_atividade']}</td>
            <td>{$row['titulo']}</td>
            <td>{$row['descricao']}</td>
            <td>{$row['caminho_anexo']}</td>
            <td>{$row['horas_solicitadas']}</td>
            <td>{$row['data']}</td>
            <td>{$row['atividade_complementar_timestamp']}</td>
        </tr>";
    }
    $html .= "</table>";
}

// mostrar se o aluno tem atividades arquivadas
if($_SESSION['arquivadas'] > 0) {
    $html .= "
        <hr>
        <h3>Atividades Excluídas</h3>
        <table>
            <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Caminho do anexo</th>
                <th>Horas Solicitadas</th>
                <th>Data de conclusão</th>
                <th>Data e hora de envio</th>
            </tr>";

    foreach($result2 as $row){
        if($row['status'] == "Arquivado")
        $html .= "
        <tr>
            <td>{$row['cod_atividade']}</td>
            <td>{$row['titulo']}</td>
            <td>{$row['descricao']}</td>
            <td>{$row['caminho_anexo']}</td>
            <td>{$row['horas_solicitadas']}</td>
            <td>{$row['data']}</td>
            <td>{$row['atividade_complementar_timestamp']}</td>
        </tr>";
    }
    $html .= "</table>";
}

// mostrar se o aluno tem atividades reprovadas no momento
if($_SESSION['reprovadas'] > 0) {
    $html .= "
        <hr>
        <h3>Atividades Reprovadas Atuais</h3>
        <table>
            <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Caminho do anexo</th>
                <th>Horas Solicitadas</th>
                <th>Data de conclusão</th>
                <th>Data e hora de envio</th>
            </tr>";

    foreach($result2 as $row){
        if($row['status'] == "Reprovado")
        $html .= "
        <tr>
            <td>{$row['cod_atividade']}</td>
            <td>{$row['titulo']}</td>
            <td>{$row['descricao']}</td>
            <td>{$row['caminho_anexo']}</td>
            <td>{$row['horas_solicitadas']}</td>
            <td>{$row['data']}</td>
            <td>{$row['atividade_complementar_timestamp']}</td>
        </tr>";
    }
    $html .= "</table>";
}

// // carregar página HTML para converter em PDF
$dompdf->loadHtml($html);


// // renderizar o arquivo como um PDF
$dompdf->render();

// // baixar arquivo PDF com o nome escolhido
$dompdf->stream("Histórico_AC_Smart", ["Attachment" => 0]);
