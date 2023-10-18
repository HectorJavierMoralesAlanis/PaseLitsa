<?php
    include ('DAO.php');
    if(isset($_POST['enviar'])){//isset($_POST['matricula'],$_POST['clave'])){

        $matricula = $_POST['matricula'];
        echo $matricula;
        $clave = $_POST['clave'];
        //Creacion de la sentencia para traer la consulta de los profesores
        $daoProfesores = new DAO();
        $consultaProfesores = "SELECT * FROM Profesores Where Matricula=:matricula AND Contra=:contra";
        $parametrosProfesores = array("matricula"=>$matricula,"contra"=>$clave);
        $resultadosProfesores = $daoProfesores->insertarConsulta($consultaProfesores,$parametrosProfesores);
        
        //Creacion de la sentencia para traer la consulta de los alumnos
        $daoEstudiantes = new DAO();
        $consultaEstudiantes = "SELECT * FROM Alumnos Where Matricula=:matricula AND Contra=:contra";
        $parametrosEstudiantes=array("matricula"=>$matricula,"contra"=>$clave);
        $resultadosEstudiantes=$daoEstudiantes->insertarConsulta($consultaEstudiantes,$parametrosEstudiantes);

        //Condicional para redirigir a la pagina indicada
        if($resultadosProfesores>=1 && $resultadosEstudiantes == 0){
            header("Location: http://157.245.253.25/Maestros/materias.php?matricula=$matricula");
        }else if($resultadosEstudiantes>0){
            header("Location: http://157.245.253.25/Alumnos/dash.php?matricula=$matricula");
        }else{
            header("Location: http://157.245.253.25/login.php");
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <title>Login</title>
</head>
<body>
  <main class="vh-100">
        <div class="row d-flex justify-content-center align-content-center h-100">
            <div class="col-12 col-md-6 h-100 justify-content-center align-content-center flex-wrap d-flex">
                <form class="w-75" method="POST" action="login.php">
                    <div class="d-flex my-4">
                        <h5 class="text-center fw-bold mb-0">Bienvenidos</h5>
                    </div>

                    <!-- input de Usuario -->
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="matricula" name="matricula">
                        <label for="floatingInput">Matricula</label>
                    </div>

                    <!-- input de Contraseña -->
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="clave" placeholder="clave" name="clave">
                        <label for="floatingPassword">Contraseña</label>
                    </div>

                    <div class="d-md-block d-grid text-end mt-4 pt-2">
                        <button type="submit" name="enviar" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem" data-bind="click: login">
                            Aceptar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>
</body>
</html>