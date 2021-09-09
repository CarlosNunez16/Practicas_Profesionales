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

    }
    elseif($_GET["dia"] == "Lunes")
    {
        echo"<div class='row d-flex justify-content-center'>
            <div class='col-12 m-3'>
                <table class='table table-striped table-hover table-sm'>
                <form method='post'>
                    <thead>
                        <tr>
                            <th scope='col'class='table-primary'></th>";
                            
                                $tabla = 'aula';
                                $consulta = $objeto -> SQL_consulta($tabla,"aula");
            
                                while ($fila = $consulta -> fetch_assoc())
                                {
                                    echo "<th scope='col' class='table-primary'>$fila[aula]</th>";
                                    $array[]=$fila['aula'];
                                }
                            $col=mysqli_num_rows($consulta);
                            
                        echo"</tr>
                    </thead>
                    <tbody>
                            <tr>";
                                 
                                $n=0;
                                $tabla = 'detalle';
                                $consultahr = $objeto -> SQL_consulta_condicional($tabla,"materia,codigo_materia","id_horario = 1"); 

                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 1");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                    $ha=$fila['ha']; //de aqui se tomara para la hora
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        $campos = 'materia.materia as Materia, materia.codigo_materia as CodMateria, docente.nombres_us AS NombresUS, docente.apellidos_us AS ApellidosUS, grupo.grupo AS Grupo';
                                        $tabla = 'detalle INNER JOIN materia ON (detalle.idMateria_FK=materia.id_materia) INNER JOIN docente ON (detalle.idDocente_FK=docente.id_docente) INNER JOIN grupo ON (detalle.idGrupo_FK=grupo.id_grupo) INNER JOIN aula ON (detalle.idAula_FK=aula.id_aula)';
                                        $consulta = $objeto -> SQL_consulta_condicional($tabla, $campos,"dia = '".$_GET["dia"]."' && ha = '".$ha."' && aula.aula = '".$array[$n]."'");

                                        // var_dump($consulta);

                                        if(mysqli_num_rows($consulta) < 1)
                                        {
                                            ?>
                                            <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>&ha=<?php echo $ha;?>&aula=<?php echo $array[$i];?>','','width=600,height=400,left=400,top=200,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                            <?php
                                        }
                                        else
                                        {
                                            while ($fila = $consulta -> fetch_assoc())
									        {
                                                echo "
                                                    <td>
                                                        $fila[Materia],
                                                        $fila[CodMateria],
                                                        $fila[NombresUS] $fila[ApellidosUS],
                                                        $fila[Grupo]
                                                    </td>
                                                ";
                                            }
                                        }
                                        $n++;
                                    }
                                
                            echo"</tr>
                            <tr>";   
                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 2");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        echo "<td><a href='#'>Agregar Horario</a></td>";
                                    }
                                
                            echo"</tr>
                            <tr>
                                <td class='table-secondary' colspan='".($col+1)."' align='center'>Receso</td>
                            </tr>
                            <tr>";
                              
                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 13");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        echo "<td><a href='#'>Agregar Horario</a></td>";
                                    }
                                
                            echo"</tr>
                            <tr>";
                               
                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 14");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        echo "<td><a href='#'>Agregar Horario</a></td>";
                                    }
                                
                            echo"</tr>
                            <tr>
                                <td class='table-secondary' colspan='".($col+1)."' align='center'>Receso</td>
                            </tr>
                            <tr>";
                                
                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 15");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        echo "<td><a href='#'>Agregar Horario</a></td>";
                                    }
                                
                            echo"</tr>
                            <tr>";
                                
                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 16");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        echo "<td><a href='#'>Agregar Horario</a></td>";
                                    }
                                
                            echo"</tr>
                            <tr>
                                <td class='table-secondary' colspan='".($col+1)."' align='center'>Almuerzo</td>
                            </tr>
                            <tr>";
                                
                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 18");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        echo "<td><a href='#'>Agregar Horario</a></td>";
                                    }
                                
                            echo"</tr>
                            <tr>";
                                
                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 19");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        echo "<td><a href='#'>Agregar Horario</a></td>";
                                    }
                                
                            echo"</tr>
                            <tr>
                                <td class='table-secondary' colspan='".($col+1)."' align='center'>Receso</td>
                            </tr>
                            <tr>";
                               
                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 20");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        echo "<td><a href='#'>Agregar Horario</a></td>";
                                    }
                                
                            echo"</tr>
                            <tr>";
                             
                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 21");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        echo "<td><a href='#'>Agregar Horario</a></td>";
                                    }
                                
                            echo"</tr>
                            <tr>
                                <td class='table-secondary' colspan='".($col+1)."' align='center'>Receso</td>
                            </tr>
                            <tr>";
                                
                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 22");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        echo "<td><a href='#'>Agregar Horario</a></td>";
                                    }
                                
                            echo"</tr>
                            <tr>";
                        
                                $hr = 'horario';
                                $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 23");
                                while ($fila = $consultahr -> fetch_assoc())
                                {
                                    echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                                }
                                for ($i=0; $i<$col; $i++)
                                    {
                                        echo "<td><a href='#'>Agregar Horario</a></td>";
                                    }
                                
                            echo"</tr>
                    </tbody>
                </form>
                </table>
            </div>
        </div>";
    }
?>