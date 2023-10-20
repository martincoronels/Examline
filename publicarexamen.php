<?php
include ("ConectarDB.php");
$examenapublicar = $_REQUEST["idexamen"];
$sql = "UPDATE tabla_examenes SET publicado_si_o_no=1 WHERE idexamen='$examenapublicar'";
$resultado = mysqli_query($conex, $sql);
$sql2 = "UPDATE tabla_examenes SET fechadecreacion=(NOW()) WHERE idexamen='$examenapublicar'";
$resultado = mysqli_query($conex, $sql2);

//Actualizo el booleano del publicado y la fecha de creacion en la tabla de examenes
?>