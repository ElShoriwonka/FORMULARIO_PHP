
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/FORMULARIO/style.css">
    <title>Formulario</title>
</head>

<body>
    <?php
    include("../conexion.php");
    ?>
    <div class="container">
        <h1>Formulario de votación</h1>
        <form id="formulario" method="POST">
        <fieldset>
            <ul class="flex-outer">
                <li>
                    <label>Nombre y Apellido:</label>
                    <input type="text" name="nombre" id="nombre" required minlength="2">
                </li>
                <li>
                    <label>Alias:</label>
                    <input type="text" id="alias" name="alias" required minlength="5">
                </li>
                <li>
                    <label>Rut:</label>
                    <input type="text" id="rut" name="rut">
                </li>
                <li>
                    <label>Email:</label>
                    <input type="email" id="mail" name="mail" required minlength="2">
                </li>
                <li>
                    <?php
                    $query = 'SELECT r.id,r.nombre FROM tbl_region r order by nombre asc';
                    $resultado = $conexion->query($query);
                    ?>
                    <label for="region">Región:</label>
                    <select name="region" id="region" required>
                        <option value="nada">seleccionar una region...</option>
                        <?php
                        while ($row = $resultado->fetch_assoc()) {
                        ?>
                            <option nomRegion="<?php echo $row['nombre'];?>" id="<?php echo $row['id'];?>" value="<?php echo $row['id'];?>"><?php echo $row['nombre'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                </li>
                <li>
                    <label for="comuna">Comuna:</label>
                    <select name="comuna" id="comuna" required></select>
                </li>

                <li>
                    <label for="candidato">Candidato:</label>
                    <select name="candidato" id="candidato" required>
                        <option value="">Seleccionar opcion ...</option>
                        <?php
                        $query = 'SELECT nombre_candidato FROM candidato order by nombre_candidato asc';
                        $resultado = $conexion->query($query);
                        foreach ($resultado as $key => $valor) {
                        ?>
                            <option name="candidato" id="<?php echo $valor['nombre_candidato']; ?>" value="<?php echo $valor['nombre_candidato']; ?>"><?php echo $valor['nombre_candidato']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </li>
                <li>
                    <p>Como se enteró de nosotros:</p>
                    <ul class="flex-inner">
                        <li>
                        <input type="checkbox" class="check" name="checkbox" value="Web">
                            <label>Web</label>
                        </li>
                        <li>
                        <input type="checkbox" class="check" name="checkbox" value="Tv">
                            <label>Tv</label>
                        </li>
                        <li>
                        <input type="checkbox" class="check" name="checkbox" value="RR.SS">
                            <label>RR.SS</label>
                        </li>
                        <li>
                            <input type="checkbox" class="check" name="checkbox" value="Amigo">
                            <label>Amigo</label>
                        </li>
                    </ul>
                </li>

                <li>
                    <button id="btn-enviar">Votar</button>
                </li>
            </ul>
                    </fieldset>
        </form>
        
    </div>
    <script src="http://localhost/FORMULARIO/librerias/jquery/jquery.js"></script>
    <script src="http://localhost/FORMULARIO/librerias/jquery/rut.js"></script>
</body>

</html>

<script>
    $(document).ready(function() {

        $('#region').change(function() {
            $('#region option:selected').each(function() {
                id_region = $(this).val();
                $.post('cargarComunas.php', {
                    id_region: id_region
                }, function(data) {
                    $('#comuna').html(data);
                });
            });
        })

        $('#rut').Rut({
            on_error: function(){ alert('Rut incorrecto');
                $("#rut").val('');
                $("#rut").focus();
                return;
            },
            format_on: 'keyup'
	    });


        $("#btn-enviar").click(function(e) 
        {
            e.preventDefault();
            const nombre = $('#nombre').val();
            const alias = $('#alias').val();
            const mail = $('#mail').val();
            const rut = $('#rut').val();
            const region = $('#region option:selected').val();
            const nomRegion = $('#region option:selected').attr("nomRegion");
            const comuna = $('#comuna option:selected').val();
            const candidato = $('#candidato option:selected').val();
            const checkboxes = document.getElementsByName("checkbox");
            const idComuna = $("#comuna option:selected").attr("idComuna");
            
            let tipos = '';
            //const checked = $(".check:checked").length;
            var contador = 0;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) 
                {
                contador++;
                tipos += checkboxes[i].defaultValue+'  ';
                }
            }
            
            const regrex = /^[0-9a-zA-Z]+$/;
            const validadorMail = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
            //const validaRut = /^[0-9]+[-|‐]{1}[0-9kK]{1}$/

            if (nombre.trim() == "") {
                
                alert('Favor de ingresar un nombre');
            } else if (alias.trim().length < 5) {
                
                alert('No puede ser menor a 5 caracteres!!');
            } 
            else if (!regrex.test(alias)) {
                alert('Solo se admiten letras y numeros, no se permite el uso de otros caracteres!!');
            } 
            else if (rut == '') 
            {
                alert('El campo rut no puede estar vacio!!');
            }
            else if(rut.length<8)
            {
                alert('Ingresar un rut con mas caracteres!!');
            } 
            else if (!validadorMail.test(mail)) 
            {
                alert('El formato del correo no es valido, favor de ingresar un mail valido!!');
            } 
            else if (region == 'nada') 
            {
                alert('Seleccionar una region!!');
            } 
            else if (comuna == '') 
            {
                alert('Seleccionar una comuna');
            } 
            else if (candidato == '') 
            {
                alert('Seleccionar un candidato!!');
            }
            else if(contador <2)
            {             
                alert('Seleccionar al menos dos opciones!!');
            }
            else 
            {
                $.post('validacion.php', {rut: rut}, function(data)
                {
                    if(data == 'true')
                    {
                        alert('El rut ya fue ingresado!!');
                    }
                    else 
                    {
                        const datos = {
                                    nombre:nombre,
                                    alias:alias,
                                    rut:rut,
                                    mail:mail,
                                    id_region:region,
                                    nomRegion:nomRegion,
                                    id_comuna:idComuna,
                                    comuna:comuna,
                                    candidato:candidato,
                                    checkbox:tipos
                                }

                        $.ajax({
                            type: "POST",
                            url: "insertarDatos.php",
                            data: datos,
                            success: function(r) {
                                
                                if (r == 1) 
                                {                                  
                                    alert('datos enviados!!!');
                                    location.reload();
                                } 
                                else 
                                {
                                    alert('Error!!');
                                }
                            }
                        });                   
                    }               
                });                               
            }
        });
    });
</script>