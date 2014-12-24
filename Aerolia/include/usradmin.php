<?php

    class UserAdmin {


        //  print_contry_list($wrapper, $selected)
        //
        //  Descripción:
        //      Crea una lista de paises para un formulario, leyendo ésta de la base de datos.
        //
        //  Parámetros:
        //      * $wrapper: Objeto de la clase "Database" para efectuar la conexión a la base de
        //          datos.
        //      * $selected: ID del país seleccionado previamente.

        public static function print_country_list ($wrapper, $selected) {

            $result = $wrapper->simple_query(Array("c_pais"), null, "nom_pais");

            if (strcmp($selected, "") == 0) {
                print "<option value=\"\" selected=\"selected\" disabled=\"disabled\">--- Seleccione uno ---</option>";
            }
            else {
                print "<option value=\"\" disabled=\"disabled\">--- Seleccione uno ---</option>";
            }
            foreach ($result as &$row) {
                print "<option value=\"".$row["id_pais"]."\"";
                if (strcmp($selected, $row["id_pais"]) == 0) {
                    print " selected=\"selected\"";
                }
                print ">".$row["nom_pais"]."</option>";
            }

        }


        //  clean_name($name)
        //
        //  Descripción:
        //      Limpia los espacios adicionales en la cadena de nombre.
        //
        //  Parámetros:
        //      * $name: Cadena de nombre.
        //
        //  Valores de retorno:
        //      * Cadena de nombre limpia.

        public static function clean_name($name) {

            $name = trim($name);
            $name = preg_replace("/[\s]+/", " ", $name);

            return $name;

        }


        //  clean_serial($serial)
        //
        //  Descripción:
        //      Limpia los espacios adicionales en la cadena del número de serie.
        //
        //  Parámetros:
        //      * $serial: Cadena del número de serie.
        //
        //  Valores de retorno:
        //      * Cadena del número de serie limpia.

        public static function clean_serial($serial) {

            $serial = preg_replace("/[\s]+/", "", $serial);

            return $serial;

        }


        //  clean_email($email)
        //
        //  Descripción:
        //      Limpia los espacios adicionales en la cadena del correo electrónico.
        //
        //  Parámetros:
        //      * $email: Cadena de correo electrónico.
        //
        //  Valores de retorno:
        //      * Cadena de correo electrónico limpia.

        public static function clean_email($email) {

            $email = trim($email);

            return $email;

        }


        //  is_name_length_valid($name)
        //
        //  Descripción:
        //      Verifica si la longitud del nombre es válida.
        //
        //  Parámetros:
        //      * $name: Nombre a verificar.
        //
        //  Valores de retorno:
        //      * [true]  si el nombre es válido.
        //      * [false] si el nombre es inválido.

        public static function is_name_length_valid($name) {

            if (strlen($name) == 0) {
                return false;
            }

            if (strlen($name) > 255) {
                return false;
            }

            return true;

        }


        //  is_name_valid($name)
        //
        //  Descripción:
        //      Verifica si el nombre tiene un formato válido.
        //
        //  Parámetros:
        //      * $name: Nombre a verificar.
        //
        //  Valores de retorno:
        //      * [true]  si el nombre es válido.
        //      * [false] si el nombre es inválido.

        public static function is_name_valid($name) {

            if (preg_match("/[^a-zA-ZáéíóúÁÉÍÓÚüÜ\\- ]/", $name) > 0) {
                return false;
            }

            return true;

        }


        //  is_email_length_valid($email)
        //
        //  Descripción:
        //      Verifica si la longitud del correo electrónico es válida.
        //
        //  Parámetros:
        //      * $email: Correo electrónico a verificar.
        //
        //  Valores de retorno:
        //      * [true]  si el correo electrónico es válido.
        //      * [false] si el correo electrónico es inválido.

        public static function is_email_length_valid($email) {

            if (strlen($email) == 0) {
                return false;
            }

            if (strlen($email) > 255) {
                return false;
            }

            return true;

        }


        //  is_email_valid($email)
        //
        //  Descripción:
        //      Verifica si el correo electrónico tiene un formato válido.
        //
        //  Parámetros:
        //      * $email: Correo electrónico a verificar.
        //
        //  Valores de retorno:
        //      * [true]  si el correo electrónico es válido.
        //      * [false] si el correo electrónico es inválido.

        public static function is_email_valid($email) {

            if (preg_match_all("#@#", $email, $out) != 1) {
				return false;
			}
            if (strpos($email, ".") === 0) {
                return false;
            }
            if (strpos($email, " ") !== false) {
                return false;
            }
            if (strlen(substr($email, 0, strpos($email, "@"))) > 64) {
                return false;
            }
            if (strcmp(substr($email, strlen($email) - 1, 1), ".") == 0) {
                return false;
            }
            if (strcmp(preg_replace("#[A-Za-z0-9!\\#\\$%&'*+\-/=?\\^_`{|}~.@]#", "", $email), "") != 0) {
                return false;
            }
            if (preg_match("#\\.\\.#", $email) > 0) {
                return false;
            }

            return true;

        }


        //  exists_email($email, $wrapper)
        //
        //  Descripción:
        //      Verifica si el correo electrónico no ha sido registrado.
        //
        //  Parámetros:
        //      * $email: Correo electrónico a verificar.
        //      * $wrapper: Objeto de la clase "Database" para efectuar la conexión a la base de
        //          datos.
        //
        //  Valores de retorno:
        //      * [true]  si el correo electrónico ya existe.
        //      * [false] si el correo electrónico no existe todavía.

        public static function exists_email($email, $wrapper) {

            $email = mysql_real_escape_string($email);

            if (count($wrapper->simple_query(Array("m_usuario"), "email_usuario = '".$email."'")) == 0) {
                return false;
            }

            return true;

        }


        //  is_pass_length_valid($pass)
        //
        //  Descripción:
        //      Verifica si la longitud de la contraseña es válida.
        //
        //  Parámetros:
        //      * $pass: Contraseña a verificar.
        //
        //  Valores de retorno:
        //      * [true]  si la contraseña es válida.
        //      * [false] si la contraseña es inválida.

        public static function is_pass_length_valid($pass) {

            if (strlen($pass) == 0) {
                return false;
            }

            if (strlen($pass) > 20) {
                return false;
            }

            return true;

        }


        //  is_pass_valid($pass, $confirm)
        //
        //  Descripción:
        //      Verifica si el formato de la contraseña es válido.
        //
        //  Parámetros:
        //      * $pass: Contraseña a verificar.
        //
        //  Valores de retorno:
        //      * [true]  si la contraseña es válida.
        //      * [false] si la contraseña es inválida.

        public static function is_pass_valid($pass, $confirm) {

            if (strcmp($pass, $confirm) != 0) {
				return false;
			}

            return true;

        }


        //  is_serial_valid($serial)
        //
        //  Descripción:
        //      Verifica si el número de serie tiene un formato válido.
        //
        //  Parámetros:
        //      * $serial: Número de serie a verificar.
        //
        //  Valores de retorno:
        //      * [true]  si el número de serie es válido.
        //      * [false] si el número de serie es inválido.

        public static function is_serial_valid($serial) {

            return true;

        }


        //  exists_serial($serial, $wrapper)
        //
        //  Descripción:
        //      Verifica si el número de serie no ha sido registrado.
        //
        //  Parámetros:
        //      * $email: Número de serie a verificar.
        //      * $wrapper: Objeto de la clase "Database" para efectuar la conexión a la base de
        //          datos.
        //
        //  Valores de retorno:
        //      * [true]  si el número de serie ya existe.
        //      * [false] si el número de serie no existe todavía.

        public static function exists_serial($serial, $wrapper) {

            $serial = mysql_real_escape_string($serial);

            if (count($wrapper->simple_query(Array("m_aero"), "ns_aero = '".$serial."'")) == 0) {
                return false;
            }

            return true;

        }


        //  process_password($pass)
        //
        //  Descripción:
        //      Procesa la contraseña para poder ser almacenada en la base de datos
        //
        //  Parámetros
        //      * $pass: Contraseña a procesar.
        //
        //  Valores de retorno:
        //      * Contraseña procesada.

        public static function process_password($pass) {

            return hash("sha256", "aero".$pass."1");

        }


        //  db_insert($name, $email, $pass, $country, $serial, $wrapper)
        //
        //  Descripción:
        //      Inserta los datos del usuario a la base.
        //
        //  Parámetros
        //      * $name: Nombre.
        //      * $email: Correo Electrónico.
        //      * $pass: Contraseña cifrada.
        //      * $country: Código de país.
        //      * $serial: Número de serie.
        //      * $wrapper: Objeto "Database" para efectuar la conexión.

        public static function db_insert($name, $email, $pass, $country, $serial, $wrapper) {

            $id_user = $wrapper->simple_insert(
                "m_usuario",
                Array(
                    "nom_usuario" => $name,
                    "email_usuario" => $email,
                    "pass_usuario" => UserAdmin::process_password($pass),
                    "id_pais" => $country,
                    "val_usuario" => false
                ),
                "id_usuario"
            );

            $wrapper->simple_insert(
                "m_aero",
                Array(
                    "id_usuario" => $id_user,
                    "ns_aero" => $serial
                )
            );

            return $id_user;

        }


        //  create_validation_code($email)
        //
        //  Descripción:
        //      Crea el código de validación de la cuenta, el cuál será enviado al correo electrónico
        //
        //  Parámetros
        //      * $email: Correo Electrónico.
        //
        //  Valores de retorno:
        //      * Cadena representando el código de validación


        public static function create_validation_code($email) {

            return hash("sha256", "val".$email."2");

        }


        //  create_validation_link($id, $email)
        //
        //  Descripción:
        //      Crea el vínculo de validación de la cuenta, el cuál será enviado al correo electrónico.
        //
        //  Parámetros
        //      * $id: ID del usuario.
        //      * $email: Correo Electrónico.
        //
        //  Valores de retorno:
        //      * Cadena representando el código de validación

        public static function create_validation_link($id, $email) {

            return "http://".$_SERVER["SERVER_NAME"]."/aerolia/validreg.php?id=".$id."&code=".UserAdmin::create_validation_code($email);

        }


        //  validate_registry($id, $code, $wrapper)
        //
        //  Descripción:
        //      Realiza el proceso de validación del registro (confirmación del código y
        //      los cambios correspondientes en la base de datos).
        //
        //  Parámetros
        //      * $id: ID del usuario.
        //      * $code: Código de validación.
        //      * $wrapper: Objeto de la clase "Database" para efectuar la conexión a la base de
        //          datos.
        //
        //  Valores de retorno:
        //      * [true] si la validación fue exitosa.
        //      * [false] si la validación no fue exitosa.

        public static function validate_registry ($id, $code, $wrapper) {

            // Consulta de usuarios que poseean la ID especificada.
            $query_result = $wrapper->simple_query(Array("m_usuario"), "id_usuario = ".$id);

            // Si no existe un usuario con tal ID...
            if (count($query_result) == 0) {
                return false;
            }

            // Si el usuario ya se encuentra validado...
            if ($query_result[0]["val_usuario"]) {
                return false;
            }

            // Confirmar códigos...
            if ($code != UserAdmin::create_validation_code($query_result[0]["email_usuario"])) {
                return false;
            }

            // Validar usuario en la base de datos
            $wrapper->simple_update("m_usuario", Array("val_usuario" => true), "id_usuario = ".$id);

            return true;

        }


        //  create_pass_rec_code($email)
        //
        //  Descripción:
        //      Crea el código de recuperación de contraseña, el cuál será enviado al correo electrónico
        //

        public static function create_pass_rec_code($email, $wrapper) {

            $result = $wrapper->simple_query(Array("m_usuario"), "email_usuario = '".mysql_real_escape_string($email)."'");

            return hash("sha256", "pass".$email.$result[0]["pass_usuario"]."3");

        }


        //  create_pass_rec_link($id, $email)
        //
        //  Descripción:
        //      Crea el vínculo de recuperación de contraseña, el cuál será enviado al correo electrónico.
        //

        public static function create_pass_rec_link($email, $wrapper) {

            return "http://".$_SERVER["SERVER_NAME"]."/aerolia/passrec.php?email=".urlencode($email)."&code=".UserAdmin::create_pass_rec_code($email, $wrapper);

        }


        public static function recover_password($email, $code, $wrapper) {

            if ($code == UserAdmin::create_pass_rec_code($email, $wrapper)) {
                $new_pass = "";
                for ($i = 0; $i < 8; $i++) {
                    switch (mt_rand(0, 2)) {
                        case 0:
                            $new_pass .= chr(mt_rand(48, 57));
                            break;
                        case 1:
                            $new_pass .= chr(mt_rand(65, 90));
                            break;
                        case 2:
                            $new_pass .= chr(mt_rand(97, 122));
                            break;
                    }
                }
                $new_hash = UserAdmin::process_password($new_pass);
                $wrapper->simple_update("m_usuario", Array("pass_usuario" => $new_hash), "email_usuario = '".mysql_real_escape_string($email)."'");
                return $new_pass;
            }

            return false;

        }


        public static function change_password($id, $pass, $new_pass, $wrapper) {

            $result = $wrapper->simple_query(Array("m_usuario"), "id_usuario = ".$id);

            if (count($result) > 0) {

                if (UserAdmin::process_password($pass) == $result[0]["pass_usuario"]) {
                    $new_hash = UserAdmin::process_password($new_pass);
                    $wrapper->simple_update("m_usuario", Array("pass_usuario" => $new_hash), "id_usuario = ".$id);
                    return true;
                }

            }

            return false;

        }
 
 
    }

?>