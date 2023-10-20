<?php
$conex = mysqli_connect("localhost", "root", "", "examline");
function consultaSQL($conn, $sql) 
{   
    $result = $conn->query($sql);
    return $result;
    
}
?>




