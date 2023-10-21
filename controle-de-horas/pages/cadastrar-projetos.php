<?php 

include_once('./db/conexao.php');

$pag = "cadastrar-projetos";

$nome_projeto = $_POST['nome_projeto'] ?? "Your Project's Name";
$descricao = $_POST['describe'] ?? "Your Project's Describe";

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
            $query = $pdo->query("INSERT INTO ")
        ?>
    </div>
    <div>
        <h3>Olá</h3>
    </div>
</div>