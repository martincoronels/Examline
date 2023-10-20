<?php
session_start();
include ("ConectarDB.php");
$idexamen = $_GET["idexamen"];
$query = "SELECT * FROM tabla_examenes WHERE idexamen = '$idexamen' LIMIT 1";
$result = mysqli_query($conex, $query);
//Hago la consulta
if($result && mysqli_num_rows($result)>0){//Si existe(la fila es mayor a 0)
    $user_data = mysqli_fetch_assoc($result);
    $nombremateria = $user_data["materia"];
    $tema = $user_data["tema"];
    //Guardo en variables la materia y el tema
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="09-examenhecho.css" rel="stylesheet"/>
    <script language="javascript" type="text/javascript" src="04-paginaprofe.js"></script>
    <title>Examline</title>
</head>

<body>

    <div class="header">
        <h1>ExamLine</h1>
    </div>

    <div class="row">
        <div class="col-3 col-s-12 menu">
            <h2>Opciones</h2>
            <ul>
                <a href="04-paginaprofe.php" style="color: white;text-decoration: none;"><li>Principal</li></a>
                
            </ul>
        </div>

        <div class="contenido col-9">
            <h1>Examen <?php echo "$nombremateria";?></h1>
            <h1> <?php echo "$tema";?></h1>

            <table class="tablita">
            <?php
            $consulta = "SELECT * FROM tabla_preguntas";
            $resultado = mysqli_query($conex, $consulta);
            $contador=1;
            if ($resultado) {
                while ($row = $resultado->fetch_array()){//Recorro el array asociativo
                    $pregunta = $row["preg"];
                    $idexam = $row["idexamen"];
                    $idpreg = $row["idpreg"];
                    //Guardo en variables los datos
                    if ($idexam===$idexamen){//Si el id de examen es igual al de la URL
                        ?>
                        <tr>
                            <td><h3>Pregunta <?php echo "$contador";$contador++;?>: <?php echo "$pregunta";?></h3></td>
                        </tr>
                        <?php
                    
                        $consulta2 = "SELECT * FROM tabla_respuestas";
                        $resultado2 = mysqli_query($conex, $consulta2);
                        while ($row2 = $resultado2->fetch_array()){//Recorro el array asociativo
                            $respuesta = $row2["resp"];
                            $idpregResp = $row2["idpreg"];
                            $correcta = $row2["respCorr"];
                            //Guardo en variables los datos
                            if ($idpregResp===$idpreg){//Si el id de la pregunta es igual al de la URL
                                if ($correcta==1){//Si es correcta(igual a 1)
                                    ?>
                                    <tr>
                                    <td><li style="color: rgb(25, 146, 25);"><?php echo "$respuesta";?></li></td>
                                    </tr>
                                    <?php
                                    //La imprimo en verde
                                } else{
                                    ?>
                                    <tr>
                                    <td><li><?php echo "$respuesta";?></li></td>
                                    </tr>
                                    <?php
                                    //Sino sin color
                                }
                            }
                            
                            
                        }
                    }       
                }
            }
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