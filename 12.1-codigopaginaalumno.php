<?php
	$user_1 = $_POST['idexamen'];//Tomamos el valor enviado del codigo del examen
	
	$con=mysqli_connect("localhost","root","","examline");//Abre una nueva conexion a la base de datos
	
	$result = mysqli_query($con,"select * from tabla_examenes where idexamen = '$user_1'");//Hace una consulta a la base de datos

	$row = mysqli_fetch_array($result);//Obtiene una fila de resultados como una matriz asociativa, una matriz numérica o ambas.
	

	$sql4="SELECT duracion FROM tabla_examenes WHERE idexamen='$user_1'";
    $duracion=mysqli_query($con,$sql4);
    $row4 = mysqli_fetch_assoc($duracion);
    $printeo4=$row4['duracion'];

	$date = new DateTime("now", new DateTimeZone('America/Argentina/Buenos_Aires') );
	//Obtenemos la hora actual en nuestro pais
    $firstTime=strtotime($date->format('H:i:s'));
	//Le cambiamos el formato a horas:minutos:segundos y con strtotime lo pasamos a fecha Unix para hacer los calculos
    $horadefinalizacion = date('H:i:s', $firstTime+strtotime("$printeo4 UTC"));
	//Sumo la hora actual y el tiempo de duracion de la base de datos en formato de fecha Unix y lo pasamos a formato de hora nuevamente
	
	$dia=date(($date->format("Y-m-d")));


	$idalumno=$_GET['idalumno'];
	

	$sql1="SELECT * FROM tabla_examenesalumnos WHERE id_examen='$user_1' AND id_alumno=$idalumno";
	$result1=mysqli_query($con,$sql1);
  	$rowcount=mysqli_num_rows($result1);

	if ($user_1==null or ($row['idexamen'] != $user_1) or $rowcount>=1){
		header("location:12-paginaalumno.php?idalumno=$idalumno"); 
	}
	elseif (null!=($row['idexamen'] == $user_1))//Si existe una coincidencia entre el valor ingresado y el valor de la base de datos
	
	{
		$sql3="INSERT INTO tabla_examenesalumnos (id_examen,id_alumno,horadefinalizacion,diaderealizacion) VALUES ($user_1,$idalumno,'$horadefinalizacion','$dia')";
    	$horadefinalizacion=mysqli_query($con,$sql3);
		header("location:14-paginarealizacionexamen.php?idalumno=$idalumno&&idexamen=$user_1"); 
		//Redireccion a traves de la funcion header
	}
		
?>