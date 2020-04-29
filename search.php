<?php
require_once 'SQL.php';
$sql = new SQL();

$keyword = $_POST['keyword'];

$villes = $sql->getData("SELECT ville_nom FROM villes_france WHERE ville_nom LIKE '$keyword%' ORDER BY CHAR_LENGTH(ville_nom) LIMIT 10");
foreach ($villes as $ville) {
	echo "<p>".$ville['ville_nom']."</p>";
}