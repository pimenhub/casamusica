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
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Administracion/index.php?u=<?php echo $_GET['u']?>">Administracion de Usuarios</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Compras/index.php?u=<?php echo $_GET['u']?>">Visualizacion de Compras</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="index.php?u=<?php echo $_GET['u']?>">Entregas de Compra</a>
                    <a class="py-2 text-dark text-decoration-none" href="../Login/logout.php">Log out</a>
                    
                <?php
                }elseif(isset($_GET['u']) && $_GET['u'] == 'manager'){
                    $usuario = "manager";
                ?>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Gestion/index.php?u=<?php echo $_GET['u']?>">Gestion de Articulos</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="../Compras/index.php?u=<?php echo $_GET['u']?>">Visualizacion de Compras</a>
                    <a class="me-3 py-2 text-dark text-decoration-none" href="index.php?u=<?php echo $_GET['u']?>">Entregas de Compra</a>
                    <a class="py-2 text-dark text-decoration-none" href="../Login/logout.php">Log out</a>
                <?php
                }
                ?>
                   
                </nav>
        </header>
        <div class="row justify-content-center">
            <form action="../Entregas/busqueda.php" method="POST">
                <div class="mb-3">
                    <input type="hidden" class="form-control" name="u" value="<?php echo $_GET['u']?>" autofocus required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="codCompra" placeholder="Ingrese el codigo de la compra" autofocus required>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="tipoCompra">
                        <option selected value="0">Seleccione tipo de compra...</option>
                        <option value="1">Cliente</option>
                        <option value="2">Anonima</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-success" value="Buscar Compra">  
                </div>
            </form>
        </div>
</body>
</html>