<?php
    require_once("../Connect.php");
    $objeto = new ClsConnection();

    $tabla = 'materia';
    if ($_GET["ciclo"] == "[ TODOS ]")
    {
        $consulta = $objeto -> SQL_consulta($tabla,"id_materia, materia");
    }
    else
    {
        $consulta = $objeto -> SQL_consulta_condicional($tabla,"id_materia, materia","ciclo_materia like '".$_GET["ciclo"]."'");
    }

    print "<option value='null'>-- SELECCIONE --</option>";
    while ($fila = $consulta -> fetch_assoc())
    {
        print "<option value='$fila[id_materia]'>$fila[materia]</option>";
    }
?>