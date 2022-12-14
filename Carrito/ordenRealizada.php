<?php
include_once("../Conexion/conexion.php");
if (!isset($_REQUEST['id_compra'])) {
    $idCompra = $_REQUEST['id_compra'];
    header("Location: ../index.php");
}
$idCompra = $_REQUEST['id_compra'];
$query = $conexion->query("SELECT 
                            x.id_compra,
                            x.total_compra
                           FROM compra x 
                           INNER JOIN cliente y
                           ON x.id_cliente_fk = y.id_cliente
                           WHERE id_compra = " . $idCompra);
$custRow = $query->fetch_assoc();

if (isset($_GET['u'])) {
    $usuarioCorreo = $_GET['u'];
    if ($usuarioCorreo === 'client') {
        $queryC = $conexion->query("SELECT DISTINCT
        x.id_compra,
        x.total_compra,
        y.primer_nombre_cliente,
        y.primer_apellido_cliente,
        y.NIT_cliente,
        y.id_cliente,
        y.correo_cliente,
        y.direccion_cliente,
        y.telefono_cliente,
        CASE
         WHEN w.tipo_envio = '1' THEN 'Recoger en Tienda'
         WHEN w.tipo_envio = '2' THEN 'Envio'
        END tipo_envio,
        w.direccion_envio
    FROM
    compra x
    INNER JOIN cliente y
    ON x.id_cliente_fk = y.id_cliente
    INNER JOIN envio w
    ON x.id_compra = w.id_compra_fk
    WHERE x.id_compra =" . $idCompra);
        $cRow = $queryC->fetch_assoc();

    $txt = "Gracias por su preferencia." . "<br>" . "El cógido de su compra es #" . $cRow['id_compra'] .
     "<br><br>" . "El total a pagar es Q." . $cRow['total_compra'] . "<br>" . "El tipo de entrega será " . $cRow['tipo_envio'] . " a <br>" . $cRow['direccion_envio'];         

    } elseif ($usuarioCorreo === 'anonimo') {
        $queryA = $conexion->query("SELECT DISTINCT
        x.id_compra_anonima,
        x.total_compra_anonima,
        y.id_cliente,
        y.correo_cliente_anonimo,
        'Recoger en Tienda' tipo_entrega
    FROM
    compra_anonima x
    INNER JOIN cliente_anonimo y
    ON x.id_cliente_anonimo_fk = y.id_cliente
    WHERE x.id_compra_anonima =" . $idCompra);
    $aRow = $queryA->fetch_assoc();

    $txt = "Gracias por su preferencia." . "<br>" . "El cógido de su compra es #" . $aRow['id_compra_anonima'] .
     "<br><br>" . "El total a pagar es Q." . $aRow['total_compra_anonima'] . "<br>" . "El tipo de entrega será " . $aRow['tipo_entrega'];         
    }
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
                        <a class="me-3 py-2 text-dark text-decoration-none" href="../index.php?u=<?php echo $_GET['u']; ?>&cod=<?php echo $_GET['cod']; ?>">Inicio</a>
                        <a class="py-2 text-dark text-decoration-none" href="../Login/logout.php">Log out</a>
                    <?php
                    } elseif (isset($_GET['u']) && $_GET['u'] == 'anonimo') {
                    ?>
                        <a class="me-3 py-2 text-dark text-decoration-none" href="../index.php?u=<?php echo $_GET['u']; ?>&cod=<?php echo $_GET['cod']; ?>">Inicio</a>
                    <?php
                    }
                    ?>
                </nav>
            </div>
        </header>
        <div class="panel panel-default">
            <div class="panel-body">

                <h1>Estado de la Compra</h1>
                <p>Su compra se a realizado exitosamente.</p>
                <p><?php echo $txt?></p>
            </div>
            <div class="panel-footer">CasaMúsica</div>
        </div>
        <!--Panek cierra-->
    </div>
</body>

</html>