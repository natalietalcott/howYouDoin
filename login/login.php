<!DOCTYPE html>
<!-- How you doin? -->
<!-- login.html -->
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="login.css" />
	<title>login</title>

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
		$email = $password = '';
	?>
	<?php 
	 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
					setcookie("loginCredentials", $email, time() + 10, "/"); //expires after 10 seconds
					// Expiring after 2 hours = time() * 7200
				} else {
					echo("this echo does not exist");
				}
            }
            else {
                echo $stmt -> error;
            }
		}
	}
	?>
	<header>
		<section id="login">
			<h1> How You Doin? </h1>
			<!-- <h2> Log In </h2> -->
			<div id="formWrap">
				<form method="post">
					<!-- action="./ajax_submit.php"-->
					<label for="email" id="email_label">Email</label>
					<input id="email" type="email" name="email" placeholder="Email"><br><br>

					<label for="password" id="pass_label">Password</label>
					<input id="password" type="password" name="password" placeholder="Password"><br><br>
					<input id="submit" type="submit" value="Log In" name="submit"><br><br>
				</form>
			</div>
			<p>New Member? <a href="../createAcc/createAcc.php">CREATE ACCOUNT</a><br>
			<p><a href="../changePassword/changePassword.php">CHANGE PASSWORD</a><br>
		</section>
	</header>
</body>

</html>