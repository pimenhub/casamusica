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
                if (isset($_GET['r']) && $_GET['r'] == '0') {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Warning!</strong> Debe de llenar todos los campos.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
                <?php
                if (isset($_GET['r']) && $_GET['r'] == '1') {
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Succes!</strong> Cliente Registrado Correctamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>




                <div class="card">
                    <div class="card-header text-white bg-primary">
                        Registrar Cliente
                    </div>
                    <form action="insertarCliente.php" method="POST" class="p-4">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nombreCliente" placeholder="Nombre cliente" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="apellidoCliente" placeholder="apellido cliente" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nitCliente" placeholder="ingrese nit" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="direccionCliente" placeholder="ingrese direccion" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="telefonoCliente" placeholder="ingrese numero de telefono" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="correoCliente" placeholder="ingrese correo electronico" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="contrasenia" placeholder="ingrese una contraseña" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="confirmarcontrasenia" placeholder="confirme contraseña" autofocus>
                        </div>

                        <div class="d-grid">
                            <input type="submit" class="btn btn-primary" value="Registrar Datos">
                        </div>
                    </form>

                </div>
            </div>
     
        </div>
</body>

</html>