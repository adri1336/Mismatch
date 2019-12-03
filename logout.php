<?php
    require_once("funcs.php");
    session_start();
    unset($_SESSION);
    session_destroy();
    deleteCookies();
    header("Location: index.php");
?>