<?php
require_once("User.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $old = new Old($email, $pass);

    $emailResult = $old->validEmail();
    $passResult = $old->validPass();

    $handle = fopen('data.txt', 'r');

    $userExist = $old->isUserExist('data.txt', $email, $pass);

    $error = $userExist;
    if ($emailResult === true && empty($userExist)) {
        header("Location: welcome.php");
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $pass;
    }

    fclose($handle); // Close the file handle after usage
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="stylelog.css">
    <script src="show.js"></script>
</head>

<body>
    <div class="container">
        <h1>LOG IN</h1>
        <?php if (isset($error)) { ?>
            <p class="error"> <?php echo $error; ?> </p>
        <?php } ?>
        <form method="Post">
            <label for="LogEmail">Email: </label>
            <input type="text" id="email" name="email" required>
            <div class="password-toggle">
                <label for="password">Password:</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" required>
                    <span class="toggle-icon" onclick="togglePasswordVisibility('password')">
                        <img  src="show.png" alt="Toggle Password Visibility">
                    </span>
                </div>
            </div>
            <input type="submit" value="log in">
            <label for="sigup" class="signup">Don't have an account?</label>
            <a href="index.php">Sign up</a>
        </form>
    </div>
</body>

</html>