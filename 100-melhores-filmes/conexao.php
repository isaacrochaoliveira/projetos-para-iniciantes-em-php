<?php
try {
	$pdo = new PDO('mysql:host=localhost;dbname=melhores_filmes;port=3306;charset=utf8mb4', 'root', '');
} catch (PDOException $e) {
	echo "Erro Ao se conectar com o banco -> " . $e->getMessage();
}

?>