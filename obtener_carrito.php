<?php
session_start();

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo json_encode([]);
    exit;
}

echo json_encode($_SESSION['carrito']);
?>