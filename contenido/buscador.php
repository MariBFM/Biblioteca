<?php
  $db_host="localhost";
  $db_user="administrador";
  $db_passwd="123456789";
  $db_nombre="biblioteca";

  $db_connection = mysqli_connect($db_host, $db_user, $db_passwd, $db_nombre);
  mysqli_set_charset($db_connection, "utf8");
  $generos = "SELECT DISTINCT genero FROM libro";

  $egenero = mysqli_query($db_connection, $generos);

  $todos_generos = [];

  if($egenero){
    if(mysqli_num_rows($egenero)>0){
      $i = 0;
      while($fila = mysqli_fetch_array($egenero)){
        $todos_generos[$i] = $fila['genero'];
        $i++;
      }
    }
  }
?>
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
        <label for="titulo">Título: </label>
        <input type="text" name="titulo" >
      </div>
      <div>
        <label for="autor">Autor/a: </label>
        <input type="text" name="autor">
      </div>
      <div>
        <label for="genero">Género: </label>
        <select class="" name="genero">
          <option value = "todos">todos</option>
          <?php
          for ($i=0; $i < count($todos_generos); $i++) {
            echo "<option value='".$todos_generos[$i]."'>".$todos_generos[$i]."</option>";
          }
          ?>
        </select>
      </div>
      <input id="buscar" class="boton" type="submit" name="bbuscar" value="Buscar">
    </form>
    <?php
    if(isset($_POST['bbuscar'])){
      $titulo = utf8_decode($_POST['titulo']);
      $autor = utf8_decode($_POST['autor']);
      $genero = $_POST['genero'];
      $sql;
      //Buscar si titulo, autor y genero estan vacios.
      if((empty($titulo)) AND (empty($autor)) AND ($genero == "todos")){
        $sql = "SELECT * FROM libro";
        //Buscar si genero esta seleccionado.
      }else if((empty($titulo)) AND (empty($autor)) AND ($genero != "todos")){
        $sql = "SELECT * FROM libro WHERE Genero = '$genero'";
        //Buscar si autor no esta vacio.
      }else if((empty($titulo)) AND (!empty($autor)) AND ($genero == "todos")){
        $sql = "SELECT * FROM libro WHERE autor LIKE '%$autor%'";
        //Buscar si titulo no esta vacio.
      }else if((!empty($titulo)) AND (empty($autor)) AND ($genero == "todos")){
        $sql = "SELECT * FROM libro WHERE Titulo LIKE '%$titulo%'";
        //Buscar si titulo y autor no estan vacios.****
      }else if((!empty($titulo)) AND (!empty($autor)) AND ($genero == "todos")){
        $sql = "SELECT * FROM libro WHERE Autor LIKE '%$autor%' AND Titulo LIKE '%$titulo%'" ;
        //Buscar si titulo y genero no estan vacios.
      }else if((!empty($titulo)) AND (empty($autor)) AND ($genero != "todos")){
        $sql = "SELECT * FROM libro WHERE Titulo LIKE '%$titulo%' AND Genero = '$genero'";
        //Buscar si autor y genero no estan vacios.
      }else if((empty($titulo)) AND (!empty($autor)) AND ($genero != "todos")){
        $sql = "SELECT * FROM libro WHERE Autor LIKE '%$autor%' AND Genero = '$genero'";
        //Buscar si todos los campos no estan vacios.
      }else if((!empty($titulo)) AND (!empty($autor)) AND ($genero != "todos")){
        $sql = "SELECT * FROM libro WHERE Autor LIKE '%$autor%' AND Titulo LIKE '%$titulo%' AND Genero = '$genero'";
      }else{
        echo "ERROR";
      }
      $rsql = mysqli_query($db_connection, $sql);
      if($rsql){
        if(mysqli_num_rows($rsql) > 0){
          echo "<table>";
          echo "<tr>";
          echo "<th>Imagen</th>";
          echo "<th>Título</th>";
          echo "<th>Autor</th>";
          echo "<th>Editorial</th>";
          echo "<th>Genero</th>";
          echo "<th>Fecha Publicación</th>";
          echo "<th>Disponibilidad</th>";
          echo "<th>Reservar</th>";
          echo "</tr>";
          while($row = mysqli_fetch_array($rsql)){
            echo "<form action='libro.php' method='post'>";
            echo "<tr>";
            echo "<td><img src='data:image/jpeg; base64,". base64_encode($row['imagen'])."'></td>";
            echo "<td><input style='display:none;' type='text' name='titulo' value='".$row['Titulo']."'><p>".$row['Titulo']."</p></td>";
            echo "<td>".$row['Autor']."</td>";
            echo "<td>".$row['Editorial']."</td>";
            echo "<td>".$row['Genero']."</td>";
            echo "<td>".$row['FechaPublicacion']."</td>";
            echo "<td>".$row['cantidad']."</td>";
            echo "<td><input type='submit' class='reserva' name='ver' value='Ver'></td>";
            echo "</tr>";
            echo "</form>";
          }
        }
      }
    }
    ?>
    <script type="text/javascript">
    </script>
  </body>
</html>
