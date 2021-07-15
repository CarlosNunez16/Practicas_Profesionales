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


<div class='row d-flex justify-content-center'>
    <div class='col-12 m-3'>
        <table class='table table-striped table-hover table-sm'>
        <form method='post'>
            <thead>
                <tr>
                    <th scope='col'class="table-primary"></th>
                    <?php
                        $tabla = 'aula';
                        $consulta = $objeto -> SQL_consulta($tabla,"aula");
                        while ($fila = $consulta -> fetch_assoc())
                        {
                            echo "<th scope='col' class='table-primary'>$fila[aula]</th>";
                        }
                       $col=mysqli_num_rows($consulta);
                    ?>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <?php    
                        $hr = 'horario';
                        $consultahr = $objeto -> SQL_consulta_condicional($hr,"ha,hf","id_horario = 1");
                        while ($fila = $consultahr -> fetch_assoc())
                        {
                            echo "<td class='table-info'>$fila[ha] $fila[hf]</td>";
                        }
                        for ($i=0; $i<$col; $i++)
                            {
                                ?>
                                <td><a href="javascript:window.open('addDetalle.php?dia=<?php echo $_GET["dia"];?>','','width=600,height=400,left=400,top=250,toolbar=yes');void 0"><p class='fs-6'>Agregar Horario</p></a></td>
                                <?php
                            }
                        ?>
                    </tr>
                    <tr>
                    <?php    
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
                        ?>
                    </tr>
                    <tr>
                        <td class="table-secondary" colspan="<?php echo $col+1; ?>" align="center">Receso</td>
                    </tr>
                    <tr>
                    <?php    
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
                        ?>
                    </tr>
                    <tr>
                    <?php    
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
                        ?>
                    </tr>
                    <tr>
                        <td class="table-secondary" colspan="<?php echo $col+1; ?>" align="center">Receso</td>
                    </tr>
                    <tr>
                    <?php    
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
                        ?>
                    </tr>
                    <tr>
                    <?php    
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
                        ?>
                    </tr>
                    <tr>
                        <td class="table-secondary" colspan="<?php echo $col+1; ?>" align="center">Almuerzo</td>
                    </tr>
                    <tr>
                    <?php    
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
                        ?>
                    </tr>
                    <tr>
                    <?php    
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
                        ?>
                    </tr>
                    <tr>
                        <td class="table-secondary" colspan="<?php echo $col+1; ?>" align="center">Receso</td>
                    </tr>
                    <tr>
                    <?php    
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
                        ?>
                    </tr>
                    <tr>
                    <?php    
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
                        ?>
                    </tr>
                    <tr>
                        <td class="table-secondary" colspan="<?php echo $col+1; ?>" align="center">Receso</td>
                    </tr>
                    <tr>
                    <?php    
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
                        ?>
                    </tr>
                    <tr>
                    <?php    
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
                        ?>
                    </tr>
            </tbody>
        </form>
        </table> 
    </div>
</div>