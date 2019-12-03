<?php
    require_once("header.php");

    if(checkLogin($con)) require_once("nav_log.php");
    else header("Location: index.php");
?>

<div class="container main-page">
    <h1 class="display-4">Últimos perfiles.</h1>
    <div class="row justify-content-center">
        <?php
            $stmt = $con->prepare("SELECT id, firstname FROM user LIMIT 10;");
            $stmt->execute();
            foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            {
                $id = $row["id"];
                $firstname = $row["firstname"];
                $img_path = "profiles/user.png";
                if(file_exists("profiles/$id.jpg"))
                    $img_path = "profiles/$id.jpg";

                echo "  <div class='col text-center' style='margin-top: 1rem;'>
                            <a href='profile.php?id=$id'><img src='$img_path' style='width: 10rem; height: 10rem;' class='rounded-circle'></a>
                            <label class='font-weight-bold label-custom-margin'>$firstname</label>
                        </div>";
            }
        ?>
    </div>
</div>

<?php
    require_once("footer.php");
?>