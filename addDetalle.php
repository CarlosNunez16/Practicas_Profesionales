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
                    <p class="d-inline">Ciclo: I</p>&nbsp&nbsp|&nbsp&nbsp 
                    <p class="d-inline">Año: 2021</p>&nbsp&nbsp|&nbsp&nbsp     
                    <p class="d-inline">Día: <?php echo $_GET["dia"]; ?></p>  
                </div>
                <div class="col-md-12">
                    <label for="grupos" class="form-label">Ciclo:</label>
                    <select class="form-select" name="ciclo" id="ciclo">
                        <Option value=''>-- SELECCIONE --</Option>
                        <Option value='I'>I</Option>
                        <Option value='II'>II</Option>
                        <Option value='III'>III</Option>
                        <Option value='IV'>IV</Option>
                        <Option value='[ TODOS ]'>[ TODOS ]</Option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="grupos" class="form-label">Grupo:</label>
                    <select class="form-select" name="grupos" id="grupos">
                        <option value="">-- SELECCIONE --</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="docente" class="form-label">Docente:</label>
                    <select class="form-select" name="docente" id="docentes">
                    <?php
                        $tabla = 'docente';
                        $consulta = $objeto -> SQL_consulta($tabla, "id_docente, nombres_us, apellidos_us");
                        echo "<option value=''>-- SELECCIONE --</option>";
                        while ($fila = $consulta -> fetch_assoc())
                        {
                            echo "<Option value='$fila[id_docente]'>$fila[apellidos_us], $fila[nombres_us]</Option>";
                        }
                    ?>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="materia" class="form-label">Materia:</label>
                    <select class="form-select" name="materia" id="materias">
                        <option value="">-- SELECCIONE --</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="aula" class="form-label">Aula:</label>
                    <select class="form-select" name="aula" id="aula">
                        <option value="<?php echo $_GET["id_aula"];?>"><?php echo $_GET["aula"];?></option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="hInicio" class="form-label">Hora inicio:</label>
                    <select class="form-select" name="hInicio" id="hInicio">
                        <option value="<?php echo $_GET["ha"];?>"><?php echo $_GET["ha"];?></option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="carreras" class="form-label" style="color:#8B0000">Selecciona los bloques:</label>
                    
                    <?php
                        $tabla = 'detalle';
                        $consulta = $objeto -> SQL_consulta_condicional($tabla, "ha", "dia = '".$_GET["dia"]."' && idAula_FK = ".$_GET["id_aula"]."");
                            
                        if(mysqli_num_rows($consulta) < 1)
                        {
                                $tabla = 'horario';
                                $consultaHr = $objeto -> SQL_consulta($tabla, "ha,hf");
                                while ($filaHr = $consultaHr -> fetch_assoc())
                                {
                                    echo"<div class='form-check text-start'>";
                                        if($filaHr['ha'] == $_GET["ha"]) 
                                        {
                                            echo"<input class='form-check-input' type='checkbox' name='bloques[]' value='$filaHr[ha]' checked>";
                                        }
                                        else
                                        {
                                            echo"<input class='form-check-input' type='checkbox' name='bloques[]' value='$filaHr[ha]'>";
                                        }
                                        echo"<label class='form-check-label' value='$filaHr[ha]'>$filaHr[ha] $filaHr[hf]</label>
                                    </div>";
                                }
                        }
                        else
                        {
                            while ($fila = $consulta -> fetch_assoc())
                            {
                                $tabla = 'horario';
                                $consultaHr = $objeto -> SQL_consulta_condicional($tabla, "ha,hf", "ha != '".$fila["ha"]."'");
                                while ($filaHr = $consultaHr -> fetch_assoc())
                                {
                                    echo"<div class='form-check text-start'>";
                                        if($filaHr['ha'] == $_GET["ha"]) 
                                        {
                                            echo"<input class='form-check-input' type='checkbox' name='bloques[]' value='$filaHr[ha]' checked disabled>";
                                        }
                                        else
                                        {
                                            echo"<input class='form-check-input' type='checkbox' name='bloques[]' value='$filaHr[ha]'>";
                                        }
                                        echo"<label class='form-check-label' value='$filaHr[ha]'>$filaHr[ha] $filaHr[hf]</label>
                                    </div>";
                                } 
                            }
                        }
                    ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#ciclo").change(function(){
                            $.get("ajax/Grupos.php","ciclo="+$("#ciclo").val(), function(data){
                                $("#grupos").html(data);
                                console.log(data);
                            });
                        });

                        $("#docentes").change(function(){
                            $.get("ajax/Materias.php","docente="+$("#docentes").val(), function(data){
                                $("#materias").html(data);
                                console.log(data);
                            });
                        });
                    });
                </script>
                <div class="col-md-12">
                    <input class="btn btn-primary" type="submit" name="enviar" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</body>

<?php
    if(isset($_POST["enviar"]))
    {
        if (isset($_POST['bloques']))
        {
            $n = count($_POST['bloques']);
            $bloques = $_POST['bloques'];
        }
        $i=0;
    
        $tabla = 'horario';
        $consultaHr = $objeto -> SQL_consulta($tabla, "ha,hf");
        while ($filaHr = $consultaHr -> fetch_assoc())
        {
            if ($i<$n)
            {
                if($filaHr["ha"] == $bloques[$i])
                {
                    $datos[] = $_POST['docente'];
                    $datos[] = $_POST['grupos'];
                    $datos[] = $_POST['materia'];
                    $datos[] = $_GET['id_aula'];
                    $datos[] = $filaHr["ha"];
                    $datos[] = $filaHr["hf"];                
                    $datos[] = $_POST['ciclo'];
                    $datos[] = $_GET['dia'];
                    $datos[] = "tipo";
                    $datos[] = "1";
                    $datos[] = "1000-01-01";
                    $datos[] = "1000-01-01";
                    $datos[] = "s";
                    $datos[] = "1000";

                    echo "<pre>";
                    var_dump($datos);
                    echo "</pre>";
                    $campos = array('idDocente_FK','idGrupo_FK', 'idMateria_FK', 'idAula_FK', 'ha', 'hf', 'ciclo', 'dia', 'tipo', 'version', 'fecha_ini', 'fecha_fin', 'comentario_reserva', 'carnet_usuario');
                    $tabla = "detalle";
                    $rs = $objeto -> SQL_insert($tabla, $campos, $datos);
                    $i++;
                }
            }
            unset($datos);
        }
        echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload(); window.close();</script>";
    }
?>