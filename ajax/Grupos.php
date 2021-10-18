<?php
require_once("../Connect.php");
$objeto = new ClsConnection();

$tabla = 'grupo';
if ($_GET["ciclo"] == "[ TODOS ]")
{
    $consulta = $objeto -> SQL_consulta($tabla,"id_grupo, grupo");
}
else
{
    $consulta = $objeto -> SQL_consulta_condicional($tabla,"id_grupo, grupo, tipo","ciclo like '".$_GET["ciclo"]."'");
}

print "<option value=''>-- SELECCIONE --</option>";
while ($fila = $consulta -> fetch_assoc())
{
    print "<option value='$fila[id_grupo]'>$fila[grupo]$fila[tipo]</option>";
}
?>