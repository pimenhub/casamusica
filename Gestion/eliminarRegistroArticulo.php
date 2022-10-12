<?php
include_once("../Conexion/conexion.php");

if(isset($_POST['idArticulo'])){
    $idArticulo = $_POST['idArticulo'];
    $usuario = $_POST['u'];
$consulta = "UPDATE articulo SET
                id_estado_articulo_fk = 2
                WHERE id_articulo = $idArticulo";

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
    $idArticulo = null;
}
?>