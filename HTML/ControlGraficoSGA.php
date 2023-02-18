<?php
require "ConexionBD.php";
$consulta = memoriaSGA();
echo json_encode($consulta);
