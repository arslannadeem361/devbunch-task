<?php
    include('conn/conn.php');

    if(empty($_GET['id']) || empty($_GET['token'])){
        header("Location: index.php");
        die;
    }
    else
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $decryption_iv = '1234567891011121';
        $decryption_key = "R@j@";

        $id = openssl_decrypt($_GET['id'], $ciphering, $decryption_key, $options, $decryption_iv);
        $token = openssl_decrypt($_GET['token'], $ciphering, $decryption_key, $options, $decryption_iv);

        $check_activation_code = $conn->query("SELECT * FROM users WHERE id = '$id' AND activation_code = '$token'");
        $row_check = mysqli_fetch_assoc($check_activation_code);

        if ($row_check['status'] == 0) {
            $query_update = $conn->query("UPDATE users SET
            status = '1',
            date_updated = NOW() WHERE id = '$id'");
            if ($query_update && $row_check['id'] > 0) {
                $user_name = $row_check['name'];
                $icon = '<i class="fas fa-check-circle text-success" style="font-size: 90px;"></i>';
                $text = "Account Activated";
                $type = "alert-success";
                $message = "Email Verified Successfully.";
            } else {
                $user_name = "";
                $icon = '<i class="fas fa-times-circle text-danger" style="font-size: 90px;"></i>';
                $text = "Account Not Activated";
                $type = "alert-danger";
                $message = "Error while verifying email. Something went wrong.";
            }
        } else if ($row_check['status'] == 1) {
            $user_name = $row_check['name'];
            $icon = '<i class="fas fa-check-circle text-success" style="font-size: 90px;"></i>';
            $text = "Account Already Activated";
            $type = "alert-warning";
            $message = "Email already verified, and account was activated successfully.";
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo $_SESSION['company_name'] ?> | Email Verification</title>

    <?php include ('includes/head.php')?>
</head>

<body class="my-login-page">
    <section>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="card-wrapper" style="margin-top: 150px;">
                    <div class="text-center">
                        <?php echo $icon ?>
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title text-center">
                                <?php echo $text ?>
                            </h4>
                            <div class="alert <?php echo $type ?> alert-dismissible fade show" role="alert">
                                <strong>Hi <?php echo $user_name ?>!</strong> <?php echo $message ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="form-group m-0">
                                <a href="" class="btn btn-primary btn-block">
                                    Login to your account
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; <?php echo date('Y') ?> &mdash; <?php echo $_SESSION['company_name'] ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
<?php
    }
?>
