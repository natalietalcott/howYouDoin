<!DOCTYPE html>
<!-- How you doin? -->
<!-- createAcc.html -->
<html lang="en">

<head>
	<meta charset="utf-8" />
	<!-- <link rel="stylesheet" type="text/css" href="changePassword.css" /> -->
	<link rel="stylesheet" type="text/css" href="../login/login.css" />
	<title>Change Password</title>

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
	$email = $password = $confirm_password = '';
	?>
	<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['email'])) {
			$email = $_POST['email'];
		}
		if (isset($_POST['password'])) {
			$password = $_POST['password'];
		}
		if (isset($_POST['confirm_password'])) {
			$confirm_password = $_POST['confirm_password'];
		}
		if (isset($_POST['submit'])) {
			if ($password != $confirm_password) {
				alert("Passwords do NOT match");
			}
			$query = "UPDATE USER_ACCOUNT SET password = ? WHERE (email = ?)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ss", $password, $email);
			if ($stmt->execute()) {
				header('Location: ../homePage/homePage.php');
				//echo ("created account successfully");
			} else {
				//echo("Failed");
				alert("was not able to create account");
			}
			$stmt->close();
		}
	}
	?>
	<!-- <header>
		<h1> How you doin? </h1>
	</header>

	<section id="create">
		<h2> Change password! </h2>
		<form method="post">
			Email: <input id="email" type="text" name="email"><br><br>
			New Password: <input id="password" type="text" name="password"><br><br>
			Re enter New Password: <input id="reenter" type="text" name="confirm_password"><br><br>
			<input id="submit" type="submit" value="Change Password" name="submit">
		</form>
		<a href="../login/login.html">I already have an account </a>

	</section> -->

	<header>
		<section id="create">
			<h1> How You Doin? </h1>
			<h2> Change Password! </h2>
			<div id="create">
				<form method="post">
					<label for="email" id="email_label">Email</label>
					<input id="email" type="email" name="email" placeholder="Email"><br><br>

					<label for="password" id="pass_label">New Password:</label>
					<input id="password" type="password" name="password" placeholder="Password"><br><br>

					<label for="reenter" id="repass_label">Re-enter New Password:</label>
					<input id="reenter" type="password" name="password" placeholder="Confirm New Password"><br><br>

					<input id="submit" type="submit" value="Log In" name="submit"><br><br>
				</form>
			</div>
			<a href="../login/login.php">I already have an account </a>
		</section>
	</header>
</body>

</html>