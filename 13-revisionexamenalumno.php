<?php
    session_start();
    include "ConexionABase.php";

    ob_start();//Guarda los headers y no se envian al navegador todavia(Se utilizo para solucionar un error)
    $conn = conectarBD();
    $idexamen=$_GET["idexamen"];
    $idalumno=$_GET["idalumno"];
    $sql1="SELECT materia FROM tabla_examenes WHERE idexamen=$idexamen";
    $materia=consultaSQL($conn,$sql1);
    $row1 = mysqli_fetch_assoc($materia);
    $printeo1=$row1['materia'];
    
    $sql1="SELECT tema FROM tabla_examenes WHERE idexamen=$idexamen";
    $tema=consultaSQL($conn,$sql1);
    $row2 = mysqli_fetch_assoc($tema);
    $printeo2=$row2['tema'];

    $sql4="SELECT count(*) FROM tabla_preguntaexamenesalumnos WHERE id_examen=$idexamen AND id_alumno=$idalumno AND respuesta_del_alumno=129";
    //La consulta consiste en contar en la tabla las filas donde el idexamen actual, el idalumno actual y la respuesta=129 estan presentes
    //Lo utilizamos para ver donde el alumno no respondio(129 es la respuesta generica de no respondio)
    $count=consultaSQL($conn,$sql4);
    $row4 = mysqli_fetch_assoc($count);
    $printeo4=$row4['count(*)'];//Devuelve una columna llamada "count(*)" con la cantidad de veces que se cumplen las condiciones

  
    desconectarBD($conn);

    
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="13-revisionexamenalumno.css" rel="stylesheet"/>
	<title>ExamLine</title>
    
    
</head>

<body>

    <div class="header">
        <h1>ExamLine</h1>
    </div>

    <div class="row">
        <div class="col-3 col-s-3 menu">
            <h2>Opciones</h2>
            <ul>
                <?php 
                echo "<form action='' name='nombrecomoID' method='POST' class='formulario'>";
                echo "<input type='submit' name='submit' class='options' value='Volver'>"?> 
            </ul>
        </div>

        <div class="contenido col-9">
            <h1>Examen <?php echo ($printeo1);?></h1>
            <h1><?php echo ($printeo2);?></h1>

                           
                <table class="tablita">
				<?php
				$contadorInc=0;//Inicializo el contador de incorrectas
                $conn=mysqli_connect("localhost","root","","examline");
                $qry=mysqli_query($conn,"SELECT * FROM tabla_preguntas WHERE idexamen=$idexamen");

                $i = 1;//Inicializo $i
                $j=1;//Inicializo $j
                $qry1=mysqli_query($conn,"SELECT respuesta_del_alumno FROM tabla_preguntaexamenesalumnos WHERE id_examen=$idexamen AND id_alumno=$idalumno");
					while($result1=mysqli_fetch_array($qry1))//Recorro las respuestas del alumno
					{
					$respuesta_del_alumno= $result1['respuesta_del_alumno'];
					if($respuesta_del_alumno==129) {//Veo cuales son iguales a 129(no respondida) para imprimir al principio
                        echo "					<tr>";
                        echo "					<td>";
						echo "<h2><span style='text-decoration: underline;color: white;font-weight: bold;font-size:0,2em;'>No respondida la $j</span></h2>";
                        echo "					</td>"; 
						echo "					</tr>";				
                	}
                    $j++;//Sumo 1 a $j
                }
                while($result=mysqli_fetch_array($qry))//Recorro las preguntas del examen
                {   
                    echo "<tr>";
					echo "<td colspan='2'>";
                    echo "			 <h3>Pregunta $i:".$result['preg']."</h3>";//Les pongo el numero y el contenido
                    echo "		</td>";
					echo "		</tr>";
                    
                    $qry2=mysqli_query($conn,"SELECT * FROM tabla_respuestas WHERE idpreg=".$result['idpreg']."");
                    while($result2=mysqli_fetch_array($qry2))//Recorro las respuestas correspondientes a esa pregunta
                    {
                    $resp= $result2['resp'];
                    $idresp= $result2['idresp'];
					
					
					$incorrecta=null;   
                    if ($result2['respCorr']==1) {//Todas las que tengan respCorr=1 las imprimo en verde y sumo 1 a correctas
                        
                        echo "					<tr>";
                        echo "					<td>";
						$correcta=$resp;
						echo "<li><span style='color: rgb(61, 199, 61);font-weight: bold;text-decoration: underline;'>$correcta</span></li>";
                        echo "					</td>"; 
						echo "					</tr>";				
					}
					$qry3=mysqli_query($conn,"SELECT respuesta_del_alumno FROM tabla_preguntaexamenesalumnos WHERE id_examen=$idexamen AND id_alumno=$idalumno");
					while($result3=mysqli_fetch_array($qry3))//Recorro las respuestas del alumno
					{
					$respuesta_del_alumno= $result3['respuesta_del_alumno'];
					if($result2['respCorr']!=1 && $idresp==$respuesta_del_alumno) {//Si respCorr es distinto de 1(incorrecta) 
                        //y el id de la respuesta es igual al id de la respuesta del alumno, imprimo en rojo
                        echo "					<tr>";
                        echo "					<td>";
						$incorrecta=$resp;
						echo "<li><span style='text-decoration: underline;color: red;font-weight: bold;'>$incorrecta</span></li>";
                        echo "					</td>"; 
						echo "					</tr>";
						$contadorInc++;//Sumo 1 al contador de Incorrectas				
                    
                	}
					
					}
					if ($result2['respCorr']!=1 && $idresp!=$respuesta_del_alumno &&$resp!=$incorrecta) {
                        //Si no cumple con ninguna condicion, lo imprimo en negro
                        
                        echo "					<tr>";
                        echo "					<td>";
						echo "<li><span>$resp</span></li>";
                        echo "					</td>"; 
						echo "					</tr>";				
					}
                    
                    
                    
                }
				$i++;
			}
                
                $variable=$i;
                mysqli_close($conn);//Cierro la conexion
                
                ?>
                <?php
                $incorrectas=intval($contadorInc+$printeo4);//Sumo las incorrectas(en rojo) y las no respondidas
                $correctas=intval($i-1-$incorrectas);//Al total le resto las incorrectas y me da las correctas
                $notafinal=intval(number_format((($i-1-$incorrectas)/($i-1))*100, 2, ',', ' '));
                //Hago las correctas sobre el total*100 y me da el porcentaje de correctas
                ?>
               <h2>Preguntas totales: <?php echo $i-1 ?></h2>
				<h2>Preguntas correctas: <?php echo $correctas ?></h2>
				<h2>Preguntas incorrectas: <?php echo $incorrectas?></h2>
				<h2>Nota final:<?php echo $notafinal?>%</h2>
				<tr>
				
										<tr>
<?php
echo"</form>";

if (isset($_POST['submit'])) {
    $conn=mysqli_connect("localhost","root","","examline");
    $sql1 = "UPDATE tabla_examenesalumnos SET correctas=$correctas,incorrectas=$incorrectas,notafinal=$notafinal WHERE id_alumno=$idalumno AND id_examen=$idexamen";
    $resultado1 = mysqli_query($conn,$sql1);
    header("location:12-paginaalumno.php?idalumno=$idalumno");
}
//Al subir las respuestas actualizo la fila del examen realizado por el alumno y subo correctas,incorrectas y la nota final
//Y lo llevo a la pagina principal, donde va a estar subido al historial el examen realizado
?>
				
	</table>
</div>
</div>

<div class="footer">
        <p class="uca col-2">UCA - Universidad Catolica Argentina</p>
        <p class="contacto col-8">examline@hotmail.com</p>
        <div class="imagencopy col-2"><img src="copyright-logo.jpg" width="100px" ></div>
    </div>

</body>

</html>

            
    


	
	


