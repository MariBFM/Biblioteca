<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tu Lectura</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <main>
      <!--Boton de volver a index.html-->
      <button class="atras" type="button" name="button" onclick="window.location.href='index.html'"><<</button>
        <!--Formulario con todos los datos para la base de datos-->
        <form class="formulari" action="registro.php" method="post">
          <div>
            <div class="grup">
              <label for="nombre" >Nombre</label>
              <input type="text" name="nombre" >
            </div>
            <div class="grup2">
              <label for="nacimiento">Fecha de nacimiento</label>
              <input type="date" name="nacimiento" value="">
            </div>
            <div class="grup">
              <label for="apellidos">Apellidos</label>
              <input type="text" name="apellidos" value="">
            </div>
          </div>
          <div>
            <div class="grup">
              <label for="email">E-mail</label>
              <input type="text" name="email" value="">
            </div>
            <div class="grup">
              <label for="direccion">Direccion</label>
              <input type="text" name="direccion" value="">
            </div>
            <div class="grup">
              <label for="cp">C.P.</label>
              <input type="text" name="cp" value="">
            </div>
            <div class="grup">
              <label for="poblacion">Población</label>
              <input type="text" name="poblacion" value="">
            </div>
          </div>
          <div id="tercero">
            <div class="grup">
              <label for="usuario">Usuario</label>
              <input type="text" name="usuario" value="">
            </div>
            <div class="grup">
              <label for="password">Contraseña</label>
              <input type="password" name="password" value="">
            </div>
            <div class="grup2">
              <label for="password2">Repetir contraseña</label>
              <input type="password" name="password2" value="">
            </div>
          </div>
          <input type="submit" name="submit" value="Enviar" id="enviar" class="boton">
        </form>
        <?php
          if(isset($_POST["submit"])){
            /*Info de la base de datos*/
            $db_host="localhost";
            $db_user="administrador";
            $db_passwd="123456789";
            $db_nombre="biblioteca";
            $db_tabla="usuario";
            /*conectarse a la base de datos*/
            $db_connection = mysqli_connect($db_host, $db_user, $db_passwd, $db_nombre);
            /*Datos del formulario*/
            $usu_name= utf8_decode($_POST['nombre']);
            $usu_apellido= utf8_decode($_POST['apellidos']);
            $usu_nacimiento= ($_POST['nacimiento']);
            $usu_email= utf8_decode($_POST['email']);
            $usu_direccion= utf8_decode($_POST['direccion']);
            $usu_cp=($_POST['cp']);
            $usu_poblacion=utf8_decode($_POST['poblacion']);
            $usu_usuario=utf8_decode($_POST['usuario']);
            $usu_password=utf8_decode($_POST['password']);
            $usu_password2=utf8_decode($_POST['password2']);
            /*Contraseña encriptada*/
            $hash = password_hash($usu_password, PASSWORD_DEFAULT);
            /*SQL donde insertamos los datos en la tabla USUARIO*/
            $sql = " INSERT INTO biblioteca.usuario (nombre, apellidos, fecha_de_nacimiento, email, direccion, poblacion, codigopostal, Usuario, password)
            VALUES('$usu_name',' $usu_apellido','$usu_nacimiento',' $usu_email ','$usu_direccion',' $usu_poblacion',' $usu_cp','$usu_usuario','$hash')";
            $exito = false;
            if(($usu_password == $usu_password2) && (!empty($usu_usuario))&&(!empty($usu_password)) ){
              if(mysqli_query($db_connection,$sql)){/*Conección linea 10, sql linea 25*/
                echo "se han introducido los datos correctamente";
                $exito = true;
                header("location: index.html");
              }else{
                echo "<p class='error'>Error al insertar en la base de datos.</p>";
              }
            }else{
              echo "<p class='error'>Las contraseñas no coinciden o los campos estan vacios.</p>";
            }
          }
        ?>
    </main>
    <script type="text/javascript">
      /*Funcion para mostrar el error durante 3s*/
      window.onload= recarga();
      function recarga(){
        let p = document.getElementsByTagName('p')[0];
        if(document.contains(p)){
          setTimeout(function(){p.remove();},3000);
        }
      }
    </script>
  </body>
</html>
