<?php
require_once 'config/Database.php';
require_once 'models/Estudiante.php';
require_once 'controllers/EstudianteController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    try {
        $database   = new Database();
        $db         = $database->getConnection();
        $model      = new Estudiante($db);
        $controller = new EstudianteController($model);

        $action = $_POST['action'] ?? '';
        $id     = (int)($_POST['id'] ?? 0);

        switch ($action) {
            case 'listar':     $respuesta = $controller->listar();            break;
            case 'obtener':    $respuesta = $controller->obtener($id);        break;
            case 'guardar':    $respuesta = $controller->guardar($_POST);     break;
            case 'actualizar': $respuesta = $controller->actualizar($_POST);  break;
            case 'eliminar':   $respuesta = $controller->eliminar($id);       break;
            default:           $respuesta = ['success' => false, 'message' => 'Accion no valida'];
        }
    } catch (Throwable $e) {
        $respuesta = ['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()];
    }
    echo json_encode($respuesta);
    exit;
}

require 'views/estudiantes/index.php';
