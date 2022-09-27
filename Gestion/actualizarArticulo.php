<?php
include_once("../Conexion/conexion.php");
$idArticulo = $_GET['codigo'];
$consulta = "SELECT x.id_articulo, 
                    x.nombre_articulo, 
                    x.precio_articulo, 
                    x.costo_articulo, 
                    x.cantidad_articulo, 
                    x.descripcion_articulo,
                    x.id_categoria_fk,
                    y.nombre_categoria
            FROM articulo x 
            INNER JOIN categoria_articulo y
            ON x.id_categoria_fk = y.id_categoria 
            WHERE x.id_estado_articulo_fk = 1
                          AND x.id_articulo = $idArticulo";
$accion = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_array($accion);
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
                <div class="card">
                    <div class="card-header bg-warning">
                        Actualizar Articulo
                    </div>
                    <form action="actualizarArticulo.php" method="POST" class="p-4">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" name="idArticulo" value="<?= $row['id_articulo'] ?>">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nombreArticulo" placeholder="Nombre de Articulo" value="<?= $row['nombre_articulo'] ?>" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" name="precioArticulo" placeholder="Precio del Articulo" value="<?= $row['precio_articulo'] ?>"  autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" name="costoArticulo" placeholder="Costo del Articulo" value="<?= $row['costo_articulo'] ?>"  autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" name="cantidadArticulo" placeholder="Cantidad del Articulo" value="<?= $row['cantidad_articulo'] ?>"  autofocus>
                        </div>
                        <div class="mb-3">
                            <textarea type="text" class="form-control" name="descripcionArticulo" placeholder="Descripcion del Articulo" rows="5" autofocus><?= $row['descripcion_articulo'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="categoriaArticulo">
                                <option value="<?= $row['id_categoria_fk'] ?>"><?= $row['nombre_categoria'] ?></option>
                                <?php
                                $categoriaCondicion = $row['id_categoria_fk'];
                                $queryCategoriaArt = $conexion->query("SELECT id_categoria, nombre_categoria FROM categoria_articulo WHERE id_categoria != $categoriaCondicion");
                                while ($valores = mysqli_fetch_array($queryCategoriaArt)) {
                                    echo '<option value="' . $valores['id_categoria'] . '">' . $valores['nombre_categoria'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-grid">
                            <input type="submit" class="btn btn-warning" value="Actualizar Articulo">
                        </div>
                        <br>
                        <div class="d-grid">
                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
</body>
</html>

<?php
include_once("../Conexion/conexion.php");



if(isset($_POST['nombreArticulo']) && isset($_POST['precioArticulo']) && isset($_POST['costoArticulo'])
&& isset($_POST['cantidadArticulo']) && isset($_POST['descripcionArticulo']) && isset($_POST['categoriaArticulo'])){

    $idArticulo = $_POST['idArticulo'];
    $nombreArticulo = $_POST['nombreArticulo'];
    $precioArticulo = $_POST['precioArticulo'];
    $costoArticulo = $_POST['costoArticulo'];
    $cantidadArticulo = $_POST['cantidadArticulo'];
    $descripcionArticulo = $_POST['descripcionArticulo'];
    $categoriaArticulo = $_POST['categoriaArticulo'];
    $fechaActualizacion = date('Y/m/d', time());//Validar con zona horaria

$consulta = "UPDATE articulo SET
                nombre_articulo = '$nombreArticulo',
                descripcion_articulo = '$descripcionArticulo',
                precio_articulo = $precioArticulo,
                costo_articulo = $costoArticulo,
                cantidad_articulo = $cantidadArticulo,
                fecha_actualizado_articulo = '$fechaActualizacion',
                id_categoria_fk = $categoriaArticulo WHERE id_articulo = $idArticulo";

$accion = mysqli_query($conexion,$consulta);

    if($accion){
        Header("Location: index.php?r=2");
    }
    else{
        Header("Location: index.php?r=0");
        mysqli_close($conexion);
    }
}
else{
    $idArticulo = null;
    $nombreArticulo = null;
    $precioArticulo = null;
    $costoArticulo = null;
    $cantidadArticulo = null;
    $descripcionArticulo = null;
    $categoriaArticulo = null;
}
?>