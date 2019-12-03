<?php
    require_once("header.php");

    $id_user = 0;
    if(checkLogin($con))
    {
        require_once("nav_log.php");
        $id_user = $_SESSION["id_user"];
    }
    else header("Location: index.php");
?>

<div class="container main-page">
    <?php
        $stmt = $con->prepare("SELECT COUNT(*) FROM response WHERE id_user = :id_user;");
        $stmt->execute(["id_user" => $id_user]);
        $total_user_topics = $stmt->fetch(PDO::FETCH_NUM)[0];
        if($total_user_topics <= 0) echo "<p class='lead'>Rellena el <a href='questions.php'>cuestionario</a> para continuar.</p>";
        else
        {   
            $stmt = $con->prepare("SELECT DISTINCT id_user FROM response WHERE id_user != :id_user;");
            $stmt->execute(["id_user" => $id_user]);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $total_users = sizeof($users);
            if($total_users <= 0) echo "<p class='lead' style='color: red;'>No hay usuarios.</p>";
            else
            {
                $user_matched = 0;
                $current_max_matches = 0;
                for($i = 0; $i < $total_users; $i ++)
                {
                    $sql = "
                        SELECT COUNT(*) AS matches FROM response AS user_responses
                        INNER JOIN response AS match_user_response
                        WHERE user_responses.id_user = :id_user AND match_user_response.id_user = :id_match_user AND user_responses.id_topic = match_user_response.id_topic AND user_responses.response != match_user_response.response;
                    ";
                    $stmt = $con->prepare($sql);
                    $stmt->execute(["id_user" => $id_user, "id_match_user" => $users[$i]["id_user"]]);
                    $matches = $stmt->fetch(PDO::FETCH_NUM)[0];
                    
                    if($matches > $current_max_matches)
                    {
                        $current_max_matches = $matches;
                        $user_matched = $users[$i]["id_user"];
                    }
                }

                if($user_matched == 0) echo "<p class='lead' style='color: red;'>No hemos encontrado a nadie con quien emparejarte.</p>";
                else
                {
                    $stmt = $con->prepare("SELECT * FROM user WHERE id = :id_matched_user LIMIT 1;");
                    $stmt->execute(["id_matched_user" => $user_matched]);
                    $user_matched_info = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo "<p class='lead' style='color: green;'>Has sido emparejado con <b>$user_matched_info[firstname]</b>, haz <a href='profile.php?id=$user_matched_info[id]'>clic para ir a su perfil.</a></p>";
                }
            }
        }
    ?>
</div>

<?php
    require_once("footer.php");
?>