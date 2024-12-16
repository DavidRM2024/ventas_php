<?php

require_once '../controllers/AuthController.php';

class AuthMiddleware
{

    public static function protect($db)
    {
        // Obtener encabezados de manera universal
        $headers = getallheaders();

        // Verificar si existe el token de autorización
        if (!isset($headers['Authorization'])) {
            http_response_code(401); // Código de error para autorización faltante
            echo json_encode(['success' => false, 'message' => 'Authorization token required.']);
            exit;
        }

        // Extraer el token del encabezado Authorization
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        // Instanciar el controlador de autenticación
        $authController = new AuthController();

        // Validar el token usando el controlador
        $validation = $authController->validateToken($token, $db);

        // Si el token no es válido, devolver una respuesta y finalizar la ejecución
        if (!$validation['success']) {
            http_response_code(401); // Código de error para token inválido
            echo json_encode($validation);
            exit;
        }

        // Retornar el ID del usuario autenticado
        return $validation['user_id'];
    }
}
