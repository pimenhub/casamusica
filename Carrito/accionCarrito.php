<?php

include_once("funcionesCarrito.php");
$cart = new Cart;

// include database configuration file
include_once("../Conexion/conexion.php");
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    if ($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id_articulo'])) {
        $idArticulo = $_REQUEST['id_articulo'];
        $usuario = $_REQUEST['u'];
        $cod = $_REQUEST['cod'];
        // get product details
        $queryUpdate = $conexion->query("UPDATE articulo SET cantidad_articulo = cantidad_articulo - 1 WHERE id_articulo = $idArticulo");       
        $query = $conexion->query("SELECT id_articulo, 
        nombre_articulo, 
        precio_articulo, 
        costo_articulo, 
        cantidad_articulo, 
        descripcion_articulo
FROM articulo WHERE id_estado_articulo_fk = 1
              AND id_articulo =" . $idArticulo);
        $row = $query->fetch_assoc();
        $itemData = array(
            'id_articulo' => $row['id_articulo'],
            'nombre_articulo' => $row['nombre_articulo'],
            'precio_articulo' => $row['precio_articulo'],
            'existencia_articulo' => $row['cantidad_articulo'],
            'cantidad_articulo' => 1
        );

        $insertItem = $cart->insert($itemData);
        $redirectLoc = $insertItem ? 'verCarrito.php?u=' . $usuario . '&cod=' . $cod : '../index.php';
        header("Location: " . $redirectLoc);

    } elseif ($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id_articulo'])) {
        $itemData = array(
            'rowid' => $_REQUEST['id_articulo'],
            'cantidad_articulo' => $_REQUEST['cantidad_articulo']
        );
        $updateItem = $cart->update($itemData);
        echo $updateItem ? 'ok' : 'err';
        die;
    } elseif ($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id_articulo']) && !empty($_REQUEST['ex'])) {
        
        $idArticulo = $_REQUEST['id'];
        $existencia = $_REQUEST['ex'];
        $queryUpdatePlus = $conexion->query("UPDATE articulo SET cantidad_articulo = cantidad_articulo + $existencia WHERE id_articulo = $idArticulo");   

        
        $deleteItem = $cart->remove($_REQUEST['id_articulo']);
        $usuario = $_REQUEST['u'];
        $cod = $_REQUEST['cod'];
        header("Location: verCarrito.php?u=" . $usuario . '&cod=' . $cod);
    } elseif ($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0) {
        // insert order details into database
        //en este apartado condicionar la compra anonima
        //tambien definir el registro del cliente anonimo
        $cod = $_REQUEST['cod'];
        if ($cod != 0) { //------------------------------------------------Comprador de tipo CLIENTE
            if (!empty($_SESSION['sessCustomerID'])) {
                $insertOrder = $conexion->query("INSERT INTO compra (total_compra, id_cliente_fk) VALUES ('" . $cart->total() . "', '" . $_SESSION['sessCustomerID'] . "')");
                if ($insertOrder === true) {
                    $consultaCompra = "SELECT max(id_compra) id_compra FROM compra
                    WHERE id_cliente_fk =" . $_SESSION['sessCustomerID'];
                    $accionCompra = mysqli_query($conexion, $consultaCompra);
                    $rowCompra = mysqli_fetch_array($accionCompra);
                    $insertarEntrega = $conexion->query("INSERT INTO entrega (id_compra_fk) VALUES (" . $rowCompra['id_compra'] . ")");

                    if ($insertarEntrega === true) {
                        if (isset($_POST['direccionEnvioExacta'])) {
                            $direccionExacta = $_POST['direccionEnvioExacta'];
                        } else {
                            $direccionExacta = "";
                        }
                        if (isset($_POST['telefonoEnvio']) && isset($_POST['tipoEnvio'])) {
                            $telefonoEnvio = $_POST['telefonoEnvio'];
                            $tipoEnvio = $_POST['tipoEnvio'];
                            $direccionExacta = $_POST['direccionEnvioExacta'];
                            $insertarEnvioCliente = $conexion->query("INSERT INTO envio (tipo_envio, id_cliente_fk, id_compra_fk, direccion_envio, telefono_envio) 
                            VALUES (" . $tipoEnvio . ", " . $_SESSION['sessCustomerID'] . ", " . $rowCompra['id_compra'] . ", '" . $direccionExacta . "', " . $telefonoEnvio . ")");
                        }
                    }
                }
                if ($insertOrder) {
                    $consultaCompra = "SELECT max(id_compra) id_compra FROM compra
                    WHERE id_cliente_fk =" . $_SESSION['sessCustomerID'];
                    $accionCompra = mysqli_query($conexion, $consultaCompra);
                    $rowCompra = mysqli_fetch_array($accionCompra);
                    //$compraID = $conexion->insert_id;
                    $compraID = $rowCompra['id_compra'];
                    $sql = '';
                    // get cart items
                    $cartItems = $cart->contents();
                    foreach ($cartItems as $item) {
                        $sql .= "INSERT INTO carrito (id_articulo_fk, id_compra_fk, cantidad) VALUES (" . $item['id_articulo'] . ", " . $compraID . ", " . $item['cantidad_articulo'] . ");";
                    }
                    // insert order items into database
                    $insertOrderItems = $conexion->multi_query($sql);

                    if ($insertOrderItems) {
                        $cart->destroy();
                        header("Location: ordenRealizada.php?id_compra=$compraID" . "&u=client" . "&cod=$cod");
                    } else {
                        header("Location: pagos.php");
                    }
                } else {
                    header("Location: pagos.php");
                }
            }
        } else { //------------------------------------------------------Comprador de tipo ANONIMO
            $insertarClienteAnonimoCondicion = false;
            if (isset($_POST['nitAnonimo'])) {
                $nitAnonimo = $_POST['nitAnonimo'];
            } else {
                $nitAnonimo = "C/F";
            }
            if (
                isset($_POST['correoAnonimo']) && isset($_POST['tipoEntrega'])
            ) {
                $nitAnonimo = $_POST['nitAnonimo'];
                $correoAnonimo = $_POST['correoAnonimo'];
                $envioAnonimo = $_POST['tipoEntrega'];
                $fechaRegistro = date('Y/m/d', time()); //Validar con zona horaria

                $insertarClienteAnonimo = $conexion->query("INSERT INTO cliente_anonimo (nit_cliente_anonimo, correo_cliente_anonimo, fecha_registro_cliente_anonimo)
                                                            VALUES('" . $nitAnonimo . "', '" . $correoAnonimo . "', '" . $fechaRegistro . "')");
                if ($insertarClienteAnonimo) {
                    $consulta = "SELECT max(id_cliente) id_cliente_anonimo FROM cliente_anonimo
                    WHERE correo_cliente_anonimo = '$correoAnonimo'";
                    $accion = mysqli_query($conexion, $consulta);
                    $rowA = mysqli_fetch_array($accion);
                    $insertarClienteAnonimoCondicion = $insertarClienteAnonimo;
                }
            }
            if ($insertarClienteAnonimoCondicion === true) {
                $insertOrderAnonima = $conexion->query("INSERT INTO compra_anonima (total_compra_anonima, id_cliente_anonimo_fk) VALUES ('" . $cart->total() . "', " . $rowA['id_cliente_anonimo']  . ")");
                if ($insertOrderAnonima === true) {
                    $consultaCompraA = "SELECT max(id_compra_anonima) id_compra_anonima FROM compra_anonima
                    WHERE id_cliente_anonimo_fk =" . $rowA['id_cliente_anonimo'];
                    $accionCompraA = mysqli_query($conexion, $consultaCompraA);
                    $rowCompraA = mysqli_fetch_array($accionCompraA);
                    $insertarEntregaAnonima = $conexion->query("INSERT INTO entrega_anonima (id_compra_anonima_fk) VALUES (" . $rowCompraA['id_compra_anonima'] . ")");
                }
                if ($insertOrderAnonima) {
                    $consultaCompraA = "SELECT max(id_compra_anonima) id_compra_anonima FROM compra_anonima
                    WHERE id_cliente_anonimo_fk =" . $rowA['id_cliente_anonimo'];
                    $accionCompraA = mysqli_query($conexion, $consultaCompraA);
                    $rowCompraA = mysqli_fetch_array($accionCompraA);
                    $compraID = $rowCompraA['id_compra_anonima'];
                    $sql = '';
                    // get cart items
                    $cartItems = $cart->contents();
                    foreach ($cartItems as $item) {
                        $sql .= "INSERT INTO carrito_anonimo (id_articulo_fk, id_compra_anonima_fk, cantidad) VALUES (" . $item['id_articulo'] . ", " . $compraID . ", " . $item['cantidad_articulo'] . ");";
                    }
                    // insert order items into database
                    $insertOrderItems = $conexion->multi_query($sql);

                    if ($insertOrderItems) {
                        $cart->destroy();
                        header("Location: ordenRealizada.php?id_compra=$compraID" . "&u=anonimo" . "&cod=$cod");
                    } else {
                        header("Location: pagos.php");
                    }
                } else {
                    header("Location: pagos.php");
                }
            }
        }
    } else {
        header("Location: ../index.php");
    }
} else {
    header("Location: ../index.php");
}
