<?php
include_once("../Conexion/conexion.php");

$nombreCliente = $_POST['nombreCliente'];
$apellidoCliente = $_POST['apellidoCliente'];
$nitCliente = $_POST['nitCliente'];
$direccionCliente = $_POST['direccionCliente'];
$telefonoCliente = $_POST['telefonoCliente'];
$correoCliente = $_POST['correoCliente'];
$contrasenia = $_POST['contrasenia'];
$confirmarContrasenia = $_POST['confirmarContrasenia'];
$fecha_registro_cliente = date('Y/m/d', time()); //Validar con zona horaria
$estado_cliente = 1;

if (
    isset($nombreCliente) && isset($apellidoCliente) && isset($nitCliente)
    && isset($direccionCliente) && isset($telefonoCliente) && isset($correoCliente) && isset($contrasenia) && isset($confirmarContrasenia)
) {

    if ($contrasenia === $confirmarContrasenia) {
        $consulta = "INSERT INTO cliente 
                (primer_nombre_cliente,
                primer_apellido_cliente,
                NIT_cliente,
                direccion_cliente,
                telefono_cliente,
                correo_cliente,
                contrasenia_cliente,
                fecha_registro_cliente,
                id_estado_cliente_fk)
               
            VALUES('$nombreCliente', '$nombreApellido',   
            '$nitCliente', '$direccionCliente', $telefonoCliente, 
            '$correoCliente', '$contresenia', '$fecha_registro_cliente', $estado_cliente)";

        $accion = mysqli_query($conexion, $consulta);

        if ($accion) {
            Header("Location: index.php?r=1");
        } else {
            Header("Location: index.php?r=0");
            mysqli_close($conexion);
        }
    }
    else{
        Header("Location: index.php?r=3");
    }
} else {
    Header("Location: index.php?r=0");
    mysqli_close($conexion);
}
