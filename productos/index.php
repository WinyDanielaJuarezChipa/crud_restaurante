<?php
    require_once __DIR__ .'/../includes/functions.php';

    if (isset($_GET['accion']) && isset($_GET['id'])) {
        switch ($_GET['accion']) {
            case 'eliminar':
                $count = eliminarProducto($_GET['id']);
                $mensaje = $count > 0 ? "Pedido eliminado con éxito." : "No se pudo eliminar el Pedido.";
                break;
            case 'toggleEntregado':
                $nuevoEstado = toggleProductoEntregado($_GET['id']);
                if ($nuevoEstado !== null) {
                    $mensaje = $nuevoEstado ? "Pedido marcado como entregado." : "Pedido marcado como no entregado.";
                } else {
                    $mensaje = "No se pudo cambiar el estado de la producto.";
                }
                break;
        }
    }

$productos = obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <link rel="stylesheet" href="public/styles.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Pedidos</h1>

        <a href="agregar.php" class="button">Agregar Nuevo Pedido</a>

        <h2>Lista de Pedidos</h2>
        <table>
            <tr>
                <th>Modelo</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Fecha de Entrega</th>
                <th>Entregado</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['modelo']); ?></td>
                <td><?php echo htmlspecialchars($producto['descripcion'] ??''); ?></td>
                <td><?php echo htmlspecialchars($producto['precio'] ??''); ?></td>
                <td><?php echo formatDate($producto['fechaEntrega'] ??''); ?></td>
                <td>
                    <a href="index.php?accion=toggleEntregado&id=<?php echo $producto['_id']; ?>"
                       class="button <?php echo isset($producto['entregado']) && $producto['entregado'] ? 'entregado' : 'no-entregado'; ?>">
                       <?php echo isset($producto['entregado']) && $producto['entregado'] ? 'Entregado' : 'No Entregado'; ?>
                    </a>
                </td>
                <td class="actions">
                    <a href="editar.php?id=<?php echo $producto['_id']; ?>" class="button">Editar</a>
                <a href="index.php?accion=eliminar&id=<?php echo $producto['_id']; ?>" class="button" onclick="return confirm('¿Estás seguro de que quieres eliminar este Pedido?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>