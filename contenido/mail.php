<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tu Lectura</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body id="bmail">
    <p id="pmail"> Escribe aquí tu sugerencia o reclamación anónima</p>
    <form method="post" class="correo" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div>
        <label for="asunto">Asunto: </label>
        <input type="text" id="casunto" name="asunto" value="">
      </div>
      <textarea name="contenido" rows="20" cols="100"  placeholder="Escribe aquí el correo..."></textarea>
      <input type="submit" name="enviar" value="ENVIAR" class="boton">
    </form>
    <?php
      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\SMTP;
      require '../../../composer/vendor/autoload.php';
      date_default_timezone_set('Etc/UTC');
        if (isset($_POST['enviar'])){
          $cont = utf8_decode($_POST['contenido']);
          $asun = utf8_decode($_POST['asunto']);
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->SMTPDebug = SMTP::DEBUG_SERVER;
          $mail->Host = 'smtp.gmail.com';
          $mail->Port = 587;
          $mail->SMTPSecure = 'tls';
          $mail->SMTPAuth = true;
          $mail->Username = 'tulectura.biblioteca@gmail.com';
          $mail->Password = 'biblioteca123';
          $mail->setFrom('tulectura.biblioteca@gmail.com', 'Sugerencia');
          $mail->addAddress('tulectura.biblioteca@gmail.com', 'TuLectura');
          $mail->Subject = $asun;
          $mail->Body = $cont;
          $mail->send();
        }
    ?>
  </body>
</html>
