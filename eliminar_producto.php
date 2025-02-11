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

// Eliminar producto del menú si se envía "delete_id"
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    try {
        $delete_id = $_POST['delete_id'];
        $sql = "DELETE FROM menu WHERE id = :delete_id";
        $stmt = $cnnPDO->prepare($sql);
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
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
    <title>Artículos Disponibles</title>
    <style>
        body {
            background-image: url('https://img.freepik.com/fotos-premium/hamburguesa-carnosa-restaurante_7939-1857.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            color: white;
            text-align: center;
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
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color:rgb(33, 33, 34);">
    <div class="container-fluid">
        <a class="navbar-brand" href="administrador.php">
            <img src="images/ML1.png" width="150px" height="65px">
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link text-white" href="administrador.php">Inicio</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <?php foreach ($productos as $producto) : ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?= htmlspecialchars($producto['img']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                    <div class="card-body">
                        <h2 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h2>
                        <p class="card-text"><?= htmlspecialchars($producto['descripcion']) ?></p>
                        <p><strong>Precio:</strong> $<?= htmlspecialchars($producto['precio']) ?></p>

                        <button class="btn btn-danger eliminarProductoBtn" data-id="<?= $producto['id'] ?>">Eliminar</button>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".eliminarProductoBtn").forEach(button => {
        button.addEventListener("click", function() {
            let id = this.dataset.id?.trim();
            let element = this.closest('.card'); // Obtiene el contenedor de la tarjeta del producto

            if (!id) {
                Swal.fire('Error', 'No se especificó el producto', 'error');
                return;
            }

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Este producto será eliminado de forma permanente!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData();
                    formData.append('delete_id', id);

                    fetch('<?php echo $_SERVER["PHP_SELF"]; ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Eliminado', data.message, 'success');
                            element.remove(); 
                            document.location,assing("eliminar_producto.php"); // Actualiza el contador del carrito
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error("Error en fetch:", error);
                       // Swal.fire('Error', 'Hubo un problema al eliminar el producto', 'error');
                    });
                }
            });
        });
    });

    // Función para actualizar el contador del carrito después de eliminar un producto
    function actualizarCarrito() {
        let cartCountElement = document.getElementById('cart-count');
        let currentCount = parseInt(cartCountElement.textContent, 10);
        cartCountElement.textContent = currentCount - 1; // Resta uno del contador
    }
});
</script>

</body>
</html>
