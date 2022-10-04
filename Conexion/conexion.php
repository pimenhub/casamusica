<?php
    //Creamos la conexion con la base de datos de MySQL
    //Variable para la conexion
    $host = "intecap-2022.mysql.database.azure.com";
    $usuario = "pimentel2022@intecap-2022.mysql.database.azure.com";
    $contrasenia = "Intecap2022.";
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