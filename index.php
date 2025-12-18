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
//leo usuarios
$stmt = $conn->prepare(query: "SELECT * FROM usuarios");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$usuarios = array();
foreach ($result as $row) {
    require_once "models/Usuario.php";
    $usuario = new Usuario($row['usuarios_id'], $row['nombre'], $row['email'], $row['password'], $row['avatar']);
    $usuarios[] = $usuario;
}

//leo votos
$stmt = $conn->prepare(query: "SELECT * FROM votos");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Recorro las fotos y les agrego los votos
foreach ($fotos as $foto) {
    foreach ($result as $row) {
        if ($row['fotos_id'] == $foto->getFoto_id()) {
            //buscar el usuario correspondiente
            foreach ($usuarios as $usuario) {
                if ($usuario->getUsuario_id() == $row['usuarios_id']) {
                    $foto->agregarVoto($usuario);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Fotos</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <h1>Galería de Fotos</h1>
    <div class="container mt-4">
        <div class="row">
            <?php foreach ($fotos as $foto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="/formacombook<?php echo $foto->getRuta(); ?>"
                            class="card-img-top"
                            alt="<?php echo htmlspecialchars($foto->getTitulo()); ?>">

                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($foto->getTitulo()); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($foto->getDescripcion()); ?></p>

                            <!-- Botón que abre el modal -->
                            <button class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#modalVotos<?php echo $foto->getFoto_id(); ?>">
                                Votos: <?php echo $foto->getVotosCount(); ?>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal con la lista de usuarios que votaron -->
                <div class="modal fade" id="modalVotos<?php echo $foto->getFoto_id(); ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Usuarios que votaron: <?php echo htmlspecialchars($foto->getTitulo()); ?>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <?php if ($foto->getVotosCount() > 0): ?>
                                    <ul class="list-group">
                                        <?php foreach ($foto->getVotos() as $usuario): ?>
                                            <li class="list-group-item">
                                                <strong><?php echo $usuario->getNombre(); ?></strong>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-muted">Nadie ha votado esta foto todavía.</p>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>