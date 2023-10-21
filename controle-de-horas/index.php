<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Horas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/stytle.css">
</head>

<body>
    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link active"><i class="fa-solid fa-house-user"></i> Home</a></li>
                <li class="nav-item"><a href="index.php?pag=cadastrar-projetos" class="nav-link" aria-current="page"><i class="fa-solid fa-computer"></i> Cadastro de Projetos</a></li>
                <li class="nav-item"><a href="index.php?pag=relatorio" class="nav-link"><i class="fa-solid fa-file-excel"></i> Relatório de Horas Trabalhadas</a></li>
            </ul>
        </header>
    </div>
    <section id="cabecalho">
        <div class="box">
            <h1>Controle de Horas</h1>
            <hr>
            <p>Controle toda sua carga horária aqui</p>
        </div>
    </section>
    <section class="container">
        <?php
            if (@$_GET['pag'] == "cadastrar-projetos") {
                include_once("pages/cadastrar-projetos.php");
            }
            if (@$_GET['pag'] == "entrada-saidas-horas") {
                include_once("pages/entrada-saidas-horas.php");
            }
        ?>
    </section>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>