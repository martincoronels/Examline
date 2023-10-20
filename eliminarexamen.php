<?php
include ("ConectarDB.php");
$examenaborrar = $_REQUEST["idexamen"];
$sql = "DELETE FROM tabla_examenes WHERE idexamen = '$examenaborrar'";
$resultado = mysqli_query($conex, $sql);

//Borro el examen buscandolo por su id en la base de datos
?>