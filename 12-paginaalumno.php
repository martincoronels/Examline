<?php
    session_start();//Crea una sesion o reanuda la actual. Es lo primero del codigo
    include "ConexionABase.php";//Incluye y evalúa el archivo especificado.  Toma todo el texto
    ///código/marcado que existe en el archivo especificado y 
    //lo copia en el archivo que usa la declaración de inclusión.

    $conn = conectarBD();//Llamamos a la funcion que conecta a la base de datos
    $idalumno=$_GET['idalumno'];//Obtengo la variable idalumno que pase por la URL

    $sql3="SELECT nombrealumno FROM tabla_alumnos WHERE idalumno=$idalumno";//Escribo la consulta SQL
    $tema=consultaSQL($conn,$sql3);//Llamamos a la funcion consultaSQL que viene del archivo incluido
    //Y pasamos como parametros la conexion a la base y la consulta SQL
    $row3 = mysqli_fetch_assoc($tema);//A lo obtenido en la funcion lo pasamos por mysqli_fetch_assoc
    //Y obtenemos como resultado una fila como una matriz(array) asociativa
    $nombre=$row3['nombrealumno'];//Para acceder a los valores de este array, ponemos el nombre del array
    //Y el key entre corchetes
			
    desconectarBD($conn);//Llamamos a la funcion para desconectar la base de datos

    
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="12-paginaalumno.css" rel="stylesheet"/>
</head>

<body>

    <div class="header">
        <h1>ExamLine</h1><h2 class="nombre">¡Bienvenido, <?php echo"$nombre";?>!</h2>
    </div>

    <div class="row">
        <div class="col-3 col-s-3 menu">
            <h2>Opciones</h2>
            <ul>
                <a href="10-loginalumnos.php" style="color: #e9ecef;text-decoration: none;"><li>Cerrar Sesion</li></a>
            </ul>
        </div>

        <div class="col-6 col-s-9 vistaExamen">
            <h1 class="tituexamenes">EXAMENES</h1>
            <?php

            $conn=mysqli_connect("localhost","root","","examline");//Abre una nueva conexion a la base de datos
            $id = $_GET["idalumno"];//Obtengo la variable idalumno que pase por la URL
                    $resultado2 = mysqli_query($conn, "SELECT id_examen FROM tabla_examenesalumnos where id_alumno=$id");
                    //Hace una consulta a la base de datos
                    while ($consulta2 = mysqli_fetch_array($resultado2)){
                    //Obtiene una fila de resultados como una matriz asociativa, una matriz numérica o ambas.
                    //Con el while la recorre
                    $idexamen= $consulta2["id_examen"];//Accedo al valor del array con el respectivo key
                    $resultado3 = mysqli_query($conn, "SELECT * FROM tabla_examenes where idexamen=$idexamen");
                    while ($consulta3 = mysqli_fetch_array($resultado3)){
                    $materia= $consulta3["materia"];
                    $tema= $consulta3["tema"];
                    echo "<a href='15-examenenelhistorial.php?idalumno=$idalumno&&idexamen=$idexamen' style='color: black;'><div style='border: solid red;color: black;margin: 10px;border-radius: 10px;'><h2>Examen de $materia: $tema</h2></div></a>";
                    //Imprimo en la pagina este elementos HTML, que en su href tiene una URL con variables
                    }
                }
                        
            ?>
            
        </div>

        <div class="col-3 col-s-12">
            <div class="aside">
                <h2>¿Como ingreso a mi examen?</h2>
                <p>Pidele a tu profesor/a que te brinde el codigo de examen generado</p>
                <div class="codigo">
                    <h2>Introduce el codigo: </h2>
                    <?php echo" <form action='12.1-codigopaginaalumno.php?idalumno=$idalumno' method='POST' id='form'> " ?>
                    <input autocomplete="off" type="text" name='idexamen' placeholder="Codigo del examen"><br>
                    <input type="submit" class="btnEntrar" name="submit" value="Entrar" onclick="funcion();">
                </div>
                
            </div>
        </div>
    </div>

    <div class="footer">
        <p class="uca col-2">UCA - Universidad Catolica Argentina</p>
        <p class="contacto col-8">examline@hotmail.com</p>
        <div class="imagencopy col-2"><img src="copyright-logo.jpg" width="100px" ></div>
    </div>

</body>

</html>