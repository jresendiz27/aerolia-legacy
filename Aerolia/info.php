<?php
require_once "./include/dbconfig.php";

require_once "./include/pchart/class/pData.class.php";
require_once "./include/pchart/class/pDraw.class.php";
require_once "./include/pchart/class/pImage.class.php";

require_once "./include/database.php";
require_once "./include/usradmin.php";
require_once "./include/user.php";
require_once "./include/datalog.php";

$db_wrapper = new Database();
$db_wrapper->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_ENC);

$user_card = new User($db_wrapper);
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
                $("#tabs").css("background-color","transparent");
                $("#tabs").tabs();
                $("#footer").css("background-color","rgba(255,255,255,0.5)");
            });
        </script>
    </head>
    <body>
        <?php
        $lang;
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
                        <li><a href="#tabs-1">Reporte</a></li>
                    </ul>
                    <div id="tabs-1" style="height: auto; text-align: center;">
                        <div id="profile-functions">
                        <?php
                        if ($user_card->is_session_active()) {
                            $result = DataLog::request_recent_data($user_card->aero[0], $db_wrapper);
                            $dresult = DataLog::request_daily_data($user_card->aero[0], date("Y-m-d"), $db_wrapper);
                        ?>
                            <h1>Consulta de información actual</h1>
                        <?php
                            foreach ($result as $info) {
                                print "<p title=\"Dato Obtenido en " . $info["date"] . " \">" . $info["desc"] . ": ";
                                if ($info["type"] == 5 || $info["type"] == 6) {
                                    if ($info["value"] == 0) {
                                        print "OK";
                                    } else {
                                        print "<b>Dañado</b>";
                                    }
                                } else {
                                    print $info["value"] . " " . $info["unit"];
                                }
                                print "</p>";
                            }

                            if ($dresult != null) {

                                $imgset = DataLog::generate_graphic($user_card->$aero[0], $dresult, Array(1, 2, 3, 4), 1);

                                foreach ($imgset as $img) {
                                    print "<p><img src=\"" . $img . "\" height=\"200\" width=\"600\" /></p>";
                                }
                            } else {

                                echo "<p>Información reciente no disponible en este momento...</p>";
                            }
                        ?>
                        <?php
                        } else {
                        ?>
                            <h1>Debes iniciar sesión primero</h1>
                        <?php
                        }
                        ?>
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