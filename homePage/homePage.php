<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="homePage.css" />
    <link rel="stylesheet" href="../fontawesome-free-5.11.2-web/css/all.css">
    <link href="calendar.css" type="text/css" rel="stylesheet" />
    <title>How You Doin'?</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="homePage.js"></script>
</head>


<body id="body">
    <?php
    $cookie_name = "loginCredentials";
    if (!isset($_COOKIE[$cookie_name])) {
        // Not logged in :(
        header("Location: ../login/login.php"); /* Redirect browser */
        exit();
    } else {
        // Logged In
    }

    include('database_connection.php');
    include 'calendar.php';
    $query = file_get_contents('databaseCreation.sql');

    if (mysqli_multi_query($conn, $query)) {
        // echo "Table created successfully!";
        do {
            /* store first result set */
            if ($result = mysqli_store_result($conn)) {
                while ($row = mysqli_fetch_row($result)) { }
                mysqli_free_result($result); // Free in order to store the next
            }
        } while (mysqli_next_result($conn));
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_next_result($conn);
    ?>
    <?php
    // define variables and set to empty values where necessary
    // $email = "jeffmck@live.com";
    $email = $_COOKIE[$cookie_name];
    $selected_emotion = $note = $date = $tag = "";



    //change password
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        }
        if (isset($_POST['confirm_password'])) {
            $confirm_password = $_POST['confirm_password'];
        }
        if (isset($_POST['submitPass'])) {
            if ($password != $confirm_password) {
                alert("Passwords do NOT match");
            }
            $query = "UPDATE USER_ACCOUNT SET password = ? WHERE (email = ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $password, $email);
            if ($stmt->execute()) {
                setcookie("loginCredentials", $email, time() + 120, "/"); //expires after 120 seconds
                //send an email to let them know their password was reset
                $to = $email;
                $subject = "HowYouDoin' Account Information";
                $msg = "Your password was just reset.\nIf you don't think this was you, maybe you should reset it yourself!!";
                // use wordwrap() if lines are longer than 70 characters
                $msg = wordwrap($msg, 70);
                $headers = "From: gabbybmeow@gmail.com" . "\r\n";
                //send the email
                mail($to, $subject, $msg, $headers);
            } else {
                //echo("Failed");
                alert("was not able to create account");
            }
            $stmt->close();
        }
    }
    ?>


    <nav>
        <div class="navbar">
            <a class="log" id="log" href="#" title="Log Emotion"><i class="far fa-edit fa-2x"></i></a>
            <!-- <a class="logout" id="logout" href="../login/login.php" title="Sign Out"><i class="fas fa-sign-out-alt"></i></a> -->
            <!-- <a class="filter" id="filter" href="#"><i class="fa fa-filter fa-2x"></i></a> -->
            <a class="filter" id="filter" href="#"><i class="fas fa-users-cog fa-2x"></i></a>

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
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['note'])) {
                    $note = ($_POST['note']);
                }
                if (isset($_POST['daily_tag'])) {
                    $tag = ($_POST['daily_tag']);
                }
                if (isset($_POST['Emoticon'])) {
                    $selected_emotion = $_POST['Emoticon'];
                    //echo($selected_emotion);
                }
                $date = date("Y-m-d");
                //echo($date);
                if (isset($_POST['submit'])) {
                    $query = "INSERT INTO daily_log(email, date, emotion, note, tag)VALUES(?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sssss", $email, $date, $selected_emotion, $note, $tag);
                    if ($stmt->execute()) {
                        echo "New records created successfully";
                    } else {
                        echo $stmt->error;
                    }
                    $stmt->close();
                    //extend cookie for activity
                    // setcookie("loginCredentials", $email, time() + 120, "/"); //expires after 120 seconds
                }
            }
            ?>
            <p id="emotion">EMOTION</p>
            <div class="emoticons">
                <?php
                echo "<i id='super_sad' class='far fa-sad-tear fa-2x'></i>";
                echo "<i id='sad' class='far fa-frown fa-2x'></i>";
                echo "<i id='neutral' class='far fa-meh fa-2x'></i>";
                echo "<i id='happy' class='far fa-smile fa-2x'></i>";
                echo "<i id='super_happy' class='far fa-grin fa-2x'></i>";
                ?>
            </div>

            <form method="POST" action="homePage.php">
                <div class="radio_emotions">
                    <input type="radio" name="Emoticon" value="super-sad" />
                    <input type="radio" name="Emoticon" value="sad" />
                    <input type="radio" name="Emoticon" value="neutral" />
                    <input type="radio" name="Emoticon" value="happy" />
                    <input type="radio" name="Emoticon" value="super-happy" />
                </div>
                <p id="note">NOTE</p>
                <textarea rows="5" type="text" name="note" class="input_note" value="<?php echo $note; ?>"></textarea><br>
                <p id="tag">TAG</p>
                <select name="daily_tag">
                    <option value="weather">Weather</option>
                    <option value="friends">Friends</option>
                    <option value="family">Family</option>
                    <option value="school">School</option>
                    <option value="work">Work</option>
                    <option value="drama">Drama</option>
                    <option value="relationship">Relationship</option>
                </select><br><br>
                <input type="submit" name="submit" />
            </form>

        </div>
    </div>

    <div id="filter_sidebar" class="filter_sidebar">
        <a href="javascript:void(0)" id="fclosebtn" class="fclosebtn">&times;</a>
        <p class="filter_log">USER SETTINGS</p>
        <div class="sidebar_contents">
            <div id="lo">
                <p>Want to Log Out??<a class="logout" id="logout" href="../login/login.php" title="Sign Out"><i class="fas fa-sign-out-alt"></i></a></p>

            </div>
            <section class="changePwd">
                <h2> Change My Password! </h2>
                <div id="change">
                    <form method="post">
                        <label for="password" id="pass_label">New Password:</label>
                        <input id="password" type="password" name="password" placeholder="Password"><br><br>

                        <label for="reenter" id="repass_label">Re-enter New Password:</label>
                        <input id="reenter" type="password" name="confirm_password" placeholder="Confirm New Password"><br><br>

                        <input id="submit" type="submit" value="Change Password" name="submitPass"><br><br>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <article>
        <?php
        //get all the calendar dates for this user
        $logList = array();
        $query = "SELECT * FROM DAILY_LOG WHERE (email = ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_array()) {
                array_push($logList, $row);
            }
            $stmt->close();
        } else {
            echo $stmt->error;
        }
        $calendar = new Calendar($logList);

        echo $calendar->show();
        ?>
    </article>

</body>


</html>