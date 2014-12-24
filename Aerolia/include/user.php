<?php

class User {

    // Atributos

    public $id;
    public $name;
    public $email;
    public $acc_type;
    public $pass;
    public $aero;
    private $wrapper;

    // Constructor

    function __construct($new_wrapper) {

        session_start();
        $this->id = $_SESSION["id"];
        $this->pass = $_SESSION["pass"];
        $this->name = $_SESSION["name"];
        $this->wrapper = $new_wrapper;

        $this->request_data();
    }

    private function request_data() {

        if ($this->id != null) {

            $result = $this->wrapper->simple_query("m_usuario", "id_usuario = " . $this->id);

            if (count($result) == 0) {
                $this->logout();
            } else {
                $this->name = $result[0]["nom_usuario"];
                $this->email = $result[0]["email_usuario"];
                $this->acc_type = $result[0]["id_tipousuario"];
                $this->pass = $result[0]["pass_usuario"];
                session_start();
                $_SESSION["id"] = $this->id;
                $_SESSION["pass"] = $this->pass;
                $_SESSION["name"] = $this->name;
                $result = $this->wrapper->simple_query("m_aero", "id_usuario = " . $this->id);
                foreach ($result as $piece) {
                    $this->aero[] = $piece["id_aero"];
                }                
            }
        }
    }

    public function login($email, $pass) {

        $result = $this->wrapper->simple_query(
                        Array("m_usuario"),
                        "email_usuario = '" . mysql_real_escape_string($email) . "' AND pass_usuario = '" . UserAdmin::process_password($pass) . "'"
        );

        if (count($result) != 1) {
            return false;
        }

        $this->id = $result[0]["id_usuario"];
        $this->request_data();

        return true;
    }

    public function logout() {

        $this->id = null;
        $this->pass = null;
        $_SESSION["id"] = null;
        $_SESSION["pass"] = null;
        session_destroy();
    }

    public function is_session_active() {

        if ($this->id != null) {
            return true;
        }

        return false;
    }

}

?>