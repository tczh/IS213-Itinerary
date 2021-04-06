<?php
    spl_autoload_register(
        function($class){
            require_once "model/$class.php";
        }
    );
    session_start();
    session_destroy();
    header("Location: ../index.php");
?>