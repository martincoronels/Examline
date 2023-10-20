<?php
$idprofe = $_GET["idprofe"];///Tomo el id del profe
$idexamen = $_GET["idexamen"];
$data=null;//Inicializo la variable data

if (isset($_GET['q'])){//Tomo el valor de q, que es igual al valor de lo ingresado y lo guardo en data
    $data=$_GET['q'];

}

$db=new mysqli('localhost','root','','examline');//Conecto con la base de datos

$x="select * from tabla_alumnos where nombrealumno like '$data%' limit 1";//Hago la consulta SQL para buscar los nombres que empiecen con lo que yo ingrese 
$y= $db->query($x);

if (mysqli_num_rows($y)>0){
    $z=$y->fetch_assoc();//Obtengo una fila de resultados como array asociativo
    echo "<span>".$z['nombrealumno']."<span>";//Imprimo el nombre
    $idalumno=$z['idalumno'];//Guardo el id de ese alumno
    $qry="SELECT * FROM tabla_examenesalumnos where id_alumno=$idalumno AND id_examen=$idexamen";//Busco la informacion del examen de ese alumno
    $hola= $db->query($qry);
    if (mysqli_num_rows($hola)>0){
        $a=$hola->fetch_assoc();//Obtengo una fila de resultados como array asociativo
        $idexam = $a["id_examen"];
        $idalumno = $a["id_alumno"];
        $correctas = $a["correctas"];
        $incorrectas = $a["incorrectas"];
        $notafinal = $a["notafinal"];
        $tiempo = $a["horadefinalizacion"];
        echo "<a href='07-revisionexamen.php?idprofe=$idprofe&&idalumno=$idalumno&&idexamen=$idexam'>";
        echo "<button style='float: right;' class='botonRevision'>Revision</button>";
        echo "</a><span style='float: right;background-color: grey;margin-left: 100px;padding: 5px;color: white;margin-right: 30px;'>$notafinal%</span>";
        echo "<span style='float: right;background-color: rgb(212, 40, 40);margin-left: 100px;color: white;padding: 5px;'>$tiempo</span><span style='float: right;background-color: rgb(212, 40, 40);margin-left: 100px;color: white;padding: 5px;'>$incorrectas</span>";
        echo "<span style='float: right;background-color: rgb(66, 170, 66);margin-left: 10px;color: white;padding: 5px'>$correctas</span></div>";

    }
    
}
//Guardo en variables la informacion y la imprimo con formato

?>

