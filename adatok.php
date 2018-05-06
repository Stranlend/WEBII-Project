<?php

class Adatok {
    
    public static function menu($szulo = 0) {
        $engedely = 1;
        if(isset($_SESSION["engedely"])) $engedely = $_SESSION["engedely"] + 1;
        
        $database = Database::getInstance();
        $req = $database->prepare("SELECT * FROM menu WHERE engedely < :engedely AND szulo_az = :szulo_az ORDER BY rendezes, szulo_az");
        $req->execute(array('engedely' => $engedely, 'szulo_az' => $szulo));
        if ($req->rowCount() > 0) {
            if($szulo == 0) {
                echo '<ul class="menu">';
            } else {
                echo '<ul class="menu submenu">';
            }
            foreach ($req->fetchAll() as $menu) {
                echo '<li class="item">';
                echo '<a href="index.php?oldal=' . $menu["fajl"] . '">' . $menu["cim"] . '</a>';
                self::menu($menu["menu_az"]);
                echo '</li>';
            }
            echo '</ul>';
        }
    }
        
}