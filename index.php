<?php
//include oop class
require_once "User.php";

// initialize variables
$error = "";
$reerror = "";


// check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $FullName = $_POST["FullName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];

    // create user object with the submitted credentials
    $user = new User($FullName, $email, $password, $repassword);

    // perform form validation and set error messages
    $emailExist = $user->existEmail('data.txt', $email);
    $emailResult = $user->validEmail();
    $passResult = $user->validPass();
    $passMatch = $user->identicalPass();
    $emailExist = $user->existEmail('data.txt', $email);


    if ($emailResult === true && empty($passResult) && empty($passMatch) && empty($emailExist)) {
        // authentication successful, save the data and redirect to save_data.php
        $data = "Email: " . $email . " Password: " . $password . "\n";
        $file = "data.txt";
        file_put_contents($file, $data, FILE_APPEND);

        session_start();
        $_SESSION["FullName"] = $FullName;
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;

        header("Location: dashboard.php");
        exit();
    } else {
        // authentication failed, display error messages
        $error = $emailResult;
        $reerror = $passMatch . "<br>" . $emailExist;
        if ($error == 1) {
            $error = "";
        }
        foreach ($passResult as $errorMessage) {
            $error .= "<br>" . $errorMessage;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" type="text/css" href="stylesign.css">
    <script src="show.js"></script>
</head>

<body>
    <div class="container">
        <h1>SIGN UP</h1>
        <?php if (isset($error)) { ?>
            <p class="error"> <?php echo $error . "<br>" . $reerror; ?> </p>
        <?php } ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="FullName">Full Name:</label>
            <input type="text" id="FullName" name="FullName" required>

            <label for="email">Email:</label>
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

            <div class="password-toggle">
                <label for="repassword">Re-enter Password:</label>
                <input type="password" id="repassword" name="repassword" required>
                <span class="toggle-icon" onclick="togglePasswordVisibility('repassword')">
                    <img src="show.png" alt="Toggle Password Visibility">
                </span>
            </div>

            <label class="agreeLabel" for="agreeBox">
                <input type="checkbox" id="agreeBox" name="agreeBox" value="agreeBox" required>
                You agree to our Terms of Use and Privacy Policy.
                <span class="checkmark"></span>
            </label>

            <label class="login" for="login">Already have an account?</label>
            <a href="login.php">Log in</a>
            <input type="submit" name="signup" value="Sign Up">
        </form>
    </div>
</body>

</html>