<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="02-loginsyregistros.css" />
    <title>Registro de alumnos</title>
  </head>
  <body>
    <div class="container">
      <form method="post" id="formulario">
        <h2>Registro</h2>
        <div class="login-email">
          <div class="form-control">
            <label for="username">Nombre y apellido</label>
            <input autocomplete="off" type="text" name="username" id="usuario" required>
            <small>Error Message</small>
          </div>
          <div class="form-control">
            <label for="email">Email</label>
            <input autocomplete="off" type="email" name="email" id="email" required>
            <small>Error Message</small>
          </div>
          <div class="form-control">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="contraseña" required>
            <small>Error Message</small>
          </div>
          <div class="form-control">
            <label for="password">Confirmar contraseña</label>
            <input type="password" name="cpassword" id="contraseña2" required>
            <small>Error Message</small>
          </div>
          <input type="submit" name="register" class="button">
          <p>&nbsp;</p>
			    <p class="login-register-text">¿Tenes una cuenta? <a href="10-loginalumnos.php">Ingresa aca</a></p>
      </form>

    </div>
	</div>
  



  </body>
</html>

<?php
include("ConectarDB.php");

if (isset($_POST['register'])) {//Si envia el register
    if (strlen($_POST['username']) >= 1 && strlen($_POST['email']) >= 1 && strlen($_POST['password']) >= 1) {
        //Si el largo del nombre, el email y la contraseña son mayores o iguales a 1
        $nombre = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $contra = trim($_POST["password"]);
        $registrado = False;
        //Guardo esos 3 datos en variables, con trim() elimino los espacios en blanco e inicializo la bandera $registrado
        $primerresultado = mysqli_query($conex, "SELECT * FROM tabla_alumnos");//Hago la consulta
        while ($consulta = mysqli_fetch_array($primerresultado)){
          //Recupera una fila de resultados como un array asociativo, un array numérico o como ambos
          //Recorro ese array
            if ($consulta["emailalumno"] == $email){//Si el email es igual al ingresado
                $registrado = True;//Es true porque ya esta registrado
            }
        }
        if ($registrado) {//Si ya esta registrado, que printee esto
            echo '<script language="javascript">
            var formu = document.getElementById("formulario");
            var para = document.createElement("h3");
            para.classList.add("avisoEmail");
            para.innerHTML = "¡Email asociado a otra cuenta!";
            formu.appendChild(para);
            </script>';
          } 
            elseif (($_POST['password'])!=($_POST['cpassword'])){
              echo '<script language="javascript">
                var formu = document.getElementById("formulario");
                var para = document.createElement("h3");
                para.classList.add("avisoEmail");
                para.innerHTML = "¡Las contraseñas no coinciden!";
                formu.appendChild(para);
                </script>';
            }
            elseif (strlen($_POST['password'])<8){
              echo '<script language="javascript">
                var formu = document.getElementById("formulario");
                var para = document.createElement("h3");
                para.classList.add("avisoEmail");
                para.innerHTML = "¡La contraseña debe tener mas de 8 digitos!";
                formu.appendChild(para);
                </script>';
            }
        else{//Sino que lo inserte en la tabla de alumnos y avise que el registro fue exitoso
            $consulta = "INSERT INTO tabla_alumnos(nombrealumno, contraseñaalumno, emailalumno) VALUES ('$nombre', '$contra', '$email')";
            $resultado = mysqli_query($conex,$consulta);
            echo '<script language="javascript">
            var formu = document.getElementById("formulario");
            var para = document.createElement("h3");
            para.classList.add("regExitoso");
            para.innerHTML = "¡Registro exitoso!";
            formu.appendChild(para);
            </script>';
        }
        
        
        
        
    }
}
?>
