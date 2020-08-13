<?php
/*
    if(round(intval($_FILES["inpFile"]["size"])/1048576, 2) > 2){
        echo "<script type='text/javascript'> alert('El archivo no puede superar los 2 MB'); window.location='interfaceNe.html';</script>";
    }
    $mTmpFile = $_FILES["inpFile"]["tmp_name"];
    $mTipo = exif_imagetype($mTmpFile);
    if (($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG)){
        echo "<script type='text/javascript'> alert('Formato de archivo no reconocido. Subir un archivo .jpg, .jpeg o .png'); window.location='interfaceNe.html';</script>";
        //echo("Formato de archivo no reconocido.");
    }
    $targetPath = "uploads/" . basename($_FILES['inpFile']["name"]);
    move_uploaded_file($_FILES["inpFile"]["tmp_name"], $targetPath);
    */
    $mailDestinatario = "No se pudo enviar el correo";
    $nombreDestinatario = "No se pudo enviar el correo";
    $apellidosDestinatario = "No se pudo enviar el correo";

    if(isset($_POST['mailDestinatario'])){
        $mailDestinatario = $_POST['mailDestinatario'];
    }
    if(isset($_POST['nombreDestinatario'])){
        $nombreDestinatario = $_POST['nombreDestinatario'];
    }
    if(isset($_POST['apellidosDestinatario'])){
        $apellidosDestinatario = $_POST['apellidosDestinatario'];
    }

    $message = "<p>Felicitaciones por parte del equipo de Mercurio por haberte unido a nuestra comunidad!</p>";
    $message .= "<p>Estimad@ $nombreDestinatario $apellidosDestinatario, para completar tu registro tendrá que hacer click en el siguiente enlace:</p>";

    $to_email = $mailDestinatario;
    $subject = 'Registro Mercurio';
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';
    $headers[] = 'From: Bryan JPV <bryanjpv@feslecorp.com>';

    mail($to_email, $subject, $message, implode("\r\n", $headers));
    echo "<script>alert('Correo enviado exitosamente');</script>";
    echo "<script>setTimeout(\"location.href='index.html'\", 1000);</script>";

    // version MAIl NUEVO
    $message .= "<link href='https://fonts.googleapis.com/css2?family=Raleway&display=swap' rel='stylesheet'>
        <body style ='font-family: Raleway, Arial, Helvetica, sans-serif;'>    
        <div style='border-radius:2rem; margin:.5rem; box-shadow: 10px 10px 10px #888888;'>
            <h1 style ='border-radius: 2rem 2rem 0 0; padding: 1rem;background-color: #26A69A; color:white'>Verificación de Correo - Mercurio</h1>
            <div style='padding: 0 1rem .5rem 1rem;'>
                <p style='margin-top: 0; text-align: justify;'>Felicitaciones por parte del equipo de Mercurio por haberte unido a nuestra comunidad!</p>
                <p style='text-align: justify;'>Estimad@ nombre apellido, para completar su registro debes registrar el siguiente código:</p>   
                <center>
                    <h1 style ='color: #26A69A;'>0059</h1>
                </center>
                <p>
                    O mediante el siguiente link 
                    <a href='' style ='text-decoration:none; color: #26A69A;'>
                        <b> Verificar Correo </b>
                    </a>
                </p>
            </div>
        </div>
    </body>";

    $to_email = "darkmyes@gmail.com";
    $subject = 'Registro Mercurio';
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';
    $headers[] = 'From: Bryan JPV <bryanjpv@feslecorp.com>';

    mail($to_email, $subject, $message, implode("\r\n", $headers));
?>