<!DOCTYPE html>
<html>

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
    // define variables and set to empty values
    $email = "jeffmck@live.com";
    $selected_emotion = $note = $date = $tag = "";
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
                        }
                        else {
                            echo $stmt -> error;
                        }
                        $stmt->close();
                        // $newLog = "INSERT INTO daily_log(email, date, emotion, note,tag)VALUES ('" . $email . "','" . $date . "','" . $selected_emotion . "','" . $note . "','" . $tag . "')";
                        // if (mysqli_query($conn, $newLog)) { echo"jdhflkdjhfa";} else {echo"bad"; }
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
            <p class="filter_log">FILTER LOGS</p>
            <div class="sidebar_contents">
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
                        <input type="radio" name="Emoticon" value="superSad" />
                        <input type="radio" name="Emoticon" value="sad" />
                        <input type="radio" name="Emoticon" value="neutral" />
                        <input type="radio" name="Emoticon" value="happy" />
                        <input type="radio" name="Emoticon" value="superHappy" />
                    </div>
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
                    <input type="submit" name="Filter" value="Filter" />
                </form>
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
            }
            else {
                echo $stmt -> error;
            }
            $calendar = new Calendar($logList);

            echo $calendar->show();

            ?>
        </article>

    </body>

</html>