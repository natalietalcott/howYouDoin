<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<!-- <link rel="stylesheet" type="text/css" href="/howYouDoin/login/login.css" /> -->
	<link rel="stylesheet" type="text/css" href="show_log.css" />
	<title>View Log</title>

</head>

<body>
<?php
    $cookie_name = "loginCredentials";
    if (!isset($_COOKIE[$cookie_name])) {
        // Not logged in :(
        header("Location: ../login/login.php"); /* Redirect browser */
        exit();
        // echo "Cookie named '" . $cookie_name . "' is not set!";
    } else {
        // Logged In
        // echo "Cookie '" . $cookie_name . "' is set!<br>";
        // echo "Value is: " . $_COOKIE[$cookie_name];

        // //send an email
        // $to = $_COOKIE[$cookie_name];
        // $subject = "Test Subject";
        // $msg = "You logged into my website!!\nSuper neat! :))";
        // // use wordwrap() if lines are longer than 70 characters
        // // $msg = wordwrap($msg, 70);
        // $headers = "From: gabbybmeow@gmail.com" . "\r\n"; 
        // //send email
        // mail($to, $subject, $msg, $headers);
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
		//set the variables
        $email = $_COOKIE[$cookie_name];
        $date =$_GET['date'];
        $selectedEmotion = $note = $tag = '';
	?>
	<?php 
	 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         if (isset($_POST['delete'])){
            $query = "DELETE FROM DAILY_LOG WHERE (email = ? && date = ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $email, $date);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
            } else {
                echo ("ERROR");
            }
         }
         if (isset($_POST['update'])){
             
            if (isset($_POST['note'])) {
                $note = ($_POST['note']);
            }
            
            if (isset($_POST['daily_tag'])) {
                $tag = ($_POST['daily_tag']);
            }
            
            if (isset($_POST['emotion'])) {
                $selectedEmotion = $_POST['emotion'];
                //echo($selected_emotion);
            }
            $query = "UPDATE DAILY_LOG SET tag=?, note=?, emotion=?  WHERE (email = ? && date = ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssss", $tag, $note, $emotion, $email, $date);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
            } else {
                echo ("ERROR");
            }
         }
	}
	?>
    <?php
        //get the value of the calendar block
        $query = "SELECT * FROM DAILY_LOG WHERE (email = ? && date = ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $date);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            //echo($result);
            while ($row = $result->fetch_array()) {
                //echo($row['email']);
                $selectedEmotion = $row['emotion'];
                $tag = $row['tag'];
                $note = $row['note'];
            }
        } else {
            echo ("ERROR");
        }

    ?>
	<header>
		<section id="log">
			<h1> View & Update Log </h1>
			<!-- <h2> Log In </h2> -->
			<div id="formWrap">
				<form method="post">
                    <label for="date" id="date_label">DATE: <?php echo $date ?></label>
					<p id="emotion">EMOTION: <?php echo $selectedEmotion;?></p>
                    <select name="emotion">
                        <option value = ""> Change Emotion </option>
                        <option value="super-sad">Super Sad</option>
                        <option value="sad">Sad</option>
                        <option value="neutral">Neurtral</option>
                        <option value="happy">Happy</option>
                        <option value="super-happy">Super Happy</option>
                    </select>
                    <p id="tag">TAG: <?php echo $tag;?></p>
                    <select name="daily_tag">
                        <option value= "">Change Tag</option>
                        <option value="weather">Weather</option>
                        <option value="friends">Friends</option>
                        <option value="family">Family</option>
                        <option value="school">School</option>
                        <option value="work">Work</option>
                        <option value="drama">Drama</option>
                        <option value="relationship">Relationship</option>
                    </select>
                    <p id="note">REASONING: </p> 
                    <textarea rows="5" type="text" name="note" class="input_note"> <?php echo $note; ?></textarea><br>
                    <input id="submit" type="submit" value="Update" name="update">
                    <input id="submit" type="submit" value="Delete" name="delete"><br><br>
				</form>
            </div>
            <!--
			<p>New Member? <a href="../createAcc/createAcc.php">CREATE ACCOUNT</a><br>
            <p><a href="../changePassword/changePassword.php">CHANGE PASSWORD</a><br>
-->
		</section>
	</header>
</body>

</html>