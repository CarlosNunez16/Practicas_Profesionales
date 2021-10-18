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
    $("#grupos").change(function(){
        $.get("ajax/bloques.php?dia="+dia+"&ha="+ha+"&id_aula="+id_aula+"&docente="+$("#docentes").val()+"&grupo="+$("#grupos").val()+"", function(data){                                
            $("#bloques").html(data);
            console.log(data);
        });
    });
});