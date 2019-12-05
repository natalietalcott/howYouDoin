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
	//try to connect to the backend so we can verify the login
    include('../homePage/database_connection.php');
    $query = file_get_contents('../homePage/databaseCreation.sql');

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
		//$email = $password = '';
	?>
	<?php 
	 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         /*
		if (isset($_POST['email'])){
			$email = $_POST['email'];
			//echo ($email);
		}
		if (isset($_POST['password'])){
			$password = $_POST['password'];
			//echo($password);
		}
		if (isset($_POST['submit'])) {
			$query = "SELECT * FROM USER_ACCOUNT WHERE (email = ? && password = ?)";
			$stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $email, $password);
            if ($stmt->execute()) {
				$count = 0;
                $result = $stmt->get_result();
                while ($row = $result->fetch_array()) {
                    $count++;
				}
				$stmt->close();
				if ($count > 0){
					header('Location: ../homePage/homePage.php');
				} else {
					echo("this echo does not exist");
				}
            }
            else {
                echo $stmt -> error;
            }
        }
        */
	}
	?>
	<header>
		<section id="log">
			<h1> View & Update Log </h1>
			<!-- <h2> Log In </h2> -->
			<div id="formWrap">
				<form method="post">
                    <label for="date" id="date_label">DATE SUBMITTED</label>
					<p id="emotion">SELECTED EMOTION</p>
                    <select name="daily_tag" value="neutral">
                        <option value="super-sad">Super Sad</option>
                        <option value="sad">Sad</option>
                        <option value="neutral">Neurtral</option>
                        <option value="happy">Happy</option>
                        <option value="super-happy">Super Happy</option>
                    </select>
                    <p id="tag">SELECTED TAG</p>
                    <select name="daily_tag" value="family">
                        <option value="weather">Weather</option>
                        <option value="friends">Friends</option>
                        <option value="family">Family</option>
                        <option value="school">School</option>
                        <option value="work">Work</option>
                        <option value="drama">Drama</option>
                        <option value="relationship">Relationship</option>
                    </select>
                    <p id="note">REASONING</p>
                    <textarea rows="5" type="text" name="note" class="input_note" value="<?php echo $note; ?>"></textarea><br>
                    <input id="submit" type="submit" value="Update" name="submit">
                    <input id="submit" type="submit" value="Delete" name="submit"><br><br>
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