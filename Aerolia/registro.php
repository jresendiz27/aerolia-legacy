<?php
require_once "./include/dbconfig.php";

require_once "./include/database.php";
require_once "./include/usradmin.php";
require_once "./include/user.php";


$db_wrapper = new Database();
$db_wrapper->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_ENC);

$user_card = new User($db_wrapper);
if ($user_card->is_session_active()) {
    header("Location: index.php?lang=" . $_GET['lang']);
} else if (!isset($_GET['lang'])) {
    if (!isset($_POST['lang'])) {
        header("Location: index.html");
    } else {
        $_GET['lang'] = $_POST['lang'];
    }
}

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

$msg = array();

if (isset($_POST["register"])) {

    $valid = true;

    $_POST["name"] = UserAdmin::clean_name($_POST["name"]);
    $_POST["email"] = UserAdmin::clean_email($_POST["email"]);
    $_POST["serial"] = UserAdmin::clean_serial($_POST["serial"]);

    if (!UserAdmin::is_name_length_valid($_POST["name"])) {
        if ($lang == "ESP") {
            $msg[] = "El nombre debe tener entre 3 y 255 caracteres.";
        } else if ($lang == "ENG") {
            $msg[] = "Name must have between 3 and 255 characters.";
        }
        $valid = false;
    } else if (!UserAdmin::is_name_valid($_POST["name"])) {
        if ($lang == "ESP") {
            $msg[] = "El nombre sólo puede contener letras.";
        } else if ($lang == "ENG") {
            $msg[] = "Name can only contain letters.";
        }
        $valid = false;
    }

    if (!UserAdmin::is_email_length_valid($_POST["email"])) {
        if ($lang == "ESP") {
            $msg[] = "El correo electrónico debe tener 255 caracteres o menos.";
        } else if ($lang == "ENG") {
            $msg[] = "E-mail must have 255 characters or less.";
        }
        $valid = false;
    } else if (!UserAdmin::is_email_valid($_POST["email"])) {
        if ($lang == "ESP") {
            $msg[] = "Correo electrónico inválido.";
        } else if ($lang == "ENG") {
            $msg[] = "E-mail invalid.";
        }
        $valid = false;
    } else if (UserAdmin::exists_email($_POST["email"], $db_wrapper)) {
        if ($lang == "ESP") {
            $msg[] = "Correo electrónico inválido.";
        } else if ($lang == "ENG") {
            $msg[] = "E-mail invalid.";
        }
        $valid = false;
    }

    if (!UserAdmin::is_pass_length_valid($_POST["password"])) {
        if ($lang == "ESP") {
            $msg[] = "La contraseña debe tener entre 6 y 20 caracteres.";
        } else if ($lang == "ENG") {
            $msg[] = "Password must have between 6 and 20 characters.";
        }
        $valid = false;
    } else if (!UserAdmin::is_pass_valid($_POST["password"], $_POST["confirm"])) {
        if ($lang == "ESP") {
            $msg[] = "Las contraseñas no coinciden.";
        } else if ($lang == "ENG") {
            $msg[] = "Passwords do not match.";
        }
        $valid = false;
    }

    if (!UserAdmin::is_serial_valid($_POST["serial"])) {
        if ($lang == "ESP") {
            $msg[] = "Número de serie inválido.";
        } else if ($lang == "ENG") {
            $msg[] = "Serial invalid.";
        }
        $valid = false;
    } else if (UserAdmin::exists_serial($_POST["serial"], $db_wrapper)) {
        if ($lang == "ESP") {
            $msg[] = "Número de serie ya registrado.";
        } else if ($lang == "ENG") {
            $msg[] = "Serial already registed.";
        }
        $valid = false;
    }

    if ($valid) {

        $id_user = UserAdmin::db_insert($_POST["name"], $_POST["email"], $_POST["password"], $_POST["country"], $_POST["serial"], $db_wrapper);
        $sucess = UserAdmin::create_validation_link($id_user, $_POST["email"]);

        $_POST["name"] = "";
        $_POST["email"] = "";
        $_POST["country"] = "";
        $_POST["serial"] = "";
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Aerolia - Registro</title>
        <link href="css/main-style.css" media="screen" type="text/css" rel="stylesheet"/>
        <link rel="stylesheet" href="css/south-street/jquery-ui-1.8.12.custom.css" media="screen" type="text/css"/>
        <link rel="stylesheet" href="css/jquery.lightbox-0.5.css" media="screen" type="text/css"/>
        <script src="js/jquery-1.5.1.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui-1.8.12.custom.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui-1.8.7.custom.min.js" type="text/javascript"></script>
        <script src="js/jquery.lightbox-0.5.js" type="text/javascript"></script>
        <script src="js/corner.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready( function (){
                $("#tabs").css("background-color","rgba(255,255,255,0.5)");
                $("#footer").css("background-color","rgba(255,255,255,0.5)");
                $('#tabs').tabs();
                //$(".corner").corner();
                $("#gallery a").lightBox();
            });
        </script>
    </head>
    <body>
<?php
if ($lang == "ESP") {
?>
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
                    <li><a href="#tabs-1">Registro</a></li>
                </ul>
                <div id="tabs-1" style="height: auto;">
<?php
        if (count($msg) > 0) {
?>
                    <div class="alert">Parte de la información es inexistente o está incorrecta. Favor de corregirla e inténtelo de nuevo.<ul><?php
                    foreach ($msg as $message) {
                        echo "<li>" . $message . "</li>";
                    }
?></ul></div>
                            <?php
                        }
                            ?>
                    <?php
                        if (isset($sucess)) {
                    ?>
                            <div class="alert">Un correo electrónico ha sido enviado ha su dirección para confirmarla. Siga las instrucciones de éste para completar su registro. <?php
                            print $sucess;
                    ?></div>
                        <?php
                        }
                        ?>
                        <form action="registro.php" method="post">
                            <input type="hidden" name="lang" id="lang" value="<?php echo $lang; ?>"/>
                            <table align="center" style="border: #cdfb74 solid medium; text-align: left;">
                                <tbody>
                                    <tr>
                                        <td>Nombre completo:</td>
                                        <td><input type="text" name="name" value="<?php print $_POST["name"]; ?>" maxlength="255" /></td>
                                        <td rowspan="7"><div id="error" style="display:inline-block; text-align: left;"><!--Posibles errores--></div></td>
                                    </tr>
                                    <tr>
                                        <td>Correo Electrónico:</td>
                                        <td><input type="text" name="email" value="<?php print $_POST["email"]; ?>" maxlength="255" /></td>
                                    </tr>
                                    <tr>
                                        <td>País:</td>
                                        <td><select name="country"><?php UserAdmin::print_country_list($db_wrapper, $_POST["country"]); ?></select></td>
                                    </tr>
                                    <tr>
                                        <td>Contraseña:</td>
                                        <td><input type="password" name="password" maxlength="20" /></td>
                                    </tr>
                                    <tr>
                                        <td>Repita la Contraseña:</td>
                                        <td><input type="password" name="confirm" maxlength="20" /></td>
                                    </tr>
                                    <tr>
                                        <td>N° Serie Aerogenerador:</td>
                                        <td><input type="text" name="serial" value="<?php print $_POST["serial"]; ?>" maxlength="20" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><p align="center"><input type="submit" name="register" value="Registrarse" style="width: auto;"/></p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        <br/><br/>
                        <a href="index.php?lang=<?php echo $_GET['lang']; ?>" class="nlink">Regresar</a>
                    </div>
                </div>
                <span id="footer" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                    <a href="http://www.insa-lyon.fr/" target="_blank" style="display: inline;">Insa Lyon</a>
                    <a href="http://www.ipn.mx/" target="_blank" style="display: inline;">IPN</a>
                    <a href="http://www.argentinarenovables.org/" target="_blank" style="display: inline;">Camara Argentina de Energias Renovables</a>
                    <div style="display: inline-block">Cecyt 9 "Juan de Dios Bátiz" Programacion México 2011</div>
                </span>
            </div>

<?php
                    } else {
?>
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
                            <br/><br/>
                            <a href="index.php?lang=<?php echo $_GET['lang']; ?>" class="nlink">Back</a>
                            <span id="footer">
                                <a href="http://www.insa-lyon.fr/" target="_blank" style="display: inline;">Insa Lyon</a>
                                <a href="http://www.ipn.mx/" target="_blank" style="display: inline;">IPN</a>
                                <a href="http://www.argentinarenovables.org/" target="_blank" style="display: inline;">Camara Argentina de Energias Renovables</a>
                                <div style="display: inline-block">Cecyt 9 "Juan de Dios Bátiz" Programacion México 2011</div>
                            </span>
                        </div>
<?php
                    }
?>
    </body>
</html>