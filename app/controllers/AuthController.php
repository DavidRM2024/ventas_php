<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/User.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController
{

    private $secret_key = "app_ventas_php";

    public function login($email, $password, $db)
    {
        $user = new User($db);
        $found_user = $user->findByEmail($email);

        if ($found_user && password_verify($password, $found_user['password'])) {
            $payload = [
                'iss' => "auth_api",
                'sub' => $found_user['id'],
                'iat' => time(),
                'exp' => time() + (60 * 60) // 1 hora
            ];

            $jwt = JWT::encode($payload, $this->secret_key, 'HS256');
            return ['success' => true, 'token' => $jwt];
        }

        return ['success' => false, 'message' => 'Invalid credentials.'];
    }

    public function register($name, $email, $password, $db)
    {
        $user = new User($db);
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;

        if ($user->create()) {
            return ['success' => true, 'message' => 'User registered successfully.'];
        }

        return ['success' => false, 'message' => 'Registration failed.'];
    }

    public function validateToken($token, $db)
    {
        try {

            // Verificar si el token está en la lista negra
            $stmt = $db->prepare("SELECT * FROM token_blacklist WHERE token like :token AND user_id = :user_id");
            $stmt->bindParam(':token', $token);
            $decoded = JWT::decode($token, new Key($this->secret_key, 'HS256'));

            $stmt->bindParam(':user_id', $decoded->sub);
            $stmt->execute();

            if ($stmt->fetch()) {
                return ['success' => false, 'message' => 'Invalid Token.'];
            }
            
            return ['success' => true, 'user_id' => $decoded->sub];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Invalid token.'];
        }
    }

    public function logout($token, $db)
    {
        try {
            // Decodificar el token para obtener el ID del usuario
            $decoded = JWT::decode($token, new Key($this->secret_key, 'HS256'));

            // Opcional: almacenar el token en una lista negra en la base de datos
            $query = "INSERT INTO token_blacklist (token, user_id, exp) VALUES (:token, :user_id, :exp)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':user_id', $decoded->sub);
            $stmt->bindParam(':exp', $decoded->exp);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Logout successful.'];
            }

            return ['success' => false, 'message' => 'Failed to revoke token.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Invalid token.'];
        }
    }
}
