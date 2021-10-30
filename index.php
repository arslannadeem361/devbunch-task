<?php
    include('conn/conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo $_SESSION['company_name'] ?> | Home</title>

    <?php include ('includes/head.php') ?>
</head>

<body class="my-login-page">
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">

            <!-- LOGIN FORM DIV  **START**   -->
            <div class="card-wrapper" id="login_div">
                <div class="brand">
                    <img src="img/logo.jpg" alt="logo">
                </div>
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title text-center">Login</h4>
                        <form method="POST" id="login_form" name="login_form">
                            <div class="form-group">
                                <label for="login_email">E-Mail Address</label>
                                <input id="login_email" type="email" class="form-control" name="login_email" value="" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="login_password">Password</label>
                                <input id="login_password" type="password" class="form-control" name="login_password" required data-eye>
                            </div>

                            <div class="g-recaptcha" data-sitekey="6LejHgMdAAAAAHiLm9GHsQsZavB6DwpbaGS7LMhU"></div>
                            <div id="captcha_error_login"></div>

                            <div class="form-group m-0 mt-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Login
                                </button>
                            </div>
                            <div class="mt-4 text-center">
                                Don't have an account? <a onclick="register()" class="pointer text-primary">Create One</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="footer">
                    Copyright &copy; <?php echo date('Y') ?> &mdash; <?php echo $_SESSION['company_name'] ?>
                </div>
            </div>
            <!-- LOGIN FORM DIV   **END**  -->


            <!-- REGISTRATION FORM DIV   **START**  -->
            <div class="card-wrapper" id="registration_div">
                <div class="brand">
                    <img src="img/logo.jpg" alt="bootstrap 4 login page">
                </div>
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title text-center">Register</h4>
                        <form method="POST" id="registration_form" name="registration_form">
                            <div class="form-group">
                                <label for="signup_name">Name</label>
                                <input type="text" class="form-control" id="signup_name" name="signup_name" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="signup_email">E-Mail Address</label>
                                <input type="email" class="form-control" id="signup_email" name="signup_email" required>
                                <div id="email_exist_msg"></div>
                            </div>

                            <div class="form-group">
                                <label for="signup_password">Password (Minimum 8 Characters)</label>
                                <input type="password" class="form-control" id="signup_password" name="signup_password" minlength="8" required>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="8" required>
                                <div id="message"></div>
                            </div>

                            <div class="form-group m-0 mt-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Register
                                </button>
                            </div>
                            <div class="mt-4 text-center">
                                Already have an account? <a onclick="login()" class="pointer text-primary">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="footer">
                    Copyright &copy; <?php echo date('Y') ?> &mdash; <?php echo $_SESSION['company_name'] ?>
                </div>
            </div>
            <!-- REGISTRATION FORM DIV   **END**  -->


        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<script src="js/custom.js"></script>

<script type="text/javascript">
    $('#signup_password, #confirm_password').on('keyup', function () {
        if ($('#signup_password').val() == $('#confirm_password').val())
        {
            $('#message').html('Password Matching').css('color', 'green');
        }
        else
        {
            $('#message').html('Password Not Matching').css('color', 'red');
        }
    });



    $("#login_form").on("submit", function(e)
    {
        e.preventDefault();

        if(grecaptcha.getResponse() == "")
        {
            e.preventDefault();
            $('#captcha_error_login').html("Please verify reCAPTCHA").css('color', 'red');
        }
        else
        {
            var login_email = $('#login_email').val();
            var login_password = $('#login_password').val();

            $.ajax({
                async: true,
                type: "POST",
                url: "login_hdl.php",
                data: {
                    "login_email": login_email,
                    "login_password": login_password
                },
                success: function (data) {
                    if(data == "loggedIn"){
                        location.href = "welcome.php";
                    }else{
                        bootbox.dialog({
                            message: "Please enter valid credentials, and try again.",
                            title: "Alert!!",
                            buttons: {
                                success: {
                                    label: "Close",
                                    className: "btn btn-danger",
                                    callback: function () {
                                        location.reload();
                                    }
                                }
                            }
                        });
                    }
                }
            });
        }
    });

    var email_state = false;

    $('#signup_email').on('blur', function()
    {
        var signup_email = $('#signup_email').val();
        if (signup_email == '')
        {
            email_state = false;
            return;
        }
        $.ajax({
            url: 'email_check_hdl.php',
            type: 'post',
            data: {
                'email_check' : 1,
                'signup_email' : signup_email,
            },
            success: function(response){
                if (response == "Email already exists.")
                {
                    email_state = false;
                    $('#signup_email').val('');

                    $('#email_exist_msg').html("Email already exists.").css('color', 'red');

                    $("#signup_email").click(function() {
                        $(this).closest('registration_form').find("input[type=signup_email]").val("");
                    });
                }
            }

        });
    });

    $("#registration_form").on("submit", function(e)
    {
        e.preventDefault();

        var signup_name = $('#signup_name').val();
        var signup_email = $('#signup_email').val();
        var signup_password = $('#signup_password').val();
        var confirm_password = $('#confirm_password').val();

        if (signup_password == confirm_password)
        {
            $.ajax({
                async: true,
                type: "POST",
                url: "register_hdl.php",
                data: {
                    "signup_name": signup_name,
                    "signup_email": signup_email,
                    "signup_password": signup_password,
                    "confirm_password": confirm_password
                },
                success: function (data) {
                    if(data == "success"){
                        bootbox.dialog({
                            message: "Your account hasbeen created successfully. Please check your email to activate your account.",
                            title: "Alert!!",
                            buttons: {
                                success: {
                                    label: "Close",
                                    className: "btn btn-success",
                                    callback: function () {
                                        location.reload();
                                    }
                                }
                            }
                        });
                    }else if(data == "error"){
                        bootbox.dialog({
                            message: "Error while saving record.",
                            title: "Alert!!",
                            buttons: {
                                success: {
                                    label: "Close",
                                    className: "btn btn-danger",
                                    callback: function () {
                                        location.reload();
                                    }
                                }
                            }
                        });
                    }
                }
            });
        }
        else
        {
            bootbox.dialog({
                message: "Please make sure Password & Confirm Password both are same.",
                title: "Alert!!",
                buttons: {
                    success: {
                        label: "Close",
                        className: "btn btn-danger",
                        callback: function () {
                        }
                    }
                }
            });
        }
    });
</script>

</body>
</html>
