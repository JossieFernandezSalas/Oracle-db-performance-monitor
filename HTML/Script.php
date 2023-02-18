<?php 
$element = $_POST['element'];
include "ConexionBD.php";
echo backup($element); 
?>