<?php include("models/db.php") ?>
<?php include("includes/headerlogin.php") ?>
<!DOCTYPE html>
<html lang="en">
  <meta charset="UTF-8">
  <title>Tu Título Aquí</title>
  <link rel="stylesheet" href="src/css/login.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<div class="background-container"></div>
<div class="login-container">
  <div class="login-card">
    <h2>Iniciar sesión</h2>
    <form action="models/loginDB.php" method="POST">
      <div class="form-group">
        <label for="user">Usuario</label>
        <input type="text" name="user" class="form-control" id="user" placeholder="Usuario" autofocus>
      </div>
      <div class="form-group">
        <label for="pass">Contraseña</label>
        <input type="password" name="pass" class="form-control" id="pass" placeholder="Contraseña" autofocus>
      </div>
      <div class="form-group">
        <input type="submit" class="login-button" name="validate_user" value="Login">
      </div>
    </form>
  </div>
</div>
<?php include("includes/footer.php") ?>
</html>
