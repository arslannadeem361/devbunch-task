<?php
    include("conn/conn.php");

    if (isset($_POST['login_email']))
    {
        $login_email = $_POST['login_email'];
        $login_email = mb_convert_encoding($login_email, 'UTF-8', 'UTF-8');
        $login_email = htmlentities($login_email, ENT_QUOTES, 'UTF-8');
    }

    if (isset($_POST['login_password']))
    {
        $login_password = $_POST['login_password'];
        $login_password = mb_convert_encoding($login_password, 'UTF-8', 'UTF-8');
        $login_password = htmlentities($login_password, ENT_QUOTES, 'UTF-8');
    }

    $query_login = "SELECT * FROM users WHERE email = '".$login_email."' AND password = '".md5($login_password)."' AND status = 1";
    $result_login = mysqli_query($conn, $query_login);
    if(mysqli_num_rows($result_login) > 0)
    {
        $row_login = mysqli_fetch_array($result_login);

        $_SESSION["loggedin"] = true;
        $_SESSION["user_id"] = ($row_login["id"]);

        echo "loggedIn";
        die;
    }
    else
    {
        echo "error";
        die;
    }
?>