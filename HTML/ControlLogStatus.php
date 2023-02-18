<?php
require "ConexionBD.php";
$consulta = logStatus();
echo json_encode($consulta);
