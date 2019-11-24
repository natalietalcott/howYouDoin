<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="homePage.css" />
    <link href="calendar.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
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
    <nav>
        <div class="navbar">
            <a class="log" id="log" href="#"><i class="fa fa-pencil-square-o fa-2x"></i></a>
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
        <p id="emotion">EMOTION</p>
        <p id="emoticon">EMOTICON</p>
        <p id="note">NOTE</p>
        <textarea rows="4" cols="50"></textarea>
        <p id="tag">TAG</p>
        <div class="submit_btn">
            <p>SUBMIT</p>
        </div>
    </div>

    <article>
        <?php
        //TOOD: this will be set earlier
        $email = "gabbybmeow@gmail.com";


        //get all the calendar dates for this user
        $logList = array();
        $query = "SELECT * FROM daily_log WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_array()) {
                array_push($logList, $row);
            }
            $stmt->close();
        }
        $calendar = new Calendar($logList);

        echo $calendar->show();
        ?>
    </article>

</body>

</html>