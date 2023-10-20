<?php
include ("ConectarDB.php");
$idexamen = $_REQUEST["idexamen"];
$pregunta = $_REQUEST["preg"];
$sql = "DELETE FROM tabla_preguntas WHERE idexamen = '$idexamen' and preg = '$pregunta'";
$resultado = mysqli_query($conex, $sql);

//Elimino la pregnunta donde el id del examen y el contenido de la pregunta son iguales a los tomados
?>