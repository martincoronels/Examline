<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="02-loginsyregistros.css" />
    <title>Login de alumnos</title>
  </head>
  <body>
    <div class="container">
      <form method="post" id="formulario">
      <h2>Login</h2>
      <div class="login-email">
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
        <input type="submit" name="login" class="button">
			<p>&nbsp;</p>
			<p class="login-register-text">¿Todavia no te sumaste?  <a href="11-registroalumnos.php">Registrate</a>.</p>
      <p class="login-register-text">¿Sos profesor?  <a href="02-loginprofes.php">Entra aca</a>.</p>
      </form>
    </div>
	</div>

  </body>
</html>
<?php
session_start();
include("ConectarDB.php");
if (isset($_POST['login'])){//Cuando se envia el login
    if (strlen($_POST['email']) >= 1 && strlen($_POST['password']) >= 1){//Si el largo del email y el de la
      //contraseña son mayores o iguales a 1  
        $email = trim($_POST["email"]);
        $contra = trim($_POST["password"]);
        //Guardo el mail y la contraseña en variables y con trim() elimino los espacios en blanco
        $query = "SELECT * FROM tabla_alumnos WHERE emailalumno = '$email' LIMIT 1";//Hago la consulta
        $result = mysqli_query($conex, $query);

        if($result){
            if($result && mysqli_num_rows($result)>0){//Si devuelve algo y tiene filas
                $user_data = mysqli_fetch_assoc($result);//Recupera una fila de resultados como un array asociativo
                $idalumno = $user_data["idalumno"];//Tomo el id del alumno
                if($user_data["contraseñaalumno"] === $contra){//Si la contraseña coincide
                    $_SESSION["nombrealumno"]=$user_data["nombrealumno"];
                    $_SESSION["idalumno"]=$user_data["idalumno"];
                    //Guardo la informacion en variables de sesion
                    header("location:12-paginaalumno.php?idalumno=$idalumno");//Redireccion a la pagina principal del alumno
                    die;
                } else{
                        echo '<script language="javascript">
                        var formu = document.getElementById("formulario");
                        var para = document.createElement("h3");
                        para.classList.add("avisoEmail");
                        para.innerHTML = "¡Email y/o contraseña incorrecta!";
                        formu.appendChild(para);
                        </script>';
                        //Sino devuelve error con un h3 

                }
            } else{
                echo '<script language="javascript">
                var formu = document.getElementById("formulario");
                var para = document.createElement("h3");
                para.classList.add("avisoEmail");
                para.innerHTML = "¡Email no asociado a ninguna cuenta!";
                formu.appendChild(para);
                </script>';
                //El error que devuelve si no encuentra el mail, es decir, si no hay filas

        }

        } else{
            echo '<script language="javascript">
            var formu = document.getElementById("formulario");
            var para = document.createElement("h3");
            para.classList.add("avisoEmail");
            para.innerHTML = "¡Email no asociado a ninguna cuenta!";
            formu.appendChild(para);
            </script>';
             //El error que devuelve si no encuentra el mail, es decir, si no hay filas

    }


    }
    

}


?>