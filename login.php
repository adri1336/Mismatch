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
        $password = $_POST["password"];

        $query = "SELECT * FROM user WHERE email = :email AND passwd = :password;";
        $stmt = $con->prepare($query);
        $stmt->execute(array(":email" => $email, ":password" => SHA1($password)));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row["id"] > 0)
        {
            $remember = false;
            if(isset($_POST["remember"]))
            $remember = true;

            recordSession($con, $row["id"], $row["passwd"], $remember);
            header("Location: index.php");
        }
        else $error = "<h3 style='color: red; margin-top: 1rem; text-align: center;'>Usuario o contraseña incorrectos.</h3>";
    }
?>

<div class="container main-page">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">

                <header class="card-header">
                    <a href="login.php" class="float-right btn btn-outline-primary mt-1">Registrarse</a>
                    <h4 class="card-title mt-2">Ingresar</h4>
                </header>
                <?php echo $error; ?>
                <article class="card-body">
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                        <div class="form-group">
                            <label>Correo eléctronico</label>
                            <input name="email" type="email" class="form-control" placeholder="" required>
                        </div>

                        <div class="form-group">
                            <label>Contraseña</label>
                            <input name="password" class="form-control" type="password" required>
                        </div>

                        <div class="form-group">
                            <input name="remember" type="checkbox" value="Remember Me">
                            <label>Mantener la sesión abierta</label>
                        </div>

                        <div class="form-group">
                            <button name="submit" type="submit" class="btn btn-primary btn-block">Ingresar</button>
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