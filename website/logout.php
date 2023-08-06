<?php
    require_once('pdo-conn.php');

    session_start();
    session_destroy();
    header("Location: ./home.php");
    exit();
?>