<?php
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$pedido = obtenerProductos($_GET['id']);

if (!$pedido) {
    header("Location: index.php?mensaje=Pedido no encontrado");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $count = actualizarProducto($_GET['id'], $_POST['modelo'], $_POST['descripcion'],$_POST['precio'] , $_POST['fechaEntrega'], isset($_POST['completada']));
    if ($count > 0) {
        header("Location: index.php?mensaje=Pedido actualizado con éxito");
        exit;
    } else {
        $error = "No se pudo actualizar el pedido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Producto</h1>

<?php if (isset($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">
    <label>Modelo: <input type="text" name="modelo" value=" " required></label><br></br>
    <label>Descripción: <textarea name="descripcion" required></textarea></label><br></br>
    <label>Precio: <input type="text" name="precio" value=" " required></label><br></br>
    <label>Fecha de Entrega: <input type="date" name="fechaEntrega" value="" required></label><br></br>
    <input type="submit" value="Guardar">
    <a href="index.php" class="button">Cancelar</a>
</form>
</div>
</body>
</html>