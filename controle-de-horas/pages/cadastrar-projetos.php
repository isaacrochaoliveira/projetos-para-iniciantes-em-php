<?php

include_once('./db/conexao.php');

$pag = "cadastrar-projetos";

$nome_projeto = $_POST['nome_projeto'] ?? "Your Project's Name (Required)";
$descricao = $_POST['describe'] ?? "Your Project's Describe (Not Required)";
$cargaHoraria = $_POST['carga'] ?? 8;
$date_time = $_POST['datetime'] ?? '';

$action = $_GET['action'] ?? 'null';

?>

<h2 class="py-4 fs-44">Cadastrar Projetos</h2>
<div class="d-flex flex-wrap justify-content-around">
    <div class="flex-2">
        <form action="<?= $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'] ?>" method="post" class="mx-2">
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
			<div class="row">
                <div class="col">
                    <label for="carga">Carga Horária</label>
					<input type="number" name="carga" id="carga" min="1" max="18" class="form-control" value="<?= $cargaHoraria ?>">
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
                    $res = $pdo->prepare("INSERT INTO projetos SET nome = :nome_projeto, carga_horaria = :carga_horaria");
                    $res->bindValue(':nome_projeto', $nome_projeto, PDO::PARAM_STR);
                } else {
                    $res = $pdo->prepare("INSERT INTO projetos SET nome = :nome_projeto, descricao = :descricao, carga_horaria = :carga_horaria");
                    $res->bindValue(':nome_projeto', $nome_projeto, PDO::PARAM_STR);
                    $res->bindValue(':descricao', $descricao, PDO::PARAM_STR);
					$res->bindValue(':carga_horaria', $cargaHoraria, PDO::PARAM_STR);
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
    <div class="flex-1-30">
        <h3>Tabela de Projetos Cadastrados</h3>
        <hr>
        <?php
        $query = $pdo->query("SELECT * FROM projetos;");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($res) > 0) {
        ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Describe</th>
                        <th></th>
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
                            <th>
                                <a href="index.php?pag=cadastrar-projetos&action=exit&id_project=<?= $id ?>#esh" title="Saídas de Horários"><i class="fa-solid fa-left-long text-danger"></i></a>
                                &nbsp;
                                <a href="index.php?pag=cadastrar-projetos&action=start&id_project=<?= $id ?>#esh" title="Entrada de Horários"><i class="fa-solid fa-right-long text-success"></i></a>
                            </th>
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
<hr>
<div id="esh" class="py-5">
    <h2 class="fs-44">Entradas e Saída de Horários</h2>
    <div>
        <?php
        $id_project = $_GET['id_project'] ?? 0;
        if ($action == 'start') {
            $query = $pdo->query("SELECT * FROM projetos WHERE id_project = '$id_project'");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $exist = $res[0]['date_in'] ?? 'null';
            if ((count($res) > 0) && ($exist == "null")) {
            ?>
                <div class="alert alert-success" role="alert">
                    Cadastrando Horários de Entrada do Projeto: <?= $res[0]['nome'] ?>
                </div>
                <form action="<?= $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'] ?>#esh" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="datetime">Horário que começou a trabalhar no mesmo?</label>
                            <input type="date" name="datetime" id="datetime" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </div>
                </form>
                <p>
                    <?php
                    if ($date_time == "") {
                    ?>
                		<p>Entre com um horário!</p>
					<?php
                    } else {
                        $res = $pdo->prepare("UPDATE projetos SET date_in = :date_in WHERE id_project = :id");
                        $res->bindValue(":date_in", $date_time);
                        $res->bindValue(':id', $id_project, PDO::PARAM_INT);
                        if ($res->execute()) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    Cadastramento de Hora feito com Sucesso!
                                </div>
                            <?php
                        }
                    }
            	?>
            </p>
        <?php
            } else {
                if ($exist != "null") {
                    ?>
                     <div class="alert alert-dark" role="alert">
                        Este projeto já tem um horário de entrada!
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-warning" role="alert">
                        Nunhum projeto para dar entrada!
                    </div>
                    <?php
                }
            }
        } else {
            if ($action == 'null') {
                ?>
                    <div class="alert alert-info" role="alert">
                        Nenhuma action para fazer no momento!
                    </div>
                <?php
            } else {
                $query = $pdo->query("SELECT * FROM projetos WHERE id_project = '$id_project'");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);
                $exist = $res[0]['date_out'] ?? 'null';
                if ((count($res) > 0) && ($exist == 'null')) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        Cadastrando Horários de Saída do Projeto: <?= $res[0]['nome'] ?>
                    </div>
                    <form action="<?= $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'] ?>#esh" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="datetime">Horário que terminou de Trabalhar no mesmo?</label>
                                <input type="date" name="datetime" id="datetime" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                    <p>
                        <?php
                            if ($date_time == "") {
                                ?>
                                    <p>Entre com um horário!</p>
                                <?php
                            } else {
                                $res = $pdo->prepare("UPDATE projetos SET date_out = :date_out WHERE id_project = :id");
                                $res->bindValue(":date_out", $date_time);
                                $res->bindValue(':id', $id_project, PDO::PARAM_INT);
                                if ($res->execute()) {
                                    ?>
                                        <div class="alert alert-success" role="alert">
                                            Cadastramento de Hora feito com Sucesso!
                                        </div>
                                    <?php
                                }
                            }
                        ?>
                </p>
                    <?php
                } else {
                    if ($exist != "null") {
                        ?>
                         <div class="alert alert-dark" role="alert">
                            Este projeto já tem um horário de saída!
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-warning" role="alert">
                            Nunhum projeto para dar saída!
                        </div>
                        <?php
                    }
                }
            }
        }
    ?>
    </div>
</div>