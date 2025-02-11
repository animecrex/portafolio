<?php
require 'db_conexion.php'; // Conexión a la base de datos

if (isset($_POST['registrar'])) {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    $ip = $_SERVER['REMOTE_ADDR'];
$captcha = $_POST['g-recaptcha-response'];
$secretkey = "6LdVGr4qAAAAAKB5EPCBa9Ni4UmlflRewuI1i4ze";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'secret' => $secretkey,
    'response' => $captcha,
    'remoteip' => $ip
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$atributos = json_decode($response, true);

if (!$atributos['success']) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error en el registro',
                text: 'El captcha no fue llenado correctamente.',
                confirmButtonText: 'OK'
            });
        </script>";
    exit; // Detenemos la ejecución si el captcha falla
}


    if (!empty($nombre) && !empty($email) && !empty($password)) {
        // Verificar si el correo ya está registrado
        $verificar = $cnnPDO->prepare("SELECT * FROM usuarios WHERE email = :email");
        $verificar->bindParam(':email', $email);
        $verificar->execute();

        if ($verificar->rowCount() > 0) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el registro',
                    text: 'El correo ya está registrado. Usa otro o inicia sesión.',
                    confirmButtonText: 'OK'
                });
            </script>";
        } else {
            // Insertar el nuevo usuario
            $sql = $cnnPDO->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)");
            $sql->bindParam(':nombre', $nombre);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':password', $password);

            if ($sql->execute()) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro exitoso',
                        text: 'Tu cuenta ha sido creada correctamente.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'registrarse.php';
                    });
                </script>";
                $mensaje = "
            <html>
            <head>
                <title>Bienvenido a Buregers Buckers</title>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
                    .container { background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1); }
                    h1 {  padding: 15px; text-align: center; }
                    .content { font-size: 16px; line-height: 1.5; }
                    .footer { text-align: center; margin-top: 20px; font-size: 14px; color: #555; }
                </style>
            </head>
            <body>
                <div class='container'><h1>Buregers Buckers</h1>
                    <p><strong>¡Bienvenido a nuestra familia!</strong></p>
                    <p>Estimado <strong>$nombre</strong>, agradecemos tu registro en nuestra plataforma. <br>
                    espero y se sienta comodo con nosotros</p>
                </div>
                <p class='footer'>&copy; 2025 Buregers Buckers - Todos los derechos reservados.</p>
            </body>
            </html>";
            
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: BurgerBuckers <no-reply@BurgerBuckers.com>' . "\r\n";
            
            mail($email, "Bienvenido a BurgerBuckers", $mensaje, $headers);
            exit();
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en el registro',
                        text: 'Hubo un problema al guardar tus datos.',
                        confirmButtonText: 'Intentar de nuevo'
                    });
                </script>";
            }
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Campos vacíos',
                text: 'Todos los campos son obligatorios.',
                confirmButtonText: 'OK'
            });
        </script>";
        header("location: registrarse.php");
    }
}
?>
