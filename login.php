<?php include("models/db.php") ?>
<?php include("includes/header.php") ?>

    <div class="row">

            <div class="col-md-4">

                

                <div class="card card-body">
                    <form action="models/loginDB.php" method="POST">
                        <div class="form-group">
                            <label for="">Usuario</label>
                            <input type="text" name="user" class="form-control" placeholder="Usuario" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Contraseña</label>
                            <input type="text" name="pass" class="form-control" placeholder="Contraseña" autofocus>
                        </div>
                        
                        <input type="submit" class="btn btn-success btn-block" name="validate_user" value="Guardar">
                    </form>
                </div>
        </div>
    </div>


<?php include("includes/footer.php") ?>