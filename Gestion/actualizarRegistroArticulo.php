<?php
include_once("../Conexion/conexion.php");


if (
    isset($_POST['nombreArticulo']) && isset($_POST['precioArticulo']) && isset($_POST['costoArticulo'])
    && isset($_POST['cantidadArticulo']) && isset($_POST['descripcionArticulo']) && isset($_POST['categoriaArticulo'])
) {

    $idArticulo = $_POST['idArticulo'];
    $nombreArticulo = $_POST['nombreArticulo'];
    $precioArticulo = $_POST['precioArticulo'];
    $costoArticulo = $_POST['costoArticulo'];
    $cantidadArticulo = $_POST['cantidadArticulo'];
    $descripcionArticulo = $_POST['descripcionArticulo'];
    $categoriaArticulo = $_POST['categoriaArticulo'];
    $fechaActualizacion = date('Y/m/d', time()); //Validar con zona horaria
    $usuario = $_POST['u'];

    $consulta = "UPDATE articulo SET
                nombre_articulo = '$nombreArticulo',
                descripcion_articulo = '$descripcionArticulo',
                precio_articulo = $precioArticulo,
                costo_articulo = $costoArticulo,
                cantidad_articulo = $cantidadArticulo,
                fecha_actualizado_articulo = '$fechaActualizacion',
                id_categoria_fk = $categoriaArticulo WHERE id_articulo = $idArticulo";

    $accion = mysqli_query($conexion, $consulta);

    if ($accion) {
        Header("Location: index.php?r=2&u=" . $usuario);
    } else {
        Header("Location: index.php?r=0&u=" . $usuario);
        mysqli_close($conexion);
    }
} else {
    $idArticulo = null;
    $nombreArticulo = null;
    $precioArticulo = null;
    $costoArticulo = null;
    $cantidadArticulo = null;
    $descripcionArticulo = null;
    $categoriaArticulo = null;
}
?>