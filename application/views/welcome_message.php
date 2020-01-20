<!doctype html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Afiliacion</title>
    <style>
        label{
            color: #1b5e20;
            /*background: red;*/
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card mt-4">
                <div class="card-header text-white bg-info">
                    FORMULARIO DE AFILIACION
                </div>
                <div class="card-body" style="background: #EFEFEF">
                    <form method="post" action="<?=base_url()?>Welcome/veri">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombres">Nombre(s)</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombre Completo" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="paterno">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="paterno" name="paterno" placeholder="Apellido Paterno" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="materno">Apellido Materno</label>
                                    <input type="text" class="form-control" id="materno" name="materno" placeholder="Apellido Materno" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="dia">Fecha de Nacimiento</label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="dia" name="dia" required placeholder="00">
                                        </div>
                                        <div class="col-sm-4">
                                            <select name="mes" id="mes" class="form-control" required>
                                                <option value="">Seleccionar..</option>
                                                <option value="ENERO">ENERO</option>
                                                <option value="FEBRERO">FEBRERO</option>
                                                <option value="MARZO">MARZO</option>
                                                <option value="ABRIL">ABRIL</option>
                                                <option value="MAYO">MAYO</option>
                                                <option value="JUNIO">JUNIO</option>
                                                <option value="JULIO">JULIO</option>
                                                <option value="AGOSTO">AGOSTO</option>
                                                <option value="SEPTIEMBRE">SEPTIEMBRE</option>
                                                <option value="OCTUBRE">OCTUBRE</option>
                                                <option value="NOVIEMBRE">NOVIEMBRE</option>
                                                <option value="DICIEMBRE">DICIEMBRE</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="anio" name="anio" required placeholder="0000">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ci">CI</label>
                                    <input type="text" class="form-control" id="ci" name="ci" required placeholder="Carnet de identidad">
                                    <small class="form-text text-muted">Escribe tu Carnet de Identidad</small>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Verificar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>