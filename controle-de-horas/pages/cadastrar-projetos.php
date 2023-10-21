<?php

include_once('./db/conexao.php');

$pag = "cadastrar-projetos";

$nome_projeto = $_POST['nome_projeto'] ?? "Your Project's Name (Required)";
$descricao = $_POST['describe'] ?? "Your Project's Describe (Not Required)";

?>

<div class="d-flex flex-wrap justify-content-between">
    <div class="w-50">
        <form action="<?= $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'] ?>" method="post">
            <div class="row my-3">
                <div class="col">
                    <label for="nome_projeto">Nome do Projeto</label>
                    <input type="text" name="nome_projeto" id="nome_projeto" class="form-control" value="<?= $nome_projeto ?>">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="describe">Descrição do seu projeto</label>
                    <textarea name="describe" id="descrobe" cols="10" rows="5" class="form-control"><?= $descricao ?></textarea>
                </div>
            </div>
            <div class="my-3">
                <button type="submit" class="btn btn-success w-100">Cadastrar</button>
            </div>
        </form>
        <?php
        if ($nome_projeto != "Your Project's Name (Required)") {

            $query = $pdo->query("SELECT nome FROM projetos WHERE nome = '$nome_projeto'");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            if (count($res) > 0) {
        ?>
                <div class="alert alert-danger" role="alert">
                    Nome de Projeto Repetido!
                </div>
            <?php
            } else {
                if ($descricao == "Your Project's Describe (Not Required)") {
                    $res = $pdo->prepare("INSERT INTO projetos SET nome = :nome_projeto");
                    $res->bindValue(':nome_projeto', $nome_projeto, PDO::PARAM_STR);
                } else {
                    $res = $pdo->prepare("INSERT INTO projetos SET nome = :nome_projeto, descricao = :descricao");
                    $res->bindValue(':nome_projeto', $nome_projeto, PDO::PARAM_STR);
                    $res->bindValue(':descricao', $descricao, PDO::PARAM_STR);
                }
                if ($res->execute()) {
                ?>
                    <div class="alert alert-success" role="alert">
                        Seu projeto foi cadastrado com êxito!
                    </div>
                <?php
                }
            }
        } else {
            ?>
            <div class="alert alert-warning" role="alert">
                Por Favor! Insert your project's name!
            </div>
        <?php
        }
        ?>
    </div>
    <div class="w-50">
        <h3>Tabela de Projetos Cadastrados</h3>
        <hr>
        <?php
        $query = $pdo->query("SELECT * FROM projetos;");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($res) > 0) {
        ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Describe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($res); $i++) {
                        $id = $res[$i]['id_project'];
                        $nome = $res[$i]['nome'];
                        $descricao = $res[$i]['descricao'];
                    ?>
                        <tr>
                            <td><?= $id ?></td>
                            <td><?= $nome ?></td>
                            <td><?= $descricao ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
        }
        ?>
    </div>
</div>