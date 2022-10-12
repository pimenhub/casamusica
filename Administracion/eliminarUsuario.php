<?php
include_once("../Conexion/conexion.php");
$idUsuario = $_GET['codigo'];
$consulta = "SELECT x.id_usuario, 
                    x.nombre_usuario 
            FROM usuario x 
            WHERE x.id_estado_usuario_fk = 1
            AND x.id_usuario = $idUsuario";
$accion = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($accion);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Casa Musica</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-danger">
                        Eliminar Articulo
                    </div>
                    <form action="eliminarRegistroUsuario.php" method="POST" class="p-4">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" name="u" value="<?php echo $_GET['u']?>" autofocus>
                        </div> 
                        <div class="mb-3">
                          <input type="hidden" class="form-control" name="idUsuario" value="<?= $row['id_usuario'] ?>">
                          <p>Esta seguro de que desea eliminar el articulo <b><?= $row['id_usuario'] ?></b> <b><?= $row['nombre_usuario'] ?></b></p>
                        </div>
                        <div class="d-grid">
                            <input type="submit" class="btn btn-danger" value="Eliminar Articulo">
                        </div>
                        <br>
                        <div class="d-grid">
                            <a href="index.php?u=<?php echo $_GET['u']?>" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
</body>
</html>