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
					<th>Carga Horária (H)</th>
                    <th>Começo</th>
                    <th>Término</th>
					<th>Dias</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $query = $pdo->query("SELECT * FROM projetos;");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $tempo_no_mes = 0;
					$dias = 0;
		  			$tempoCargaHoraria = 0;
                    if (count($res) > 0) {
                        for ($i = 0; $i < count($res); $i++) {
                            foreach ($res[$i] as $k => $v) {
                            }
							$dias_linha = 0;
                            $id = $res[$i]['id_project'];
                            $nome = $res[$i]['nome'];
                            $descricao = $res[$i]['descricao'];
							$cargaHoraria = $res[$i]['carga_horaria'] ?? 0;
                            $date_in = $res[$i]['date_in'] ?? '0000-00-00';
                            $time_in = $res[$i]['time_in'] ?? '00:00:00';
                            $time_out = $res[$i]['time_out'] ?? '00:00:00';
                            $date_out = $res[$i]['date_out'] ?? '0000-00-00';

                            $date_in_array = explode('-', $date_in);
							$date_out_array = explode('-', $date_out);
                            $time_in_array = explode(':', $time_in);
                            $time_out_array = explode(':', $time_out);
							
							if ($date_in_array[2] > '00') {
								if ($date_in_array[1] == $date_out_array[1]) {
									if ($date_in_array[2] == $date_out_array[2]) {
										$dias += 1;
										$dias_linha = 1;
									} else {
										for ($c = $date_in_array[2]; $c <= $date_out_array[2]; $c++) {
											$dias_linha += 1;
											$dias += 1;	
										}
									}
								} else {
									if ($date_out_array[1] > $date_in_array[1]) {
										if (($date_in_array[2] < $date_out_array[2]) && ($date_out_array[1] - $date_in_array[1] == 1)) {
											$month = $date_in_array[1];
											if (($month == "01") || ($month == "03") || ($month == "05") || ($month == "07") || ($month == "08") || ($month == "10") || ($month == "12")) {
												$dias_mes = "31";
											} else {
												if ($month == "02") {
													if (Date('Y') % 4 == 0) {
														$dias_mes = "29";
													} else {
														$dias_mes = "28";
													}
												} else {
													$dias_mes = "30";
												}
											}
											for ($z = $date_in_array[2]; $z <= $dias_mes; $z++) {
												$dias_linha += 1;
												$dias += 1;
											}
											$month = $date_out_array[1];
											if (($month == "01") || ($month == "03") || ($month == "05") || ($month == "07") || ($month == "08") || ($month == "10") || ($month == "12")) {
												$dias_mes = "31";
											} else {
												if ($month == "02") {
													if (Date('Y') % 4 == 0) {
														$dias_mes = "29";
													} else {
														$dias_mes = "28";
													}
												} else {
													$dias_mes = "30";
												}
											}
											if ($date_out_array[2] > 1) {
												$mes_contato = 1;
											} else {
												$mes_contato = $date_out_array[2];
											}
											for ($z = $mes_contato; $z <= $dias_mes; $z++) {
												$dias_linha += 1;
												$dias += 1;
											}
										} else {
											if (($date_in_array[2] < $date_out_array[2]) && ($date_out_array[1] - $date_in_array[1] > 1)) {
												for ($mes_contando = $date_in_array[1]; $mes_contando <= $date_out_array[1]; $mes_contando++) {
													$month = $mes_contando;
													if (($month == "01") || ($month == "03") || ($month == "05") || ($month == "07") || ($month == "08") || ($month == "10") || ($month == "12")) {
														$dias_mes = "31";
													} else {
														if ($month == "02") {
															if (Date('Y') % 4 == 0) {
																$dias_mes = "29";
															} else {
																$dias_mes = "28";
															}
														} else {
															$dias_mes = "30";
														}
													}
													for ($z = $date_in_array[2]; $z <= $dias_mes; $z++) {
														$dias_linha += 1;
														$dias += 1;
														echo $z."<br>";
													}	
												}
											}
										}
									}
								}
							}
							if ($dias_linha > 0) {
								$tempoCargaHoraria += $cargaHoraria * ($dias_linha);
								$tempo_no_mes = $tempoCargaHoraria;
							}
                            ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $nome ?></td>
                                <td><?= $descricao ?></td>
								<td><?= $cargaHoraria ?></td>
                                <td><?= implode('/', array_reverse(explode('-', $date_in))) ?></td>
                                <td><?= implode('/', array_reverse(explode('-', $date_out))) ?></td>
								<td><?= $dias_linha ?></td>
                            </tr>
                        <?php
                        }
                    }
                ?>
            </tbody>
            <tfoot>
				<div class="d-flex flex-wrap justify-content-around">
					<?php
						$minutos_mes = $tempo_no_mes * 60;
						$segundos_mes = $tempo_no_mes * 3600;
					?>
					<p>Dias de Trabalho: <?= $dias ?></p>
					<p>Horas: <?= $tempo_no_mes ?>hrs</p>
					<p>Minutos: <?= number_format($minutos_mes, 2, ',', '.') ?>min</p>
					<p>Segundos: <?= number_format($segundos_mes, 2, ',', '.') ?></p>
				</div>
				
            </tfoot>
        </table>
    </div>
</div>