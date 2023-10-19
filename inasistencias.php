<?php 
    include ('DAO.php');
    $nombre = "Ejemplo";
    $valor = 5 ;
    $matricula = "2030103";
    $asistencia = 0;
    $dia = date('Y-m-d');
    $hora = date('H:i:s');
    $grupo = 2;
    $clase = "Matematicas";
    $daoEvento = new DAO();
    $sentencia1 = "Create EVENT $nombre ON SCHEDULE EVERY $valor MINUTES STARTS '2023-10-19 02:49:00' DO BEGIN INSERT INTO Pase_de_lista (Matricula,Asistio,Dia,Hora,Grupo,Clase)"."VALUES (:matricula,:asistencia,:dia,:hora,:grupo,:clase); END";
    $parametros = array("matricula"=>$matricula,"asistio"=>$asistencia,"dia"=>$dia,"grupo"=>$grupo,"clase"=>$clase);
    $daoEvento->insertarConsulta($sentencia1,$parametros);
?>