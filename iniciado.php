
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tu Lectura</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body onload=inicio()>
    <!--Sesion iniciada si se ha logeado en la pagina de inicio-->
    <?php
      session_start();
      $usu_session = $_SESSION['name'];
      if(!isset($_SESSION['loggedin'])){
        header('Location: index.html');
        exit;
      }
    ?>
    <header>
      <!--Cambiamos estilo para que vuelva como al inicio-->
      <img src="img/logo30.png" alt="logo página" id="logo" onclick="inicio()">
      <h1 id="pero">TU LECTURA</h1>
      <p id="usu"><?=$usu_session?></p><!--Se muestra el usuario que ha iniciado sesion-->
    </header>
    <section class="iniciado">
      <menu>
        <!--Menú lateral-->
        <div class="menu">
          <ul>
            <li><h3>MENÚ</h3></li>
            <li><a class="link" href="#" onclick="cambiar(0)">Buscar libro</a></li>
            <li><a class="link" href="#" onclick="cambiar(1)">Enviar sugerencia</a></li>
            <li><a class="link" href="#" onclick="cambiar(2)">Mis reservas</a></li>
            <li><a class="link" href="#" onclick="cambiar(3)">Configurar perfíl</a></li>
          </ul>
        </div>
        <!--Boton para mostrar y esconder menu-->
        <a href="#" id="menu_bt" onclick="menu()">►</a>
      </menu>
      <div class="contenido">
        <!--Contenido por defecto-->
        <div id="novedades">
          <h2>Te recomendamos...</h2>
          <?php
            $db_host="localhost";
            $db_user="administrador";
            $db_passwd="123456789";
            $db_nombre="biblioteca";
            $db_connection = mysqli_connect($db_host, $db_user, $db_passwd, $db_nombre);
            mysqli_set_charset($db_connection, "utf8");
            $sql = "SELECT * FROM libro";
            $rsql = mysqli_query($db_connection, $sql);
            $limagen = [];
            $ltitulo = [];
            $autor = [];
            $i = 0;
            if($rsql){
              if(mysqli_num_rows($rsql) > 0){
                while($row = mysqli_fetch_array($rsql)){
                  $limagen[$i] = $row['imagen'];
                  $ltitulo[$i] = $row['Titulo'];
                  $lautor[$i] = $row['Autor'];
                  $descripcion[$i] = $row['descripcion'];
                }
              }
            }
            $numrandom = 0;
            echo "<div>";
            echo "<img id='imgnovedad' style='width:180px;'src='data:image/jpeg; base64,". base64_encode($limagen[$numrandom])."'>";
            echo "<div>";
            echo "<h3>".$ltitulo[$numrandom]."</h3>";
            echo "<p>".$lautor[$numrandom]."</p>";
            echo "<p>".$descripcion[$numrandom]."</p>";
            echo "</div>";
            echo "</div>";
          ?>
        </div>
        <!--Aqui se mostraran las paginas php segun lo que se escoja en el menú-->
        <iframe id="contenedor" src="about:blank" width="80%" height="80%" scrolling="no" onload='javascript:resizeIframe(this);'></iframe>
      </div>
      <aside>
        <div class="publicidad">
        </div>
      </aside>
    </section>
    <footer>
      <p>Nuestras redes sociales</p>
      <div>
        <div class="twitter"></div>
        <div class="facebook"></div>
        <div class="instagram"></div>
      </div>
    </footer>
    <script type="text/javascript">
      var novedades = document.getElementById('novedades');
      var contenido = document.getElementById('contenedor');
      var con = document.getElementsByClassName('contenido')[0];
      var section = document.getElementsByTagName('section')[0];
      /*Funcion para cambiar el contenido del iframe segun el menu y cambiar lo que se muestra con style*/
      function resizeIframe(obj){
        let frame = obj.contentWindow.document.body.scrollHeight + 'px';
        obj.style.height = frame;
        con.style.height =frame;
        section.style.height=frame;
      }
      function cambiar(valor){
        switch (valor) {
          case 0:
            novedades.style.display = "none";
            contenido.style.display = "block";
            contenido.src= "contenido/buscador.php";
            break;
          case 1:
            novedades.style.display = "none";
            contenido.style.display = "block";
            contenido.src= "contenido/mail.php";
            break;
          case 2:
            novedades.style.display = "none";
            contenido.style.display = "block";
            contenido.src= "contenido/reservas.php";
            break;
          case 3:
            novedades.style.display = "none";
            contenido.style.display = "block";
            contenido.src= "contenido/perfil.php";
            break;
        }
      }
      function inicio(){
        novedades.style.display = "flex";
        contenido.style.display = "none";
        section.style.height = "800px";
      }
      function menu(){
        let menu = document.getElementsByClassName('menu')[0];
        let boton = document.getElementById('menu_bt');
        let lista = document.getElementsByTagName('ul')[0];
        if (menu.style.marginLeft == "0px") {
          menu.style.marginLeft = "-350px";
          menu.style.transition = "margin-left 2s";
          boton.style.transform = "scaleX(1)";
        }else{
          menu.style.marginLeft = "0px";
          menu.style.transition = "margin-left 2s";
          boton.style.transform = "scaleX(-1)";
        }
      }
    </script>
  </body>
</html>
