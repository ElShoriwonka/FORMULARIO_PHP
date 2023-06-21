<?php
    $conexion=mysqli_connect('localhost','root','','formulario');

    $nombre = $_POST['nombre'];
    $alias = $_POST['alias'];
    $rut = $_POST['rut'];
    $email = $_POST['mail'];
    $region = $_POST['region'];
    $comuna = $_POST['comuna'];
    $candidato = $_POST['candidato'];
    $opciones = $_POST['checkbox'];

    $sql = "insert into datos(nombre,alias,rut,email,region,comuna,candidato,tipo_comunicacion)
            values('$nombre','$alias','$rut','$email','$region','$comuna','$candidato','$opciones')";

    echo mysqli_query($conexion,$sql);
?>