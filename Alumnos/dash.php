<?php 
    include ('../DAO.php');

    //Se crea el objeto dao para la Sentencia de pase de lista
    $dao =  new DAO();
    $consulta = "SELECT * FROM Pase_de_lista Where Matricula=:id";
    $parametros = array("id"=>$_GET['matricula']);
    $alumnos = $dao->ejecutarConsulta($consulta,$parametros);

    //Funcion para Obtener el nombre del dia
    function semanaDias($dia){
        $fechaEntera = strtotime($dia);
        $dias = date('D',$fechaEntera);
        switch($dias){
            case "Mon":
                $dias = "Lunes";
                break;
            case "Tue":
                $dias = "Martes";
                break;
            case "Wed":
                $dias = "Miercoles";
                break;
            case "Thu":
                $dias = "Jueves";
                break;
            case "Fri":
                $dias = "Viernes";
                break;
        }
        return $dias;
    }
    //Fin Funcion 

    //Arreglo semana
    $semana[0] = "Lunes";
    $semana[1] = "Martes";
    $semana[2] = "Miercoles";
    $semana[3] = "Jueves";
    $semana[4] = "Viernes";
    //Fin arreglo
?>

<!-- Inicio del Html -->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <title>Asistencia</title>
</head>
<body>
    <div class="container">
        <section class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <!-- Inicio del header-->
                            <div class="card-header">
                                <!-- Titulo de la carta -->
                                <h3 class="card-title">
                                    Alumnos
                                </h3>
                                <!-- Boton para regresar-->
                                <div class="btn-group" style="float:right;">
                                    <a href="../login.php" class="btn btn-block btn-success" style="float: right;">
                                        Regresar
                                    </a>
                                </div>
                            </div>
                            <!-- Fin del header-->
                            <!-- Inicio de la tabla -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <!-- Incio Header Tabla -->
                                    <thead>
                                        <tr>
                                            <th>Materia</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Asistio</th>
                                        </tr>
                                    </thead>
                                    <!-- Fin Header Tabla-->
                                    <!-- Inicio del body de la tabla -->
                                    <tbody>
                                        <?php echo $alumnos; 
                                        foreach($alumnos as $alumno){?>
                                        <tr>
                                            <th><?php echo $alumno['Clase'];?></th>
                                            <th><?php echo $alumno['Dia'];?></th>
                                            <th><?php echo $alumno['Hora'];?></th>
                                            <th><?php echo $alumno['Asistio'];?></th>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <!-- Fin del body de la tabla-->
                                </table>
                            </div>
                            <!-- Fin de la tabla -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>

<!-- Fin del Html -->