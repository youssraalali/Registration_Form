<?php
session_start();
echo "Welcome <br> Your email is [ " . $_SESSION["email"] . " ] <br>And your password is [ " . sha1($_SESSION["password"]). " ]" ;

echo "<form method='post'>";
echo "<br>";
echo "<input type='submit' name='logOut' value='Logout'>";
echo "</form>";

if (isset($_POST['logOut'])) {
    session_destroy();
    header("location: login.php");
    exit();
}
