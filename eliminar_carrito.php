<?php
session_start();

// Verificar si se ha enviado el ID del producto a eliminar
if (isset($_GET['producto_id'])) {
    $producto_id = $_GET['producto_id'];

    // Verificar si el producto existe en el carrito
    if (isset($_SESSION['carrito'][$producto_id])) {
        // Eliminar el producto del carrito
        unset($_SESSION['carrito'][$producto_id]);

        // Redirigir de vuelta al carrito con un mensaje de éxito
        $_SESSION['mensaje'] = "Producto eliminado del carrito correctamente.";
    } else {
        // Redirigir de vuelta al carrito con un mensaje de error
        $_SESSION['mensaje'] = "El producto no existe en el carrito.";
    }
} else {
    // Redirigir de vuelta al carrito con un mensaje de error
    $_SESSION['mensaje'] = "No se ha especificado un producto para eliminar.";
}

header("Location: carrito.php");
exit();
?>