<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Apostas</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php 
        $quant = $_GET['quant'] ?? 0;
    ?>
    <main>
        <h1>Gerador de Apostas</h1>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
            <label for="quant">Quantidade de Apostas</label>
            <input type="number" name="quant" id="quant" value="<?= $quant ?>">
            <button type="submit">Gerar Palpites</button>
        </form>
    </main>
    <section>
        <h2>Resultados</h2>
        <?php 
            for ($i = 0; $i < $quant; $i++) {
                $apostas = [mt_rand(1, 40), mt_rand(1, 40), mt_rand(1, 40), mt_rand(1, 40)];
                if (($apostas[0] == $apostas[1]) || ($apostas[0] == $apostas[2]) || ($apostas[0] == $apostas[3])) {
                    $apostas[0] = mt_rand(1, 40);
                } else {
                    if (($apostas[1] == $apostas[2]) || ($apostas[1]) == $apostas[0] || ($apostas[1] == $apostas[3])) {
                        $apostas[1] = mt_rand(1, 40);
                    } else {
                        if (($apostas[2] == $apostas[3]) || ($apostas[2] == $apostas[0]) || ($apostas[2] == $apostas[1]) || ($apostas[2] == $apostas[3])) {
                            $apostas[2] = mt_rand(1, 20);
                        }
                    }
                }
                echo "<p>O Meu Palpite - Nº" . $i+1 . ": " . $apostas[0] . " " . $apostas[1] . " " . $apostas[2] . " " . $apostas[3] ." </p>";
            }
         ?>
    </section>
</body>
</html>