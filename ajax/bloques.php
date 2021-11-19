<?php
require_once("../Connect.php");
$objeto = new ClsConnection();


$tabla = 'horario';
$consulta = $objeto -> SQL_consulta_condicional($tabla, "ha,hf", "ha IN (SELECT ha FROM detalle WHERE dia = '".$_GET["dia"]."' && id_d = ".$_GET["docente"]." && YEAR='".$_GET["year"]."')");
print "<h4>Bloques ocupados del docente seleccionado:</h4>";
print "<div class='alert alert-primary' role='alert'>";
if(mysqli_num_rows($consulta) < 1)
{
    print "Todos los bloques de horario están disponibles.";
}
else
{
    while ($fila = $consulta -> fetch_assoc())
    {
        print "$fila[ha]-$fila[hf] <b>|</b> ";

    }
}
print "</div>";

$tabla = 'horario';
$consulta = $objeto -> SQL_consulta_condicional($tabla, "ha,hf", "ha IN (SELECT ha FROM detalle WHERE dia = '".$_GET["dia"]."' &&  id_g = ".$_GET["grupo"]." && YEAR='".$_GET["year"]."')");
print "<h4>Bloques ocupados del grupo seleccionado:</h4>";
print "<div class='alert alert-primary' role='alert'>";
if(mysqli_num_rows($consulta) < 1)
{
    print "Todos los bloques de horario están disponibles.";
}
else
{
    while ($fila = $consulta -> fetch_assoc())
    {
        print "$fila[ha]-$fila[hf] <b>|</b> ";

    }
}
print "</div>";


print "<label for='bloques' class='form-label' style='color:#8B0000'>Selecciona los bloques disponibles:</label>";               

    $tabla = 'detalle';
    $consulta = $objeto -> SQL_consulta_condicional($tabla, "ha", "dia = '".$_GET["dia"]."' && aula = ".$_GET["id_aula"]."  && YEAR='".$_GET["year"]."'");
        
    if(mysqli_num_rows($consulta) < 1)
    {
            $tabla = 'horario';
            $consultaHr = $objeto -> SQL_consulta_condicional($tabla, "ha,hf", "ha NOT IN (SELECT ha FROM detalle WHERE YEAR='".$_GET["year"]."' && dia = '".$_GET["dia"]."' && (id_d = ".$_GET["docente"]." or id_g = ".$_GET["grupo"]."))");
            while ($filaHr = $consultaHr -> fetch_assoc())
            {
                print"<div class='form-check text-start'>";
                    if($filaHr['ha'] == $_GET["ha"]) 
                    {
                        print"<input class='form-check-input' type='checkbox' id='idbloques' name='bloques[]' value='$filaHr[ha]' checked>";
                    }
                    else
                    {
                        print"<input class='form-check-input' type='checkbox' id='idbloques' name='bloques[]' value='$filaHr[ha]'>";
                    }
                    print"<label class='form-check-label' value='$filaHr[ha]'>$filaHr[ha] $filaHr[hf]</label>
                </div>";
            }
    }
    else
    {
            $tabla = 'horario';
            $consultaHr = $objeto -> SQL_consulta_condicional($tabla, "ha,hf", "ha NOT IN (SELECT ha FROM detalle WHERE YEAR='".$_GET["year"]."' && dia = '".$_GET["dia"]."' && (id_d = ".$_GET["docente"]." or id_g = ".$_GET["grupo"]."))");
            while ($filaHr = $consultaHr -> fetch_assoc())
            {
                print"<div class='form-check text-start'>";
                    if($filaHr['ha'] == $_GET["ha"]) 
                    {
                        print"<input class='form-check-input' type='checkbox' id='idbloques' name='bloques[]' value='$filaHr[ha]' checked>";
                    }
                    else
                    {
                        print"<input class='form-check-input' type='checkbox' id='idbloques' name='bloques[]' id='inha' value='$filaHr[ha]'>";
                    }
                    print"<label class='form-check-label' value='$filaHr[ha]'>$filaHr[ha] $filaHr[hf]</label>
                </div>";
            } 
    }
?>