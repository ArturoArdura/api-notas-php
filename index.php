<?php
header("Content-Type: application/json");
include_once 'config.php';

$metodo = $_SERVER['REQUEST_METHOD'];
$input = file_get_contents("php://input");
$datos = json_decode($input, true);

switch ($metodo) {
    case 'GET':
        $stmt = $conn->prepare("SELECT * FROM notas");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        if (!empty($datos['titulo']) && !empty($datos['contenido'])) {
            $sql = "INSERT INTO notas (titulo, autor, contenido, clasificacion)
                    VALUES (:titulo, :autor, :contenido, :clasificacion)";
            $stmt = $conn->prepare($sql);
            $finalizado = $stmt->execute([
                ':titulo' => $datos['titulo'],
                ':autor' => $datos['autor'],
                ':contenido' => $datos['contenido'],
                ':clasificacion' => $datos['clasificacion']
            ]);
            if ($finalizado) {
                echo json_encode(["mensaje" => "Nota guardada", "id" => $conn->lastInsertId()]);
            } else {
                echo json_encode(["error" => "No se pudo insertar"]);
            }
        } else {
            echo json_encode(["error" => "Faltan datos en el JSON", "recibido" => $datos]);
        }
        break;

    case 'PUT':
        if (!empty($datos['id'])) {
            $sql = "UPDATE notas SET titulo=:titulo, autor=:autor, contenido=:contenido, clasificacion=:clasificacion WHERE id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':id' => $datos['id'],
                ':titulo' => $datos['titulo'],
                ':autor' => $datos['autor'],
                ':contenido' => $datos['contenido'],
                ':clasificacion' => $datos['clasificacion']
            ]);
            echo json_encode(["mensaje" => "Nota actualizada"]);
        }
        break;

    case 'DELETE':
        if (!empty($datos['id'])) {
            $stmt = $conn->prepare("DELETE FROM notas WHERE id = :id");
            $stmt->execute([':id' => $datos['id']]);
            echo json_encode(["mensaje" => "Nota eliminada"]);
        }
        break;
}
?>