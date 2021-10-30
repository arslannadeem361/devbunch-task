<?php
    include('conn/conn.php');

    if(!isset($_SESSION["user_id"]))
    {
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo $_SESSION['company_name'] ?> | Welcome</title>

    <?php include ('includes/head.php') ?>
</head>

<body class="my-login-page">
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">

            <div class="card-wrapper" style="margin-top: 150px;">

                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title text-center">
                            Welcome to your profile <br> <strong>arslanraja722</strong>
                        </h4>

                        <div class="form-group m-0">
                            <a href="logout.php" class="btn btn-primary btn-block">
                                Logout
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
