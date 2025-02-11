<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Registro</title>
    <style>
        body {
            background-image: url('https://img.freepik.com/foto-gratis/closeup-foto-hamburguesa-tocino-queso-taza-cafe-roja_181624-4345.jpg?ga=GA1.1.1240151379.1737325733&semt=ais_hybrid');
            background-repeat: no-repeat;
            background-position: center, center;
            background-attachment: fixed;
            background-size: cover;
            margin: 0;
            color: white;
            text-align: center;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Aseguramos que el body ocupe toda la altura de la ventana */
        }

        .navbar-nav .nav-link {
            color: rgb(80, 80, 82); /* Color del texto de los enlaces */
        }

        .navbar-nav .nav-link:hover {
            color: rgb(255, 255, 255); /* Color del texto cuando pasas el mouse por encima */
        }


        .tabla {
            border: 10px solid white;
            border-collapse: collapse;
            width: 30%;
        }

        .tablaform2 {
            margin-top: 10px;
            width: 90%;
        }

        .php-text {
            font-size: 35px;
        }

        .tablaform2 th, .tablaform2 td {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .btn1 {
            width: 250px;
            height: 65px;
            font-size: 20px;
            margin-top: 130px;
            background-color: rgb(75, 75, 153);
            border: 5px solid rgb(235, 221, 221);
        }

        /* Nuevo CSS para centrar la tabla */
        .tabla-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Ocupa toda la altura de la ventana */
            position: relative;
        }

        /* Fondo difuminado */
        .tabla-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6); /* Fondo oscuro y semitransparente */
            backdrop-filter: blur(10px); /* Aplica el desenfoque */
            z-index: -1; /* Asegura que el fondo esté detrás de la tabla */
        }

        .navbar-toggler {
            border-color: white; /* Cambia el color del borde del botón */
        }

        .navbar-toggler-icon {
            background-color: white; /* Color de las barras */
            -webkit-mask-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='white' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
            mask-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='white' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }
        /* From Uiverse.io by minecrafte_8792 */ 
            button {
            color: #fff;
            padding: 0.7em 1.7em;
            font-size: 18px;
            border-radius: 0.5em;
            background: #212121;
            cursor: pointer;
            border: 1px solid #212121;
            transition: all 0.3s;
            box-shadow:
                6px 6px 12px #0a0a0a,
                -6px -6px 12px #2f2f2f;
            }

            button:active {
            color: #666;
            box-shadow:
                0px 0px 0px #000,
                0px 0px 0px #2f2f2f,
                inset 4px 4px 12px #1a1a1a,
                inset -4px -4px 12px #1f1f1f;
            }

        .loader-container {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .burger-loader {
            width: 80px;
            height: 80px;
            animation: spin 2s infinite linear;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color:rgb(33, 33, 34);">
    <div class="container-fluid">
        <a class="navbar-brand" href="mariano.php">
            <img src="images/ML1.png" width="150px" height="65px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span  class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="registrarse.php">Registrarse</a></li>
                <li class="nav-item"><a class="nav-link" href="iniciar.php">Iniciar Sesión</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="aam.php">Menú</a></li> -->
            </ul>
        </div>
    </div>
</nav>

<div class="loader-container" id="loader">
    <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" class="burger-loader" alt="Cargando...">
</div>

<!-- Contenedor para centrar la tabla -->
<div class="tabla-container">
    <div class="tabla-background"></div>
    <table class="tabla">
        <tr>
            <td>
                <div class="container mt-5" style="padding: 15px;">
                    <h1>REGISTRO</h1>
                    <form id="registroForm" action="" method="post">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Introduce tu nombre">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Introduce tu email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" placeholder="Introduce tu contraseña">
                        </div>
                        <br>
                        
                        <div class="mb-3">
                            <div class="g-recaptcha" data-sitekey="6LdVGr4qAAAAAPNRRWpr1463g2SdPTPFMu3cWVGG"></div>
                        </div>

                        <button id="registrarBtn" type="submit" name="registrar" >Registrar</button>
                    </form>
                    <br>
                    <button><a href="iniciar.php" style="color: white; text-decoration: none;">Iniciar sesión</a></button>
                </div>
            </td>
        </tr>
    </table>
</div>

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
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("registroForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Evita el envío inmediato
            document.getElementById("loader").style.display = "flex"; // Muestra el loader
            document.getElementById("registrarBtn").disabled = true; // Deshabilita el botón para evitar doble envío
            
            // Simulación de tiempo de procesamiento antes de enviar el formulario
            setTimeout(() => {
                this.submit(); // Envía el formulario después del efecto de carga
            }, 2000);
        });
    });
</script>

<footer class="text-center text-white" style="background-color: rgb(33, 33, 34); padding: 20px;">
    <p>&copy; 2025 Burgers Buckers. Todos los derechos reservados.</p>
    <br>
    <a class="navbar-brand" href="polpriv.html">POLITICA DE PRIVACIDAD</a>
    <br>
    <br><br>
    <!-- From Uiverse.io by david-mohseni --> 
    <ul class="wrapper">
  <label class="icon facebook">
    <a class="navbar-brand" href="https://www.facebook.com/profile.php?id=100022291620191" target="_blank">
      <span class="tooltip">Facebook</span>
      <svg
        viewBox="0 0 320 512"
        height="1.2em"
        fill="currentColor"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
        ></path>
      </svg>
    </a>
  </label>
  <label class="icon instagram">
    <a class="navbar-brand" href="https://www.instagram.com/animecrex/" target="_blank">
      <span class="tooltip">Instagram</span>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        height="1.2em"
        fill="currentColor"
        class="bi bi-instagram"
        viewBox="0 0 16 16"
      >
        <path
          d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"
        ></path>
      </svg>
    </a>
  </label>
</ul>


</footer>
</body>
</html>
