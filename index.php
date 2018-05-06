<?php
session_start();

include('adatbazis.php');
include('adatok.php');

$oldal = "kezdolap";

if(isset($_GET["oldal"])) {
    if(file_exists(__DIR__ . "/oldalak/" . $_GET["oldal"] . ".php")) {
        $oldal = $_GET["oldal"];
    } else {
        $oldal = "404";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/main.css" type="text/css" />
        <script src="scripts/jquery.js"></script>
        <script src="scripts/script.js"></script>
        <title>Cseh Dávid</title>
    </head>
    <body>
        <header>
            <h1>Számítástechnikai üzlet és szervíz</h1>
        </header>
        <nav>
            <?php
                Adatok::menu();
            ?>
        </nav>
        <div class="body">
            <?php include("oldalak/" . $oldal . ".php"); ?>
        </div>
        <footer>
            <?php if(!isset($_SESSION["id"])) { ?>
                <a href="index.php?oldal=bejelentkezes">Bejelentkezés</a> | 
                <a href="index.php?oldal=regisztracio">Regisztráció</a>
            <?php } else { ?>
                <a id="kijelentkezes" href="#">Kijelentkezés</a>
            <?php } ?>
        </footer>
    </body>
</html>
