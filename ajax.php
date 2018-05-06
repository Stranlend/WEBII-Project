<?php
require_once("adatbazis.php");

if($_GET["action"] == 'velemeny') {
    session_start();
    $conn = Database::getInstance();
    $req = $conn->prepare("INSERT INTO velemenyek (felhasznalo, velemeny, datum) VALUES (:felhasznalo, :velemeny, :datum)");
    $req->execute(array('felhasznalo' => $_SESSION["id"], 'velemeny' => $_POST["velemeny"], 'datum' => date("Y-m-d H:i:s")));
    echo json_encode(array('resp' => 1));
} else if($_GET["action"] == 'velemenyek') {
    session_start();
    $conn = Database::getInstance();
    $req = $conn->prepare("SELECT *, (SELECT felhasznalonev FROM felhasznalok WHERE id = velemenyek.felhasznalo) as felhasznalonev FROM velemenyek ORDER BY datum DESC");
    $req->execute();
    echo json_encode(array('resp' => 1, 'velemenyek' => $req->fetchAll()));
} else if($_GET["action"] == 'bejelentkezes') {
    $conn = Database::getInstance();
    $req = $conn->prepare("SELECT id, felhasznalonev, engedely FROM felhasznalok WHERE felhasznalonev = :felhasznalonev AND jelszo = PASSWORD(:jelszo) LIMIT 1");
    $req->execute(array('felhasznalonev' => $_POST["felhasznalonev"], 'jelszo' => $_POST["jelszo"]));
    if($req->rowCount() == 1) {
        $adat = $req->fetch();
        session_start();
        $_SESSION["id"] = $adat["id"];
        $_SESSION["felhasznalonev"] = $adat["felhasznalonev"];
        $_SESSION["engedely"] = $adat["engedely"];
        echo json_encode(array('resp' => 1));
    } else {
        echo json_encode(array('resp' => 0));
    }
} else if($_GET["action"] == 'regisztracio') {
    $conn = Database::getInstance();
    $req = $conn->prepare("SELECT id FROM felhasznalok WHERE felhasznalonev = :felhasznalonev OR email = :email");
    $req->execute(array('felhasznalonev' => $_POST["felhasznalonev"], 'email' => $_POST["email"]));
    if($req->rowCount() == 0) {
        $req = $conn->prepare("INSERT INTO felhasznalok (felhasznalonev, jelszo, email) VALUES (:felhasznalonev, PASSWORD(:jelszo), :email)");
        $req->execute(array('felhasznalonev' => $_POST["felhasznalonev"], 'email' => $_POST["email"], 'jelszo' => $_POST["jelszo"]));
        if($req->rowCount() == 1) {
            echo json_encode(array('resp' => 1));
        } else {
            echo json_encode(array('resp' => 0));
        }
    } else {
        echo json_encode(array('resp' => 0));
    }
} else if($_GET["action"] == 'logout') {
    session_start();
    session_destroy();
    echo json_encode(array('resp' => 1));
}