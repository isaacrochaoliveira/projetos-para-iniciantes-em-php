<?php 

try {
    $pdo = new PDO("mysql:host=localhost;dbname=controle_de_horas;port=3306;charset=utf8", "root", "");
} catch (PDOException $e) {
    echo "Houve um pequino problema com a nocexão do banco: " . $e->getMessage();
}

?>