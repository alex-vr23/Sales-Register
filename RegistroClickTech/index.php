<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="stylesphp.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClickTech</title>
</head>
<body>


<?php
require_once "connexio.php";
echo "<div class=\"contenido\">";
echo "<h1 class=\"titulo\">ClickTech<h1>";


echo "-------------------------------------------------";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["codigo"]) && isset($_POST["nombre"])) {
        // Obtener el código y el nombre ingresados por el usuario
        $codigo = $_POST["codigo"];
        $nombre = $_POST["nombre"];

        try {
            $dbh = new PDO("mysql:host=$server;dbname=$bbd", $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insertar el código y el nombre en la base de datos
            $stmt = $dbh->prepare("INSERT INTO tabla (CODE, NAME) VALUES (?, ?)");
            $stmt->execute([$codigo, $nombre]);

            echo "<p>DATABASE UPDATED</p>";
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }
}





?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <label for="nombre">Name:</label>
  <input type="text" name="nombre" id="nombre">
  <br>
  <label for="codigo">Code:</label>
  <input type="text" name="codigo" id="codigo">
  <br>
  <input type="submit" value="SEND">
</form>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="visualizar" value="1">
        <input type="submit" value="ALL DATABASE">
    </form>

     -------------------------------------------------
     <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="search">Search in our Database:</label>
        <input type="text" name="search" id="search">
        <br>
        <input type="submit" value="SEARCH">
    </form>
    
    
<?php
require_once "connexio.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $search = $_POST["search"];

    try {
        $dbh = new PDO("mysql:host=$server;dbname=$bbd", $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $dbh->prepare("SELECT * FROM tabla WHERE CODE = ?");
        $stmt->execute([$search]);
        $rows = $stmt->fetchAll();

        if ($rows) {
            echo "<h2>RESULT</h2>";
            echo "<ul>";
            foreach ($rows as $row) {
                echo "<li>CODE: " . $row['CODE'] . " -- NAME: " . $row['NAME'] . " -- " . $row['Fecha'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>NOT FOUND '$search'.</p>";
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
}


if (isset($_POST["visualizar"])) {
    try {
        $dbh = new PDO("mysql:host=$server;dbname=$bbd", $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $dbh->query("SELECT * FROM tabla");
        echo "<h2>ALL DATABASE</h2>";
        echo "<ul>";
        while ($row = $stmt->fetch()) {
            echo "<li>CODE: " . $row['CODE'] . " -- NAME: " . $row['NAME'] . " -- " . $row['Fecha'] . "</li>";
        }
        echo "</ul>";
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
}

?>

</body>
</html>