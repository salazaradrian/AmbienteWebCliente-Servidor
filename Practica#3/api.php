<?php
/**
 * PROYECTO: Mini Sistema de Gestión de Tareas (To-Do List)
 * ROL: Integrante 1 - Backend & API (PHP + Sessions)
 */

// 1. Configuración de Seguridad y Manejador de Errores (Req. 2.5)
header('Content-Type: application/json'); // Siempre responderemos en JSON

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "exito" => false,
        "mensaje" => "Método no permitido."
    ]);
    exit;
}

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("Error: [$errno] $errstr en $errfile:$errline");
    echo json_encode([
        "exito" => false, 
        "mensaje" => "Error interno del servidor."
    ]);
    exit;
});

// 2. Gestión de Sesión (Req. 3 - Almacenamiento)
session_start();

// Inicializar el arreglo de tareas si no existe en la sesión
if (!isset($_SESSION['tareas']) || !is_array($_SESSION['tareas'])) {
    $_SESSION['tareas'] = [];
}

// Función auxiliar para encontrar el índice de una tarea por ID
function findTaskIndex($tasks, $id) {
    foreach ($tasks as $index => $task) {
        if (isset($task['id']) && $task['id'] === $id) {
            return $index;
        }
    }
    return -1;
}

// 3. Captura de la petición
// Aceptamos la acción por POST (según Req. 5)
$accion = isset($_POST['accion']) ? trim($_POST['accion']) : '';
$respuesta = ["exito" => false, "tareas" => []];

try {
    switch ($accion) {
        case 'listar':
            $respuesta["exito"] = true;
            $respuesta["tareas"] = $_SESSION['tareas'];
            break;

        case 'agregar':
            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            
            // Validación en servidor (Req. 2.5)
            if (empty($nombre) || strlen($nombre) > 100) {
                $respuesta["mensaje"] = "El nombre de la tarea es obligatorio.";
            } else {
                // Estructura de datos sugerida (Req. 4) + Seguridad (Req. 3)
                $nuevaTarea = [
                    "id" => uniqid('task_', true),
                    "nombre" => htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'), 
                    "completada" => false
                ];
                $_SESSION['tareas'][] = $nuevaTarea;
                
                $respuesta["exito"] = true;
                $respuesta["tareas"] = $_SESSION['tareas'];
            }
            break;

        case 'completar':
            $id = isset($_POST['id']) ? trim($_POST['id']) : '';
            
            if (empty($id) || !is_string($id)) {
                $respuesta["mensaje"] = "ID de tarea requerido.";
            } else {
                $indice = findTaskIndex($_SESSION['tareas'], $id);
                if ($indice !== -1) {
                    $_SESSION['tareas'][$indice]['completada'] = true;
                    $respuesta["exito"] = true;
                    $respuesta["tareas"] = $_SESSION['tareas'];
                } else {
                    $respuesta["mensaje"] = "ID de tarea no válido.";
                }
            }
            break;

        case 'eliminar':
            $id = isset($_POST['id']) ? trim($_POST['id']) : '';
            
            if (empty($id) || !is_string($id)) {
                $respuesta["mensaje"] = "ID de tarea requerido.";
            } else {
                $indice = findTaskIndex($_SESSION['tareas'], $id);
                if ($indice !== -1) {
                    // Eliminar y re-indexar el arreglo para evitar huecos (Req. 2.4)
                    array_splice($_SESSION['tareas'], $indice, 1);
                    $respuesta["exito"] = true;
                    $respuesta["tareas"] = $_SESSION['tareas'];
                } else {
                    $respuesta["mensaje"] = "ID de tarea no válido.";
                }
            }
            break;

        default:
            $respuesta["mensaje"] = "Acción '" . htmlspecialchars($accion, ENT_QUOTES, 'UTF-8') . "' no reconocida.";
            break;
    }

} catch (Throwable $e) {
    error_log("Excepción: " . $e->getMessage());
    $respuesta["exito"] = false;
    $respuesta["mensaje"] = "Error interno del servidor.";
}

// 4. Respuesta Final (Req. 5)
echo json_encode($respuesta);
exit;
