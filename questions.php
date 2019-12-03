<?php
    require_once("header.php");

    $id_user = 0;
    if(checkLogin($con))
    {
        require_once("nav_log.php");
        $id_user = $_SESSION["id_user"];
    }
    else header("Location: index.php");

    $error = "";
    if(isset($_POST["submit"]))
    {
        foreach($_POST as $id_topic => $response)
        {
            if($id_topic != "submit")
            {
                $stmt = $con->prepare("DELETE FROM response WHERE id_user = :id_user AND id_topic = :id_topic;");
                $stmt->execute(array(":id_user" => $id_user, ":id_topic" => $id_topic));

                $stmt = $con->prepare("INSERT INTO response VALUES (NULL, :response, :id_user, :id_topic);");
                $stmt->execute(array(":response" => $response, ":id_user" => $id_user, ":id_topic" => $id_topic));

                $error = "<h1 class='display-5' style='color: green; margin-top: 1rem; text-align: center;'>Cuestionario actualizado.</h1>";
            }
        }
    }
?>

<div class="container main-page">
    <?php
        $stmt = $con->prepare("SELECT * FROM category;");
        $stmt->execute();
        echo $error;
        echo "<form action='$_SERVER[PHP_SELF]' method='POST'><div class='row'>";
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
        {
            echo "
            <div class='col-4'><p>
                <h1 class='display-5'>$row[name]</h1>";

            $stmt = $con->prepare("SELECT * FROM topic WHERE id_category = :id_category;");
            $stmt->execute(array(":id_category" => $row["id"]));
            foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row2)
            {
                $stmt = $con->prepare("SELECT response FROM response WHERE id_user = :id_user AND id_topic = :id_topic LIMIT 1;");
                $stmt->execute(array(":id_user" => $id_user, ":id_topic" => $row2["id"]));
                $response = $stmt->fetch(PDO::FETCH_NUM)[0];

                $checked_0 = "";
                $checked_1 = "";
                if($response != null)
                {
                    if($response == 0) $checked_0 = "checked";
                    if($response == 1) $checked_1 = "checked";
                }

                echo "
                <h4 class='display-5 d-inline' style='margin-right: 1rem;'>$row2[name]</h4>
                <div class='form-check form-check-inline'>
                    <input class='form-check-input' type='radio' name='$row2[id]' value='0' $checked_0>
                    <label class='form-check-label'>No</label>
                </div>
                <div class='form-check form-check-inline'>
                    <input class='form-check-input' type='radio' name='$row2[id]' value='1' $checked_1>
                    <label class='form-check-label'>Sí</label>
                </div>
                <br>
                ";
            }
            echo "</p></div>";
        }
        echo "</div>
        <div class='row' style='margin-top: 1rem;'>
            <div class='col text-center'>
                <button name='submit' type='submit' class='btn btn-primary'>Enviar</button>
            </div>
        </div>
        </form>";
    ?>
</div>

<?php
    require_once("footer.php");
?>