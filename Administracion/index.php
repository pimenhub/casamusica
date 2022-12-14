<?php
include_once("../Conexion/conexion.php");
$consulta = "SELECT x.id_usuario, 
                    x.nombre_usuario, 
                    x.apellido_usuario, 
                    x.telefono_usuario, 
                    x.correo_usuario,
                    x.nick_name_usuario,
                    y.nombre_tipo_usuario
            FROM usuario x
            INNER JOIN tipo_usuario y
            ON x.id_tipo_usuario_fk = y.id_tipo_usuario
            WHERE x.id_estado_usuario_fk = 1";
            
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
    <div class="container py-5">
    <header>
            <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
                <a href="../index.php?u=<?php echo $_GET['u']?>" class="d-flex align-items-center text-dark text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img">
                        <title>CasaMúsica</title>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path>
                    </svg>
                    <span class="fs-4">CasaMúsica</span>
                </a>

                <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                <?php
                if(isset($_GET['u']) && $_GET['u'] == 'admin'){
                    $usuario = "admin";
                ?>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Gestion/index.php?u=<?php echo $_GET['u']?>">Gestion de Articulos</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="index.php?u=<?php echo $_GET['u']?>">Administracion de Usuarios</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Compras/index.php?u=<?php echo $_GET['u']?>">Visualizacion de Compras</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Entregas/index.php?u=<?php echo $_GET['u']?>">Entregas de Compra</a>
                    <a class="py-2 text-dark text-decoration-none" href="../Login/logout.php">Log out</a>
                    
                <?php
                }elseif(isset($_GET['u']) && $_GET['u'] == 'manager'){
                    $usuario = "manager";
                ?>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Gestion/index.php?u=<?php echo $_GET['u']?>">Gestion de Articulos</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Compras/index.php?u=<?php echo $_GET['u']?>">Visualizacion de Compras</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Entregas/index.php?u=<?php echo $_GET['u']?>">Entregas de Compra</a>
                    <a class="py-2 text-dark text-decoration-none" href="../Login/logout.php">Log out</a>
                <?php
                }
                ?>
                   
                </nav>
        </header>
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
                    <strong>Succes!</strong> Usuario Actualizado Correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                    }
                ?>
                <?php
                    if(isset($_GET['r']) && $_GET['r'] == '3'){
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Succes!</strong> Usuario Eliminado.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                    }
                ?>
                <?php
                    if(isset($_GET['r']) && $_GET['r'] == '4'){
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Succes!</strong> La Contraseña no es la misma, intente de nuevo.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                    }
                ?>
                <div class="card">
                    <div class="card-header text-white bg-primary">
                        Registrar Usuario
                    </div>
                    <form action="insertarUsuario.php" method="POST" class="p-4">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" name="u" value="<?php echo $_GET['u']?>" autofocus>
                        </div> 
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nombreUsuario" placeholder="Nombre del Usuario" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="apellidoUsuario" placeholder="Apellido del Usuario" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="telefonoUsuario" placeholder="Telefono del Usuario" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="correoUsuario" placeholder="Correo del Usuario" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nickName" placeholder="Nick Name para el Usuario ej. nombre.apellido" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="passwordUsuario" placeholder="Agregue una Contraseña" autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="rectificarPasswordUsuario" placeholder="Repita la Contraseña" autofocus>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="tipoUsuario">
                                <option selected value="0">Seleccione un tipo de Usuario..</option>
                                <?php
                                $queryTipoUsuario = $conexion->query("SELECT id_tipo_usuario, nombre_tipo_usuario FROM tipo_usuario");
                                while ($valores = mysqli_fetch_array($queryTipoUsuario)) {
                                    echo '<option value="' . $valores['id_tipo_usuario'] . '">' . $valores['nombre_tipo_usuario'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-grid">
                            <input type="submit" class="btn btn-primary" value="Registrar Usuario">
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-md-12">
            <div class="card">
                    <div class="card-header text-white bg-success">
                        Listado de Usuarios
                    </div>
                    <div class="p-4">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                   <th scope="col">CODIGO</th> 
                                   <th scope="col">NOMBRE</th>
                                   <th scope="col">APELLIDO</th> 
                                   <th scope="col">TELEFONO</th> 
                                   <th scope="col">CORREO</th> 
                                   <th scope="col">NICK NAME</th>  
                                   <th scope="col">TIPO DE USUARIO</th>  
                                   <th scope="col" colspan="2">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($row = mysqli_fetch_array($accion)):
                                ?>
                                <tr>
                                    <td scope="row"><?= $row['id_usuario'] ?></td>
                                    <td scope="row"><?= $row['nombre_usuario'] ?></td>
                                    <td scope="row"><?= $row['apellido_usuario'] ?></td>
                                    <td scope="row"><?= $row['telefono_usuario'] ?></td>
                                    <td scope="row"><?= $row['correo_usuario'] ?></td>
                                    <td scope="row"><?= $row['nick_name_usuario'] ?></td>
                                    <td scope="row"><?= $row['nombre_tipo_usuario'] ?></td>

                                    <td><a href="actualizarUsuario.php?codigo=<?= $row['id_usuario'] ?>&u=<?php echo $_GET['u']?>"><i class="bi bi-pencil-square"></i></a></td>
                                    <td><a href="eliminarUsuario.php?codigo=<?= $row['id_usuario'] ?>&u=<?php echo $_GET['u']?>"><i class="bi bi-trash3"></i></a></td>
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