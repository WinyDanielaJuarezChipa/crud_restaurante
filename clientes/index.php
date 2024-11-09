<?php
// 1. Incluir conexión a la base de datos
require_once '../config/database.php';

// 2. Función para obtener todos los clientes
function obtenerClientes() {
    global $db;
    return $db->clientes->find([], ['sort' => ['nombre' => 1]]);
}

// 3. Función para eliminar cliente
if (isset($_POST['eliminar'])) {
    $id = new MongoDB\BSON\ObjectId($_POST['id']);
    $db->clientes->deleteOne(['_id' => $id]);
    header('Location: index.php');
    exit;
}

// 4. Obtener lista de clientes
$clientes = obtenerClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="public/styles.css">
    <!-- Bootstrap CSS -->
    <link href="<https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css>" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h2>Lista de Clientes</h2>
                <!-- Botón Añadir Nuevo -->
                <a href="editar.php" class="btn btn-primary mb-3">
                    Añadir Nuevo Cliente
                </a>

                <!-- Tabla de Clientes -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente->nombre); ?></td>
                            <td><?php echo htmlspecialchars($cliente->correo); ?></td>
                            <td><?php echo htmlspecialchars($cliente->telefono); ?></td>
                            <td><?php echo htmlspecialchars($cliente->direccion); ?></td>
                            <td>
                                <!-- Botones de acción -->
                                <a href="editar.php?id=<?php echo $cliente->_id; ?>"
                                   class="btn btn-sm btn-warning">
                                    Editar
                                </a>

                                <form action="" method="POST" style="display: inline;">
                                    <input type="hidden" name="id"
                                           value="<?php echo $cliente->_id; ?>">
                                    <button type="submit" name="eliminar"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Estás seguro?');">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="<https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js>"></script>
</body>
</html>
