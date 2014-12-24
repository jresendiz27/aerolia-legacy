<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Aerolia - Ingresar</title>
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
                        <li><a href="#tabs-1">Ingresar</a></li>
                    </ul>
                    <div id="tabs-1" style="height: auto; text-align: center;">
                    <?php
                    if ($_GET["err"]) {
                    ?>
                        <div class="alert">
                            Nombre de usuario o contraseña incorrecta
                        </div>
                    <?php } else if (isset($_GET['validate'])) {
                    ?>                         <div class="alert">
                            Validado!
                        </div>
                    <?php } ?>
                    <form action="login.php" method="post">
                        <input type="hidden" name="lang" id="lang" value="<?php echo $lang; ?>"/>
                        <div id="form" style="width:75%; display: inline-block; text-align: center;">
                            <center>
                                <table align="left" style="border: #cdfb74 solid medium; text-align: center;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                Correo electrónico:
                                            </td>
                                            <td>
                                                <div style="display: block"><input type="text" name="email"/></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Contraseña</td>
                                            <td>
                                                <div style="display: block"><input type="password" name="password" /></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div style="display: block"><p align="center"><input type="submit" name="login" value="Iniciar sesión" style="width: auto;" /></p>    </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div style="display:block;"><p><a href="passrec.php">¿Olvidó su contraseña?</a></p></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </center>
                        </div>
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

        <?php } else {
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
                            <br/><br/>
                            <a href="index.php?lang=<?php echo $_GET['lang']; ?>" class="nlink">Back</a>
                        </div>
                        <span id="footer">
                            <a href="http://www.insa-lyon.fr/" target="_blank" style="display: inline;">Insa Lyon</a>
                            <a href="http://www.ipn.mx/" target="_blank" style="display: inline;">IPN</a>
                            <a href="http://www.argentinarenovables.org/" target="_blank" style="display: inline;">Camara Argentina de Energias Renovables</a>
                            <div style="display: inline-block">Cecyt 9 "Juan de Dios Bátiz" Programacion México 2011</div>
                        </span>
                    </div>
        <?php } ?>
    </body>
</html>