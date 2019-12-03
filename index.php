<?php
    require_once("header.php");

    $name = "visitante";
    $last = "";

    $id_user = 0;
    if(checkLogin($con))
    {
        require_once("nav_log.php");
        
        $id_user = $_SESSION["id_user"];
        $stmt = $con->prepare("SELECT firstname FROM user WHERE id = :id_user;");
        $stmt->execute(array(":id_user" => $id_user));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $row["firstname"];

        $stmt = $con->prepare("SELECT COUNT(*) FROM topic;");
        $stmt->execute();
        $total_topics = $stmt->fetch(PDO::FETCH_NUM)[0];

        $stmt = $con->prepare("SELECT COUNT(*) FROM response WHERE id_user = :id_user;");
        $stmt->execute(array(":id_user" => $id_user));
        $total_user_topics = $stmt->fetch(PDO::FETCH_NUM)[0];

        if($total_user_topics >= $total_topics) $last = "Enhorabuena, tu cuestionario está completo, si quieres puedes <a href='edit.php'>editar</a> tu perfil.";
        else
        {
            $percentage = ($total_user_topics * 100.0) / $total_topics;
            $last = "Tu cuestionario está completo al $percentage%, completalo <a href='questions.php'>aquí</a>.";
        }
    }
    else
    {
        require_once("nav.php");

        $stmt = $con->prepare("SELECT COUNT(*) FROM user;");
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_NUM)[0];

        $last = "Registrate para empezar, ya hay $total personas registradas.";
    }
?>

<div class="container main-page">
    <h1 class="display-4">Bienvenido, <?php echo $name; ?>.</h1>
    <p class="lead"><?php echo $last; ?></p>
</div>

<?php
    require_once("footer.php");
?>