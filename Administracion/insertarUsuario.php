<?php
include_once("../Conexion/conexion.php");

$nombreUsuario = $_POST['nombreUsuario'];
$apellidoUsuario = $_POST['apellidoUsuario'];
$telefonoUsuario = $_POST['telefonoUsuario'];
$correoUsuario = $_POST['correoUsuario'];
$nickNameUsuario = $_POST['nickName'];
$passwordUsuario = $_POST['passwordUsuario'];
$rectificarPassUsuario = $_POST['rectificarPasswordUsuario'];
$tipoUsuario = $_POST['tipoUsuario'];
$fechaRegistro = date('Y/m/d', time()); //Validar con zona horaria
$estadoUsuario = 1;
$usuario = $_POST['u'];

if (
    isset($nombreUsuario) && isset($apellidoUsuario) && isset($telefonoUsuario)
    && isset($correoUsuario) && isset($nickNameUsuario) && isset($passwordUsuario)
) {
    if ($passwordUsuario === $rectificarPassUsuario) {
        $consulta = "INSERT INTO usuario 
        (nombre_usuario,
        apellido_usuario,
        telefono_usuario,
        correo_usuario,
        nick_name_usuario,
        password_usuario,
        fecha_ingreso_usuario,
        id_tipo_usuario_fk,
        id_estado_usuario_fk)
    VALUES('$nombreUsuario', '$apellidoUsuario', 
    '$telefonoUsuario', '$correoUsuario', '$nickNameUsuario', '$passwordUsuario',
    '$fechaRegistro', $tipoUsuario, $estadoUsuario)";

        $accion = mysqli_query($conexion, $consulta);

        if ($accion) {
            Header("Location: index.php?r=1&u=" . $usuario);
        } else {
            Header("Location: index.php?r=0&u=" . $usuario);
            mysqli_close($conexion);
        }
    } else {
        Header("Location: index.php?r=4&u=" . $usuario);
        mysqli_close($conexion);
    }
} else {
    Header("Location: index.php?r=0&u=" . $usuario);
    mysqli_close($conexion);
}
