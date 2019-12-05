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
	//reset cookie at begininning
	setcookie("loginCredentials", "", -1, "/");

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
		if (isset($_POST['email'])) {
			$email = $_POST['email'];
			//echo ($email);
		}
		if (isset($_POST['password'])) {
			$password = $_POST['password'];
			//echo($password);
		}
		if (isset($_POST['submit'])) {
			$query = "SELECT * FROM USER_ACCOUNT WHERE (email = ? && password = ?) && activated = true";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ss", $email, $password);
			if ($stmt->execute()) {
				$count = 0;
				$result = $stmt->get_result();
				while ($row = $result->fetch_array()) {
					$count++;
				}
				$stmt->close();
				if ($count > 0) {
					header('Location: ../homePage/homePage.php');
					setcookie("loginCredentials", $email, time() + 120, "/"); //expires after 120 seconds
					// Expiring after 2 hours = time() * 7200
				} else {
					//TODO: ADD COULD NOT LOGIN THING
					// echo ("this echo does not exist");
					echo '<div id="myModal" class="modal">

					<!-- Modal content -->
					<div class="modal-content">
						<span class="close">&times;</span>
						<h2>Couldn\'t Log In</h2>
						<p>Have you activated your account yet?</p>
						<p>Make sure to check your password</p>
					</div>
				</div>';
				}
			} else {
				echo $stmt->error;
			}
		}
	}
	?>
	<!-- The Modal -->
	<!-- <div id="myModal" class="modal"> -->

		<!-- Modal content -->
		<!-- <div class="modal-content">
			<span class="close">&times;</span>
			<h2>Couldn't Log In</h2>
			<p>Have you activated your account yet?</p>
		</div>
	</div> -->
	<header>
		<section id="login">

			<h1> How You Doin? </h1>
			<h2> Log In </h2>
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
	<script>
		var modal = document.getElementById("myModal");

		// Get the button that opens the modal
		var btn = document.getElementById("myBtn");

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks on the button, open the modal
		// btn.onclick = function() {
		// 	modal.style.display = "block";
		// }

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	</script>
</body>

</html>