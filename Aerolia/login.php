<?php
session_start();
require_once "./include/dbconfig.php";

require_once "./include/database.php";
require_once "./include/usradmin.php";
require_once "./include/user.php";

$db_wrapper = new Database();
$db_wrapper->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_ENC);

$user_card = new User($db_wrapper);

if (isset($_POST["login"])) {
    if ($user_card->login($_POST["email"], $_POST["password"])) {
        header("Location: index.php?lang=" . $_POST['lang']."#tabs-6");
    } else {
        header("Location: sign_in.php?lang=" . $_POST['lang'] . "&err=1");
    }
} else if (isset($_GET["logout"])) {
    $user_card->logout();
    header("Location: index.php?lang=".$_POST['lang']);
    //print_r($_SESSION);
}
?>