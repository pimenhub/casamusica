<?php
    //Creamos la conexion con la base de datos de MySQL
    //Variable para la conexion
    $host = "localhost";
    $usuario = "root";
    $contrasenia = "";
    $bd = "dbcasamusica"; 
    $conexion = mysqli_init();

    //Realizar la conexion
    mysqli_real_connect($conexion,$host,$usuario,$contrasenia,$bd);
    mysqli_set_charset($conexion,"utf8");

    //Prueba de conexion
    if(!mysqli_connect_error($conexion)){        
       // echo "Conexion Exitosa...<br>";
    }
    else{
        die("Error de Conexion ". mysqli_connect_error());
    }

?>