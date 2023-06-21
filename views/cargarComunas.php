<?php 
    include("../conexion.php");

    $id_region = $_POST['id_region'];

    $queryC = " SELECT 
                r.id,
                c.id_comuna,
                c.nombre
                FROM tbl_region r
                inner join tbl_provincia p on r.id = p.idRegion
                inner join tbl_comuna c on p.id = c.idProvincia
                where r.id ='$id_region' order by c.nombre asc";

    $resultadoC = $conexion->query($queryC);

    $html = "<option value=''>seleccionar una comuna...</option>";
    while ($comunas = $resultadoC->fetch_assoc()) 
    {
        $html.= "<option idComuna='".$comunas['id_comuna']."' value='".$comunas['nombre']."'>".$comunas['nombre']."</option>";
    }
    echo $html;

?>