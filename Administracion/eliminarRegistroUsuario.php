<?php
include_once("../Conexion/conexion.php");

if(isset($_POST['idUsuario'])){

    $idUsuario = $_POST['idUsuario'];
    $usuario = $_POST['u'];
$consulta = "UPDATE usuario SET
                id_estado_usuario_fk = 2
                WHERE id_usuario = $idUsuario";

$accion = mysqli_query($conexion,$consulta);

    if($accion){
        Header("Location: index.php?r=3&u=" . $usuario);
    }
    else{
        Header("Location: index.php?r=0&u=" . $usuario);
        mysqli_close($conexion);
    }
}
else{
    $idUsuario = null;
}
?>