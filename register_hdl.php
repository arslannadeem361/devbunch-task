<?php
    include("conn/conn.php");

    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options   = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "R@j@";

    use PHPMailer\PHPMailer\PHPMailer;
    require 'vendor/autoload.php';

    if (isset($_POST['signup_name']))
    {
        $signup_name = $_POST['signup_name'];
        $signup_name = mb_convert_encoding($signup_name, 'UTF-8', 'UTF-8');
        $signup_name = htmlentities($signup_name, ENT_QUOTES, 'UTF-8');
    }

    if (isset($_POST['signup_email']))
    {
        $signup_email = $_POST['signup_email'];
        $signup_email = mb_convert_encoding($signup_email, 'UTF-8', 'UTF-8');
        $signup_email = htmlentities($signup_email, ENT_QUOTES, 'UTF-8');
    }

    if (isset($_POST['signup_password']))
    {
        $signup_password = $_POST['signup_password'];
        $signup_password = mb_convert_encoding($signup_password, 'UTF-8', 'UTF-8');
        $signup_password = htmlentities($signup_password, ENT_QUOTES, 'UTF-8');
        $EncryptPassword = md5($signup_password);
    }

    $activation_code = rand();

    $query_insert = "INSERT INTO users SET
    name = '".$signup_name."',
    email = '".$signup_email."',
    password = '".$EncryptPassword."',
    activation_code = '".$activation_code."',
    status = '0',
    date_created = NOW(),
    date_updated = NOW()
    ";

    if ($conn->query($query_insert) === TRUE)
    {
        $last_id = $conn->insert_id;

        $link = "<a href='http://localhost/devbunch-task/email-verify.php?id=".openssl_encrypt($last_id, $ciphering, $encryption_key, $options, $encryption_iv)."&token=".
        openssl_encrypt($activation_code, $ciphering, $encryption_key, $options, $encryption_iv)."'>Click and Verify Email</a>";

        $mail = new PHPMailer();
        $mail->CharSet =  "utf-8";
        $mail->IsSMTP();
        // enable SMTP authentication
        $mail->SMTPAuth = true;
        // GMAIL username
        $mail->Username = "arslan@wintexintl.com";
        // GMAIL password
        $mail->Password = "0773v63d@741";
        $mail->SMTPSecure = "ssl";
        // sets GMAIL as the SMTP server
        $mail->Host = "mail.wintexintl.com";
        // set the SMTP port for the GMAIL server
        $mail->Port = "465";

        $mail->From='arslan@wintexintl.com';
        $mail->FromName='Devbunch Test';
        $mail->AddAddress($signup_email, $signup_name);
        $mail->Subject  =  'Please verify your email address';
        $mail->IsHTML(true);
        $mail->Body    = 'Hello '.$signup_name.' <br>
        You registered an account on DEVBUNCH TEST, before being able to use your account you need to verify that this is your email address 
        by clicking here: '.$link.' <br>
        Kind Regards, <br>
        Devbunch Test';
        if($mail->Send())
        {
            echo "Message was Successfully Send :)";
        }
        else
        {
            echo "Mail Error - >".$mail->ErrorInfo;
        }

        echo "success";
        die;
    }
    else
    {
        echo "error";
        die;
    }
?>