<?php
    session_start(); //Inicio de la sesión
    session_destroy(); //Destrucción de la sesión
    header('Location: index.php'); //Redirección al index
?>