<?php
include ("ConectarDB.php");
$respuesta = $_REQUEST["respuesta"];
$sql = "DELETE FROM tabla_respuestas WHERE resp = '$respuesta'";
$resultado = mysqli_query($conex, $sql);

//Elimino la respuesta buscando su contenido
?>