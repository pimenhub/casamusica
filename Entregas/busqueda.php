<?php
include_once("../Conexion/conexion.php");
if(isset($_POST['codCompra']) && isset($_POST['tipoCompra'])){
    $codCompra = $_POST['codCompra'];
    $tipoCompra = $_POST['tipoCompra'];
    if($tipoCompra == 1){
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
                WHERE x.id_compra = ". $codCompra;
$accionCompraCliente = mysqli_query($conexion, $consultaCompraCliente);
    }
    elseif($tipoCompra == 2){
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
        WHERE x.id_compra_anonima = ". $codCompra;
$accionCompraAnonima = mysqli_query($conexion, $consultaCompraAnonima);
    }
}
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
        <div class="row justify-content-center">
        <div class="footBtn">
        <a href="../Entregas/index.php?u=<?php echo $_POST['u']?>" class="btn btn-warning">Nueva Busqueda</a>
        </div>
        <br>
        <br>
        <div class="footBtn">
            <a href="index.php?u=<?php echo $_POST['u']?>" class="btn btn-secondary">Cancelar</a>
        </div>
        <br>
        <br>
        <?php 
        if($tipoCompra == 1){
        ?>
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
<?php
        }elseif($tipoCompra == 2){
?>
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
            <?php
        }
            ?>
        </div>
</body>
</html>