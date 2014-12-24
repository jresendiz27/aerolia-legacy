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
			$("body").css("background-image","none");
		});
	</script>
</head>
<body>
<form action="login.php" method="post">
    <p>Correo electrónico: <input type="text" name="email"/></p>
    <p>Contraseña <input type="password" name="password" /></p>
    <p><input type="submit" name="login" value="Iniciar sesión" /></p>
	<p><a href="passrec.php">¿Olvidó su contraseña?</a></p>
</form>
</body>
</html>