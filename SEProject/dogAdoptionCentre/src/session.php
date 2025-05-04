<?php

namespace src;

class session
{
    public function killSession() {
        $_SESSION = []; //Overwrites current session with an empty array (clears it)

        if(ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), //session cookie name
                '', //empty value
                time() - 42000, //deletes the cookie
                $params["path"], //path
                $params["domain"], //domain
                $params["secure"], //secure flag
                $params["httponly"] //HttpOnly flag
            );
        }
        session_destroy(); //Destroys the session
    }
    public function forgetSession() {
        $this->killSession();
        header('Location: ../public/login.php'); // match your structure
        exit;
    }
}