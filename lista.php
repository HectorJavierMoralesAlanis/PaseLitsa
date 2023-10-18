<?php 
    include ('DAO.php');
    //Consulta para traer la lista de alumnos
    $daoAlumnos = new DAO();
    $consultaAlumnos = "SELECT * FROM Alumnos";
    $alumnosLista = $daoAlumnos->ejecutarConsulta($consultaAlumnos);

    //Consulta para traer la lista de profesores
    $daoProfesores = new DAO();
    $consultaProfesores = "SELECT * FROM Profesor";
    $maestrosLista = $daoProfesores->ejecutarConsulta($consultaProfesores);

    //Obtengo el valor para la asistencia
    $valor = $_POST["uid"];

    //Inicio de la funcion para obtener el nombre de la clase
    function nombreClase($id){
        $daoNombreClase = new DAO();
        $consultaNombreClase = "SELECT nombre FROM Clase Where id=:id";
        $parametros = array("id"=>$id);
        $nombre = $daoNombreClase->ejecutarConsulta($consultaNombreClase,$parametros);
        return $nombre;
    }
    //Fin de la funcion para obtener el nomrbe de la clase

    //Inicio de la funcion para obetener la hora de la clase 
    function claseHora($dia,$hora,$clase){
        
        $daoHora = new DAO();
        $consultaHora = "SELECT * FROM Semana Where dia=:dia AND clase=:clase";
        $parametrosHora = array("dia"=>$dia,"clase"=>$clase);
        $resultadoHora = $daoHora->ejecutarConsulta($consultaHora,$parametrosHora);
        foreach($resultadoHora as $horas){
            if($horas['horaInicio']>=$hora || $horas['horaFinal']<=$hora){
                $asistio=1;
            }else{
                $asistio=0;
            }
        }

        return $asistio;
    }
    //Fin de la funcion para obetner la hora de la clase
    
    //Inicio de la funcion para obtener el id de la clase
    function claseId($matricula){

        $daoClase = new DAO();
        $consultaIdclase = "SELECT Clase FROM Alumnos WHERE Matricula=:matricula";
        $parametrosIdclase = array("matricula"=>$matricula);
        $claseArregloId = $daoClase->ejecutarConsulta($consultaIdclase,$parametrosIdclase);
        
        foreach($claseArregloId as $id){
            $claseIdNombre = $id['Clase'];
        }
        
        return $claseIdNombre;
    }
    //Fin de la funcinon par aobetner el id de la clase

    //Inicio de la funcion para obetneer el id del grupo
    function grupoId($matricula){

        $daoIdGrupo = new DAO();
        $consultaIdGrupo = "SELECT Grupo FROM Alumnos WHERE Matricula=:matricula";
        $parametrosIdGrupo = array("matricula"=>$matricula);
        $grupoIdArreglo = $daoIdGrupo->ejecutarConsulta($consultaIdGrupo,$parametrosIdGrupo);

        
        foreach($grupoIdArreglo as $id){
            $grupoId = $id['Grupo'];
        }

        return $grupoId;
    }
    //Fin de la funcion para obtener el id del grupo

    //Inicio de la funcion para insertar la asistencia
    function insertarAsistenciaAlumnos($matricula,$clase,$grupo){
        date_default_timezone_set('America/Monterrey');
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $asistencia=1;
 
        $daoInsertar = new DAO();
        $consultaInsertar = "INSERT INTO Pase_de_lista (Matricula,Asistio,Dia,Hora,Grupo,Clase)"."VALUES (:matricula,:asistio,:dia,:hora,:grupo,:clase)";
        $parametrosInsertar = array("matricula"=>$matricula,"asistio"=>$asistencia,"dia"=>$fecha,"hora"=>$hora,"grupo"=>$grupo,"clase"=>$clase);
        $daoInsertar->insertarConsulta($consultaInsertar,$parametrosInsertar);
    }
    //Fin de la funcion para insertar la asistenca

    //Inicio del ciclo para ingresar la asistencia de los alumnos
    foreach($alumnosLista as $alumno){
        //Inicio de la condicional para saber si utilizo tarjeta o contraseña
        if($alumno['IDcard'] === $valor){
            
            //Mensaje para que comprube que se ingreso con tarjeta
            echo "Ingresado";

            //Variable para obtener la matricula del alumno
            $matricula = $alumno['Matricula'];

            //Consulta para traer el id de la clase
            $idClase = claseId($matricula);

            //Consulta para traer el id del grupo
            $idGrupo = grupoId($matricula);

            //Se llama la funcion para insertar la asistencia
            insertarAsistenciaAlumnos($matricula,$idClase,$idGrupo);
            
            break;
            
        }else if($alumno['Contra'] === $valor){
            
            //Mensaje para indicar que ingreso con Contraseña
            echo "Ingresado";

            //Variable para obetner la matricula
            $matricula = $alumno['Matricula'];

            //Consulta para traer el id de la clase
            $idClase = claseId($matricula);

            //Consulta para traer el id del grupo
            $idGrupo = grupoId($matricula);
            
            //Se llama la funcion para insertar la asistencia
            insertarAsistenciaAlumnos($matricula,$idClase,$idGrupo);

            break;
            
        }
        //Fin de la condicional para saber si utilizo tarjetra o contraseña
    }
    //Fin del ciclo para ingresar la asistencia de los alumnos 
    
    //Inicio del ciclo para ingresar la asitencia del maestro
    foreach($maestrosLista as $maestro){
        //Inicio de la condicional para saber si utilizo tarjeta o contraseña
        if($maestro['IDcard'] === $valor){

            //Mensaje para saber que ha ingresado con Tarjeta
            echo "Ingresado";

            //Se obtiene la matricula del maestro
            $matricula=$maestro['Matricula'];

            //Se obtiene la hora de la materia
            $consultaHora = "SELECT * FROM Clases Where matriculaMaestro=:matricula";
            $parametrosHora = array("matricula"=>$matricula);
            $resultadoHora = $daoHora->ejecutarConsulta($consultaHora,$parametrosHora);
            
            foreach($resultadosHora as $horas){
                if($horas['horaInicio']>=$hora || $horas['horaFinal']<=$hora){
                    $grupo=$horas['grupo'];
                    $clase=$horas['id'];
                }
            }
            $daoPase = new DAO();
            $consultaPase = "INSERT INTO Pase_de_lista (Matricula,Asitio,Fecha,Hora,Grupo,Clase)"."VALUES (:matricula,:asistio,:fecha,:hora,:grupo,:clase)";
            $parametrosPase = array("matricula"=>$matricula,"asistio"=>$asistio,"fecha"=>$fecha,"hora"=>$hora,"grupo"=>$grupo,"clase"=>$clase);
            $paseMaestro = $daoPase->ejecutarConsulta($consultaPase,$parametrosPase);
            break;
        }else if($maestro['Contra'] === $valor){

            echo "Ingresado";
            
            $matricula = $maestro['Matricula'];
            
            $daoPase = new DAO();
            $consultaPase = "INSERT INTO Pase_de_lista (Matricula,Asistio,Fecha,Hora,Grupo,Clase)"."VALUES (:matricula,:asistio,:fecha,:hora,:grupo,:clase)";
            $parametrosPase = array("matricula"=>$matricula,"asistio"=>$asistio,"fecha"=>$fecha,"hora"=>$hora,"grupo"=>$grupo,"clase"=>$clase);
            $paseMaestro = $daoPase->ejecutarConsulta($consultaPase,$parametrosPase);
            break;
        }
        //Fin de la condicional para saber si utilizo tarjeta o contraseña
        break;
    }
    //Fin del ciclo para ingresar la asitencia del maestro
?>