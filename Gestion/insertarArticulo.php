<?php
include_once("../Conexion/conexion.php");

$nombreArticulo = $_POST['nombreArticulo'];
$precioArticulo = $_POST['precioArticulo'];
$costoArticulo = $_POST['costoArticulo'];
$cantidadArticulo = $_POST['cantidadArticulo'];
$descripcionArticulo = $_POST['descripcionArticulo'];
$categoriaArticulo = $_POST['categoriaArticulo'];
$fechaRegistro = date('Y/m/d', time());//Validar con zona horaria
$estadoArticulo = 1;
$usuario = $_POST['u'];

if(isset($nombreArticulo) && isset($precioArticulo) && isset($costoArticulo)
&& isset($cantidadArticulo) && isset($descripcionArticulo) && isset($categoriaArticulo)){
$consulta = "INSERT INTO articulo 
                (nombre_articulo,
                descripcion_articulo,
                precio_articulo,
                costo_articulo,
                cantidad_articulo,
                fecha_registro_articulo,
                id_categoria_fk,
                id_estado_articulo_fk)
            VALUES('$nombreArticulo', '$descripcionArticulo', 
            $precioArticulo, $costoArticulo, $cantidadArticulo, 
            '$fechaRegistro', $categoriaArticulo, $estadoArticulo)";

$accion = mysqli_query($conexion,$consulta);

    if($accion){
        Header("Location: index.php?r=1&u=" . $usuario);
        
    }
    else{
        Header("Location: index.php?r=0&u=" . $usuario);
        mysqli_close($conexion);
    }
}
else{
    Header("Location: index.php?r=0&u=" . $usuario);
        mysqli_close($conexion);
}
?>
