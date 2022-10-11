<?php
// include database configuration file
include_once("../Conexion/conexion.php");

// initializ shopping cart class
include_once("funcionesCarrito.php");
$cart = new Cart;
$usuario = $_GET['u'];
$cod = $_GET['cod'];
// redirect to home if cart is empty
if ($cart->total_items() <= 0) {
    header("Location: index.php");
}

// set customer ID in session
$_SESSION['sessCustomerID'] = $cod;

// get customer details by session customer ID
if ($cod != 0) {
    $query = $conexion->query("SELECT * FROM cliente WHERE id_cliente = " . $_SESSION['sessCustomerID']);
    $custRow = $query->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">

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

    <script type="text/javascript">
        function showInp() {
            var getSelectValue = document.getElementById("tipoEnvio").value;
            if (getSelectValue == "2") {
                document.getElementById("direccionEnvioExacta").style.display = "inline-block";
            }
            else{
                document.getElementById("direccionEnvioExacta").style.display = "none";
                document.getElementById("direccionEnvioExacta").value = "RT";
            }
        }
    </script>
</head>

<body>
    <div class="container py-3">
        <header>
            <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
                <a href="../index.php?u=<?php echo $_GET['u']; ?>&cod=<?php echo $_GET['cod']; ?>" class="d-flex align-items-center text-dark text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img">
                        <title>CasaMúsica</title>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path>
                    </svg>
                    <span class="fs-4">CasaMúsica</span>
                </a>

                <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                    <?php
                    if (isset($_GET['u']) && $_GET['u'] == 'client') {
                    ?>
                        <a class="py-2 text-dark text-decoration-none" href="../Login/logout.php">Log out</a>
                    <?php
                    }
                    ?>
                </nav>
            </div>
        </header>
        <div class="panel panel-default">

            <div class="panel-body">
                <h1>Vista previa de la Orden</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Pricio</th>
                            <th>Cantidad</th>
                            <th>Sub total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($cart->total_items() > 0) {
                            //get cart items from session
                            $cartItems = $cart->contents();
                            foreach ($cartItems as $item) {
                        ?>
                                <tr>
                                    <td><?php echo $item["nombre_articulo"]; ?></td>
                                    <td><?php echo 'Q.' . $item["precio_articulo"]; ?></td>
                                    <td><?php echo $item["cantidad_articulo"]; ?></td>
                                    <td><?php echo 'Q.' . $item["subtotal"]; ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4">
                                    <p>No hay articulos en tu carta......</p>
                                </td>
                            <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <?php if ($cart->total_items() > 0) { ?>
                                <td class="text-center"><strong>Total <?php echo 'Q.' . $cart->total() ?></strong></td>
                            <?php } ?>
                        </tr>
                    </tfoot>
                </table>
                <div class="shipAddr">
                    <?php
                    if ($cod != 0) {
                    ?>
                        <h4>Detalles de Compra</h4>
                        <p>Nombre: <?php echo $custRow['primer_nombre_cliente']; ?></p>
                        <p>Apellido: <?php echo $custRow['primer_apellido_cliente']; ?></p>
                        <p>NIT: <?php echo $custRow['NIT_cliente']; ?></p>
                        <p>Telefono: <?php echo $custRow['telefono_cliente']; ?></p>
                        <p>Correo: <?php echo $custRow['correo_cliente']; ?></p>
                        <p>Direccion: <?php echo $custRow['direccion_cliente']; ?></p>
                        <form action="accionCarrito.php" method="POST">
                            <input type="hidden" class="form-control" name="action" autofocus value="placeOrder">
                            <input type="hidden" class="form-control" name="cod" autofocus value="<?php echo $cod?>">
                            <input type="hidden" class="form-control" name="telefonoEnvio" autofocus value="<?php echo $custRow['telefono_cliente']; ?>">
                            <div class="mb-3">
                            <select class="form-select" name="tipoEnvio" id="tipoEnvio" onchange="showInp()">
                                <option selected value="0">Seleccione como desea obtener su producto...</option>
                                <option value="1">Recoger en Tienda</option>
                                <option value="2">Envio</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="direccionEnvioExacta" id="direccionEnvioExacta" placeholder="Ingrese la direccion exacta a donde desea el envio" style="display: none;" autofocus required>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-success" value="Realizar Compra">  
                        </div>
                        </form>
                        
                    <?php
                    } else {
                    ?>
                        <h4>Compra Anonima</h4>
                        <form action="accionCarrito.php" method="POST">
                            <input type="hidden" class="form-control" name="action" autofocus value="placeOrder">
                            <input type="hidden" class="form-control" name="cod" autofocus value="<?php echo $cod?>">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="correoAnonimo" placeholder="Ingrese su correo" autofocus required>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="nitAnonimo" placeholder="NIT" autofocus>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" name="tipoEntrega">
                                    <option selected value="1">Recoger en Tienda</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <p class="text-danger">Ya que su compra es sin estar registrado, debe de recorger su producto en tienda</p>
                            </div>
                            <div class="mb-3">
                            <input type="submit" class="btn btn-success" value="Realizar Compra">                                
                            </div>
                        </form>
                    <?php
                    }
                    ?>
                </div>
                <div class="footBtn">
                    <a href="../index.php?u=<?php echo $_GET['u']; ?>&cod=<?php echo $_GET['cod']; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Continue Comprando</a>
                </div>
            </div>
            <div class="panel-footer">CasaMúsica</div>
        </div>
        <!--Panek cierra-->
    </div>
</body>

</html>