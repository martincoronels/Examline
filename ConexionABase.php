<?php

// https://www.w3schools.com/php/php_ref_mysqli.asp

function conectarBD() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "examline";
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Checkear conexión
    // if ($conn->connect_error) {
    //     die("Conexion fallida: " . $conn->connect_error);
    // } 
    // echo "Conexion EXITOSA";

    return $conn;
}


function consultaSQL($conn, $sql) 
{   
    $result = $conn->query($sql); //Se tiene la clase creada mysqli guardada en la variable $conn 
    //y con el operador de objeto(->) se llama a la funcion query()(que realiza una consulta en la base de datos) dentro de $conn
    return $result;
    
}


function desconectarBD($conn) 
{
    // cerrar conexión
    $conn->close();//close() cierra una conexion a la base de datos previamente abierta
}


?>