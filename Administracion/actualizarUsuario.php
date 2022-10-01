<?php
include_once("../Conexion/conexion.php");
$idUsuario = $_GET['codigo'];
$consulta = "SELECT x.id_usuario, 
                    x.nombre_usuario, 
                    x.apellido_usuario, 
                    x.telefono_usuario, 
                    x.correo_usuario,
                    x.nick_name_usuario,
                    x.id_tipo_usuario_fk,
                    y.nombre_tipo_usuario 
                    FROM usuario x 
                    INNER JOIN tipo_usuario y 
                    ON x.id_tipo_usuario_fk = y.id_tipo_usuario 
                    WHERE x.id_estado_usuario_fk = 1
                                AND x.id_usuario = $idUsuario";
$accion = mysqli_query($conexion, $consulta);
// if (!$accion) {
//     printf("Error: %s\n", mysqli_error($conexion));
//     exit();
// }
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
                <?php
                if (isset($_GET['r']) && $_GET['r'] == '0') {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Succes!</strong> La Contraseña no es la misma, intente de nuevo.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
                <div class="card">
                    <div class="card-header bg-warning">
                        Actualizar Usuario
                    </div>
                    <form action="actualizarUsuario.php" method="POST" class="p-4">
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
                            <input type="password" class="form-control" name="passwordUsuario" placeholder="Agregue una Contraseña" value="1" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="rectificarPasswordUsuario" placeholder="Repita la Contraseña" value="1" autofocus>
                        </div>

                        <div class="d-grid">
                            <input type="submit" class="btn btn-warning" value="Actualizar Usuario">
                        </div>
                        <br>
                        <div class="d-grid">
                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
</body>
</html>

<?php
include_once("../Conexion/conexion.php");


if (
    isset($_POST['nombreUsuario']) && isset($_POST['apellidoUsuario']) && isset($_POST['telefonoUsuario'])
    && isset($_POST['correoUsuario']) && isset($_POST['nickName']) && isset($_POST['passwordUsuario']) && isset($_POST['rectificarPasswordUsuario'])
) {

    $idUsuario = $_POST['idUsuario'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $apellidoUsuario = $_POST['apellidoUsuario'];
    $telefonoUsuario = $_POST['telefonoUsuario'];
    $correoUsuario = $_POST['correoUsuario'];
    $nickNameUsuario = $_POST['nickName'];
    $passwordUsuario = $_POST['passwordUsuario'];
    $idTipoUsuario = 1;
    $fechaActualizacion = date('Y/m/d', time()); //Validar con zona horaria
    $rectificarPassUsuario = $_POST['rectificarPasswordUsuario'];

    if ($passwordUsuario === $rectificarPassUsuario) {
        $consulta = "UPDATE usuario SET nombre_usuario = '$nombreUsuario',
                apellido_usuario = '$apellidoUsuario',
                telefono_usuario = '$telefonoUsuario',
                correo_usuario = '$correoUsuario',
                nick_name_usuario = '$nickNameUsuario',
                password_usuario = '$passwordUsuario',
                fecha_actualizado_usuario = '$fechaActualizacion',
                id_tipo_usuario_fk = $idTipoUsuario WHERE id_usuario = $idUsuario";

        $accion = mysqli_query($conexion, $consulta);

        if ($accion) {
            Header("Location: index.php?r=2");
        } else {
            Header("Location: index.php?r=0");
            mysqli_close($conexion);
        }
    } else {
        Header("Location: actualizarUsuario.php?r=0");
        //mysqli_close($conexion);
    }
} else {
    $idUsuario = null;
    $nombreUsuario = null;
    $apellidoUsuario = null;
    $telefonoUsuario = null;
    $correoUsuario = null;
    $nickNameUsuario = null;
    $passwordUsuario = null;
    $rectificarPassUsuario = null;
    $idTipoUsuario = null;
}
?>