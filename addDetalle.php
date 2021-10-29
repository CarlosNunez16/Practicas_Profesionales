<?php
    require_once("Connect.php");
    $objeto = new ClsConnection();
    date_default_timezone_set("America/El_Salvador");
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
                    <p class="d-inline">Día: <?php echo $_GET["dia"]; ?></p>&nbsp&nbsp|&nbsp&nbsp  
                    <p class="d-inline">Aula: <?php echo $_GET["aula"]; ?></p> 
                </div>
                <?php
                    if(isset($_POST["Guardar"]))
                    {
                        if (isset($_POST['bloques']))
                        {
                            $n = count($_POST['bloques']);
                            $bloques = $_POST['bloques'];
                        }
                        else
                        {
                            $n=0;
                        }

                        if ($n==0 || $_POST['docente'] == "null" || $_POST['grupos'] == "null" || $_POST['materia'] == "null" || $_POST['ciclo'] == "null")
                        {
                            echo "
                                <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
                                    <symbol id='exclamation-triangle-fill' fill='currentColor' viewBox='0 0 16 16'>
                                        <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
                                    </symbol>
                                </svg>
                            
                                <div class='alert alert-danger d-flex align-items-center mt-3' role='alert'>
                                    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                                    <div>
                                        Error: No seleccionó todos los campos.
                                    </div>
                                </div>";
                        }
                    }
                ?>
                <div class="col-md-12">
                    <label for="grupos" class="form-label">Ciclo:</label>
                    <select class="form-select" name="ciclo" id="ciclo" required>
                        <Option value='null'>-- SELECCIONE --</Option>
                        <Option value='I'>I</Option>
                        <Option value='II'>II</Option>
                        <Option value='III'>III</Option>
                        <Option value='IV'>IV</Option>
                        <Option value='[ TODOS ]'>[ TODOS ]</Option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="materia" class="form-label">Materia:</label>
                    <select class="form-select" name="materia" id="materias">
                        <option value="null">-- SELECCIONE --</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="docente" class="form-label">Docente:</label>
                    <select class="form-select" name="docente" id="docentes">
                    <?php
                        $tabla = 'docente';
                        $consulta = $objeto -> SQL_consulta($tabla, "id_docente, nombres_us, apellidos_us");
                        echo "<option value='null'>-- SELECCIONE --</option>";
                        while ($fila = $consulta -> fetch_assoc())
                        {
                            echo "<Option value='$fila[id_docente]'>$fila[apellidos_us], $fila[nombres_us]</Option>";
                        }
                    ?>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="grupos" class="form-label">Grupo:</label>
                    <select class="form-select" name="grupos" id="grupos">
                        <option value="null">-- SELECCIONE --</option>
                    </select>
                </div>
                <div class="col-md-12" id="bloques">

                </div>
                <div class="col-md-12">
                    <label for="fechaIni" class="form-label">Fecha de inicio:</label>
                    <input type="date" name="fechaIni" id="fechaIni" required>
                </div>
                <div class="col-md-12">
                    <label for="fechaFin" class="form-label">Fecha de fin:</label>
                    <input type="date" name="fechaFin" id="fechaFin" required>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#ciclo").change(function(){
                            $.get("ajax/Grupos.php","ciclo="+$("#ciclo").val(), function(data){
                                $("#grupos").html(data);
                                console.log(data);
                            });
                        });

                        $("#ciclo").change(function(){
                            $.get("ajax/Materias.php","ciclo="+$("#ciclo").val(), function(data){
                                $("#materias").html(data);
                                console.log(data);
                            });
                        });

                        const valores = window.location.search;
                        const urlParams = new URLSearchParams(valores);
                        var dia = urlParams.get('dia');
                        var ha = urlParams.get('ha');
                        var id_aula = urlParams.get('id_aula');

                        if ($("#docentes").val() != "")
                        {
                            $("#grupos").change(function(){
                            $.get("ajax/bloques.php?dia="+dia+"&ha="+ha+"&id_aula="+id_aula+"&docente="+$("#docentes").val()+"&grupo="+$("#grupos").val()+"", function(data){                                
                                $("#bloques").html(data);
                                console.log(data);
                            });
                            });
                        }
                        if ($("#grupos").val() != "")
                        {
                            $("#docentes").change(function(){
                            $.get("ajax/bloques.php?dia="+dia+"&ha="+ha+"&id_aula="+id_aula+"&docente="+$("#docentes").val()+"&grupo="+$("#grupos").val()+"", function(data){                                
                                $("#bloques").html(data);
                                console.log(data);
                            });
                            });
                        }
                        
                        $("#Guardar").click(function(){
                            if($("input:checkbox[name='bloques[]']").is(":checked")){
                                $("input:checkbox[name='bloques[]']").prop('required', false);
                            }
                            else
                            {
                                $("input:checkbox[name='bloques[]']").prop('required', true);
                            }
                        });
                    });
                </script>
                <div class="col-md-12">
                    <input class="btn btn-primary" type="submit" name="Guardar" id="Guardar" value="Guardar">
                </div>
            </form>
<?php
    if(isset($_POST["Guardar"]))
    {
        if (isset($_POST['bloques']))
        {
            $n = count($_POST['bloques']);
            $bloques = $_POST['bloques'];
        }
        else
        {
            $n=0;
        }
        $i=0;

        if ($n!=0 && $_POST['docente'] != "null" && $_POST['grupos'] != "null" && $_POST['materia'] != "null" && $_POST['ciclo'] != "null")
        {
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

                            $consultaTipo = $objeto -> SQL_consulta_condicional("grupo", "tipo", "id_grupo = ".$_POST['grupos']."");
                            $tipo = mysqli_fetch_array($consultaTipo);
                            
                            $datos[] = $tipo["tipo"];
                            $datos[] = "v1";

                            $fecha_ini = str_replace('/', '-', $_POST['fechaIni']);
                            $fechaIniSql = date('Ymd', strtotime($fecha_ini));

                            $fecha_fin = str_replace('/', '-', $_POST['fechaFin']);
                            $fechaFinSql = date('Ymd', strtotime($fecha_fin));

                            $datos[] = $fechaIniSql;
                            $datos[] = $fechaFinSql;
                            $datos[] = "s";
                            $datos[] = "1000";

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
    }
?>
        </div>
    </div>
</body>