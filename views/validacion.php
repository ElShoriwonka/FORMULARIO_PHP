<?php
    include("../conexion.php");

    $rut = $_POST['rut'];

    $query = "select rut from datos where rut = '$rut'";
    $resultado = $conexion->query($query);
    try{
        if($resultado)
        {
            $rows = mysqli_num_rows($resultado);
            if ($rows>0) 
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
        }
    }
    catch(Exception $e)
    {
        echo $e.'false';
    }
?>