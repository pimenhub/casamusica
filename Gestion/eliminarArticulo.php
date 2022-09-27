<?php
include_once("../Conexion/conexion.php");
$idArticulo = $_GET['codigo'];
$consulta = "SELECT x.id_articulo, 
                    x.nombre_articulo 
            FROM articulo x 
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
                <div class="card">
                    <div class="card-header bg-danger">
                        Eliminar Articulo
                    </div>
                    <form action="eliminarArticulo.php" method="POST" class="p-4">
                        <div class="mb-3">
                          <input type="hidden" class="form-control" name="idArticulo" value="<?= $row['id_articulo'] ?>">
                          <p>Esta seguro de que desea eliminar el articulo <b><?= $row['id_articulo'] ?></b> <b><?= $row['nombre_articulo'] ?></b></p>
                        </div>
                        <div class="d-grid">
                            <input type="submit" class="btn btn-danger" value="Eliminar Articulo">
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

if(isset($_POST['idArticulo'])){

    $idArticulo = $_POST['idArticulo'];

$consulta = "UPDATE articulo SET
                id_estado_articulo_fk = 2
                WHERE id_articulo = $idArticulo";

$accion = mysqli_query($conexion,$consulta);

    if($accion){
        Header("Location: index.php?r=3");
    }
    else{
        Header("Location: index.php?r=0");
        mysqli_close($conexion);
    }
}
else{
    $idArticulo = null;
}
?>