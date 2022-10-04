<?php
include_once("../Conexion/conexion.php");


if (
    isset($_POST['idUsuario']) && isset($_POST['nombreUsuario']) && isset($_POST['apellidoUsuario']) && isset($_POST['telefonoUsuario'])
    && isset($_POST['correoUsuario']) && isset($_POST['nickName']) && isset($_POST['passwordUsuario']) && isset($_POST['rectificarPasswordUsuario']) && isset($_POST['idTipoUsuario'])
) {

    $idUsuario = $_POST['idUsuario'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $apellidoUsuario = $_POST['apellidoUsuario'];
    $telefonoUsuario = $_POST['telefonoUsuario'];
    $correoUsuario = $_POST['correoUsuario'];
    $nickNameUsuario = $_POST['nickName'];
    $passwordUsuario = $_POST['passwordUsuario'];
    $idTipoUsuario = $_POST['idTipoUsuario'];
    $fechaActualizacion = date('Y/m/d', time()); //Validar con zona horario
    $rectificarPassUsuario = $_POST['rectificarPasswordUsuario'];

    if (!empty($passwordUsuario)) {
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
            Header("Location: index.php?r=4");
            //mysqli_close($conexion);
        }
    } else {
        Header("Location: index.php?r=0");
        mysqli_close($conexion);
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
