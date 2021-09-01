<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tu Lectura</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <form class="perfil" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" target="_top">
      <?php
      session_start();
      if(!isset($_SESSION['loggedin'])){
        header('Location: error.php');
        exit;
      }
        $usu_session = $_SESSION['name'];
        $db_host="localhost";
        $db_user="administrador";
        $db_passwd="123456789";
        $db_nombre="biblioteca";
        $db_connection = mysqli_connect($db_host, $db_user, $db_passwd, $db_nombre);
        mysqli_set_charset($db_connection, "utf8");
        $sql = "SELECT * FROM usuario WHERE nombre = '$usu_session';";
        $rsql = mysqli_query($db_connection, $sql);
        $u_name="";
        $u_apellidos="";
        $u_email="";
        $u_direc="";
        $u_poblacion="";
        $u_cp="";
        $u_usu="";
        $u_passwd="";
        $u_id="";
        $pass="";
        if($rsql){
          if(mysqli_num_rows($rsql) > 0){
            while($row = mysqli_fetch_array($rsql)){
              $u_name = $row['nombre'];
              $u_apellidos = $row['apellidos'];
              $u_email = $row['email'];
              $u_direc = $row['direccion'];
              $u_poblacion = $row['poblacion'];
              $u_cp = $row['codigopostal'];
              $u_usu = $row['Usuario'];
              $u_passwd = $row['password'];
              $u_id = $row['IDUsuario'];
              $pass = $row['password'];
            }
          }
        }
        if(isset($_POST['guardar'])){
          if(!empty($_POST['nombre'])){
            $ssql = "UPDATE usuario set nombre = '".$_POST['nombre']."' WHERE IDUsuario = '$u_id'";
            mysqli_query($db_connection,$ssql);
          }
          if(!empty($_POST['apellidos'])){
            $ssql = "UPDATE usuario set apellidos = '".$_POST['apellidos']."' WHERE IDUsuario = '$u_id'";
            mysqli_query($db_connection,$ssql);
          }
          if(!empty($_POST['email'])){
            $ssql = "UPDATE usuario set email = '".$_POST['email']."' WHERE IDUsuario = '$u_id'";
            mysqli_query($db_connection,$ssql);
          }
          if(!empty($_POST['direccion'])){
            $ssql = "UPDATE usuario set direccion = '".$_POST['direccion']."' WHERE IDUsuario = '$u_id'";
            mysqli_query($db_connection,$ssql);
          }
          if(!empty($_POST['poblacion'])){
            $ssql = "UPDATE usuario set poblacion = '".$_POST['poblacion']."' WHERE IDUsuario = '$u_id'";
            mysqli_query($db_connection,$ssql);
          }
          if(!empty($_POST['cp'])){
            $ssql = "UPDATE usuario set codigopostal = '".$_POST['cp']."' WHERE IDUsuario = '$u_id'";
            mysqli_query($db_connection,$ssql);
          }
          if(!empty($_POST['usuario'])){
            $ssql = "UPDATE usuario set Usuario = '".$_POST['usuario']."' WHERE IDUsuario = '$u_id'";
            mysqli_query($db_connection,$ssql);
          }
          $pasa =utf8_decode($_POST['p_antiguo']);
          $pas = utf8_decode($_POST['p_nuevo']);
          $pas2 = utf8_decode($_POST['p_nuevo2']);
          if(!empty($pasa)){
            if(!empty($pas)){
              if(!empty($pas2)){
                if(password_verify($pasa, $pass)){
                  if($pas == $pas2){
                    $hash = password_hash($pas, PASSWORD_DEFAULT);
                    $ssql = "UPDATE usuario set password = '".$hash."' WHERE IDUsuario = '$u_id'";
                    mysqli_query($db_connection,$ssql);
                  }
                }
              }
            }
            $ssql = "UPDATE usuario set nombre = '".$_POST['nombre']."' WHERE IDUsuario = '$u_id'";
            mysqli_query($db_connection,$ssql);
          }
          header('Location:../index.html');
        }
       ?>
      <div>
       <label for="nombre">Nombre:</label>
       <p><?php echo $u_name; ?></p>
       <input type="text" name="nombre">
       <a href="#" class="cambiar" onclick="mostrar(0)">Cambiar</a>
      </div>
      <div>
        <label for="nombre">Apellidos:</label>
        <p><?php echo $u_apellidos; ?></p>
        <input type="text" name="apellidos">
        <a href="#" class="cambiar" onclick="mostrar(1)">Cambiar</a>
      </div>
      <div>
        <label for="nombre">Email:</label>
        <p><?php echo $u_email; ?></p>
        <input type="text" name="email">
        <a href="#" class="cambiar" onclick="mostrar(2)">Cambiar</a>
      </div>
      <div>
        <label for="nombre">Dirección:</label>
        <p><?php echo $u_direc; ?></p>
        <input type="text" name="direccion">
        <a href="#" class="cambiar" onclick="mostrar(3)">Cambiar</a>
      </div>
      <div>
        <label for="nombre">Poblacion:</label>
        <p><?php echo $u_poblacion; ?></p>
        <input type="text" name="poblacion">
        <a href="#" class="cambiar" onclick="mostrar(4)">Cambiar</a>
      </div>
      <div>
        <label for="nombre">Codigo postal:</label>
        <p><?php echo $u_cp; ?></p>
        <input type="text" name="cp">
        <a href="#" class="cambiar" onclick="mostrar(5)">Cambiar</a>
      </div>
      <div>
        <label for="nombre">Usuario:</label>
        <p><?php echo $u_usu; ?></p>
        <input type="text" name="usuario">
        <a href="#" class="cambiar" onclick="mostrar(6)">Cambiar</a>
      </div>
      <div id="passwd">
        <label for="p_antiguo">Contraseña actual:</label>
        <input type="password" name="p_antiguo">
        <label for="p_nuevo">Nueva contraseña:</label>
        <input type="password" name="p_nuevo">
        <label for="p_nuevo2">Repetir contraseña</label>
        <input type="password" name="p_nuevo2">
      </div>
      <a href="#" class="cambiar" onclick="mostrar(7)">Cambiar contraseña</a>
      <input style="display:block;" class="boton" type="submit" name="guardar" value="Guardar cambios" >
    </form>
    <script type="text/javascript">
      function mostrar(num) {
        switch (num) {
          case 0:
            document.getElementsByName('nombre')[0].style.display="block";
            document.getElementsByClassName('cambiar')[0].style.display="none";
            break;
          case 1:
            document.getElementsByName('apellidos')[0].style.display="block";
            document.getElementsByClassName('cambiar')[1].style.display="none";
            break;
          case 2:
            document.getElementsByName('email')[0].style.display="block";
            document.getElementsByClassName('cambiar')[2].style.display="none";
            break;
          case 3:
            document.getElementsByName('direccion')[0].style.display="block";
            document.getElementsByClassName('cambiar')[3].style.display="none";
            break;
          case 4:
            document.getElementsByName('poblacion')[0].style.display="block";
            document.getElementsByClassName('cambiar')[4].style.display="none";
            break;
          case 5:
            document.getElementsByName('cp')[0].style.display="block";
            document.getElementsByClassName('cambiar')[5].style.display="none";
            break;
          case 6:
            document.getElementsByName('usuario')[0].style.display="block";
            document.getElementsByClassName('cambiar')[6].style.display="none";
            break;
          case 7:
            document.getElementById('passwd').style.display="block";
            document.getElementsByName('p_antiguo')[0].style.display="block";
            document.getElementsByName('p_nuevo')[0].style.display="block";
            document.getElementsByName('p_nuevo2')[0].style.display="block";
            document.getElementsByClassName('cambiar')[7].style.display="none";
            break;
        }
      }
    </script>
  </body>
</html>
