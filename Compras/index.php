<?php
include_once("../Conexion/conexion.php");
$consultaCompraCliente = "SELECT
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
                w.direccion_envio,
                v.cantidad
                FROM
                compra x
                INNER JOIN cliente y
                ON x.id_cliente_fk = y.id_cliente
                LEFT JOIN envio w
                ON x.id_compra = w.id_compra_fk
                LEFT JOIN carrito v
                ON x.id_compra = v.id_compra_fk
                WHERE x.id_compra IS NOT NULL";
$accionCompraCliente = mysqli_query($conexion, $consultaCompraCliente);

$consultaCompraAnonima = "SELECT DISTINCT
                x.id_compra_anonima,
                x.total_compra_anonima,
                y.nit_cliente_anonimo,
                y.id_cliente,
                y.correo_cliente_anonimo,
                'Recoger en Tienda' tipo_entrega,
                w.cantidad
                FROM
                compra_anonima x
                INNER JOIN cliente_anonimo y
                ON x.id_cliente_anonimo_fk = y.id_cliente
                LEFT JOIN carrito_anonimo w
                ON x.id_compra_anonima = w.id_compra_anonima_fk
                WHERE x.id_compra_anonima IS NOT NULL";
$accionCompraAnonima = mysqli_query($conexion, $consultaCompraAnonima);

?>
<!DOCTYPE html>
<html>

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
    <div class="container py-5"">
    <header>
            <div class=" d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
        <a href="../index.php?u=<?php echo $_GET['u']?>" class="d-flex align-items-center text-dark text-decoration-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img">
                <title>CasaM??sica</title>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path>
            </svg>
            <span class="fs-4">CasaM??sica</span>
        </a>

        <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                <?php
                if(isset($_GET['u']) && $_GET['u'] == 'admin'){
                    $usuario = "admin";
                ?>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Gestion/index.php?u=<?php echo $_GET['u']?>">Gestion de Articulos</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Administracion/index.php?u=<?php echo $_GET['u']?>">Administracion de Usuarios</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="index.php?u=<?php echo $_GET['u']?>">Visualizacion de Compras</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Entregas/index.php?u=<?php echo $_GET['u']?>">Entregas de Compra</a>
                    <a class="py-2 text-dark text-decoration-none" href="../Login/logout.php">Log out</a>
                    
                <?php
                }elseif(isset($_GET['u']) && $_GET['u'] == 'manager'){
                    $usuario = "manager";
                ?>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Gestion/index.php?u=<?php echo $_GET['u']?>">Gestion de Articulos</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="index.php?u=<?php echo $_GET['u']?>">Visualizacion de Compras</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Entregas/index.php?u=<?php echo $_GET['u']?>">Entregas de Compra</a>
                    <a class="py-2 text-dark text-decoration-none" href="../Login/logout.php">Log out</a>
                <?php
                }
                ?>
                   
                </nav>
        </header>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white bg-success">
                        Listado de Compras por Clientes
                    </div>
                    <div class="p-4">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">ID COMPRA</th>
                                    <th scope="col">TOTAL COMPRA</th>
                                    <th scope="col">NOMBRE CLIENTE</th>
                                    <th scope="col">APELLIDO CLIENTE</th>
                                    <th scope="col">NIT CLIENTE</th>
                                    <th scope="col">ID CLIENTE</th>
                                    <th scope="col">CORREO CLIENTE</th>
                                    <th scope="col">DIRECCION CLIENTE</th>
                                    <th scope="col">TELEFONO CLIENTE</th>
                                    <th scope="col">TIPO ENVIO</th>
                                    <th scope="col">DIRECCION ENVIO</th>
                                    <th scope="col">CANTIDAD ARTICULOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($accionCompraCliente)) :
                                ?>
                                    <tr>
                                        <td scope="row"><?= $row['id_compra'] ?></td>
                                        <td scope="row"><?= 'Q.', $row['total_compra'] ?></td>
                                        <td scope="row"><?= $row['primer_nombre_cliente'] ?></td>
                                        <td scope="row"><?= $row['primer_apellido_cliente'] ?></td>
                                        <td scope="row"><?= $row['NIT_cliente'] ?></td>
                                        <td scope="row"><?= $row['id_cliente'] ?></td>
                                        <td scope="row"><?= $row['correo_cliente'] ?></td>
                                        <td scope="row"><?= $row['direccion_cliente'] ?></td>
                                        <td scope="row"><?= $row['telefono_cliente'] ?></td>
                                        <td scope="row"><?= $row['tipo_envio'] ?></td>
                                        <td scope="row"><?= $row['direccion_envio'] ?></td>
                                        <td scope="row"><?= $row['cantidad'] ?></td>
                                    </tr>
                                <?php
                                endwhile;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white bg-primary">
                        Listado de Compras Anonimas
                    </div>
                    <div class="p-4">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">ID COMPRA ANONIMA</th>
                                    <th scope="col">TOTAL COMPRA ANONIMA</th>
                                    <th scope="col">NIT CLIENTE ANONIMO</th>
                                    <th scope="col">ID CLIENTE ANONIMO</th>                                    
                                    <th scope="col">CORREO CLIENTE ANONIMO</th>                                    
                                    <th scope="col">TIPO ENTREGA</th>
                                    <th scope="col">CANTIDAD ARTICULOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($accionCompraAnonima)) :
                                ?>
                                    <tr>
                                        <td scope="row"><?= $row['id_compra_anonima'] ?></td>
                                        <td scope="row"><?= 'Q.', $row['total_compra_anonima'] ?></td>
                                        <td scope="row"><?= $row['nit_cliente_anonimo'] ?></td>
                                        <td scope="row"><?= $row['id_cliente'] ?></td>
                                        <td scope="row"><?= $row['correo_cliente_anonimo'] ?></td>
                                        <td scope="row"><?= $row['tipo_entrega'] ?></td>
                                        <td scope="row"><?= $row['cantidad'] ?></td>
                                    </tr>
                                <?php
                                endwhile;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>