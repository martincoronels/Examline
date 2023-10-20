<?php
include ("ConectarDB.php");
$idexamen = $_REQUEST["idexamen"];
$pregunta = $_REQUEST["preg"];
$opcion = $_REQUEST["opcion"];
$correcta = $_REQUEST["correcta"];

//Guardo la informacion en variables



$query = "SELECT * FROM tabla_preguntas WHERE preg = '$pregunta' and idexamen='$idexamen' LIMIT 1";
$resultado = mysqli_query($conex, $query);
//Hago la consulta
if($resultado && mysqli_num_rows($resultado)>0){
    $user_data = mysqli_fetch_assoc($resultado);
    $idpregunta = $user_data["idpreg"];
    //Guardo el id de la pregunta
}

if ($idpregunta){
    $sql = "INSERT INTO tabla_respuestas (idpreg, respCorr, resp) VALUES ('$idpregunta', '$correcta', '$opcion');";
    $result = mysqli_query($conex, $sql);
    //Inserto en la tabla de respuestas la informacion   
}


?>