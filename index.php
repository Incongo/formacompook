<?php

require_once "utils/Database.php";


$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare(query: "SELECT * FROM fotos");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$fotos = array();
foreach ($result as $row) {
    require_once "models/Foto.php";
    $foto = new Foto($row['fotos_id'], $row['titulo'], $row['ruta'], $row['descripcion']);
    $fotos[] = $foto;
}

$stmt = $conn->prepare(query: "SELECT * FROM usuarios");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$usuarios = array();
foreach ($result as $row) {
    require_once "models/Usuario.php";
    $usuario = new Usuario($row['usuarios_id'], $row['nombre'], $row['email'], $row['password'], $row['avatar']);
    $usuarios[] = $usuario;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Fotos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Galería de Fotos</h1>
    <div class="gallery">
        <?php foreach ($fotos as $foto): ?>
            <div class="photo-card">
                <img src="/formacombook<?php echo $foto->getRuta(); ?>" alt="<?php echo htmlspecialchars($foto->getTitulo()); ?>">
                <h2><?php echo htmlspecialchars($foto->getTitulo()); ?></h2>
                <p><?php echo htmlspecialchars($foto->getDescripcion()); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>