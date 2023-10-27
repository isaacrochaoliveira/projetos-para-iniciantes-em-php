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
                    $tempo_no_mes = 0;
					$minutos = 0;
                    if (count($res) > 0) {
                        for ($i = 0; $i < count($res); $i++) {
                            foreach ($res[$i] as $k => $v) {
                            }
                            $id = $res[$i]['id_project'];
                            $nome = $res[$i]['nome'];
                            $descricao = $res[$i]['descricao'];
                            $date_in = $res[$i]['date_in'] ?? '0000-00-00';
                            $time_in = $res[$i]['time_in'] ?? '00:00:00';
                            $time_out = $res[$i]['time_out'] ?? '00:00:00';
                            $date_out = $res[$i]['date_out'] ?? '0000-00-00';

                            $date_in_array = explode('-', $date_in);
                            $time_in_array = explode(':', $time_in);
                            $time_out_array = explode(':', $time_out);
							
                            if ($date_in_array[2] >= '01') {
                                if ($time_out_array[0] > $time_in_array[0]) {
                                    if (($time_out_array[0] >= "00") && ($time_out_array[0] < "12")) {
                                        $timezone_out = 'AM';
										if (($time_in_array[0] >= "12") && ($time_in_array[0] <= "23")) {
											$timezone_in = 'PM';
										} else {
											$timezone_in = 'AM';
										}
										for ($c = $time_in_array[0]; $c < $time_out_array[0]; $c++) {
											$tempo_no_mes += 1;
										}
                                    } else {
										$timezone_out = "PM";
										if (($time_in_array[0] >= "12") && ($time_in_array[0] < "23")) {
											$timezone_in = 'PM';
										} else {
											$timezone_in = 'AM';
										}
										for ($c = $time_in_array[0]; $c < $time_out_array[0]; $c++) {
											$tempo_no_mes += 1;
										}
                                    }
                                } else {
                                    if (($time_out_array[0] >= "01") && ($time_out_array[0] < "12")) {
                                        if (($time_in_array[0] >= "12") && ($time_in_array[0] <= "23")) {
											$timezone_in = "PM";
                                        } else {
											echo $time_in_array[0];
											$timezone_in = 'AM';
										}
                                        $timezone_out = 'AM';
                                        $c = $time_in_array[0];
										while ($timezone_in != "AM") {
											if ($c < "24") {
												$timezone_in = "PM";
												$tempo_no_mes += 1;
											} else {
												if ($timezone_out == "AM") {
													for ($z = 0; $z <= $time_out_array[0]; $z++) {
														$tempo_no_mes += 1;
													}
												}
												$timezone_in = "AM";
												break;
											}
											$c++;
										}
                                    } else {
                                        $tempo_no_mes += $time_out_array[0] - $time_in_array[0];
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $nome ?></td>
                                <td><?= $descricao ?></td>
                                <th><?= implode('/', array_reverse(explode('-', $date_in))) . " - " . $time_in_array[0] . ":" . $time_in_array[1] ?></th>
                                <th><?= implode('/', array_reverse(explode('-', $date_out))) . " - " . $time_out_array[0] . ":" . $time_out_array[1] ?></th>
                            </tr>
                        <?php
                        }
                    }
                ?>
            </tbody>
            <tfoot>
				<div class="d-flex justify-content-around">
					<?php
						$minutos_mes = $tempo_no_mes * 60;
					?>
					<p>Horas Trabalhado no Mês: <?= $tempo_no_mes ?>hrs</p>
					<p>Minutos Trabalhados no Mês: <?= $minutos_mes ?>min</p>
					<p>Dias de Trabalho</p>
				</div>
				
            </tfoot>
        </table>
    </div>
</div>