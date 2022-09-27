<?php
include_once("../Conexion/conexion.php");
$consulta = "SELECT id_articulo, 
                    nombre_articulo, 
                    precio_articulo, 
                    costo_articulo, 
                    cantidad_articulo, 
                    descripcion_articulo
            FROM articulo WHERE id_estado_articulo_fk = 1";
$accion = mysqli_query($conexion,$consulta);
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
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <?php
                    if(isset($_GET['r']) && $_GET['r'] == '0'){
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Warning!</strong> Debe de llenar todos los campos.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                    }
                ?>
                <?php
                    if(isset($_GET['r']) && $_GET['r'] == '1'){
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Succes!</strong> Articulo Registrado Correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                    }
                ?>
                <?php
                    if(isset($_GET['r']) && $_GET['r'] == '2'){
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Succes!</strong> Articulo Actualizado Correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                    }
                ?>
                <?php
                    if(isset($_GET['r']) && $_GET['r'] == '3'){
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Succes!</strong> Articulo Eliminado.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                    }
                ?>
                <div class="card">
                    <div class="card-header text-white bg-primary">
                        Registrar Producto
                    </div>
                    <form action="insertarArticulo.php" method="POST" class="p-4">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nombreArticulo" placeholder="Nombre de Articulo" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" name="precioArticulo" placeholder="Precio del Articulo" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" name="costoArticulo" placeholder="Costo del Articulo" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" name="cantidadArticulo" placeholder="Cantidad del Articulo" autofocus>
                        </div>
                        <div class="mb-3">
                            <textarea type="text" class="form-control" name="descripcionArticulo" placeholder="Descripcion del Articulo" rows="5" autofocus></textarea>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="categoriaArticulo">
                                <option selected value="0">Seleccione un tipo de Articulo...</option>
                                <?php
                                $queryCategoriaArt = $conexion->query("SELECT id_categoria, nombre_categoria FROM categoria_articulo");
                                while ($valores = mysqli_fetch_array($queryCategoriaArt)) {
                                    echo '<option value="' . $valores['id_categoria'] . '">' . $valores['nombre_categoria'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-grid">
                            <input type="submit" class="btn btn-primary" value="Registrar Articulo">
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-md-8">
            <div class="card">
                    <div class="card-header text-white bg-success">
                        Listado de Articulos
                    </div>
                    <div class="p-4">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                   <th scope="col">CODIGO</th> 
                                   <th scope="col">NOMBRE</th>
                                   <th scope="col">PRECIO</th> 
                                   <th scope="col">COSTO</th> 
                                   <th scope="col">CANTIDAD</th> 
                                   <th scope="col">DESCRIPCION</th>  
                                   <th scope="col" colspan="2">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($row = mysqli_fetch_array($accion)):
                                ?>
                                <tr>
                                    <td scope="row"><?= $row['id_articulo'] ?></td>
                                    <td scope="row"><?= $row['nombre_articulo'] ?></td>
                                    <td scope="row"><?= 'Q.',$row['precio_articulo'] ?></td>
                                    <td scope="row"><?= 'Q.',$row['costo_articulo'] ?></td>
                                    <td scope="row" align="center"><?= $row['cantidad_articulo'] ?></td>
                                    <td scope="row"><?= $row['descripcion_articulo'] ?></td>

                                    <td><a href="actualizarArticulo.php?codigo=<?= $row['id_articulo'] ?>"><i class="bi bi-pencil-square"></i></a></td>
                                    <td><a href="eliminarArticulo.php?codigo=<?= $row['id_articulo'] ?>"><i class="bi bi-trash3"></i></a></td>
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