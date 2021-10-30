<?php
include("conn/conn.php");

if (isset($_POST['email_check']))
{
    $signup_email = $_POST['signup_email'];
    $sql = "SELECT * FROM users WHERE email='".$signup_email."'";
    $results = mysqli_query($conn, $sql);
    if (mysqli_num_rows($results) > 0)
    {
        echo "Email already exists.";
        die();
    }
}
?>