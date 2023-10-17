<?php 
    include ('../DAO.php');
    $dao = new DAO();
    $consulta = "SELECT * FROM Clases WHERE matriculaMaestro=:matricula";
    $parametros = array("matricula"=>$_GET['matricula']);
    $clases = $dao->ejecutarConsulta($consulta,$parametros);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Materias</title>
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="container">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Materias</h3>
                                <div class="btn-group" style="float: right;">
                                    <a href="../login.php" class="btn btn-block btn-success" style="float: right;">Cerrar Sesion</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Materia</th>
                                            <th>Detalles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($clases as $clases){?>
                                            <tr>
                                                <td><?php echo $clase['id'];?></td>
                                                <td><?php echo $clase['nombre'];?></td>
                                                <td class="align-middle"><a href="./dash.php?id=<?php echo $clase['id']?>&matricula=<?php echo $clase['matriculaMaestro']?>" method="POST" class="btn btn-info btn-block btn-sm">Ingresar</a></td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>