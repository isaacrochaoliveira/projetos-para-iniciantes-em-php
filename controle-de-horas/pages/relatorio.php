<?php 

include_once('./db/conexao.php');

$start = Date("Y-m") . "-01";
$month = Date("m");
if (($month == "01") || ($month == "03") || ($month == "05") || ($month == "07") || ($month == "08") || ($month == "10") || ($month == "12")) {
    $fim = "31";
} else {
    if ($month == "02") {
        if (Date('Y') % 4 == 0) {
            $fim = "29";
        } else {
            $fim = "28";
        }
    } else {
        $fim = "30";
    }
}
$exit = Date("Y-m") . "-$fim";

?>

<div class="py-5">
    <form action="<?= $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'] ?>" method="post">
        <div class="row">
            <div class="col-md-3">
                <label for="start">Data de Início:</label>
                <input type="date" name="start" id="start" class="form-control" value="<?= $start ?>">
            </div>
            <div class="col-md-3">
                <label for="exit">Data da Término</label>
                <input type="date" name="exit" id="exit" class="form-control" value="<?= $exit ?>">
            </div>
            <div class="col-md-3">
                <label for="select">Selecione</label>
                <select name="select" id="select" class="form-select">
                    <option value="todos">Todos</option>
                    <option value="terminados">Trabalhos Terminados</option>
                    <option value="começados">Trabalhos Começados</option>
                </select>
            </div>
        </div>
    </form>
    <hr>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Começo</th>
                    <th>Término</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $query = $pdo->query("SELECT * FROM projetos;");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    if (count($res) > 0) {
                        for ($i = 0; $i < count($res); $i++) {
                            foreach ($res[$i] as $k => $v) {
                            }
                            $id = $res[$i]['id_project'];
                            $nome = $res[$i]['nome'];
                            $descricao = $res[$i]['descricao'];
                            $date_in = $res[$i]['date_in'];
                            $time_in = $res[$i]['time_in'];
                            $time_out = $res[$i]['time_out'];
                            $date_out = $res[$i]['date_out'];
                            ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $nome ?></td>
                                <td><?= $descricao ?></td>
                                <th><?= implode('/', array_reverse(explode('-', $date_in))) . " - " . $time_in ?></th>
                                <th><?= implode('/', array_reverse(explode('-', $date_out))) . " - " . $time_out ?></th>
                            </tr>
                        <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>