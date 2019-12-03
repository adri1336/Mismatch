<?php
    require_once("header.php");

    $id_user = 0;
    if(checkLogin($con))
    {
        require_once("nav_log.php");
        $id_user = $_SESSION["id_user"];
    }
    else header("Location: index.php");
    
    $img_path = "profiles/user.png";
    if(file_exists("profiles/$id_user.jpg"))
        $img_path = "profiles/$id_user.jpg";

    $error = "";
    if(isset($_POST["submit"]))
    {
        $tmp_profile_img = $_FILES["profile_img"]["tmp_name"];
        if(file_exists($tmp_profile_img) || is_uploaded_file($tmp_profile_img)) 
        {
            if($_FILES["profile_img"]["error"] == 0)
            {
                if(move_uploaded_file($tmp_profile_img, "profiles/$id_user.jpg"))
                    $img_path = "profiles/$id_user.jpg";
            }
        }

        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $gender = $_POST["gender"];
        $birthdate = $_POST["birthdate"];
        $city = $_POST["city"];
        $state = $_POST["state"];

        $stmt = $con->prepare("UPDATE user SET firstname = :firstname, lastname = :lastname, gender = :gender, birthdate = :birthdate, city = :city, state = :state WHERE id = :id;");
        $stmt->execute(["firstname" => $firstname, "lastname" => $lastname, "gender" => $gender, "birthdate" => $birthdate, "city" => $city, "state" => $state, "id" => $id_user]);

        $error = "<h3 style='color: green; margin-top: 1rem; text-align: center;'>Perfil actualizado.</h3>";
    }

    $stmt = $con->prepare("SELECT *, DATE_FORMAT(birthdate, '%Y-%m-%d') AS datebirth FROM user WHERE id = :id_user LIMIT 1;");
    $stmt->execute(array(":id_user" => $id_user));
    
    if($stmt->rowCount() == 0)
        header("Location: index.php");

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container main-page">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                
                <header class="card-header">
                    <h4 class="card-title mt-2">Editar perfil</h4>
                </header>
                <?php echo $error; ?>
                <article class="card-body">
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">

                        <div class="form-group text-center">
                            <label for="image_input">    
                                <?php echo "<img id='profile_img' src='$img_path' class='rounded-circle' style='width: 12rem; height: 12rem; margin-bottom: 1rem;'>"; ?>
                            </label>
                            <label class="font-weight-bold label-imgprofile-custom-margin">Haz clic en la foto para cambiarla</label>
                            <input id="image_input" name="profile_img" type="file" accept="image/*" onChange="onFileSelected(event)" style="display: none;">
                        </div>

                        <div class="form-row">
                            <div class="col form-group">
                                <label>Nombre</label>   
                                <?php echo "<input name='firstname' type='text' class='form-control' value='$row[firstname]' required>"; ?>
                            </div>
                            <div class="col form-group">
                                <label>Apellidos</label>
                                <?php echo "<input name='lastname' type='text' class='form-control' value='$row[lastname]' required>"; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-check form-check-inline">
                                <?php
                                    if($row["gender"] == 0) echo "<input class='form-check-input' type='radio' name='gender' value='0' required checked>";
                                    else echo "<input class='form-check-input' type='radio' name='gender' value='0' required>";
                                ?>
                                <span class="form-check-label"> Masculino </span>
                            </label>

                            <label class="form-check form-check-inline">
                                <?php
                                    if($row["gender"] == 1) echo "<input class='form-check-input' type='radio' name='gender' value='1' required checked>";
                                    else echo "<input class='form-check-input' type='radio' name='gender' value='1' required>";
                                ?>
                                <span class="form-check-label"> Femenino</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Fecha de nacimiento</label>
                            <?php echo "<input name='birthdate' type='date' class='form-control' value='$row[datebirth]'>"; ?>
                        </div>

                        <div class="form-row">
                            <div class="col form-group">
                                <label>Ciudad</label>   
                                <?php echo "<input name='city' type='text' class='form-control' value='$row[city]'>"; ?>
                            </div>
                            <div class="col form-group">
                                <label>Provincia</label>
                                <?php echo "<input name='state' type='text' class='form-control' value='$row[state]'>"; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <button name="submit" type="submit" class="btn btn-primary btn-block">Actualizar</button>
                        </div>
                    </form>
                </article>
                
            </div>
        </div>
    </div>
</div>

<script>
function onFileSelected(event)
{
    let selectedFile = event.target.files[0];
    let reader = new FileReader();

    let profile_img = document.getElementById("profile_img");
    profile_img.title = selectedFile.name;

    reader.onload = function(event)
    {
        profile_img.src = event.target.result;
    };

    reader.readAsDataURL(selectedFile);
}
</script>

<?php
    require_once("footer.php");
?>