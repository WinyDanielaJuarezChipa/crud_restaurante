<?php
    require_once __DIR__ .'/../config/database.php';

    function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }
    
    function formatDate($date) {
        if ($date instanceof DateTime) {
            return $date->format('Y-m-d');
        } else {
            // Handle invalid input, e.g., return an empty string or a default date
            return 'Invalid Date';
        }
    }

    function crearProducto($modelo, $descripcion, $precio, $fechaEntrega,) {
        global $db;
        $collection = $db->productos;
        try {
            $resultado = $collection->insertOne([
                'modelo' => sanitizeInput($modelo),
                'descripcion' => sanitizeInput($descripcion),
                'precio' => sanitizeInput($precio),
                'fechaEntrega' => new MongoDB\BSON\UTCDateTime(strtotime($fechaEntrega) * 1000),
                'entregado' => false
            ]);

            return $resultado->getInsertedId();
        } catch (Exception $e) {
            echo "Error al crear el producto: " . $e->getMessage();
            return false;
        }
    }
    
    function obtenerProductos() {
        global $db;
        $collection = $db->productos;
        try {
            $productos = $collection->find();
            return $productos;
        } catch (Exception $e) {
            echo "Error al obtener productos: " . $e->getMessage();
            return []; // Retornar un array vacío en caso de error
        }
    }
    
    function obtenerProductoPorId($id) {
        global $tasksCollection;
        return $tasksCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    }
    
    function actualizarProducto($id, $modelo, $descripcion, $precio, $fechaEntrega, $entregado) {
        global $db;
        $collection = $db->productos;
    
        try {
            $result = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)],
                ['$set' => [
                'modelo' => sanitizeInput($modelo),
                'descripcion' => sanitizeInput($descripcion),
                'precio' => sanitizeInput($precio),
                'fechaEntrega' => new MongoDB\BSON\UTCDateTime(strtotime($fechaEntrega) * 1000),
                'entregado' => $entregado
                ]]
            );
    
            return $result->getModifiedCount();
        } catch (Exception $e) {
            echo "Error al actualizar el producto: " . $e->getMessage();
            return false;
        }
    }

    function eliminarProducto($id) {
        global $db;
        $collection = $db->productos;
    
        try {
            $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        } catch (Exception $e) {
            echo "Error al eliminar el producto: " . $e->getMessage();
            return false;
        }
    }

    function toggleProductoEntregado($id) {
        global $db;
        $collection = $db->productos;
    
        $producto = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    
        if ($producto && isset($producto['entregado'])) {
            $nuevoEstado = !$producto['entregado'];
        }
    }
    
?>