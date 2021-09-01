
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>TuLectura</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <?php
  $error = "";
  //Al intentar iniciar sesion
  if (isset($_POST["submit"])){
    session_start();
    //Datos introducidos en index.html
    $user = utf8_decode($_POST['user']);
    $contra = utf8_decode($_POST['passwd']);
    $pass = password_hash($contra, PASSWORD_DEFAULT);
    //Datos de la base de datos
    $db_host="localhost";
    $db_user="administrador";
    $db_passwd="123456789";
    $db_nombre="biblioteca";
    //Conexión base de datos
    $conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_nombre);
    if(!$conn){
      die("Fallo al conectarse a la base de datos: " . myswli_connect_error());
    }
    //Creación de la consulta
    $sql = "SELECT * FROM usuario WHERE Usuario = '$user'";
    $rsql = mysqli_query($conn, $sql ); //hacemos la consulta
    if($rsql){
      if(mysqli_num_rows($rsql) > 0){
        while($row = mysqli_fetch_array($rsql)){
          //si la consulta se ejecuta y el resultado da más de una fila buscamos la columna password
          $pass2 = $row['password'];
          $name = $row['nombre'];
          $bibliotecario = $row['Bibliotecario_IDUsuario'];
        }
        //Si la contraseña dada y la de la base de datos coinciden:
        if(password_verify($contra, $pass2)){
          session_regenerate_id();
          $_SESSION['loggedin']=TRUE;
          $_SESSION['name']=$name;
          if($bibliotecario == NULL){
            echo "<script>top.location.href = 'iniciado.php';</script>";
          }else{
            echo "<script>top.location.href = 'iniciadob.php';</script>";
          }
        }else{
          echo "<p class='error'>La contraseña es incorrecta.</p>";
        }
      }
    }else{
      echo "<p class='error'>El usuario no existe.</p>";
    }
  }
  ?>
  <body id="inicio_sesion">
    <!--Formulario que contiene los datos que procesa index.php-->
    <form action="index.php" method="post" id="form_sesion">
      <!--Al darle iniciar sesión se muestra estos inputs-->
      <div class="usuario">
        <input type="usuario" placeholder="Usuario" name="user">
        <input type="password" placeholder="Contraseña" name="passwd">
      </div>
      <!--Botones para iniciar sesion o ir a registrar-se-->
      <div class="botones">
        <input class="boton" type="button" name="sesion" id="sesion" value="Iniciar sesión" onclick="mostrar()">
        <button class="boton" type="button" id="registro" value="Regístrate"><a id="re" href="registro.php" target="_parent">Regístrate</a></button>
        <input class="boton"type="submit" name="submit" id="login" value="Iniciar sesión">
      </div>
    </form>

    <!--Parte Javascript-->
    <script type="text/javascript">
      /*Funcion al pulsar "Iniciar sesión", Muestra los inputs para iniciar sesión y modifica el estilo de la página*/
      function mostrar(){
        let p = document.getElementsByTagName('p')[0];
        if(p){
          p.style.display="none";
        }
        document.getElementsByClassName("usuario")[0].style.display = "flex";
        document.getElementById("login").style.display="block";
        document.getElementById("sesion").style.display="none";
        document.getElementsByTagName("div")[1].style.flexDirection = "row";
        document.getElementById("registro").style.backgroundColor = "var(--latte)";
        document.getElementById("re").style.color = "var(--marron)";
        document.getElementById("registro").style.color = "var(--marron)";
      }
    </script>
  </body>
</html>
