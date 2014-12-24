<?php

    header("Content-type: text/html; charset=utf-8");


    require_once "./include/dbconfig.php";

    require_once "./include/database.php";
    require_once "./include/usradmin.php";


    $db_wrapper = new Database();
    $db_wrapper->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_ENC);

    if (UserAdmin::validate_registry($_GET["id"], $_GET["code"], $db_wrapper)) {
        header("Location: sign_in.php?lang=es&validate=true#tabs-1");        
    } else {
        header("Location: index.php?lang=esp&err=1#tabs-6");
    }


?>