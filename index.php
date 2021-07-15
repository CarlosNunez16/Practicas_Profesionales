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
    <title>Administrador</title> 
</head>
<body onload="mueveReloj()"> 
    <div class="container-fluid">
        <div class="row">
            <header>
                <div class="col-12 d-flex justify-content-between align-items-center" style="background-color:#fff">
                    <img title="AYUDA, ESTO NO ES UN MEME" class="img-fluid rounded float-start" src="logo.png" alt="ITCA-FEPADE">
                    <h1 class="d-inline text-center fw-bold fs-4 text-dark" title="AYUDA DIOSITO :(">SISTEMA DE HORARIOS.</h1>
                    <div class="d-inline col-1 text-center">
                        <form name="form_reloj">
                            <input title="Ya enserio, ayuda" class="border-0" type="text" name="reloj" size="10" disabled>
                        </form>
                    </div>
                </div>
            </header>
        </div>
        <nav class="row navbar navbar-expand-lg"  style="background-color:#8B0000">
                <div class="col-10 d-inline collapse navbar-collapse d-flex" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white active" aria-current="page" href="index.php?pagina=Manta.php" title="¿Manta?">Manta</a>
                        </li>
                </div>
            </ul>
        </nav>
        <section class="row d-flex justify-content-center">
            <?php
                if(isset($_GET["pagina"]))
                {
                    include ($_GET["pagina"]);
                }
                else 
                {
                    
                }
            ?>
        </section>
            <br>
        <footer class="row border-top border-danger" style="background-color:#F5F5F5">
                <p class="text-center fs-9">ESCUELA ESPECIALIZADA EN INGENIERÍA ITCA-FEPADE, TODOS LOS DERECHOS RESERVADOS.<br>
                CARRETERA A SANTA TECLA KM. 11, LA LIBERTAD, EL SALVADOR C.A.<br>
                TEL. (503) 2132-7400</p>
        </footer>
    </div>
</body>
</html>