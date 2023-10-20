<?php
session_start();
include ("ConectarDB.php");

$idexamen=$_GET["idexamen"];
$idex=$_GET["idexamen"];
$idprof=$_GET["idprofe"];
$idprofe=$_GET["idprofe"];
//Tomo esas variables de la URL
$query = "SELECT * FROM tabla_examenes WHERE idexamen = '$idexamen' LIMIT 1";
$result = mysqli_query($conex, $query);//Hago la consulta

if($result && mysqli_num_rows($result)>0){//Si hay filas, guardo la materia, el tema y la duracion
    $user_data = mysqli_fetch_assoc($result);
    $materia = $user_data["materia"];
    $tema = $user_data["tema"];
    $duracion = $user_data["duracion"];
}

if (isset($_POST['guardarCambios'])) {//Si guardo los cambios, guardo esa nueva informacion en variables
    $materia= $_POST['materia'];
    $tema = $_POST['tema'];
    $duracion=$_POST['duracion'];

    $query = "UPDATE tabla_examenes SET publicado_si_o_no=0, materia='$materia', tema='$tema', duracion='$duracion' WHERE idexamen='$idexamen'";
    $result = mysqli_query($conex, $query);
    //Y la actualizo en la base de datos
    
}

if (isset($_POST["agregarPreg"])){
    $pregunta = $_POST['preg'];
    $sql = "INSERT INTO tabla_preguntas (idexamen, preg) VALUES ('$idexamen','$pregunta');";
    $result = mysqli_query($conex, $sql);
    //Si agrego una pregunta, la guardo en una variable y en la base de datos
}
    
   
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="05-paginaelaboracion.css" rel="stylesheet"/>
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

        <div class="vistaExamen col-9 col-s-9">
            <form class="formulario" method="POST" id="form">  <!--El name es unico como el id pero se utiliza solo en forms
                el action lo que hace es enviar la informacion a una base de datos. El method GET no usar.-->
                <h1 class="tituloformulario" style="background-color: #da6e6e;"id="display3">Materia: <?php if ($materia){echo "$materia";} ?></h1>
                <h1 class="tituloformulario" style="background-color: #da6e6e;"id="display">Tema: <?php if ($tema){echo "$tema";} ?></h1>
                <div class="separador">
                    <label class="centtitulos">Nombre de la materia: </label>
                    <div class="centinputs"><input autocomplete="off" class="inputresp" type="text" style="width: 500px;" name="materia" id="pregunta3" placeholder="Ingrese la materia" value="<?php if ($materia){echo "$materia";} ?>"></div>
                    <div class="centinputs"><button type="button" class="btnVerde" onclick="getDisplayMateria('pregunta3', 'display3')" >Modificar</button></div>
                </div>

                <div class="separador">
                    <label class="centtitulos">Titulo del examen: </label>
                    <div class="centinputs"><input autocomplete="off" class="inputresp" type="text" style="width: 500px;" name="tema" id="pregunta1" placeholder="Ingrese el tema" value="<?php if ($tema){echo "$tema";} ?>"></div>
                    <div class="centinputs"><button type="button" onclick="getDisplayTema('pregunta1', 'display')" class="btnVerde">Modificar</button></div>
                </div>
                
                <div class="separador" id = "Temporizador">
                    <label class="centtitulos">Tiempo estipulado para el examen: </label>
                    <div class="centinputs"><input class="inputresp" style="width: 500px;" type="time" name="duracion" id="ingresoTiempo" placeholder="Seleccione el tiempo" value="<?php if ($duracion){echo "$duracion";} ?>"></div>
                    <div class="centinputs"><button type="button" onclick="getDisplayTiempo('ingresoTiempo', 'tiempoCargado')" class="btnVerde">Agregar</button></div>
                    <label id="tiempoCargado">Tiempo: <?php if ($duracion){echo "$duracion";} ?></label>
                </div>

                <div class="separador" id = "Cerradas">
                    <label class="centtitulos" for="cantidadOpciones">Pregunta de opcion multiple: </label>
                    <div class="centinputs"><input autocomplete="off" class="inputresp" type="text" style="width: 500px;" name="preg" placeholder="Ingrese la pregunta" id="inputPreguntasC"></div>
                    <div class="centinputs"><input type="button" value="Agregar Pregunta" class="btnVerde" id="<?php echo ($idexamen); ?>" onclick="agregarPreg(this)"></div>
                    
                </div>

                <div id="preguntas" class="preguntass">
                <?php
                $consulta = "SELECT * FROM tabla_preguntas";
                $resultado = mysqli_query($conex, $consulta);
                if ($resultado) {
                    while ($row = $resultado->fetch_array()){// Obtiene una fila de resultados como un 
                        //array asociativo, numérico, o ambos
                        $pregunta = $row["preg"];
                        $idexam = $row["idexamen"];
                        $idpreg = $row["idpreg"];
                        //Guardo en variables
                        $cadena =str_replace(' ', '', $pregunta);//Saco los espacios en la pregunta mediante
                        //str_replace para despues comparar
                        if ($idexam===$idexamen){//Si los id de examen son iguales
                            ?>
                            <div class="preguntasjava" id="<?php echo "$cadena"."/";?>">
                                <h4 style="text-decoration: underline;">Pregunta cargada: </h4>
                                <h4 id="<?php echo "$cadena"."+";?>"><?php echo "$pregunta";?></h4>
                                <button class="modpreg" type="button" id="<?php echo "$cadena"."//";?>" onclick="modificarPregunta('<?php echo($pregunta); ?>','<?php echo($cadena); ?>','<?php echo($idexamen); ?>')">Modificar pregunta</button>
                                <button class="eliminarpreg" type="button" id="<?php echo "$cadena"."#";?>" onclick="eliminarPregunta('<?php echo($pregunta); ?>','<?php echo($cadena); ?>','<?php echo($idexamen); ?>')">Eliminar pregunta</button>
                                <br>
                                <input class="inputresp" type="text" id="<?php echo($cadena); ?>">
                                <div id="<?php echo "$cadena"."$$$";?>">
                                <!-- Printea la pregunta cargada con los botones de modificar, eliminar pregunta y agregar opcion -->
                                <?php
                                    $consulta3 = "SELECT * FROM tabla_respuestas WHERE idpreg='$idpreg'";//Si hay respuestas 
                                    //con el id de la pregunta respectiva
                                    $resultado3 = mysqli_query($conex, $consulta3);
                                    $corr = 0;
                                    if ($resultado3){
                                        while ($row3 = $resultado3->fetch_array()){// Obtiene una fila de resultados como un 
                                            //array asociativo, numérico, o ambos
                                            $correct = $row3["respCorr"];
                                            if ($correct==1){//Si respCorr es igual a 1
                                                $corr=1;//Cambio el valor de la bandera
                                            }
                                        }

                                    }
                                    if ($corr==0){//Si sigue siendo igual a 0
                                        ?>
                                        <input class="btnCheck" type="checkbox" id="<?php echo "$cadena"."*";?>">
                                        <?php
                                        //Le imprimo un checkbox debajo del input

                                    }
                                    
                                    ?>
                                </div>
                            
                                <button class="btnOpcion" type="button" onclick="agregarOpcion('<?php echo($pregunta); ?>','<?php echo($cadena); ?>','<?php echo($idexamen); ?>')" id="<?php echo "$cadena"."//";?>">Agregar opcion</button>
                                <?php
                                $consulta2 = "SELECT * FROM tabla_respuestas";
                                $resultado2 = mysqli_query($conex, $consulta2);
                                while ($row2 = $resultado2->fetch_array()){//Recorro las respuestas
                                    $respuesta = $row2["resp"];
                                    $idpregResp = $row2["idpreg"];
                                    $correcta = $row2["respCorr"];
                                    $cadena2 =str_replace(' ', '', $respuesta);
                                    //Guardo la informacion en variables
                                    if ($idpregResp===$idpreg){//Si los id de las preguntas son iguales
                                        ?>
                                        <div id="<?php echo "$cadena2";?>">
                                            <li id="<?php echo "$cadena2".">";?>" class="respuestas" style="<?php if($correcta==1){ echo "color: rgb(104, 248, 104)"; } ?>"><?php echo "$respuesta";?></li>
                                            <button class="modpreg" type="button" id="<?php echo "$cadena2"."<>";?>" onclick="editarOpcion('<?php echo($idexamen); ?>','<?php echo($respuesta); ?>','<?php echo($correcta); ?>','<?php echo($cadena2); ?>','<?php echo($cadena); ?>')">Editar</button>
                                            <button class="eliminarpreg" type="button" id="<?php echo "$cadena2"."^";?>" onclick="eliminarOpcion('<?php echo($idexamen); ?>','<?php echo($respuesta); ?>','<?php echo($correcta); ?>','<?php echo($cadena2); ?>','<?php echo($cadena); ?>')">Eliminar</button>
                                        </div>
                                        <?php
                                        //Imprimo la respuesta junto con los botones de editar y eliminar
                                    }
                                    

                                }?>

                            </div>

                            <?php 
                        }       
                    }   
                        
                }
                ?>
                

                </div>

                <input type="submit" name="guardarCambios" class="btnVerde" value="Guardar cambios" >
                <input type="button" value="Vista previa" class="btnVerde" id="<?php echo ($idprof); ?>" onclick="vistaprevia(this, '<?php echo ($idex); ?>')">
                
            </form>
            
        </div>
        
    </div>

    <div class="footer">
        <p class="uca col-2">UCA - Universidad Catolica Argentina</p>
        <p class="contacto col-8">examline@hotmail.com</p>
        <div class="imagencopy col-2"><img src="copyright-logo.jpg" width="100px" ></div>
    </div>

</body>
<script>

function getDisplayMateria(ingreso, display){
    var tipeo= document.getElementById(ingreso).value;
    document.getElementById(display).innerHTML= "Materia: " + tipeo;
}
function getDisplayTema(ingreso, display){
    var tipeo= document.getElementById(ingreso).value;
    document.getElementById(display).innerHTML= "Tema: " + tipeo;
}
function getDisplayTiempo(ingreso, display){
    var tipeo= document.getElementById(ingreso).value;
    console.log(tipeo);
    document.getElementById(display).innerHTML= "Tiempo: " + tipeo;
}


// Funcion que agrega preguntas y las muestra, recibiendo como parametro el boton Agregar Pregunta.
function agregarPreg(boton) {
    
    var preg = document.getElementById("inputPreguntasC").value;
    var idpreg = preg.replace(/ /g, "");

    if(document.getElementById(idpreg+"/")){ // no pueden haber 2 preguntas iguales en el mismo examen
        alert("Esta pregunta ya fue cargada!");

    }else{
        const xmlhttp = new XMLHttpRequest(); //crea el Request
        console.log("agregarPregunta.php?idexamen=" + boton.id+"&&preg="+preg);
        xmlhttp.open("GET", "agregarPregunta.php?idexamen=" + boton.id+"&&preg="+preg); // A traves del metodo GET envia las variables a un archivo PHP en donde se hara la carga de la pregunta
        xmlhttp.send();
        // a partir de este momento se empiezan a crear los elementos necesarios para cada pregunta
        var div = document.createElement("div");
        div.setAttribute("id", idpreg+"/");
        div.classList.add("preguntasjava");
        var h3 = document.createElement("h4");
        h3.innerHTML="Pregunta cargada: ";
        h3.setAttribute("style", "text-decoration: underline;");
        var h4preg = document.createElement("h4");
        h4preg.innerHTML=preg;
        h4preg.setAttribute("id", idpreg+"+");
        var botonModificarPegunta = document.createElement("button");
        botonModificarPegunta.innerHTML="Modificar pregunta";
        botonModificarPegunta.classList.add("modpreg");
        botonModificarPegunta.setAttribute("type", "button");
        botonModificarPegunta.setAttribute("id", idpreg+"///");
        botonModificarPegunta.setAttribute("onclick", "modificarPregunta('"+preg+"','"+idpreg+"','"+boton.id+"')");
        var botonEliminarPregunta = document.createElement("button");
        botonEliminarPregunta.setAttribute("type", "button");
        botonEliminarPregunta.classList.add("eliminarpreg");
        botonEliminarPregunta.setAttribute("id", idpreg+"#");
        botonEliminarPregunta.setAttribute("onclick", "eliminarPregunta('"+preg+"','"+idpreg+"','"+boton.id+"')");
        botonEliminarPregunta.innerHTML="Eliminar pregunta";
        var input = document.createElement("input");
        input.setAttribute("id", idpreg);
        input.classList.add("inputresp");

        var botonAgregarOpciones = document.createElement("button");                                                 
        botonAgregarOpciones.setAttribute("onclick", "agregarOpcion('"+preg+"','"+idpreg+"','"+boton.id+"')");
        botonAgregarOpciones.classList.add("btnOpcion");

        var correcta = document.createElement("input"); 
        correcta.setAttribute("type", "checkbox");
        correcta.setAttribute("value", "prendido");
        correcta.setAttribute("id", idpreg+"*");
        correcta.classList.add("btnCheck");
        var divboton = document.createElement("div");
        divboton.setAttribute("id", idpreg+"$$$");
        botonAgregarOpciones.setAttribute("type", "button");
        botonAgregarOpciones.setAttribute("id", idpreg+"//");
        botonAgregarOpciones.innerHTML="Agregar opcion";
        var x = document.createElement("br");
        div.appendChild(h3);
        div.appendChild(h4preg);
        div.appendChild(botonModificarPegunta);
        div.appendChild(botonEliminarPregunta);
        div.appendChild(x);
        div.appendChild(input);
        divboton.appendChild(correcta);
        div.appendChild(divboton);
        div.appendChild(botonAgregarOpciones);
        document.getElementById("preguntas").appendChild(div);
        console.log(preg);


    }
    
    

}
// funcion que recibe como parametro la pregunta en si, el identificador de la pregunta y el ID del examen
function agregarOpcion(preg, id, idexamen) {
    var opcion = document.getElementById(id);
    var texto = opcion.value;
    var checkbox = document.getElementById(id+"*");
    // aqui se verifica si el CHECK de respuesta correcta esta activado y en caso de que lo este elimina la opcion de poder agregar ptra respuesta correcta
    if (checkbox){
        var isChecked = checkbox.checked;
        if(isChecked){
            var correcta = 1
            checkbox.parentNode.removeChild(checkbox);
        
        }else{
            var correcta = 0
        }

    }else{
        var correcta = 0
    }
    
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "agregarOpcion.php?idexamen=" + idexamen +"&&preg="+preg+"&&opcion="+texto+"&&correcta="+correcta);
    xmlhttp.send();
    var idop = texto.replace(/ /g, "");
    var div = document.createElement("div");
    div.setAttribute("id",idop);
    var li = document.createElement("li");
    li.setAttribute("id",idop+">");
    li.classList.add("respuestas");
    li.innerHTML = texto;
    if (correcta==1){
        li.setAttribute("style","color: rgb(104, 248, 104)");
    }
    var botonEditar = document.createElement("button");
    botonEditar.classList.add("modpreg");
    botonEditar.setAttribute("type", "button");
    botonEditar.setAttribute("id", idop+"<>");
    botonEditar.setAttribute("onclick", "editarOpcion('"+idexamen+"','"+texto+"','"+correcta+"','"+idop+"','"+id+"')");
    botonEditar.innerHTML="Editar";
    var botonEliminar = document.createElement("button");
    botonEliminar.classList.add("eliminarpreg");
    botonEliminar.setAttribute("type", "button");
    botonEliminar.setAttribute("id", idop+"^");
    botonEliminar.setAttribute("onclick", "eliminarOpcion('"+idexamen+"','"+texto+"','"+correcta+"','"+idop+"','"+id+"')");
    botonEliminar.innerHTML="Eliminar";

    div.appendChild(li);
    div.appendChild(botonEditar);
    div.appendChild(botonEliminar);


    document.getElementById(id+"/").appendChild(div);
}
// modifica la pregunta cargada recibiendo como parametro la preg, el identificador de la preg y el id del examen
function modificarPregunta(preg, id, idexamen) {
    var input = document.createElement("input");
    input.setAttribute("value", preg);
    input.setAttribute("id", id+"-");
    //style="width: 500px;"
    input.setAttribute("style", "width: 500px;");
    var boton = document.createElement("button");
    boton.classList.add("btnOpcion");
    boton.setAttribute("type", "button");
    boton.setAttribute("onclick", "guardarPregMod('"+preg+"','"+id+"','"+idexamen+"')");
    boton.innerHTML="Guardar";
    var h4preg = document.getElementById(id+"+");
    h4preg.innerHTML="";
    h4preg.appendChild(input);
    h4preg.appendChild(boton);
    console.log(preg);
    console.log(id);
    console.log(idexamen);

}


// el boton de guardar la pregnta que desplegas al omneto de modificarla
function guardarPregMod(preg, id, idexamen) {

    const xmlhttp = new XMLHttpRequest();
    var input = document.getElementById(id+"-");
    texto = input.value;
    var newid = texto.replace(/ /g, "");
    xmlhttp.open("GET", "modificarPregunta.php?idexamen=" + idexamen +"&&preg="+preg+"&&mod="+texto);
    xmlhttp.send();
    var h4preg = document.getElementById(id+"+");
    h4preg.innerHTML=texto;
    document.getElementById(id+"/").setAttribute("id", newid+"/");
    document.getElementById(id+"+").setAttribute("id", newid+"+");
    document.getElementById(id).setAttribute("id", newid);
    document.getElementById(id+"*").setAttribute("id", newid+"*");
    document.getElementById(id+"//").setAttribute("onclick", "agregarOpcion('"+texto+"','"+newid+"','"+idexamen+"')");
    document.getElementById(id+"///").setAttribute("onclick", "modificarPregunta('"+texto+"','"+newid+"','"+idexamen+"')");
    document.getElementById(id+"#").setAttribute("onclick", "eliminarPregunta('"+texto+"','"+newid+"','"+idexamen+"')");
    document.getElementById(id+"//").setAttribute("id", newid+"//");
    document.getElementById(id+"///").setAttribute("id", newid+"///");
    document.getElementById(id+"#").setAttribute("id", newid+"#");

}


// edita una de las respuestas cargadas enteriormente. Recibe el id del examen, la respuesta en si, si la respuesta era correcta o no, el identificador de la respuesta y el identificador de la pregunta.
function editarOpcion(idexamen, texto, correcta, idop, idpreg) {
    var boton = document.createElement("button");
    boton.classList.add("btnOpcion");
    boton.setAttribute("type", "button");
    boton.innerHTML="Guardar";
    var check = document.createElement("input");
    check.setAttribute("type", "checkbox");
    check.setAttribute("id", idop+"=");
    check.classList.add("btnCheck");
    var input = document.createElement("input");
    input.classList.add("inputresp");
    input.setAttribute("value", texto);
    input.setAttribute("id", idop+"~");
    var li = document.getElementById(idop+">");
    li.innerHTML="";
    if (correcta==1){
        check.checked=true;
    }
    boton.setAttribute("onclick", "guardarOpMod('"+idexamen+"','"+idop+"','"+texto+"','"+correcta+"','"+idpreg+"')");
    li.appendChild(input);
    li.appendChild(check);
    li.appendChild(boton);

    



}
// funcion para uardar lo editado de la opcion. Recibe el id del examen, el id de la respuesta, la respuesta que tenia anteriormente, si era correcta o no y el identificador de la pregunta
function guardarOpMod(idexamen, idop, respAnterior, correct, idpreg) {
    var li = document.getElementById(idop+">");
    var opcion = document.getElementById(idop+"~");
    var texto = opcion.value;
    var check = document.getElementById(idop+"=");
    var isChecked = check.checked;
    if(isChecked){ //verifica si al momento de guardar la modificacion marco la opcion de respuesta correcta o no
        if (correct==1){ // si la marco y ademas la respuesta venia de ser correcta no altera nada
            var correcta = 1;
            li.setAttribute("style","color: rgb(104, 248, 104);");
        }else{ // si la marco pero no venia de estar marcada pasa lo siguiente
            if (document.getElementById(idpreg+"*")){ // si existe la posibilidad de ser marcada como correcta lo hace y elimina la posibilidad que tenia con el cjeck anterior
                var correcta = 1;
                li.setAttribute("style","color: rgb(104, 248, 104);");
                var btn = document.getElementById(idpreg+"*");
                btn.parentNode.removeChild(btn);
            }else{ // si ya hay una correcta existente no lo deja 
                alert("Existe una respuesta correcta!");
                var correcta = 0;
                li.setAttribute("style","color: white;");

            }
        }
        

    }else{// si no esta marcada como correcta
        if (correct==1){ // si venia marcada como correcta entonces vuelve a habilitar la opcion de marcarla como correcta nuevamente a futuras respuestass
            var chekk = document.createElement("input"); 
            chekk.setAttribute("type", "checkbox");
            chekk.setAttribute("value", "prendido");
            chekk.setAttribute("id", idpreg+"*");
            chekk.classList.add("btnCheck");
            var divboton = document.getElementById(idpreg+"$$$");
            divboton.appendChild(chekk);
            var correcta = 0;
            li.setAttribute("style","color: white;");
        }else{ // caso contrario no altera nada
            var correcta = 0;
            li.setAttribute("style","color: white;");

        }
        

    }
    var newid = texto.replace(/ /g, "");
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "editarOpcion.php?idexamen=" + idexamen +"&&opcion="+texto+"&&correcta="+correcta+"&&respAnterior="+respAnterior);
    xmlhttp.send();
    
    li.innerHTML=texto;
    console.log(correcta, texto, idop, respAnterior);
    // al modificar la opcion se modifican con ella su id, su value y muchos de los atributos que tienen que ser modificados 
    document.getElementById(idop).setAttribute("id", newid);
    document.getElementById(idop+">").setAttribute("id", newid+">");
    document.getElementById(idop+"<>").setAttribute("onclick", "editarOpcion('"+idexamen+"','"+texto+"','"+correcta+"','"+newid+"','"+idpreg+"')");
    document.getElementById(idop+"<>").setAttribute("id", newid+"<>");
    document.getElementById(idop+"^").setAttribute("onclick", "eliminarOpcion('"+idexamen+"','"+texto+"','"+correcta+"','"+newid+"','"+idpreg+"')");
    document.getElementById(idop+"^").setAttribute("id", newid+"^");
    console.log("editarOpcion('"+idexamen+"','"+texto+"','"+correcta+"','"+newid+"')");
    

}

function eliminarPregunta(preg, idpreg, idexamen) {
    var div = document.getElementById(idpreg+"/");
    div.parentNode.removeChild(div);
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "eliminarPregunta.php?idexamen="+idexamen+"&&preg="+preg);
    xmlhttp.send();
    
}

function eliminarOpcion(idexamen, texto, correcta, idop, idpreg) {
    // en caso de eliminar la opcion y que esta haya sido correcta, se habilita la posibilidad de una nueva correcta e el futuro y se elimina esta
    if (correcta==1) {
        var chekk = document.createElement("input"); 
        chekk.setAttribute("type", "checkbox");
        chekk.setAttribute("value", "prendido");
        chekk.setAttribute("id", idpreg+"*");
        chekk.classList.add("btnCheck");
        console.log(chekk);
        var divboton = document.getElementById(idpreg+"$$$");
        divboton.appendChild(chekk);
    }
    
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "eliminarOpcion.php?respuesta="+texto);
    xmlhttp.send();

    var div = document.getElementById(idop);
    div.parentNode.removeChild(div);
}

function vistaprevia(botonaso, idexamen){
    var idprofe = botonaso.id;
    window.location = '08.1-vistaprevia.php?idprofe='+idprofe+'&&idexamen='+idexamen;

}
</script>

</html>