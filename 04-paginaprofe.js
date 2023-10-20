
function eliminarExamen(boton){
    const xmlhttp = new XMLHttpRequest();//Creo una instancia/un objeto XMLHttpRequest
    xmlhttp.open("GET", "eliminarexamen.php?idexamen=" + boton.id);//Realiza una petición de apertura de comunicación con un método GET
    xmlhttp.send();//Envía la petición al servidor
    console.log("eliminarexamen.php?idexamen=" + boton.id);
    var div = boton.parentNode;//Guardo en la variable el nodo padre
    div.parentNode.removeChild(div);//Elimino el div del examen
    
}

function publicarExamen(boton){
    const xmlhttp = new XMLHttpRequest();//Creo una instancia/un objeto XMLHttpRequest
    xmlhttp.open("GET", "publicarexamen.php?idexamen=" + boton.id);//Realiza una petición de apertura de comunicación con un método GET
    xmlhttp.send();//Envía la petición al servidor
    var div = boton.parentNode;//Guardo en la variable el nodo padre
    document.getElementById("nopublic").removeChild(div);//Elimino el div de los no publicados
    alert("¡Examen publicado exitosamente!");//Mando un aviso al usuario de que se publico el examen
    location.reload();//Cargo de nuevo la pagina actual

    
    

}
