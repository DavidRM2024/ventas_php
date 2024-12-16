<?php

require_once '../config/database.php';
require_once '../models/User.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/ProductoController.php';
require_once '../controllers/CategoriaController.php';
require_once '../controllers/ProveedorController.php';
require_once '../middleware/AuthMiddleware.php';

$db = (new Database())->getConnection();
$authController = new AuthController();
$productoController = new ProductoController();
$categoriaController = new CategoriaController();
$proveedorContoller = new ProveedorController();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}


if ($_GET['action'] === 'validate_token') {
    // Proteger la ruta utilizando AuthMiddleware
    $user_id = AuthMiddleware::protect($db);

    http_response_code(200);
    echo json_encode(['message' => 'Token válido']);
    exit;
}



// Manejo de rutas basadas en el método HTTP y la acción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Ruta para login (sin autenticación requerida)
    if ($_GET['action'] === 'login') {
        $response = $authController->login($data['email'], $data['password'], $db);
        echo json_encode($response);
        exit;
    }

    // Ruta para registro (sin autenticación requerida)
    if ($_GET['action'] === 'register') {
        $response = $authController->register($data['name'], $data['email'], $data['password'], $db);
        echo json_encode($response);
        exit;
    }

    // Ruta para logout (requiere autenticación)
    if ($_GET['action'] === 'logout') {
        // Proteger la ruta utilizando AuthMiddleware
        $user_id = AuthMiddleware::protect($db);

        // Obtener el token del encabezado
        $headers = apache_request_headers();
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        // Lógica para registrar el token en la lista negra
        $response = $authController->logout($token, $db);
        echo json_encode($response);
        exit;
    }


     // Ruta para listar categorias (requiere autenticación)
     if ($_GET['action'] === 'categoria_index') {
        // Proteger la ruta utilizando AuthMiddleware
        $user_id = AuthMiddleware::protect($db);

        // Obtener el token del encabezado
        $headers = apache_request_headers();
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        // Lógica para extraer todos los productos
        $response = $categoriaController->index($db);
        echo json_encode($response);
        exit;
    }

    // Ruta para listar proveedores (requiere autenticación)
    if ($_GET['action'] === 'proveedor_index') {
        // Proteger la ruta utilizando AuthMiddleware
        $user_id = AuthMiddleware::protect($db);

        // Obtener el token del encabezado
        $headers = apache_request_headers();
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        // Lógica para extraer todos los productos
        $response = $proveedorContoller->index($db);
        echo json_encode($response);
        exit;
    }

    // Ruta para listar productos (requiere autenticación)
    if ($_GET['action'] === 'producto_index') {
        // Proteger la ruta utilizando AuthMiddleware
        $user_id = AuthMiddleware::protect($db);

        // Obtener el token del encabezado
        $headers = apache_request_headers();
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        // Lógica para extraer todos los productos
        $response = $productoController->index($db);
        echo json_encode($response);
        exit;
    }

    if ($_GET['action'] === 'producto_show' && isset($_GET['id'])) {
        // Proteger la ruta utilizando AuthMiddleware
        $user_id = AuthMiddleware::protect($db);

        // Obtener el token del encabezado
        $headers = apache_request_headers();
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        // Lógica para extraer todos los productos
        $response = $productoController->show($_GET['id'], $db);
        echo json_encode($response);
        exit;
    }


    if ($_GET['action'] === 'producto_store') {
        // Proteger la ruta utilizando AuthMiddleware
        $user_id = AuthMiddleware::protect($db);

        // Obtener el token del encabezado
        $headers = apache_request_headers();
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        $data = json_decode(file_get_contents('php://input'), true);

        // Lógica para extraer todos los productos
        $response = $productoController->store($data, $db);
        echo json_encode($response);
        exit;
    }

    if ($_GET['action'] === 'producto_update'  && isset($_GET['id'])) {
        // Proteger la ruta utilizando AuthMiddleware
        $user_id = AuthMiddleware::protect($db);

        // Obtener el token del encabezado
        $headers = apache_request_headers();
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        $data = json_decode(file_get_contents('php://input'), true);

        // Lógica para extraer todos los productos
        $response = $productoController->update($_GET['id'], $data, $db);
        echo json_encode($response);
        exit;
    }


    if ($_GET['action'] === 'producto_delete'  && isset($_GET['id'])) {
        // Proteger la ruta utilizando AuthMiddleware
        $user_id = AuthMiddleware::protect($db);

        // Obtener el token del encabezado
        $headers = apache_request_headers();
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        $data = json_decode(file_get_contents('php://input'), true);

        // Lógica para extraer todos los productos
        $response = $productoController->delete($_GET['id'], $db);
        echo json_encode($response);
        exit;
    }
}

// Si no se encuentra ninguna acción válida, devolver un mensaje de error
http_response_code(404);
echo json_encode(['success' => false, 'message' => 'Invalid action or method.']);
exit;
