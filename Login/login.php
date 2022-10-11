<?php
//session_start(); 
include_once("../Conexion/conexion.php");
include_once("../Carrito/funcionesCarrito.php");
$cart = new Cart;
if (isset($_POST['correoLogin']) && isset($_POST['passwordLogin'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['correoLogin']);
    $pass = validate($_POST['passwordLogin']);

    if (empty($uname)) {
        header("Location: index.php?r=0");
        exit();
    } else if (empty($pass)) {
        header("Location: index.php?r=0");
        exit();
    } else {
        $consultaUsuario = "SELECT x.nick_name_usuario, 
                                   x.password_usuario, 
                                   x.id_tipo_usuario_fk, 
                                   y.nombre_tipo_usuario
                                   FROM usuario x
                                   INNER JOIN tipo_usuario y 
                                   ON x.id_tipo_usuario_fk = y.id_tipo_usuario
                                   WHERE nick_name_usuario='$uname' 
                                   AND password_usuario='$pass' 
                                   AND id_estado_usuario_fk = 1";

        $consultaCliente = "SELECT 
                                   id_cliente, 
                                   correo_cliente, 
                                   contrasenia_cliente 
                                   FROM cliente 
                                   WHERE correo_cliente='$uname' 
                                   AND contrasenia_cliente='$pass' 
                                   AND id_estado_cliente_fk = 1";

        $resultUsuario = mysqli_query($conexion, $consultaUsuario);
        $resultCliente = mysqli_query($conexion, $consultaCliente);

        if (mysqli_num_rows($resultUsuario) === 1) {
            $row = mysqli_fetch_assoc($resultUsuario);
            if ($row['nick_name_usuario'] === $uname && $row['password_usuario'] === $pass) {
                $_SESSION['nick_name_usuario'] = $row['nick_name_usuario'];
                $_SESSION['nombre_tipo_usuario'] = $row['nombre_tipo_usuario'];

                if ($row['id_tipo_usuario_fk'] == 1) {
                    header("Location: ../index.php?u=admin");
                    $cart->destroy();
                } elseif ($row['id_tipo_usuario_fk'] == 2) {
                    header("Location: ../index.php?u=manager");
                    $cart->destroy();
                }
                exit();
            } else {
                header("Location: index.php?error=El usuario o la contraseña son incorrectos");
                exit();
            }
        } elseif (mysqli_num_rows($resultCliente) === 1) {
            $row = mysqli_fetch_assoc($resultCliente);
            if ($row['correo_cliente'] === $uname && $row['contrasenia_cliente'] === $pass) {
                $_SESSION['correo_cliente'] = $row['correo_cliente'];
                $_SESSION['id_cliente'] = $row['id_cliente'];

                header("Location: ../index.php?u=client&cod=".$row['id_cliente']);
                $cart->destroy();
            }
        } else {
            header("Location: index.php?error=El usuario o la contraseña son incorrectos");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
