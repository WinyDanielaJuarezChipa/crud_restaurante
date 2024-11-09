<?php
require_once __DIR__ . '/../includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = crearProducto($_POST['modelo'], $_POST['descripcion'],$_POST['precio'], $_POST['fechaEntrega']);
    if ($id) {
        header("Location: index.php?mensaje=Pedido creado con éxito");
        exit;
    } else {
        $error = "No se pudo crear el pedido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Pedido</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Nueva Pedido</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>


    <form method="POST">
        <label>Modelo: <input type="text" name="modelo" required></label><br></br>
        <label>Descripción: <textarea name="descripcion" required></textarea></label><br></br>
        <label>Precio: <input type="text" name="precio" required></label><br></br>
        <label>Fecha de Entrega: <input type="date" name="fechaEntrega" required></label><br></br>
    <input type="submit" value="Crear Pedido">
</form>
    <a href="index.php" class="button">Volver a la lista de pedidos</a>
</body>
</html>