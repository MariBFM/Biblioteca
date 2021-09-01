<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tu Lectura</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
<?php
  $db_host="localhost";
  $db_user="administrador";
  $db_passwd="123456789";
  $db_nombre="biblioteca";
  $db_connection = mysqli_connect($db_host, $db_user, $db_passwd, $db_nombre);
  mysqli_set_charset($db_connection, "utf8");

  session_start();
  if(!isset($_SESSION['loggedin'])){
    header('Location: error.php');
    exit;
  }
  $id_usu="";
  $name = $_SESSION['name'];

  $us = "SELECT * FROM usuario WHERE nombre = '".$name."'";
  $res = mysqli_query($db_connection,$us);
  if($res){
    if(mysqli_num_rows($res)>0){
      while($row = mysqli_fetch_array($res)){
        $id_usu=$row['IDUsuario'];
      }
    }
  }
  $nus = "SELECT * FROM reserva WHERE ID_usuario = '$id_usu'";
  $rres = mysqli_query($db_connection,$nus);
  if($rres){
    if(mysqli_num_rows($rres)>0){
      echo "<table>";
      echo "<tr>";
      echo "<th>ID_reserva</th>";
      echo "<th>ID_ususario</th>";
      echo "<th>ID_libro</th>";
      echo "<th>Fecha de Reserva</th>";
      echo "<th>Fecha de Caducidad</th>";
      echo "</tr>";
      while($row = mysqli_fetch_array($rres)){
        echo "<tr>";
        echo"<td>".$row['ID_reserva']."</td>";
        echo"<td>".$row['ID_usuario']."</td>";
        echo"<td>".$row['ID_libro']."</td>";
        echo"<td>".$row['fecha_reserva']."</td>";
        echo"<td>".$row['fecha_devolucion']."</td>";
        echo "</tr>";
      }
      echo "</table>";
    }
  }
?>
  </body>
</html>
