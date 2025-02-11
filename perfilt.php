<?php
session_start();
require 'db_conexion.php';

// Inicio de sesión
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validación de datos
    if (!empty($email) && !empty($password)) {
        $select = $cnnPDO->prepare('SELECT * FROM usuarios WHERE email = ?');
        $select->execute([$email]);
        $usuario = $select->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            session_regenerate_id(true);
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['email'] = $usuario['email'];
            header('location: perfil.php');
            exit();
        } else {
            $_SESSION['mensaje'] = "error|Error|Credenciales incorrectas";
            header('location: ison.php');
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "warning|Advertencia|Por favor, completa todos los campos";
        header('location: ison.php');
        exit();
    }
}

// Cambiar la contraseña (en cambiar_password.php)
if (isset($_POST['current_password'], $_POST['new_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    // Consultar la base de datos para obtener el usuario actual
    $select = $cnnPDO->prepare('SELECT * FROM usuarios WHERE email = ?');
    $select->execute([$_SESSION['email']]);
    $usuario = $select->fetch(PDO::FETCH_ASSOC);

    // Verificar si la contraseña actual es correcta
    if ($usuario && password_verify($current_password, $usuario['password'])) {
        // Si la contraseña es correcta, actualizamos la nueva contraseña
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $update = $cnnPDO->prepare('UPDATE usuarios SET password = ? WHERE email = ?');
        $update->execute([$new_password_hashed, $_SESSION['email']]);

        $_SESSION['mensaje'] = "success|Éxito|Contraseña cambiada con éxito.";
        header('location: perfild.php');
        exit();
    } else {
        $_SESSION['mensaje'] = "error|Error|La contraseña actual es incorrecta.";
        header('location: perfild.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Perfil del Usuario</title>
    <style>
        body {
            background-image: url('images/ba.png');
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
            background-color: white;
            color: green;
            border: 10px solid white;
            border-collapse: collapse;
            width: 40%;
            height: 60%;
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

            input {
                width: 59%; 
            }

            li {
                width: 99%; 
                align-items: center;
            }

    </style>


</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-success fixed-top">
    <a class="navbar-brand" href="tarjetasbelma.php">
            <img src="images/ba.png" height="75px" >
            <strong>Banco Azteca</strong>
    </a>
    <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="sesioniniciada.php" class="nav-link">Regresar</a>
            </li>
            <li>
                <a href="#.php" class="nav-link">Iniciar sesión</a>
            </li>
        </ul>
    </div>
</nav>

<div class="tabla-container">
    <div class="tabla-background"></div>
    <div class="tabla">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>
        <br>
        
            <label class="">Nombre registrado: <?php echo htmlspecialchars($_SESSION['nombre']); ?></label>
            <br>
            <label class="">Email: <?php echo htmlspecialchars($_SESSION['email']); ?></label>
        <br><br>
        
        
        <button style="background-color: red; color: white;">
                <a href="cerrar_sesion.php" style="color: white; text-decoration: none;">Cerrar sesión</a>
            </button>
    </div>
</div>



</body>
</html>
