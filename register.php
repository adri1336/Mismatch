<?php
    require_once("header.php");

    if(checkLogin($con))
    {
        header("Location: index.php");
        return;
    }

    require_once("nav.php");
    
    $error = "";
    if(isset($_POST["submit"]))
    {
        $email = $_POST["email"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $gender = $_POST["gender"];
        $password = sha1($_POST["password"]);

        $stmt = $con->prepare("SELECT * FROM `user` WHERE email = :email LIMIT 1;");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if($stmt->rowCount()) $error = "<h3 style='color: red; margin-top: 1rem; text-align: center;'>El usuario ya existe.</h3>";
        else
        {
            $stmt = $con->prepare("INSERT INTO user (email, passwd, firstname, lastname, gender) VALUES (:email, :pass, :firstname, :lastname, :gender);");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pass', $password);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':gender', $gender);
            $stmt->execute();
            $error = "<h3 style='color: green; margin-top: 1rem; text-align: center;'>Usuario registrado.</h3>";
        }
    }
?>

<div class="container main-page">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                
                <header class="card-header">
                    <a href="login.php" class="float-right btn btn-outline-primary mt-1">Ingresar</a>
                    <h4 class="card-title mt-2">Registrarse</h4>
                </header>
                <?php echo $error; ?>
                <article class="card-body">
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">

                        <div class="form-group">
                            <label>Correo eléctronico</label>
                            <input name="email" type="email" class="form-control" placeholder="" required>
                        </div>

                        <div class="form-row">
                            <div class="col form-group">
                                <label>Nombre</label>   
                                <input name="firstname" type="text" class="form-control" placeholder="" required>
                            </div>
                            <div class="col form-group">
                                <label>Apellidos</label>
                                <input name="lastname" type="text" class="form-control" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="0" required>
                                <span class="form-check-label"> Masculino </span>
                            </label>

                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="1" required>
                                <span class="form-check-label"> Femenino</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Contraseña</label>
                            <input name="password" class="form-control" type="password" required>
                        </div>

                        <div class="form-group">
                            <button name="submit" type="submit" class="btn btn-primary btn-block">Registrarse</button>
                        </div>
                    </form>
                </article>
                
            </div>
        </div>
    </div>
</div>

<?php
    require_once("footer.php");
?>