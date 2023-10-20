<?php
session_start();
include "ConexionABase.php";
$conn = conectarBD();

$nombre = $_SESSION["nombreprofe"];
$id = $_SESSION["idprofe"];
//Guardo en la variable el nombre del profe y del alumno de la sesion
if (isset($_POST['realizacion'])) {//Cuando se envia el realizacion
    $materia=null;
    $tema=null;
    $preg=null;
    $time=null;
    $opcion=null;
    $sql1 = "INSERT INTO tabla_examenes (id_profe, materia,tema,duracion,publicado_si_o_no) VALUES ('$id','$materia','$tema','$time',0);";
    //Inserto la fila en los examenes(por ahora) toda vacia, para despues ir llenandose de a poco
    if ($conn->query($sql1) === TRUE) {
        $last_id = $conn->insert_id;//Devuelve el id de la ultima consulta realizada
    }
    header("location:05-paginaelaboracion.php?idprofe=$id&&idexamen=$last_id");
    //Redireccion a la pagina de elaboracion de ese profe y ese examen especifico
    desconectarBD($conn);
}  



?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="04-paginaprofe.css" rel="stylesheet"/>
    <script language="javascript" type="text/javascript" src="04-paginaprofe.js"></script>
    <title>Examline</title>
</head>

<body>

    <div class="header">
        <h1>ExamLine</h1><h2 class="nombre">¡Bienvenido, <?php echo"$nombre";?>!</h2>

    </div>

    <div class="row">
        <div class="col-3 col-s-3 menu">
            <h2>Opciones</h2>
            <form action="" method="POST">
            <ul>
                <input type="submit" name="realizacion" value="Realizar nuevo examen" class="options">
                <a href="02-loginprofes.php" style="color: #e9ecef;text-decoration: none;" name="cerrarsesion"><li>Cerrar Sesion</li></a>
                
            </ul>
            </form>
        </div>

        <div class="col-9 col-s-9 vistaExamen">
            <h1>Examenes</h1>
            <div class="contenedorExamenes">
                <div class="divPublicados col-7" id="public">
                    <h2 class="publicados">Publicados</h2>
                    
                </div>
                <div class="divNoPublicados col-5" id="nopublic">
                    <h2 class="nopublicados">No Publicados</h2>
                    
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

<?php

$nombre = $_SESSION["nombreprofe"];
$id = $_SESSION["idprofe"];
$resultado = mysqli_query($conn, "SELECT * FROM `tabla_examenes` ORDER BY `fechadecreacion` DESC");
//Hago la consulta de todos los examenes
while ($consulta = mysqli_fetch_array($resultado)){
    if ($consulta["id_profe"] == $id){//Si el id es igual al del profe
        if ($consulta["publicado_si_o_no"] == 1){//Si el booleano de publicado es igual a 1(publicado)
            $idexamen = $consulta["idexamen"];
            $materia = $consulta["materia"];
            $tema = $consulta["tema"];
            $fechadecreacion = $consulta["fechadecreacion"];
            $validohasta = $consulta["duracion"];
            //Guardo todos los datos en variables
            echo "<script>
            var contenedor = document.getElementById('public');
            var newdiv = document.createElement('div');
            var titulo = document.createElement('h3');
            titulo.classList.add('titulomateria');
            titulo.innerHTML = 'Examen $materia:<br>$tema';
            var codigo = document.createElement('h4');
            codigo.innerHTML = 'Codigo: $idexamen';
            var fechacreacion = document.createElement('h4');
            fechacreacion.innerHTML = 'Publicado: $fechadecreacion';
            var validohasta = document.createElement('h4');
            validohasta.innerHTML = 'Duracion: $validohasta';
            var verresultados = document.createElement('input');
            var visualizar = document.createElement('input');
            var link = document.createElement('a');
            link.setAttribute('href','09-examenhecho.php?idprofe=$id&&idexamen=$idexamen');
            var link2 = document.createElement('a');
            link2.setAttribute('href','06-tablaexamenes.php?idprofe=$id&&idexamen=$idexamen');
            verresultados.classList.add('btnVerde');
            visualizar.classList.add('btnVerde');
            verresultados.setAttribute('value','Ver resultados');
            visualizar.setAttribute('value','Visualizar');
            visualizar.setAttribute('type','submit');
            verresultados.setAttribute('type','submit');
            visualizar.setAttribute('name','visualizar');
            verresultados.setAttribute('name','verresultados');
            var formulario = document.createElement('form');
            link.appendChild(visualizar);
            link2.appendChild(verresultados);
            formulario.setAttribute('method','post');
            
            


            newdiv.appendChild(titulo);
            newdiv.appendChild(codigo);
            newdiv.appendChild(fechacreacion);
            newdiv.appendChild(validohasta);
            newdiv.appendChild(formulario);
            newdiv.appendChild(link);
            newdiv.appendChild(link2);

            
            contenedor.appendChild(newdiv);
            </script>";
            //Creo el div del examen debajo del titulo de "Publicados"
        } else{
            $idexamen = $consulta["idexamen"];
            $materia = $consulta["materia"];
            $tema = $consulta["tema"];
            $fechadecreacion = $consulta["fechadecreacion"];
            $validohasta = $consulta["duracion"];
            echo "<script>
            var contenedor = document.getElementById('nopublic');
            var newdiv = document.createElement('div');
            var titulo = document.createElement('h3');
            titulo.classList.add('titulomateria');
            titulo.innerHTML = 'Examen $materia:<br>$tema';
            var validohasta = document.createElement('h4');
            validohasta.innerHTML = 'Duracion: $validohasta';
            
            var publicar = document.createElement('button');
            var editar = document.createElement('a');
            var eliminar = document.createElement('button');
            var botonEditar = document.createElement('button');
            
            editar.setAttribute('href','05-paginaelaboracion.php?idprofe=$id&&idexamen=$idexamen');
            editar.setAttribute('id','visualizar');
            botonEditar.classList.add('btnVerde');
            botonEditar.setAttribute('id','editar');
            botonEditar.innerHTML = 'Editar';
            editar.appendChild(botonEditar);

            publicar.classList.add('btnVerde');

            eliminar.classList.add('btnEliminar');
            
            publicar.innerHTML = 'Publicar';
            eliminar.innerHTML = 'Eliminar';
            
            eliminar.setAttribute('onclick', 'eliminarExamen(this)');
            eliminar.setAttribute('id', '$idexamen');
            publicar.setAttribute('onclick', 'publicarExamen(this)');
            publicar.setAttribute('id', '$idexamen');

            newdiv.appendChild(titulo);
            newdiv.appendChild(validohasta);
            newdiv.appendChild(publicar);
            newdiv.appendChild(editar);
            newdiv.appendChild(eliminar);

            contenedor.appendChild(newdiv);
            </script>";
            //Creo el div del examen debajo del titulo de "No Publicados"

            
        }
    }
}
 




?>

</html>