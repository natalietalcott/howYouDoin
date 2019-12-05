<!DOCTYPE html>
<!-- How you doin? -->
<!-- createAcc.html -->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <!-- <link rel="stylesheet" type="text/css" href="changePassword.css" /> -->
    <link rel="stylesheet" type="text/css" href="../login/login.css" />
    <title>Activate Account</title>

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


    //set the variables
    $email =  $_GET["email"];
    $hasActivated = '';

    //check if they already activated
    $query = "SELECT activated FROM USER_ACCOUNT WHERE (email = ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_row()) {
            $hasActivated = $row[0];
        }
        $stmt->close();
    } else {
        echo $stmt->error;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['submit'])) {
            $query = "UPDATE USER_ACCOUNT SET activated = true WHERE (email = ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                setcookie("loginCredentials", $email, time() + 120, "/"); //expires after 120 seconds
                header('Location: ../homePage/homePage.php');
                //send an email to let them know they successfully activated their account
                $to = $email;
                $subject = "HowYouDoin' Account Information";
                $msg = "You just activated your account!! Good for you :)";
                // use wordwrap() if lines are longer than 70 characters
                $msg = wordwrap($msg, 70);
                $headers = "From: gabbybmeow@gmail.com" . "\r\n";
                //send the email
                mail($to, $subject, $msg, $headers);
            } else {
                //echo("Failed");
                alert("was not able to activate account");
            }
            $stmt->close();
        }
    }
    ?>
    <header>
        <!-- php if -->
        <section id="activate">
            <h1> How You Doin? </h1>
            <h2> Activate Account! </h2>

        
        <?php
        if (!$hasActivated) {
            echo '<div>
            <p>Click below to activate your account so you can login!</p>
            <form method="post">
                <input id="submit" type="submit" value="Activate Account" name="submit"><br><br>
            </form>
        </div>';
        } else { 
            echo '<p>Looks like you already activated your account...</p><p><a href="../login/login.php">Go to Login?</a></p>';
        }
        ?>
        </section>
    </header>
</body>

</html>