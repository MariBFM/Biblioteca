<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style.css">
    <title></title>
  </head>
  <body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='post'>
      <?php
        if(isset($_POST['ver'])){
          session_start();
          if(!isset($_SESSION['loggedin'])){
            header('Location: error.php');
            exit;
          }
          $nombre_usu = $_SESSION['name'];
          $id_usu="";
          $db_host="localhost";
          $db_user="administrador";
          $db_passwd="123456789";
          $db_nombre="biblioteca";
          $db_connection = mysqli_connect($db_host, $db_user, $db_passwd, $db_nombre);
          mysqli_set_charset($db_connection, "utf8");
          $ql = "SELECT * FROM usuario WHERE nombre LIKE '%$nombre_usu%'";
          $rql = mysqli_query($db_connection, $ql);
          if($rql){
            if(mysqli_num_rows($rql)>0){
              while($row = mysqli_fetch_array($rql)){
                $id_usu = $row['IDUsuario'];
              }
            }
          }
          $titulo =  utf8_decode($_POST['titulo']);
          $sql = "SELECT * FROM libro WHERE titulo = '$titulo'";
          $rsql = mysqli_query($db_connection, $sql);
          if($rsql){
            if(mysqli_num_rows($rsql)>0){
              while($fila = mysqli_fetch_array($rsql)){
                echo "<div class='libro'>";
                echo "<img src='data:image/jpeg; base64,". base64_encode($fila['imagen'])."'>";
                echo "<div>";
                echo "<h2><input style='display:none' type='text' name='titulo' value='". $fila['Titulo']."'>". $fila['Titulo']."</h2>";
                echo "<p>Autor: ".$fila['Autor']."</p>";
                echo "<p>Editorial: ".$fila['Editorial']."</p>";
                echo "<p>Género: ".$fila['Genero']."</p>";
                echo "<p>Fecha de publicación: ".$fila['FechaPublicacion']."</p>";
                echo "<p>Descripción: ".$fila['descripcion']."</p>";
                echo "<input type='submit' class='reserva' name='reservar' value='RESERVAR'>";
              }
            }
          }
        }
      ?>
    </form>
      <?php
        if(isset($_POST['reservar'])){
          session_start();
          if(!isset($_SESSION['loggedin'])){
            header('Location: error.php');
            exit;
          }
          $nombre_usu = $_SESSION['name'];
          $id_usu="";
          $db_host="localhost";
          $db_user="administrador";
          $db_passwd="123456789";
          $db_nombre="biblioteca";
          $db_connection = mysqli_connect($db_host, $db_user, $db_passwd, $db_nombre);
          mysqli_set_charset($db_connection, "utf8");
          $ql = "SELECT * FROM usuario WHERE nombre = '$nombre_usu'";
          $rql = mysqli_query($db_connection, $ql);
          if($rql){
            if(mysqli_num_rows($rql)>0){
              while($row = mysqli_fetch_array($rql)){
                $id_usu = $row['IDUsuario'];
              }
            }
          }
          $titulo =  utf8_decode($_POST['titulo']);
          $fecha = date("Y-m-d");
          $fechacad = date("Y-m-d", strtotime($fecha. "+ 1 month"));
          $newsql = "SELECT * FROM libro WHERE Titulo = '$titulo'";
          $newrsql = mysqli_query($db_connection, $newsql);
          if($newrsql){
            if(mysqli_num_rows($newrsql)>0){
              while($fila = mysqli_fetch_array($newrsql)){
                $id_libro = $fila['IDLibro'];
                $reserva = "INSERT INTO reserva (ID_usuario, ID_libro, fecha_reserva, fecha_devolucion)
                VALUES ('$id_usu','$id_libro','$fecha','$fechacad')";
                $res= mysqli_query($db_connection, $reserva);
                if($res){
                  echo"<p>Se ha efectuado la reserva correctamente.</p>";
                }
              }
            }
          }
        }
       ?>
  </body>
</html>
