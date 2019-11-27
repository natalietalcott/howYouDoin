<?php
    include ('database_connection.php');
?>
<?php
    if($_POST['logSubmit'] == "Submit")
    {
        //echo ($_POST["email"]);
        //echo ($_POST["date"]);
        //echo ($_POST["emotion"]);
        echo ($_POST["note"]);
        
        /*
        $newLog = "INSERT INTO DAILY_LOG (email, date, emotion, note) VALUES ('".$_POST["email"]."','".$_POST["date"]."','".$_POST["selectedEmotion"]."','".$_POST["note"]."')";
        if (mysqli_query($conn, $newLog)) {
            echo "New log created successfully";
            } else {
                echo "Failed";
            }
            */
    }
?>