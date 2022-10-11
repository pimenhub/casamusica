<?php
include_once("../Conexion/conexion.php");
$idUsuario = $_GET['codigo'];
$consulta = "SELECT u.id_usuario, 
                    u.nombre_usuario, 
                    u.apellido_usuario, 
                    u.telefono_usuario, 
                    u.correo_usuario,
                    u.nick_name_usuario,
                    u.id_tipo_usuario_fk,
                    t.nombre_tipo_usuario,
                    u.password_usuario
            FROM usuario u 
            INNER JOIN tipo_usuario t 
            ON u.id_tipo_usuario_fk = t.id_tipo_usuario 
            WHERE u.id_estado_usuario_fk = 1
                                AND u.id_usuario = $idUsuario";
$accion = mysqli_query($conexion, $consulta);
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
                    <div class="card-header bg-warning">
                        Actualizar Usuario
                    </div>
                    <form action="actualizarRegistroUsuario.php" method="POST" class="p-4">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" name="idUsuario" value="<?= $row['id_usuario'] ?>">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nombreUsuario" placeholder="Nombre del Usuario" value="<?= $row['nombre_usuario'] ?>" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="apellidoUsuario" placeholder="Apellido del Usuario" value="<?= $row['apellido_usuario'] ?>" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="telefonoUsuario" placeholder="Telefono del Usuario" value="<?= $row['telefono_usuario'] ?>" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="correoUsuario" placeholder="Correo del Usuario" value="<?= $row['correo_usuario'] ?>" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nickName" placeholder="Nick Name para el Usuario ej. nombre.apellido" value="<?= $row['nick_name_usuario'] ?>" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="passwordUsuario" placeholder="Agregue una Contraseña" value="" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="rectificarPasswordUsuario" placeholder="Repita la Contraseña" value="" autofocus>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="idTipoUsuario">
                                <option value="<?= $row['id_tipo_usuario_fk'] ?>"><?= $row['nombre_tipo_usuario'] ?></option>
                                <?php
                                $idTipoCondicion = $row['id_tipo_usuario_fk'];
                                $queryTipoUsuario = $conexion->query("SELECT id_tipo_usuario, nombre_tipo_usuario FROM tipo_usuario WHERE id_tipo_usuario != $idTipoCondicion");
                                while ($valores = mysqli_fetch_array($queryTipoUsuario)) {
                                    echo '<option value="' . $valores['id_tipo_usuario'] . '">' . $valores['nombre_tipo_usuario'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-grid">
                            <input type="submit" class="btn btn-warning" value="Actualizar Usuario">
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