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
	<header>

		<section id="login">
			<h1> How You Doin? </h1>
			<!-- <h2> Log In </h2> -->
			<div id="formWrap">
				<form method="post"> <!-- action="./ajax_submit.php"-->
					<label for="email" id="email_label">Email</label>
					<input id="email" type="email" name="email" placeholder="Email"><br><br>
					
					<label for="password" id="pass_label">Password</label>
					<input id="password" type="password" name="password" placeholder="Password"><br><br>
					<input id="submit" type="submit" value="Log In"><br><br>
				</form>
			</div>
			<p>New Member? <a href="../createAcc/createAcc.html">CREATE ACCOUNT</a><br>
			<p>Did you forget your password you dumb shit? <span id="forget" onclick="forgot()">Reset Password</span></p>

			<script>
				function forgot() {
					document.getElementById("forget").style.color = "purple";
					alert("An email was sent to you containing account recovery information");

				}
			</script>
		</section>
	</header>
</body>

</html>