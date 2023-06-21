<?php
    $conexion=mysqli_connect('localhost','root','','formulario');

    $nombre = $_POST['nombre'];
    $alias = $_POST['alias'];
    $rut = $_POST['rut'];
    $email = $_POST['mail'];
    $id_region = $_POST['id_region'];
    $nomRegion = $_POST['nomRegion'];
    $id_comuna = $_POST['id_comuna'];
    $comuna = $_POST['comuna'];
    $candidato = $_POST['candidato'];
    $opciones = $_POST['checkbox'];

    $sql = "insert into datos(nombre,alias,rut,email,id_region,region,id_comuna,comuna,candidato,tipo_comunicacion)
            values('$nombre','$alias','$rut','$email','$id_region','$nomRegion','$id_comuna','$comuna','$candidato','$opciones')";

    echo mysqli_query($conexion,$sql);
?>