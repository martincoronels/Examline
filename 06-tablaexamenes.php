<?php
session_start();
include ("ConectarDB.php");
$idexamen = $_GET["idexamen"];
$idprofe = $_GET["idprofe"];
//Tomo las variables idexamen e idprofe de la URL


?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="06-tablaexamenes.css" rel="stylesheet"/>
    <script language="javascript" type="text/javascript" src="04-paginaprofe.js"></script>
    <title>Examline</title>
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
            echo "<a href='04-paginaprofe.php?idprofe=$idprofe' style='color: white;text-decoration: none;'><li>"."Principal"."</li></a>";
            ?>
                   
            </ul>
        </div>



        <div class="col-9 col-s-9 vistaExamen">
            <h1>Resultados</h1>
            <input class="inputresp" type="text" onkeyup="hola(this.value)" placeholder="Buscar alumno">
            <!-- El evento onkeyup ocurre cuando el usuario suelta una tecla (en el teclado). -->
            <div class="contenedorResultados">
                <div style="color: #ffffff;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);"><span>NOMBRE Y APELLIDO</span><span style="float:right;margin-right: 15px;">CORRECTAS / INCORRECTAS / FINALIZACION(H:M:S) / NOTA-REVISION</span></div>
                
            <div id="content">
                Buscar....
            </div>
                <?php
                $consulta = "SELECT * FROM tabla_examenesalumnos";
                $resultado = mysqli_query($conex, $consulta);
                //Hago la consulta en la base de Datos
                if ($resultado) {
                    while ($row = $resultado->fetch_array()){
                        //Obtiene una fila de resultados como un array asociativo, numérico, o ambos
                        //Recorro el array
                        $idexam = $row["id_examen"];
                        $idalumno = $row["id_alumno"];
                        $correctas = $row["correctas"];
                        $incorrectas = $row["incorrectas"];
                        $notafinal = $row["notafinal"];
                        $tiempo = $row["horadefinalizacion"];
                        //Guardo los datos en variables
                        if ($idexam===$idexamen){//Si el id del examen es igual al de la URL
                            $consulta2 = "SELECT * FROM tabla_alumnos";
                            $resultado2 = mysqli_query($conex, $consulta2);
                            //Hago la consulta en la base de Datos
                            while ($row2 = $resultado2->fetch_array()) {
                                $idtablaalumno = $row2["idalumno"];//Guardo el id del alumno en la tabla
                                if ($idtablaalumno===$idalumno){//Si ambos son iguales
                                    $nombrealumno = $row2["nombrealumno"];//Guardo el nombre del alumno en la variable
                            ?>
                            <div class="rldo"><span><?php echo "$nombrealumno";?></span>
                            <?php echo "<a href='07-revisionexamen.php?idprofe=$idprofe&&idalumno=$idtablaalumno&&idexamen=$idexamen'>" ?>
                            <button style="float: right;" class="botonRevision">Revision</button></a><span style="float: right;background-color: grey;margin-left: 100px;padding: 5px;color: white;margin-right: 30px;"><?php echo "$notafinal";?>%</span><span style="float: right;background-color: rgb(212, 40, 40);margin-left: 100px;color: white;padding: 5px;"><?php echo "$tiempo";?></span><span style="float: right;background-color: rgb(212, 40, 40);margin-left: 100px;color: white;padding: 5px;"><?php echo "$incorrectas";?></span><span style="float: right;background-color: rgb(66, 170, 66);margin-left: 10px;color: white;padding: 5px"><?php echo "$correctas";?></span></div>
                            <?php
                            //Imprimo el nombre del alumno, sus datos y el boton revision con el hipervinculo
                                }
                            }   
                        }
                    }   
                }

                        

                ?>
            
            </div>
            
        </div>

        
    </div>
    <script type="text/javascript">
let content=document.getElementById('content');//Tomo el elemento mediante su id y lo guardo en una variable

function hola(x){
    if(x.length==0){
        content.innerHTML='Vacio..'//Si el length de lo que escribo es 0(esta vacio), imprimo vacio
    }
    else{
      var XML= new XMLHttpRequest();//Creo una instancia/un objeto XMLHttpRequest
      XML.onreadystatechange=function(){//onreadystatechange Almacena el nombre de la función que se ejecutará cuando el objeto XMLHttpRequest cambie de estado.
          if(XML.readyState == 4 && XML.status == 200){//Si el valor es 4(la operacion esta completada) y el estado es igual a 200(respuesta satisfactoria)
             content.innerHTML=XML.responseText;//Devuelve un DOMString que contiene la  respuesta a la consulta como un texto o null si la consulta  no tuvo exito o  aun no ha sido completada.
          }
      };
      XML.open('GET','buscar.php?idprofe=<?php echo $idprofe?>&&idexamen=<?php echo $idexamen?>&&q='+x,true)//Realiza una petición de apertura de comunicación con un método GET
      XML.send();//Envía la petición al servidor
    }
}

</script>
    <div class="footer">
        <p class="uca col-2">UCA - Universidad Catolica Argentina</p>
        <p class="contacto col-8">examline@hotmail.com</p>
        <div class="imagencopy col-2"><img src="copyright-logo.jpg" width="100px" ></div>
    </div>

</body>

</html>