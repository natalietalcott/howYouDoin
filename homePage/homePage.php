<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="homePage.css" />
    <link rel="stylesheet" href="../fontawesome-free-5.11.2-web/css/all.css">
    <title>How You Doin'?</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="homePage.js"></script>
</head>
<?php
    include ('database_connection.php');
?>
<?php
    $query = file_get_contents('databaseCreation.sql');

    if (mysqli_multi_query($conn, $query)) {
        // echo "Table created successfully!";
        do {
            /* store first result set */
            if ($result = mysqli_store_result($conn)) {
                while ($row = mysqli_fetch_row($result)) {
                }
                mysqli_free_result($result); // Free in order to store the next
            }
        } while (mysqli_next_result($conn));
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_next_result($conn);
?>
<?php
    // define variables and set to empty values
    $email= $selected_emotion = $note= $date= "";
?>
<body id="body">
    <nav>
        <div class="navbar">
            <a class="log" id="log" href="#"><i class="far fa-edit fa-2x"></i></a>
            <a class="filter" id="filter" href="#"><i class="fa fa-filter fa-2x"></i></a>
        </div>
    </nav>
    <header>
        <div class="title">
            <h1>How You Doin'?</h1>
        </div>
    </header>
    <div id="log_sidebar" class="sidebar">
        <a href="javascript:void(0)" id="closebtn" class="closebtn">&times;</a>
        <p class="daily_log">DAILY LOG</p>
        <div class="sidebar_contents">
        <?php
            if(isset($_POST['logSubmit']))
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
                <p id="emotion">EMOTION</p>
                <div class="emoticons">
                    <?php 
                            if($selected_emotion == "super_sad"){
                                echo "<i id='super_sad_selected' class='fas fa-sad-tear fa-2x'></i>";
                            } else {
                                echo "<i id='super_sad' class='far fa-sad-tear fa-2x'></i>";
                            }
                        ?>
                    <?php 
                            if($selected_emotion == "sad"){
                                echo "<i id='sad_selected' class='fas fa-frown fa-2x'></i>";
                            } else {
                                echo "<i id='sad' class='far fa-frown fa-2x'></i>";
                            }
                        ?>
                    <?php 
                            if($selected_emotion == "neutral"){
                                echo "<i id='neutral_selected' class='fas fa-meh fa-2x'></i>";
                            } else {
                                echo "<i id='neutral' class='far fa-meh fa-2x'></i>";
                            }
                        ?>
                    <?php 
                            if($selected_emotion == "happy"){
                                echo "<i id='happy_selected' class='fas fa-smile fa-2x'></i>";
                            } else {
                                echo "<i id='happy' class='far fa-smile fa-2x'></i>";
                            }
                        ?>
                    <?php 
                            if($selected_emotion == "super_happy"){
                                echo "<i id='super_happy_selected' class='fas fa-grin fa-2x'></i>";
                            } else {
                                echo "<i id='super_happy' class='far fa-grin fa-2x'></i>";
                            }
                    ?>
                </div>
            <form action="./homePage.php" method="post">
                <input type="hidden" name="emoticon" value="<?php echo $selected_emotion;?>"><br>
                <p id="note">NOTE</p>
                <input type="text" name="note" value="<?php echo $note;?>"><br>
                <p id="tag">TAG</p>
                <input type="submit" value="Submit" name="logSubmit">
            </form>
        </div>
    </div>
    <article>
        <div style="display: flex;">
            <div class="calendar" id="november">
                <p class="month_name">
                    November
                </p>
                <div class="month" id="december"></div>
                <p class="month_name">
                    December
                </p>
                <div class="month" id="january"></div>
                <p class="month_name">
                    January
                </p>
                <div class="month" id="february"></div>
                <p class="month_name">
                    February
                </p>
                <div class="month"></div>
            </div>
        </div>
    </article>

</body>

</html>