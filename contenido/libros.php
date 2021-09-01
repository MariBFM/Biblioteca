<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tu Lectura</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <form class="libros" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
      <p>Añadir libro</p>
      <div>
        <label for="titulo">Título: </label>
        <input type="text" name="titulo" >
      </div>
      <div>
        <label for="autor">Autor/a: </label>
        <input type="text" name="autor" >
      </div>
      <div>
        <label for="fecha">Fecha publicación: </label>
        <input type="date" name="fecha" >
      </div>
      <div>
        <label for="editorial">Editorial: </label>
        <input type="text" name="editorial" >
      </div>
      <div>
        <label for="genero">Género pincipal: </label>
        <input type="text" name="genero">
      </div>
      <div>
        <label for="descripcion">Descripción: </label>
        <input type="text" name="descripcion" >
      </div>
      <div>
        <label for="cantidad">Unidades: </label>
        <input type="number" name="cantidad">
      </div>
      <div>
        <label for="imagen">Imágen portada: </label>
        <input type="file" name="im" id="im" multiple>
      </div>
      <input class = "boton" type="submit" name="submit" value="Agregar libro">
    </form>
    <?php
      if(isset($_POST["submit"])){
        $db_host="localhost";
        $db_user="administrador";
        $db_passwd="123456789";
        $db_nombre="biblioteca";

        $db_connection = mysqli_connect($db_host, $db_user, $db_passwd, $db_nombre);
        mysqli_set_charset($db_connection, "utf8");
            $img = $_FILES['im']['tmp_name'];
            $fp = fopen($img,'r');
            $datos_img = fread($fp, filesize($img));
            $data = mysqli_real_escape_string($db_connection,$datos_img);
            fclose($fp);
            $titulo = utf8_decode($_POST['titulo']);
            $autor = utf8_decode($_POST['autor']);
            $fecha = $_POST['fecha'];
            $editorial = utf8_decode($_POST['editorial']);
            $genero = utf8_decode($_POST['genero']);
            $cantidad = $_POST['cantidad'];
            $descripcion = utf8_decode($_POST['descripcion']);
            $sql = " INSERT INTO biblioteca.libro (Titulo, Autor, Editorial, Genero, FechaPublicacion, imagen, cantidad, descripcion)
            VALUES('$titulo',' $autor','$editorial','$genero','$fecha','$data','$cantidad','$descripcion')";

            mysqli_query($db_connection,$sql);
            echo "<p>Exito al subir el libro a la base de datos</p>";
            mysqli_close($db_connection);
        }

     ?>
  </body>
  </html>
