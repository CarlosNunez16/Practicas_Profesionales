<?php
require_once("../Connect.php");
$objeto = new ClsConnection();

$consulta = $objeto -> SQL_consulta_condicional("docente","id_docente, idDepartamento_FK2","id_docente = ".$_GET["docente"]."");
while ($fila = $consulta -> fetch_assoc())
{
    $tabla = 'materia';
    $consultaMat = $objeto -> SQL_consulta_condicional($tabla,"id_materia, materia","idDepartamento_FK3 = ".$fila['idDepartamento_FK2']."");
}

print "<option value=''>-- SELECCIONE --</option>";
while ($filas = $consultaMat -> fetch_assoc())
{
    print "<option value='$filas[id_materia]'>$filas[materia]</option>";
}
?>