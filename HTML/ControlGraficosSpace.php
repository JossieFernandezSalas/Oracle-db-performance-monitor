<?php
require "ConexionBD.php";
$consulta = datosTS();
echo json_encode($consulta);
?>