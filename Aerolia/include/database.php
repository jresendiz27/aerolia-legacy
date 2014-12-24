<?php

    class Database {


        // Atributos

        private $link;


        // Constructor

        function __construct() {

            $this->link = null;

        }


        //  is_connected()
        //
        //  Descripción:
        //      Verifica si el vínculo a la base de datos es válido con el propósito de confirmar
        //      si existe una conexión a ella.
        //
        //  Valores de retorno:
        //      * [true]  si existe una conexión válida a la base de datos.
        //      * [false] si no existe conexión válida.

        public function is_connected() {

            if ($this->link === null) {
                return false;
            }

            return true;

        }


        //  set_encoding($encoding)
        //
        //  Descripción:
        //      Permite la modificación de la codificación empleada durante la comunicación del
        //      sistema con la base de datos.
        //
        //  Parámetros:
        //      * $encoding: Cadena representando la codificación a utilizar.

        public function set_encoding($encoding) {
            mysql_query("SET NAMES '".$encoding."'");
        }


        //  connect()
        //
        //  Efectua una conexión a la base de datos.
        //
        //  Valores de retorno:
        //      * [true]  si la conexión tuvo éxito
        //      * [false] si la conexión no pudo realizarse

        public function connect($host, $user, $pass, $db_name, $encoding = "ascii") {

            // Realizamos conexión a la base de datos guardando el valor del vínculo en una variable
            $this->link = mysql_connect($host, $user, $pass);

            // Si ese valor es falso entonces no se pudo realizar y devolvemos -1
            if (!$this->link) {
                $this->link = null;
                return false;
            }

            // Si no podemos seleccionar base de datos...
            if (!mysql_select_db($db_name, $this->link)) {
                $this->link = null;
                return false;
            }

            // Cambiamos la codificación de las comunicaciones entre la base de datos
            $this->set_encoding($encoding);

            // Regresamos el valor de la conexión, necesario para acceder a la base de datos
            return true;

        }


        // custom_query($query)
        //
        //  Descripción:
        //      Realiza una consulta directa.
        //
        //  Parámetros:
        //      * $query: Cadena representando la consulta.
        //
        //  Valores de retorno:
        //      * Un arreglo de tuplas, cada una de ellas representando otro arreglo de atributos,
        //        identificado cada uno con su nombre en la base de datos.

        public function custom_query($query) {

            $query_result = mysql_query($query, $this->link);

            $result = Array();

            while ($result[] = mysql_fetch_assoc($query_result));

            print mysql_error();

            unset($result[count($result) - 1]);

            return $result;

        }


        // custom_exec ($query)
        //
        //  Descripción:
        //      Realiza una acción directa en la base de datos (que no involucre consulta).
        //
        //  Parámetros:
        //      * $query: Cadena representando la consulta.

        public function custom_exec($query) {

            mysql_query($query, $this->link);

        }


        //  simple_query($tables, $conditions = null, $order = null, $limit = null)
        //
        //  Descripción:
        //      Realiza una consulta simple a la base de datos, realizando una unión natural de
        //      tablas.
        //
        //  Parámetros:
        //      * $tables: Cadena con el nombre de la tabla a consultar o arreglo con los nombres
        //          de las tablas si se pretende hacer una unión natural de éstas.
        //      * $conditions: Cadena con las condiciones.
        //      * $order: Cadena representando el orden en el cual se realizará la consulta.
        //      * $limit: Número entero representando cuántos resultados se regresarán como máximo.
        //
        //  Valores de retorno:
        //      * Un arreglo de tuplas, cada una de ellas representando otro arreglo de atributos,
        //        identificado cada uno con su nombre en la base de datos.

        public function simple_query($tables, $conditions = null, $order = null, $limit = null) {

            $query = "SELECT * FROM ";

            if (is_array($tables)) {
                for ($i = 0; $i < count($tables); $i++) {
                    if (($i + 1) == count($tables)) {
                        $query .= $tables[$i];
                    } else {
                        $query .= $tables[$i]." NATURAL JOIN ";
                    }
                }
            } else {
                $query .= $tables;
            }

            if ($conditions !== null) {
                $query .= " WHERE ".$conditions;
            }

            if ($order !== null) {
                $query .= " ORDER BY ".$order;
            }

            if ($limit !== null) {
                $query .= " LIMIT ".$limit;
            }

            return $this->custom_query($query);

        }


        //  simple_insert($table, $values, $id = null)
        //
        //  Descripción:
        //      Realiza una consulta simple a la base de datos, realizando una unión natural de
        //      tablas.
        //
        //  Parámetros:
        //      * $table: Nombre de las tabla.
        //      * $values: Arreglo con los valores, cada uno de ellos identificado por una llave
        //          cuyo valor deberá ser igual al nombre del atributo en la base de datos.
        //      * $id: Nombre del identificador (llave primaria) del registro, en caso de que se
        //          desee obtener el valor de éste ID asignado a la nueva tupla a insertar.
        //
        //  Valores de retorno:
        //      * ID asignado al nuevo conjunto de valores insertados.
        //      * [null], de no haberse definido el ID.

        public function simple_insert($table, $values, $id = null) {

            $query = "INSERT INTO ".$table."(";

            while ($value = each($values)) {
                $query .= $value["key"].", ";
            }

            $query = substr($query, 0, strlen($query) - 2);
            $query .= ") VALUES (";

            reset($values);

            while ($value = each($values)) {
                if (is_string($value["value"])) {
                    $query .= "'".mysql_real_escape_string($value["value"])."', ";
                } else if (is_numeric($value["value"])) {
                    $query .= mysql_real_escape_string($value["value"]).", ";
                } else if ($value["value"]) {
                    $query .= "TRUE, ";
                } else {
                    $query .= "FALSE, ";
                }
            }

            $query = substr($query, 0, strlen($query) - 2);
            $query .= ")";

            mysql_query($query, $this->link);

            if ($id !== null) {

                reset($values);

                $query = "SELECT ".$id." FROM ".$table." WHERE ";

                while ($value = each($values)) {
                    $query .= $value["key"]." = ";
                    if (is_string($value["value"])) {
                        $query .= "'".mysql_real_escape_string($value["value"])."'";
                    } else if (is_numeric($value["value"])) {
                        $query .= mysql_real_escape_string($value["value"]);
                    } else if ($value["value"]) {
                        $query .= "TRUE";
                    } else {
                        $query .= "FALSE";
                    }
                    $query .= " AND ";
                }

                $query = substr($query, 0, strlen($query) - 5);

                $query_result = mysql_query($query, $this->link);
                while ($result[] = mysql_fetch_assoc($query_result));
                return($result[0][$id]);
 
            }

            return null;

        }


        //  simple_update($table, $values, $id = null)
        //
        //  Descripción:
        //      Realiza una modificación simple a un conjunto de tuplas en la base de datos dada
        //      una condición específica.
        //
        //  Parámetros:
        //      * $table: Nombre de las tabla.
        //      * $values: Arreglo con los valores, cada uno de ellos identificado por una llave
        //          cuyo valor deberá ser igual al nombre del atributo en la base de datos.
        //      * $conditions: Cadena con las condiciones.

        public function simple_update($table, $values, $conditions) {

            $query = "UPDATE ".$table." SET ";

            while ($value = each($values)) {
                $query .= $value["key"]." = ";
                if (is_string($value["value"])) {
                    $query .= "'".mysql_real_escape_string($value["value"])."', ";
                } else if (is_numeric($value["value"])) {
                    $query .= mysql_real_escape_string($value["value"]).", ";
                } else if ($value["value"]) {
                    $query .= "TRUE, ";
                } else {
                    $query .= "FALSE, ";
                }
            }

            $query = substr($query, 0, strlen($query) - 2);
            $query .= " WHERE ".$conditions;

            mysql_query($query, $this->link);

        }


    }

?>