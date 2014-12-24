<?php
require_once "./include/dbconfig.php";

require_once "./include/database.php";
require_once "./include/user.php";


$db_wrapper = new Database();
$db_wrapper->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_ENC);

$user_card = new User($db_wrapper);

if (!isset($_GET['lang'])) {
    header("Location: index.html");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Aerolia</title>
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
                $("#gallery a").lightBox();
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
                        <li><a href="#tabs-1">Aerolia</a></li>
                        <li><a href="#tabs-2">Project Criter</a></li>
                        <li><a href="#tabs-3">Eolik</a></li>
                        <li><a href="#tabs-4">Ubicaci&oacute;n</a></li>
                        <li><a href="#tabs-5">Contacto</a></li>
                    <?php if (!isset($_SESSION['id'])) {
                    ?>
                        <li><a href="#tabs-6">Clientes</a></li>
                    <?php } else {
                    ?>
                        <li><a href="#tabs-6">Perfil</a></li>
                    <?php } ?>
                </ul>
                <div id="tabs-1" style="height: auto;">
                    <p>
                        <p><b>Aerolia</b></p>
                        <p style="text-align: left; font-size: x-large;font-weight: bold;"> ¿Quienes Somos? </p>
                        <hr/>
                        Información de la presentación.Unas cuantas imagenes por ahi...
                        <hr/>
                        <p style="text-align: left; font-size: x-large;font-weight: bold;"> Misi&oacute;n </p>
                        <div style="display: inline-block;">
                            <div style="float: left; width: 60%; text-align: left;">El mercado actual es una enorme industria de información, es donde la competencia en el ámbito de la Informática es elevada. Es por ello que brindando productos de alta calidad, diseñados  y  compaginados a las necesidades de cada cliente y haciendo uso de las más altas tecnologías y refinados conocimientos sobre el uso de las Tecnologías de la Información, se planea penetrar el mercado de software actual.

                                Así también se tiene como misión un impacto notable en el mercado actual, como un equipo líder a nivel nacional dentro de la rama de análisis, diseño y producción de software contando con todos los parámetros y requerimientos de cada uno de nuestros clientes.</div>
                            <div style="width: 40%; float: right;"><img src="img/Mision.jpg" alt="" width="240" height="170"></img></div>
                        </div>
                        <p style="text-align: right; font-size: x-large;font-weight: bold;"> Visi&oacute;n a 5 años </p>
                        <div style="display: inline-block;">
                            <div style="float: right; width: 60%; text-align: left;">
                                A partir del proyecto a desarrollar actualmente, los integrantes del equipo dentro del área de programación tienen la visión de formar una empresa, la cuál llegaría a ser líder local y social en producción de sistemas relacionados a las tecnologías de la información, mediante un constante proceso evolutivo y sustentado, adaptándonos a las necesidades de cada uno de nuestros clientes y al constante cambio dentro de la cultura del desarrollo de software. 
                                Con bases sólidas y políticas flexibles nos vemos como una sociedad estable y concisa.
                            </div>
                            <div style="width: 40%; float: left;"><img src="img/vision.jpg" alt="" width="212" height="170"></img></div>
                        </div>
                        <p style="text-align: left; font-size: x-large;font-weight: bold;"> Valores </p>
                        <div style="display: inline-block;">
                            <div style="float: left; width: 60%; text-align: left;">
                                Para lograr el crecimiento, tanto del equipo de trabajo como de cada individuo perteneciente a éste, se considera trabajar en los valores siguientes:
                                <ul style="list-style-type:square;">
                                    <li>Respeto: estará dirigido hacia nuestros usuarios como a los integrantes del equipo de trabajo. </li>
                                    <li>Compromiso: con nuestros clientes y usuarios para su satisfacción. </li>
                                    <li>Responsabilidad: por parte de nosotros y así lograr la eficacia total en nuestro software. </li>
                                    <li>Honestidad: no solo de nosotros, sino también entre los clientes y usuarios para la seguridad en el intercambio de información. </li>
                                    <li>Confianza: Fundamental dentro del proceso de comunicación interno del equipo de trabajo.</li>
                                    <li>Solidaridad: Colaborar en equipo y comunicarnos respetuosamente para alcanzar metas comunes.</li>
                                    <li>Trabajo: simplemente es aprovechar la oportunidad que se nos brinda para innovar y mejorar nuestros productos de manera constante.</li>
                                </ul>
                            </div>
                            <div style="width: 40%; float: right;"><img src="img/valores.jpg" alt="" width="212" height="170"></img></div>
                        </div>
                        <hr/>                        
                        <!--<p>
                            <div style="display:inline-block;">
                                <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="320" HEIGHT="240" id="Yourfilename" ALIGN="">
                                    <PARAM NAME="movie" VALUE="presentacion.swf"/>
                                    <PARAM NAME="quality" VALUE="high"/>
                                    <EMBED src="presentacion.swf" quality="high" WIDTH="715" HEIGHT="543" NAME="presentacion" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
                                    </EMBED>
                                </OBJECT>
                            </div>
                        </p>-->
                    </p>
                </div>
                <div id="tabs-2" style="height: auto;">
                    <p>
                        <p><b>Project Criter</b></p>
                        <p>El Proyecto Colaborativo Internacional CRITER tiene como objetivo principal que diferentes equipos
                            de estudiantes (preparatorias técnicas del sector de Lyon, preparatorias interlocutoras en Argentina y
                            México, el INSA de Lyon) compartan información sobre un mismo tema. Dichos equipos deberán
                            concebir y fabricar todo o parte de un objeto técnico que utilice las energías renovables.</p>
                        <p>El trabajo sobre el mismo tema permitirá una cooperación entre los distintos equipos y, además, la
                            comunicación a través de la red informática se convertirá en una herramienta indispensable para
                            compartir información e intercambiar documentos y resultados intermediarios.</p>
                        <p>
                            <b>Alcances</b>
                            Como producto de este proyecto, cada equipo participante deberá realizar un objeto técnico, el cuál
                            se encuentre relacionado con el tema de Energías Renovables, así como la diversa documentación
                            técnica y de promoción del producto final.
                        </p>
                        <p>
                            De igual forma, se espera que a corto y mediano plazo este proyecto permita crear vínculos entre
                            escuelas técnicas de Argentina, el CECyT 9 de México, el Liceo Franco Mexicano y el INSA de Lyon,
                            permitiendo la constitución de equipos pedagógicos internacionales que trabajen sobre un mismo
                            proyecto
                        </p>
                    </p>
                    <a href="http://pci.vije.net/moodle/" target="_blank">M&aacute;s informaci&oacute;n [+]</a>
                </div>
                <div id="tabs-3" style="height: auto;">
                    <p><b>Eolik</b></p>
                    <p>Proyecto actual en el que nos encontramos trabajando, este consta de un aerogenerador domestico
                        capaz de satisfacer las necesidades básicas de una familia humilde de México.</p>
                    <p>Con una estructura sencilla y fácil de usar, se lanza esta idea innovadora para fomentar el uso
                        de energias renovables tales como la energia eolica.</p>
                    <p>
                        Para mayor información respecto a Eolik. <a href="download.php?f=Objetivos.pdf">Haz Click!</a>
                    </p>
                    <p style="text-align: right; font-size: x-large;font-weight: bold;"> Galería </p>
                    <div id="gallery" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                        <ul>
                            <li>
                                <a style="text-decoration: none;" href="photos/image1.png" title="Nuestras primeras pruebas.">
                                    <div class="corner"><img alt=""  src="photos/thumb_image1.png"></img></div>
                                </a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="photos/image2.png" title="Un trabajo intenso.">
                                    <div class="corner"><img alt=""  src="photos/thumb_image2.png"></img></div>
                                </a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="photos/image3.png" title="Planeaci&oacute;n; base de Eolik">
                                    <div class="corner"><img alt=""  src="photos/thumb_image3.png"></img></div>
                                </a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="photos/image4.png" title="Ensamblando.">
                                    <div class="corner"><img alt=""  src="photos/thumb_image4.png"></img></div>
                                </a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="photos/image5.png" title="Prototipo funcionando">
                                    <div class="corner"><img alt=""  src="photos/thumb_image5.png"></img></div>
                                </a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="photos/image6.png" title="Realizando m&aacute;s pruebas">
                                    <div class="corner"><img alt=""  src="photos/thumb_image6.png"></img></div>
                                </a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="photos/image7.png" title="Eje funcionando.">
                                    <div class="corner"><img alt=""  src="photos/thumb_image7.png"></img></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="tabs-4" style="height: auto;">
                    <p><b>Ubicación</b></p>
                    <div id="map">
                        <iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?hl=en&amp;q=cecyt9&amp;ie=UTF8&amp;hq=cecyt9&amp;hnear=&amp;ll=19.455829,-99.174786&amp;spn=0.009712,0.013733&amp;z=16&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?hl=en&amp;q=cecyt9&amp;ie=UTF8&amp;hq=cecyt9&amp;hnear=&amp;ll=19.455829,-99.174786&amp;spn=0.009712,0.013733&amp;z=16&amp;source=embed" style="color:#0000FF;text-align:left">View Larger Map</a></small>
                    </div>
                    <div id="address">
                        MAR MEDITERRÁNEO # 227 COLONIA POPOTLA C.P. 11400

                        DELEGACIÓN MIGUEL HIDALGO, CIUDAD DE MÉXICO, D.F.

                        TELÉFONO 5729 6000 EXT. 63825
                    </div>
                </div>
                <div id="tabs-5" style="height: auto;">
                    <p><b>Contacto</b></p>
                    <p>
                        <p>Correo Electrónico</p>
                        <p align="center"><a href="mailto:jresendiz27@gmail.com">Juan Alberto Reséndiz Arteaga</a></p>
                        <p align="center"><a href="mailto:adonnas@hotmail.com">Sergio Adonais Romero Gonzalez</a></p>
                        <br/>
                        <br/>
                        <p>Telefono</p>
                        <p align="center">044(55)27137383</p>
                    </p>
                </div>
                <div id="tabs-6" style="height: auto;">
                    <?php
                    if ($user_card->is_session_active()) {
                    ?>
                        <div id="profile">
                            <div id="profile-data"><span style="text-align:center;"><b>Bienvenido</b> <?php echo htmlspecialchars($_SESSION['name']); ?> <br/><a href="login.php?lang=<?php echo $lang; ?>&logout=true" class="nlink">Salir</a></span></div>
                            <br/>
                            <div id="profile-functions">
                                <p align="left"><b>Funciones</b></p>
                                <li><p><a href="reporte.php?lang=<?php echo $lang; ?>" target="_self">Reportes</a></p></li>
                                <li><p><a href="historia.php?lang=<?php echo $lang; ?>" target="_self">Historial de eventos</a></p></li>
                                <li><p><a href="passc.php?lang=<?php echo $lang; ?>" target="_self">Cambio de contraseña</a></p></li>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div id="functions">
                            <p><b>Clientes</b></p>
                            <li>¿Cuentas con alguna cuenta? <a href="sign_in.php?lang=<?php echo $lang; ?>" target="_self">Ingresa</a></li>
                            <li>¿Aun no te has registrado? <a href="registro.php?lang=<?php echo $lang; ?>" target="_self">Registrate</a></li>
                        </div>
                    <?php
                    }
                    ?>

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