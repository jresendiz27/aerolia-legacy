<?php
require_once "./include/dbconfig.php";

require_once "./include/database.php";
require_once "./include/user.php";
require_once "./include/usradmin.php";


$lang = "";
switch (strtoupper($_GET['lang'])) {
    case 'ESP':
        $lang = strtoupper($_GET['lang']);
        break;
    case 'ENG':
        $lang = strtoupper($_GET['lang']);
        break;
    default:
        $lang = "ESP";
        break;
}

$db_wrapper = new Database();
$db_wrapper->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_ENC);

$user_card = new User($db_wrapper);

if ($user_card->is_session_active()) {

    if (isset($_POST["passc"])) {

        $id = $user_card->id;

        $valid = true;

        if (!UserAdmin::is_pass_length_valid($_POST["newpassword"])) {
            if ($lang == "ESP") {
                $msg[] = "La contraseña debe tener entre entre 6 y 20 caracteres.";
            } else if ($lang == "ENG") {
                $msg[] = "Password must have between 6 and 20 characters.";
            }
            $valid = false;
        } else if (!UserAdmin::is_pass_valid($_POST["newpassword"], $_POST["confirm"])) {
            if ($lang == "ESP") {
                $msg[] = "Las contraseñas no coinciden.";
            } else if ($lang == "ENG") {
                $msg[] = "Passwords do not match.";
            }
            $valid = false;
        }

        if ($valid) {

            if (change_password($id, $_POST["password"], $_POST["newpassword"], $db_wrapper)) {
                if ($lang == "ESP") {
                    $msg[] = "Contraseña cambiada exitosamente.";
                } else if ($lang == "ENG") {
                    $msg[] = "Password changed succesfully.";
                }
            } else {
                if ($lang == "ESP") {
                    $msg[] = "La contraseña actual no coincide con la introducida.";
                } else if ($lang == "ENG") {
                    $msg[] = "Actual password does not match with the introduced one.";
                }
            }
        }
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Aerolia - Registro</title>
        <link href="css/main-style.css" media="screen" type="text/css" rel="stylesheet"/>
        <link rel="stylesheet" href="css/south-street/jquery-ui-1.8.12.custom.css" media="screen" type="text/css"/>
        <script src="js/jquery-1.5.1.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui-1.8.12.custom.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui-1.8.7.custom.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready( function (){
                $("#tabs").css("background-color","rgba(255,255,255,0.5)");
                $("#footer").css("background-color","rgba(255,255,255,0.5)");
                $("#tabs").css("text-align","left");
                $('#tabs').tabs();
            });
        </script>
    </head>
    <body>
        <?php
        if ($lang == "ESP") {
        ?><div id="main">
                <div id="header">
                    <div id="logo">
                        <img alt="Aerolia" width="100" height="100" src="img/logo2_vectorized.png"/>
                    </div>
                    <div id="banner">
                        <a href="index.php?lang=<? echo $lang; ?>" class="header-link"><img alt="aerolia"  src="img/banner.png" height="100" width="517"/></a>
                    </div>
                </div>
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Cambio de contrase&ntilde;a</a></li>
                    </ul>
                    <div id="tabs-1" style="height: auto; text-align: center;">
                        <div id="profile-functions">
                        <?php if ($user_card->is_session_active()) {
                        ?>
                            <div id="profile-data"><span style="text-align:center;"><b>Bienvenido</b> <?php echo htmlspecialchars($_SESSION['name']); ?> <br/><a href="login.php?lang=<?php echo $lang; ?>&logout=true">Salir</a></span></div>
                            <h1>Cambio de contraseña</h1>
                        <?php
                            if (count($msg) > 0) {
                        ?>
                                <div class="alert"><ul><?php
                                foreach ($msg as $message) {
                                    echo "<li>" . $message . "</li>";
                                }
                        ?></ul></div>
                        <?php
                            }
                        ?>
                            <form action="passc.php" method="post">
                                <table align="center" style="border: #cdfb74 solid medium; text-align: center;">
                                    <tbody>
                                        <tr>
                                            <td>Contraseña actual:</td>
                                            <td><input type="password" name="password" maxlength="20" /></td>
                                        </tr>
                                        <tr>
                                            <td>Nueva Contraseña:</td>
                                            <td><input type="password" name="newpassword" maxlength="20" /></td>
                                        </tr>
                                        <tr>
                                            <td>Repita la Nueva Contraseña:</td>
                                            <td><input type="password" name="confirm" maxlength="20" /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="submit" name="passc" value="Cambiar" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>

                        <?php } else {
 ?>
                            <h1>Debes iniciar sesi&oacute;n primero</h1>
<?php } ?>
                        <a href="index.php?lang=<?php echo $_GET['lang']; ?>#tabs-6" class="nlink">Regresar</a>
                    </div>
                </div>
            </div>
            <span id="footer" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <a href="http://www.insa-lyon.fr/" target="_blank" style="display: inline;">Insa Lyon</a>
                <a href="http://www.ipn.mx/" target="_blank" style="display: inline;">IPN</a>
                <a href="http://www.argentinarenovables.org/" target="_blank" style="display: inline;">Camara Argentina de Energias Renovables</a>
                <div style="display: inline-block">Cecyt 9 "Juan de Dios Bátiz" Programación México 2011</div>
            </span>
        </div>
<?php } else { ?>
                        <div id="main">
                            <div id="header">
                                <div id="logo">
                                    <img alt="Aerolia" width="100" height="100" src="img/logo2_vectorized.png"/>
                                </div>
                                <div id="banner">
                                    <a href="index.php?lang=<? echo $lang; ?>" class="header-link"><img alt="aerolia"  src="img/banner.png" height="100" width="517"/></a>
                                </div>
                            </div>
                            <div id="tabs">
                                <ul>
                                    <li><a href="#tabs-1">We're sorry</a></li>
                                </ul>
                                <div id="tabs-1" style="height: auto;">
                                    <p>
                                    <p><b>We're sorry!</b></p>
                                    <p style="text-align: left; font-size: x-large;font-weight: bold;"> About us </p>
                                    <p>
                                        We are working on it!
                                    </p>
                                    </p>
                                </div>
                            </div>
                            <span id="footer" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                                <a href="http://www.insa-lyon.fr/" target="_blank" style="display: inline;">Insa Lyon</a>
                                <a href="http://www.ipn.mx/" target="_blank" style="display: inline;">IPN</a>
                                <a href="http://www.argentinarenovables.org/" target="_blank" style="display: inline;">Camara Argentina de Energias Renovables</a>
                                <div style="display: inline-block">Cecyt 9 "Juan de Dios Bátiz" Programación México 2011</div>
                            </span>
                        </div>
<?php } ?>
    </body>
</html>
