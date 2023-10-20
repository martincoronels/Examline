<?php
    session_start();
    include "ConexionABase.php";
    ob_start();

    $conn = conectarBD();
    $idexamen=$_GET["idexamen"];
    $idalumno=$_GET["idalumno"];
    $sql1="SELECT materia FROM tabla_examenes WHERE idexamen=$idexamen";
    $materia=consultaSQL($conn,$sql1);
    $row1 = mysqli_fetch_assoc($materia);
    $printeo1=$row1['materia'];

    $sql2="SELECT tema FROM tabla_examenes WHERE idexamen=$idexamen";
    $tema=consultaSQL($conn,$sql2);
    $row2 = mysqli_fetch_assoc($tema);
    $printeo2=$row2['tema'];

    $sql4="SELECT count(*) FROM tabla_preguntas WHERE idexamen=$idexamen";
    $preg=consultaSQL($conn,$sql4);
    $row4 = mysqli_fetch_assoc($preg);
    $printeo4=$row4['count(*)'];

    $sql5="SELECT horadefinalizacion FROM tabla_examenesalumnos WHERE id_examen=$idexamen AND id_alumno=$idalumno";
    $hora=consultaSQL($conn,$sql5);
    $row2 = mysqli_fetch_assoc($hora);
    $horadefinalizacion=strtotime($row2['horadefinalizacion']);
    
    $date = new DateTime("now", new DateTimeZone('America/Argentina/Buenos_Aires') );
    $firstTime=strtotime($date->format('H:i:s'));
    $timeDiff=$horadefinalizacion-$firstTime;
    $diferencia=gmdate("H:i:s", $timeDiff);
    //La resta seria la hora de finalizacion subida a la base de datos cuando empieza el examen menos
    //La hora actual que se actualiza a cada segundo
    //Esto para evitar reinicios en el cronometro cuando se recarga la pagina

    


    $i=1;
    if (isset($_POST['submit'])) {//Cuando lo envia, recorre todas las respuestas, por un lado si fueron 
        //enviadas y por el otro si NO fueron enviadas
        while ($i<=$printeo4){
        
        if(empty($_POST['ans'.$i])){
            $sql5="SELECT idpreg FROM tabla_respuestas WHERE idresp=129";
            $idpreg=consultaSQL($conn,$sql5);
            $row5 = mysqli_fetch_assoc($idpreg);
            $printeo5=$row5['idpreg'];
            $sql1 = "INSERT INTO tabla_preguntaexamenesalumnos (id_examen, id_alumno,id_pregunta,respuesta_del_alumno) VALUES ($idexamen,$idalumno,$printeo5,129);";
            $resultado1 = consultaSQL($conn,$sql1);
        }
        else{
            $seleccionada=$_POST['ans'.$i];
            $sql6="SELECT idpreg FROM tabla_respuestas WHERE idresp=$seleccionada";
            $idpreg=consultaSQL($conn,$sql6);
            $row6 = mysqli_fetch_assoc($idpreg);
            $printeo6=$row6['idpreg'];
            $sql2 = "INSERT INTO tabla_preguntaexamenesalumnos (id_examen, id_alumno,id_pregunta,respuesta_del_alumno) VALUES ($idexamen,$idalumno,$printeo6,$seleccionada);";
            $resultado2 = consultaSQL($conn,$sql2);
        }
        $i++;
        }
        header("location: 13-revisionexamenalumno.php?idalumno=$idalumno&&idexamen=$idexamen"); 
    }
         
        
        
        

    desconectarBD($conn);

    
?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="14-paginarealizacionexamen.css" rel="stylesheet"/>
    <title>Examline</title>
</head>

<body>

    <div class="header">
        <h1>ExamLine</h1>
    </div>

    <div class="row">
        <div class="col-3 col-s-12 menu">
            <h2 style="text-decoration:underline;">Seleccionar UNA OPCION por pregunta</h2>
            
        </div>


        <div class="contenido col-9">
            <h1>Examen <?php echo ($printeo1);?></h1>
            <h1><?php echo ($printeo2);?></h1>
            <form action="" method="post" class="formu">
                <table class="tablita">
                    <tbody>
                    
                    <?php
                    
                    $conn=mysqli_connect("localhost","root","","examline");
                    $qry=mysqli_query($conn,"SELECT * FROM tabla_preguntas WHERE idexamen=$idexamen");

                    $i = 1;
                    while($result=mysqli_fetch_array($qry))//Recorro las preguntas del examen
                    {   
                        echo "<tr>";
                        echo "			 <td><h3>Pregunta $i: "  .$result['preg']."</h3></td>";//Les pongo el numero y el contenido
                        echo "		</tr>";
                        $qry2=mysqli_query($conn,"SELECT * FROM tabla_respuestas WHERE idpreg=".$result['idpreg']."");
                        while($result2=mysqli_fetch_array($qry2))//Recorro las respuestas correspondientes a esa pregunta
                        {  
                        $idresp=$result2['idresp'];
                            echo "					<tr>";
                            echo "			 <td><input type='radio' name='ans$i' class='res' value='$idresp' >".$result2['resp']."</td>";
                            echo "					</tr>";				
                    }
                            
                
                        
                        $i++;
                    }
                    
                    $variable=$i;
                    mysqli_close($conn);
                    ?>
                    
                    <tr>
                        <td><input id="botonterminar" type="submit" name="submit" class="sigPregunta" value="Terminar examen"></td>
                    </tr>




                    </tbody>

                </table>

            </form>
            

            <nav class="tiempo cont-temporizador">
            <h2>TIEMPO</h2>
            <div class="bloques">
                <div class="horas" id="horas">--</div>
                <p>Horas</p>
            </div>
            <div class="bloque">
                <div class="minutos" id="minutos">--</div>
                <p>Minutos</p>
            </div>
            <div class="bloque">
                <div class="segundos" id="segundos">--</div>
                <p>Segundos</p>
            </div>
        </nav>


        </div>







    </div>


    <div class="footer">
        <p class="uca col-2">UCA - Universidad Catolica Argentina</p>
        <p class="contacto col-8">examline@hotmail.com</p>
        <div class="imagencopy col-2"><img src="copyright-logo.jpg" width="100px" ></div>
    </div>

</body>
<script>

    var duraciondelexamen = "<?php echo "$diferencia";?>";//Guardo en una variable en JavaScript 
    //la diferencia previamente explicada
    
    
    let horas = parseInt(duraciondelexamen.slice(0, 2))
    let minutos = parseInt(duraciondelexamen.slice(3, 5))
    let segundos = parseInt(duraciondelexamen.slice(6, 8))

    //Usamos metodos de strings para separar horas, minutos y segundos
    
    //Definimos y ejecutamos los segundos
    function cargarSegundo(){
        let txtSegundos

        if(segundos < 0){//Si llega a ser menor a 0, pasa a ser 59
            segundos = 59
        }

        //Mostrar Segundos es pantalla
        if (segundos < 10){
            txtSegundos = `0${segundos}`//Si es menor a 10, pasa a ser 0 y los segundos que falten
        }
        else{
            txtSegundos = segundos
        }
        document.getElementById('segundos').innerHTML = txtSegundos
        segundos --

        cargarMinutos(segundos)
    }

    //Definimos y ejecutamos los minutos
    function cargarMinutos(segundos){
        let txtMinutos

        if (segundos == -1 && minutos !== 0){
            setTimeout(() => {
                minutos--
            }, 500)
        }
        else if (segundos == -1 && minutos == 0){
            setTimeout(() => {
                minutos=59
            },500)
        }

        //Mostrar minutos en pantalla
        if (minutos < 10){
            txtMinutos = `0${minutos}`
        }
        else{
            txtMinutos = minutos
        }
        document.getElementById('minutos').innerHTML = txtMinutos
        cargarHoras(segundos, minutos)
    }

    //Defnimos y ejecutamos las horas
    function cargarHoras(segundos, minutos){
        let txtHoras

        if(segundos == -1 && minutos == 0 && horas !==0){
            setTimeout(() => {
                horas--
            },500)
        }
        else if(segundos == -1 && minutos == 0 && horas ==0){
            setTimeout(() => {
                document.getElementById('botonterminar').click();
            },500)
        }

        //Mostrar horas en pantalla
        if(horas < 10){
            txtHoras = `0${horas}`
        }
        else{
            txtHoras = horas
        }
        document.getElementById('horas').innerHTML = txtHoras
    }


    //Ejecutamos cada segundo
    setInterval(cargarSegundo, 1000)

    cargarSegundo()
</script>

</html>
