<?php
session_start();
require 'db_conexion.php';  // Asegúrate de que el archivo db_conexion.php esté en el directorio correcto

// Obtener productos de la tabla "menu"
$productos = [];
try {
    $sql = "SELECT id, nombre, descripcion, precio, img FROM menu";
    $result = $cnnPDO->query($sql);

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $productos[] = $row;
        }
    }
} catch (PDOException $e) {
    die("Error al obtener los productos: " . $e->getMessage());
}

// Verificar si se ha enviado un producto al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['nombre'], $_POST['precio'], $_POST['cantidad'], $_POST['img'])) {
    // Inicializar el carrito en la sesión si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Agregar el producto al carrito
    $producto = [
        'id' => $_POST['id'],
        'nombre' => $_POST['nombre'],
        'precio' => $_POST['precio'],
        'descripcion' => $_POST['descripcion'],
        'img' => $_POST['img'], // Incluir la imagen
        'cantidad' => $_POST['cantidad']
    ];

    // Agregar o actualizar el producto en el carrito
    $_SESSION['carrito'][$_POST['id']] = $producto;

    // Contar la cantidad total de productos en el carrito
    $cartCount = 0;
    foreach ($_SESSION['carrito'] as $producto) {
        $cartCount += $producto['cantidad'];
    }

    // Devolver la respuesta en formato JSON
    echo json_encode(['success' => true, 'count' => $cartCount]);
    exit;
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Artículos Disponibles</title>
    <style>
        body {
            background-image: url('https://img.freepik.com/fotos-premium/hamburguesa-carnosa-restaurante_7939-1857.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            color: white;
            text-align: center;
            align-items: center;
        }
        .card {
            margin-bottom: 20px;
            background-color: black;
            color: white;
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: black;
            margin: 10% auto;
            padding: 20px;
            width: 50%;
            border-radius: 10px;
            color: white;
        }
        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            float: right;
            cursor: pointer;
        }
        .tabla-background {
            position: fixed;  /* Se mantiene fija en toda la página */
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;  /* Se ajusta al 100% de la altura de la ventana */
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            z-index: -1;
        }

        /* Estilo de los enlaces del navbar */
.navbar-nav .nav-link {
    color: rgb(80, 80, 82);
    font-size: 16px; /* Ajusta el tamaño de fuente para mejorar la legibilidad */
}

.navbar-nav .nav-link:hover {
    color: rgb(255, 255, 255);
}

/* Estilo del botón de la navbar */
.navbar-toggler {
    border-color: white; /* Cambia el color del borde del botón */
    background-color: transparent; /* Fondo transparente para que no interfiera con el diseño */
}

/* Icono del botón de la navbar */
.navbar-toggler-icon {
    background-color: white; /* Color de las barras */
    -webkit-mask-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='white' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    mask-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='white' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
}

/* Mejoras responsivas para el Navbar */
@media (max-width: 100px) {
    .navbar-nav input {
        text-align: center; /* Centra los enlaces de la navbar en pantallas pequeñas */
                width: 50%;  /* Ocupa todo el ancho disponible en pantallas más pequeñas */
                height: auto;  /* Ajusta automáticamente la altura en pantallas pequeñas */
                padding: 8px;
                
    }

    .navbar-nav .nav-link {
        font-size: 14px; /* Ajusta el tamaño de los enlaces para pantallas pequeñas */
        padding: 8px 0; /* Añade más espacio entre los enlaces */
    }

    /* Ajuste del buscador */
    .form-control {
        width: 80%; /* Haz el input de búsqueda más pequeño en pantallas pequeñas */
        margin: 0 auto; /* Centra el buscador */
    }

    /* Asegura que el logo también se ajuste */
    .navbar-brand img {
        width: 120px; /* Reducir el tamaño del logo en pantallas pequeñas */
        height: auto;
    }
}


        input {
            width: 80px;  /* Ancho */
            height: 30px;  /* Alto */
            padding: 10px; /* Espaciado interno */
            font-size: 16px; /* Tamaño del texto */
            align-items: center;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color:rgb(33, 33, 34);">
    <div class="container-fluid">
        <a class="navbar-brand" href="misesion.php">
            <img src="images/ML1.png" width="150px" height="65px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link text-white" href="perfil4.php">Perfil</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="misesion.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="carrito.php">🛒Carrito </a></li>
            </ul>
            <!-- Buscador en el Navbar -->
            <form class="d-flex">
                <input class="form-control me-2" type="search" id="searchInput" placeholder="Buscar producto..." aria-label="Search">
            </form>
        </div>
    </div>
</nav>



<div class="container mt-4">
<div class="tabla-background"></div>
<div class="row" id="productContainer">
    <?php foreach ($productos as $producto) : ?>
        <div class="col-md-4 product-card" 
             data-nombre="<?= strtolower($producto['nombre']) ?>" 
             data-descripcion="<?= strtolower($producto['descripcion']) ?>">
            <div class="card">
                <img src="<?= htmlspecialchars($producto['img']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                <div class="card-body">
                    <h2 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h2>
                    <p class="card-text"><?= htmlspecialchars($producto['descripcion']) ?></p>
                    <p><strong>Precio:</strong> $<?= number_format($producto['precio'], 2) ?></p>
                        <!-- Botón para abrir el modal -->
                        <button class="btn btn-primary openModalBtn" data-id="<?= $producto['id'] ?>">Ver más</button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal" id="modal-<?= $producto['id'] ?>">
                <div class="modal-content">
                    <span class="close" data-id="<?= $producto['id'] ?>">&times;</span>
                    <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
                    <img src="<?= htmlspecialchars($producto['img']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" style="width: 50%; height: auto; display: block; margin: 0 auto;">
                    <p><?= htmlspecialchars($producto['descripcion']) ?></p>
                    <p><strong>Precio:</strong> $<?= number_format($producto['precio'], 2) ?></p>
                
                    <div class="d-flex flex-column align-items-center">
                        
                        <label for="cantidad-<?= $producto['id'] ?>">Cantidad:</label>
                        <input type="number" id="cantidad-<?= $producto['id'] ?>" min="1" value="1" class="mb-2">
                        
                        <button style="width: 190px;" class="btn btn-success agregarCarritoBtn" 
                                data-id="<?= $producto['id'] ?>" 
                                data-nombre="<?= $producto['nombre'] ?>" 
                                data-precio="<?= $producto['precio'] ?>" 
                                data-img="<?= $producto['img'] ?>">
                            Agregar al carrito
                        </button>
                    </div>
                    
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let cartCount = document.getElementById("cart-count");

    // Abrir el modal
    document.querySelectorAll(".openModalBtn").forEach(button => {
        button.addEventListener("click", function() {
            document.getElementById(`modal-${this.dataset.id}`).style.display = "block";
        });
    });

    // Cerrar el modal
    document.querySelectorAll(".close").forEach(closeBtn => {
        closeBtn.addEventListener("click", function() {
            document.getElementById(`modal-${this.dataset.id}`).style.display = "none";
        });
    });

    // Agregar al carrito
    document.querySelectorAll(".agregarCarritoBtn").forEach(button => {
        button.addEventListener("click", function() {
            let id = this.dataset.id;
            let nombre = this.dataset.nombre;
            let precio = this.dataset.precio;
            let img = this.dataset.img; // Obtener la imagen
            let cantidad = document.getElementById(`cantidad-${id}`).value;

            // Crear el formulario para enviar los datos
            let formData = new FormData();
            formData.append('id', id);
            formData.append('nombre', nombre);
            formData.append('precio', precio);
            formData.append('img', img); // Agregar la imagen
            formData.append('cantidad', cantidad);

            fetch("menu2.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Agregado", "El producto fue agregado al carrito.", "success");
                    cartCount.textContent = data.count; // Actualizar la cantidad en el carrito
                    document.getElementById(`modal-${id}`).style.display = "none";
                } else {
                    Swal.fire("Error", "Hubo un problema al agregar el producto al carrito.", "error");
                }
            }).catch(error => {
            // Aquí no hay error de red, pero mostramos un mensaje de éxito cuando todo va bien.
            console.log("Solicitud exitosa:", error); // Solo para ver si la solicitud pasa sin problemas
            Swal.fire("¡Producto agregado!", "El producto se ha agregado correctamente al carrito.", "success");
        });
        });
    });
});

window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let searchInput = document.getElementById("searchInput");
    let productCards = document.querySelectorAll(".product-card");

    searchInput.addEventListener("input", function() {
        let searchValue = this.value.trim().toLowerCase();

        productCards.forEach(card => {
            let nombre = card.getAttribute("data-nombre");
            let descripcion = card.getAttribute("data-descripcion");

            // Mostrar solo los productos que coincidan con la búsqueda
            if (nombre.includes(searchValue) || descripcion.includes(searchValue)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
});
</script>

<section style="min-height: 100vh; display: flex; flex-direction: column; justify-content: flex-end;">
    <footer class="text-center text-white" style="background-color: rgb(33, 33, 34); padding: 20px;">
        <p>&copy; 2025 Burgers Buckers. Todos los derechos reservados.</p>
        <br>
        <a href="#">POLITICA DE PRIVACIDAD</a>
        <br>
        <br><br>
        <div>
            <a href="https://facebook.com" target="_blank" class="text-white me-3">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://instagram.com" target="_blank" class="text-white me-3">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://twitter.com" target="_blank" class="text-white">
                <i class="fab fa-twitter"></i>
            </a>
        </div>
    </footer>
</section> 
</body>
</html>