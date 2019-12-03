<?php
    require_once("header.php");

    $id_profile = 0;
    $id_user = 0;
    if(checkLogin($con))
    {
        if(isset($_GET["id"]))
        {
            require_once("nav_log.php");
            $id_profile = $_GET["id"];
            $id_user = $_SESSION["id_user"];
        }
        else header("Location: index.php");
    }
    else header("Location: index.php");
?>

<div class="container main-page">
    
    <?php
        $stmt = $con->prepare("SELECT *, TIMESTAMPDIFF(YEAR, birthdate, NOW()) AS age FROM user WHERE id = :id_user LIMIT 1;");
        $stmt->execute(array(":id_user" => $id_profile));
        if($stmt->rowCount() > 0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $img_path = "profiles/user.png";
            if(file_exists("profiles/$row[id].jpg"))
                $img_path = "profiles/$row[id].jpg";

            $gender = $row["gender"] == 0 ? "masculino" : "femenino";
            $age = $row["age"] == null ? "sin especificar" : $row["age"] . " años";
            $city = $row["city"] == null ? "sin especificar" : $row["city"];
            $state = $row["state"] == null ? "sin especificar" : $row["state"];
            echo "
                <div class='row justify-content-center'>
                    <div class='col-md-7'>
                        <div class='card'>

                            <header class='card-header'>";
                                if($id_profile == $id_user)
                                    echo "<a href='edit.php' class='float-right btn btn-outline-primary mt-1'>Editar</a>";
                                echo "
                                <h4 class='card-title mt-2'>Perfil de $row[firstname]</h4>
                            </header>

                            <article class='card-body'>
                                <div class='row'>
                                    <div class='col-md-5 d-flex align-items-center justify-content-center'>
                                        <img src='$img_path' style='width: 12rem; height: 12rem;' class='rounded-circle'>
                                    </div>
                                    <div class='col'>

                                        <div class='row'>
                                            <div class='col'>
                                                <label class='font-weight-bold label-custom-margin'>Nombre</label>
                                                <label>$row[firstname]</label>
                                            </div>
                                            <div class='col'>
                                                <label class='font-weight-bold label-custom-margin'>Apellidos</label>
                                                <label>$row[lastname]</label>
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class='col'>
                                                <label class='font-weight-bold label-custom-margin'>Género</label>
                                                <label>$gender</label>
                                            </div>
                                            <div class='col'>
                                                <label class='font-weight-bold label-custom-margin'>Edad</label>
                                                <label>$age</label>
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class='col'>
                                                <label class='font-weight-bold label-custom-margin'>Ciudad</label>
                                                <label>$city</label>
                                            </div>
                                            <div class='col'>
                                                <label class='font-weight-bold label-custom-margin'>Provincia</label>
                                                <label>$state</label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </article>

                        </div>
                    </div>
                </div>
            ";
        }
        else echo "<h1 style='color: red;' class='display-4'>Perfil no válido.</h1>";
    ?>
</div>

<?php
    require_once("footer.php");
?>