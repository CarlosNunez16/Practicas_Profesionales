<?php
    require_once("Connect.php");
    $objeto = new ClsConnection();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type='text/javascript' src='Hora.js'></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="js/jquery-3.6.0.min.js"></script>
    <title>Horarios</title> 
</head>
<body> 
    <div class="row d-flex justify-content-center">
        <div class="col-11 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
            <h1 class="alert alert-primary text-center">AGREGAR HORARIO</h1>
            <form class="row g-3 needs-validation" method="post">
                <div class="col-md-6 d-inline">
                    <p class="d-inline" for="ciclo">Ciclo: I</p>&nbsp&nbsp|&nbsp&nbsp 
                    <p class="d-inline" for="año">Año: 2021</p>&nbsp&nbsp|&nbsp&nbsp     
                    <p class="d-inline" for="dia">Día: <?php echo $_GET["dia"]; ?></p>  
                </div>
                <div class="col-md-12">
                    <label for="grupos" class="form-label">Ciclo:</label>
                    <select class="form-select" name="grupos" id="ciclo">
                        <Option value='I'>I</Option>
                        <Option value='II'>II</Option>
                        <Option value='III'>III</Option>
                        <Option value='IV'>IV</Option>
                        <Option value='[ TODOS ]'>[ TODOS ]</Option>
                    </select>
                </div>
                <?php 
                     echo"<script type='text/javascript'>
                            
                            if($('#ciclo option:selected').text() == 'I'){";
                                echo "<div class='col-md-12'>
                                    <label for='grupos' class='form-label'>Grupo:</label>
                                    <select class='form-select' name='grupos'>";
                                            $tabla = 'grupo';
                                            $consulta = $objeto -> SQL_consulta_condicional($tabla, "id_grupo, grupo", "ciclo = I");
                                            while ($fila = $consulta -> fetch_assoc())
                                            {
                                                echo "<Option value='$fila[id_grupo]'>$fila[grupo]</Option>";
                                            }
                                    echo "</select>
                                </div>";
                            echo"}else{
                                alert('Olaaaaaaaaa');
                            }
                    </script>";
                    $ciclo = "<script>  $('#ciclo') </script>";
                    if ($ciclo == "I")
                    {
                        echo "<script> alert('Criko 1'); </script>";
                    }
                        echo $ciclo;
                ?>
                <div class="col-md-12">
                    <label for="grupos" class="form-label">Grupo:</label>
                    <select class="form-select" name="grupos">
                        <?php
                            $tabla = 'grupos';
                            $consulta = $objeto -> SQL_consulta($tabla, "idGrupo, nombre");
                            while ($fila = $consulta -> fetch_assoc())
                            {
                                echo "<Option value='$fila[idGrupo]'>$fila[nombre]</Option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="subgrupos" class="form-label">Subgrupo:</label>
                    <select class="form-select" name="subgrupos">
                        <?php
                            $tabla = 'subgrupos';
                            $consulta = $objeto -> SQL_consulta($tabla, "idSubgrupo, nombre");
                            while ($fila = $consulta -> fetch_assoc())
                            {
                                echo "<Option value='$fila[idSubgrupo]'>$fila[nombre]</Option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="nombre">Nombre: </label>
                    <input class="form-control" type="text" name="nombre" title="Ingresa tu nombre" required>        
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="marca">Marca: </label>
                    <input class="form-control" type="text" name="marca" required>      
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="modelo">Modelo: </label>
                    <input class="form-control" type="text" name="modelo" required>    
                </div>
                <div class="col-md-1">
                    <label class="form-label" for="color">Color: </label>
                    <input class="form-control form-control-color" type="color" name="color" required>    
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="serie">Número de serie: </label>
                    <input class="form-control" type="text" name="serie" required>    
                </div>
                <div class="col-md-6">
                    <label for="usuarios" class="form-label">Usuario:</label>
                    <select class="form-select" name="usuarios">
                        <?php
                            $tabla = 'usuarios';
                            $consulta = $objeto -> SQL_consulta($tabla." where tipo_usuario='Administrador' or tipo_usuario='Empleado'", "carnet, nombres, apellidos");
                            while ($fila = $consulta -> fetch_assoc())
                            {
                                echo "<Option value='$fila[carnet]'>$fila[nombres] $fila[apellidos]</Option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="ubicacion">Ubicación: </label>
                    <input class="form-control" type="text" name="ubicacion" required>   
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="calidad">Calidad: </label>
                    <select class="form-select" name="calidad">
                        <Option value='Excelente'>Excelente</Option>
                        <Option value='Muy bueno'>Muy bueno</Option>
                        <Option value='Bueno'>Bueno</Option>
                        <Option value='Malo'>Malo</Option>
                        <Option value='Necesita reparación'>Necesita reparación</Option>
                    </select>     
                </div>
                <div class="col-md-12">
                    <input class="btn btn-primary" type="submit" name="enviar" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</body>