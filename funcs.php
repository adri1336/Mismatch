<?php
    function checkLogin($con)
    {
        if(!isset($_SESSION["id_user"])) session_start();
        
        if(isset($_SESSION["id_user"]) && isset($_SESSION["token"]))
        { //hay sesion, comprobar si es valida
            $id_user = $_SESSION["id_user"];
            $token = $_SESSION["token"];

            $sql = "SELECT * FROM session WHERE id_user = :id_user AND token = :token;";
            $stmt = $con->prepare($sql);
            $stmt->execute(array(":id_user" => $id_user, ":token" => $token));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row["id_user"] > 0)
            {
                return true;
            }
        }
        else if(isset($_COOKIE["id_user"]) && isset($_COOKIE["token"]))
        { //no hay sesion, pero hay cookies de sesion, comprobar si son correctas
            $id_user = $_COOKIE["id_user"];
            $token = $_COOKIE["token"];

            $sql = "SELECT * FROM session WHERE id_user = :id_user AND token = :token;";
            $stmt = $con->prepare($sql);
            $stmt->execute(array(":id_user" => $id_user, ":token" => $token));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row["id_user"] > 0)
            {
                createSession($_COOKIE["id_user"], $_COOKIE["token"]);
                return true;
            }
        }
        return false;
    }

    function createCookies($id_user, $token)
    {
        setcookie("id_user", $id_user, time() + (3600 * 24 * 7), "/");
        setcookie("token", $token, time() + (3600 * 24 * 7), "/");
    }

    function deleteCookies()
    {
        setcookie("id_user", "", time() - 3600, "/");
        setcookie("token", "", time() - 3600, "/");
    }

    function createSession($id_user, $token)
    {
        $_SESSION["id_user"] = $id_user;
        $_SESSION["token"] = $token;
    }

    function recordSession($con, $id_user, $password, $remember)
    {
        $con->prepare("DELETE FROM session WHERE id_user = :id_user;")->execute(array(":id_user" => $id_user));
        
        $token = getSerial(32);
        if($remember) createCookies($id_user, $token);

        createSession($id_user, $token);
        $stmt = $con->prepare("INSERT INTO session (token, date, id_user) VALUES (:token, now(), :id_user);");
        $stmt->execute(array(":token" => $token, ":id_user" => $id_user));
    }

    function getSerial($long)
    {
        $phrase = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm";
        return substr(str_shuffle($phrase), 0, $long);
    }
?>