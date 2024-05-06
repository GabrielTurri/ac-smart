<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo "<title>Detalhes da Atividade {$_GET["titulo"]}</title>";?>
</head>
<body>
    <?php
        echo"
            <p>Título da atividade: {$_GET["titulo"]}</p>
            <p>Descrição da ativdade: {$_GET["descricao"]}</p>
            <p>Anexo: {$_GET["caminho_anexo"]}</p>
            <p>Horas Solicitadas: {$_GET["horas_solicitadas"]}</p>
            <p>Horas Aprovadas: {$_GET["horas_aprovadas"]}</p>
            <p>Data de conclusão da atividade: {$_GET["data"]}</p>
            <p>Status da Atividade: {$_GET["status"]}</p>
        ";
        print_r($_GET);

    ?>
    
</body>
</html>