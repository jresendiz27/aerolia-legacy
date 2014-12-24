<?php
header("Content-type: text/html; charset=utf-8");


require_once "./include/dbconfig.php";

require_once "./include/database.php";
require_once "./include/usradmin.php";

if (isset($_POST["passrec"])) {

    $db_wrapper = new Database();
    $db_wrapper->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_ENC);

    $_POST["email"] = UserAdmin::clean_email($_POST["email"]);

    if (UserAdmin::exists_email($_POST["email"], $db_wrapper)) {
        print UserAdmin::create_pass_rec_link($_POST["email"], $db_wrapper);
    } else {
        print "Correo inválido";
    }
} else if (isset($_GET["code"]) && isset($_GET["email"])) {

    $db_wrapper = new Database();
    $db_wrapper->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_ENC);

    if (UserAdmin::exists_email($_GET["email"], $db_wrapper)) {
        if ($new_pass = UserAdmin::recover_password($_GET["email"], $_GET["code"], $db_wrapper)) {
            print "Contraseña cambiada a " . $new_pass;
        } else {
            print "Código inválido";
        }
    } else {
        print "Correo Inválido";
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
                $("#tabs").tabs();
                $("#footer").css("background-color","rgba(255,255,255,0.5)");
            });
        </script>
    </head>
    <body>
<?php
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
                    <li><a href="#tabs-1">Recuperar Contrase&ntilde;a</a></li>
                </ul>
                <div id="tabs-1" style="height: auto; text-align: center;">
                    <form action="login.php" method="post">
                        <input type="hidden" name="lang" id="lang" value="<?php echo $lang; ?>"/>
                        <div id="form" style="width:75%; display: inline-block; text-align: center;">
                            <form action="passrec.php" method="post">
                                <table align="center" style="border: #cdfb74 solid medium; text-align: center;"></table>
                                <tbody>
                                    <tr>
                                        <td> Correo: </td>
                                        <td> <input type="text" name="email" /> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> <input type="submit" name="passrec" /> </td>
                                    </tr>
                                </tbody>                               
                            </form>
                        </div>
                    </form>
                </div>
            </div>
            <span id="footer" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <a href="http://www.insa-lyon.fr/" target="_blank" style="display: inline;">Insa Lyon</a>
                <a href="http://www.ipn.mx/" target="_blank" style="display: inline;">IPN</a>
                <a href="http://www.argentinarenovables.org/" target="_blank" style="display: inline;">Camara Argentina de Energias Renovables</a>
                <div style="display: inline-block">Cecyt 9 "Juan de Dios Bátiz" Programacion México 2011</div>
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
                </div>
                <div id="footer">
                    <a href="http://www.insa-lyon.fr/" target="_blank" style="display: inline;">Insa Lyon</a>
                    <a href="http://www.ipn.mx/" target="_blank" style="display: inline;">IPN</a>
                    <a href="http://www.argentinarenovables.org/" target="_blank" style="display: inline;">Camara Argentina de Energias Renovables</a>
                    <div style="display: inline-block">Cecyt 9 "Juan de Dios Bátiz" Programacion México 2011</div>
                </div>
<?php } ?>
    </body>
</html>