
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tu Lectura</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <form class="buscador" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <div>
        <label for="usuario">Usuario: </label>
        <input type="text" name="usuario" >
      </div>
      <div>
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre">
      </div>
      <div>
        <label for="apellido">Apellidos: </label>
        <input type="text" name="apellido">
      </div>
      <input id="buscaru" class="boton" type="submit" name="bbuscar" value="Buscar">
    </form>
    <?php
    $db_host="localhost";
    $db_user="administrador";
    $db_passwd="123456789";
    $db_nombre="biblioteca";

    $db_connection = mysqli_connect($db_host, $db_user, $db_passwd, $db_nombre);
    mysqli_set_charset($db_connection, "utf8");
    if(isset($_POST['bbuscar'])){
      $usuario = utf8_decode($_POST['usuario']);
      $nombre = utf8_decode($_POST['nombre']);
      $apellido = utf8_decode($_POST['apellido']);
      $sql;

      if((empty($usuario)) AND (empty($nombre)) AND (empty($apellido))){
        $sql = "SELECT * FROM usuario";

      }else if((empty($usuario)) AND (empty($nombre)) AND (!empty($apellido))){
        $sql = "SELECT * FROM usuario WHERE apellidos = '$apellido'";

      }else if((empty($usuario)) AND (!empty($nombre)) AND (empty($apellido))){
        $sql = "SELECT * FROM usuario WHERE nombre LIKE '%$nombre%'";

      }else if((!empty($usuario)) AND (empty($nombre)) AND (empty($apellido))){
        $sql = "SELECT * FROM usuario WHERE Usuario LIKE '%$usuario%'";

      }else if((!empty($usuario)) AND (!empty($nombre)) AND (empty($apellido))){
        $sql = "SELECT * FROM usuario WHERE nombre LIKE '%$nombre%' AND Usuario LIKE '%$usuario%'" ;

      }else if((!empty($usuario)) AND (empty($nombre)) AND (!empty($apellido))){
        $sql = "SELECT * FROM usuario WHERE Usuario LIKE '%$usuario%' AND apellidos = '$apellido'";

      }else if((empty($usuario)) AND (!empty($nombre)) AND (!empty($apellido))){
        $sql = "SELECT * FROM usuario WHERE nombre LIKE '%$nombre%' AND apellidos = '$apellido'";

      }else if((!empty($usuario)) AND (!empty($nombre)) AND (!empty($apellido))){
        $sql = "SELECT * FROM usuario WHERE nombre LIKE '%$nombre%' AND Usuario LIKE '%$usuario%' AND apellidos = '$apellido'";
      }else{
        echo "ERROR";
      }
      $rsql = mysqli_query($db_connection, $sql);
      if($rsql){
        if(mysqli_num_rows($rsql) > 0){
          echo "<table>";
          echo "<tr>";
          echo "<th>ID del usuario</th>";
          echo "<th>Nombre</th>";
          echo "<th>Apellidos</th>";
          echo "<th>Fecha de nacimiento</th>";
          echo "<th>email</th>";
          echo "<th>Población</th>";
          echo "<th>Usuario</th>";
          while($row = mysqli_fetch_array($rsql)){
            echo "<tr>";
            echo "<td>".$row['IDUsuario']."</td>";
            echo "<td>".$row['nombre']."</td>";
            echo "<td>".$row['apellidos']."</td>";
            echo "<td>".$row['fecha_de_nacimiento']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['poblacion']."</td>";
            echo "<td>".$row['Usuario']."</td>";
            echo "</tr>";
          }
        }
      }
    }
    ?>
    <form class="eliminar_usuario" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <p>Introduzca el ID exacto del usuario para eliminar:</p>
      <small>Si necesita estar seguro busque el usuario en el buscador de arriba.</small>
      <div>
        <label for="del_usu">ID del usuario a eliminar: </label>
        <input type="number" name="del_usu">
      </div>
      <input class="boton" type="submit" name="eliminar" value="Eliminar">
    </form>
    <?php
      if(isset($_POST['eliminar'])){
        $id_usu = $_POST['del_usu'];
        $newsql = "DELETE FROM `usuario` WHERE `usuario`.`IDUsuario` = $id_usu;";
        $rsql = mysqli_query($db_connection, $newsql);
        if($rsql){
          echo"<p>Se ha eliminado el usuario correctamente.</p>";
        }else{
          echo"<p>Error al intentar eliminar el usuario.</p>";
        }
      }
     ?>
    <script type="text/javascript">
    </script>
  </body>
</html>
