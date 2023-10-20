<?php
include ("ConectarDB.php");
$idexamen = $_REQUEST["idexamen"];
$pregunta = $_REQUEST["preg"];
//Guardo la informacion en variables
$sql = "INSERT INTO tabla_preguntas (idexamen, preg) VALUES ('$idexamen','$pregunta');";
$result = mysqli_query($conex, $sql);
//Inserto la pregunta en la tabla
?>