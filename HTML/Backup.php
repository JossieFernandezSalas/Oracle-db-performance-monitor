<?php
$element = $_POST['elem'];
//$type = $_POST['tip'];
$bd = $_POST['base'];
session_start();
$_SESSION["elem"] = $element;
//$_SESSION["tipo"] = $type;
$_SESSION["base"] = $bd;
?>