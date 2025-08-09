<?php
require_once "connexio.php";

try {
    $dbh = new PDO("mysql:host=$server;dbname=$bbd", $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->query("SELECT * FROM tabla");
    echo "<h2>Registros en la base de datos</h2>";
    echo "<ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>" . $row['CODE'] . "</li>";
    }
    echo "</ul>";
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>
