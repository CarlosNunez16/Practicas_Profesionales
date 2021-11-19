<?php
    @session_start();
    $_SESSION["year"] = 2018;
?>

<div class="row d-flex justify-content-center">
	<div class="col-3 m-3 s-1 p-3 border border-dark rounded-3 d-block" style="background-color:#F5F5F5">
        <h1 class="text-center fs-4">Día Seleccionado: <?php echo $_GET["dia"]; ?></h1>
		<form class="row g-3 needs-validation" name='form1' method="post" target='_self'>
        <div class="col-md-12">
            <label class="form-label" for="tipo">Seleccionar día</label>
            <select class="form-select" name="tipo" onChange='javascript:abreSitio()' required>
                <option value='#'>Elegir...</option>
                <option value='?pagina=Manta.php&dia=Lunes'>Lunes</option>
                <option value='?pagina=Manta.php&dia=Martes'>Martes</option>
                <option value='?pagina=Manta.php&dia=Miércoles'>Miércoles</option>
                <option value='?pagina=Manta.php&dia=Jueves'>Jueves</option>
                <option value='?pagina=Manta.php&dia=Viernes'>Viernes</option>
                <option value='?pagina=Manta.php&dia=Sábado'>Sábado</option>
                <option value='?pagina=Manta.php&dia=Domingo'>Domingo</option>
            </select>
        </div>
        </form>
    </div>
</div>

<?php
    if ($_GET["dia"] == "Ninguno")
    {
        echo"<h2>seleccione un día</h2>";
    }
    else
    {
        echo"<div class='row d-flex justify-content-center'>
            <div class='col-12 m-3'>
                <table class='table table-striped table-hover table-sm'>
                <form method='post'>
                    <thead>
                        <tr>
                            <th scope='col'class='table-primary'></th>";
                            
                                $tabla = 'aula';
                                $consulta = $objeto -> SQL_consulta($tabla,"id_aula,aula");
            
                                while ($fila = $consulta -> fetch_assoc())
                                {
                                    echo "<th scope='col' class='table-primary'>$fila[aula]</th>";
                                    $arrayAula[]=$fila['aula'];
                                    $arrayIdAula[]=$fila['id_aula'];
                                }
                            $col=mysqli_num_rows($consulta);
                            
                        echo"</tr>
                    </thead>
                    <tbody>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 1");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '07:50:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {
                                                        echo "
                                                        <td rowspan='2'>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 2");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '07:00:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {

                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else 
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>
                                <td class='table-secondary' colspan='".($col+1)."' align='center'>Receso</td>
                            </tr>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 13");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '09:50:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {
                                                        echo "
                                                        <td rowspan='2'>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 14");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '09:00:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {

                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else 
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>
                                <td class='table-secondary' colspan='".($col+1)."' align='center'>Receso</td>
                            </tr>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 15");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '11:30:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {
                                                        echo "
                                                        <td rowspan='2'>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 16");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '10:40:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {

                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else 
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>
                                <td class='table-secondary' colspan='".($col+1)."' align='center'>Almuerzo</td>
                            </tr>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 18");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '13:50:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {
                                                        echo "
                                                        <td rowspan='2'>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 19");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '13:00:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {

                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else 
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>
                                <td class='table-secondary' colspan='".($col+1)."' align='center'>Receso</td>
                            </tr>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 20");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '15:30:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {
                                                        echo "
                                                        <td rowspan='2'>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 21");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '14:40:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {

                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else 
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>
                                <td class='table-secondary' colspan='".($col+1)."' align='center'>Receso</td>
                            </tr>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 22");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '17:10:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {
                                                        echo "
                                                        <td rowspan='2'>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>";
                                 
                                $n=0;

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 23");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha'];
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigomateria as CodMateria, docente.nom_usuario AS NombresUS, docente.ape_usuario AS ApellidosUS, grupo.grupo AS Grupo, grupo.tipo as Tipo, cod_alldetalle';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.id_m=materia.id_materia) INNER JOIN docente ON (detalle.id_d=docente.id_docente) INNER JOIN grupo ON (detalle.id_g=grupo.id_grupo)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]."");

                                        

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $arrayAula[$i];?>&year=<?php echo $_SESSION["year"];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $consultaUnir = $objeto -> SQL_consulta_condicional("detalle", "cod_alldetalle","dia = '".$_GET["dia"]."' && aula = '".$arrayAula[$n]."' && detalle.YEAR=".$_SESSION["year"]." && ha = '16:20:00'");
                                            $cod_alldetalle2=$consultaUnir->fetch_assoc();

                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                if(mysqli_num_rows($consultaUnir) > 0)
                                                {
                                                    if ($cod_alldetalle2["cod_alldetalle"]==$fila["cod_alldetalle"])
                                                    {

                                                    }
                                                    else
                                                    {
                                                        echo "
                                                            <td>
                                                                <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        ";
                                                    }
                                                }
                                                else 
                                                {
                                                    echo "
                                                        <td>
                                                            <table style='text-align:center' class='border border-dark table table-bordered table-sm'>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Materia]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-primary border border-dark'><b>$fila[CodMateria]</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[NombresUS] $fila[ApellidosUS]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class='table-light border border-dark'>$fila[Grupo]$fila[Tipo]</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    ";
                                                }
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                    </tbody>
                </form>
                </table>
            </div>
        </div>";
    }
?>