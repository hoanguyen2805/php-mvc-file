<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<div class="container" style="margin-top: 40px">
    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center">Forgot Password?</h2>
                        <p>We will be sending a reset password link to your email</p>
                        <div class="panel-body">

                            <form id="register-form" role="form" autocomplete="off" class="form" method="post"
                                  action="index.php?controller=users&action=forgotPasswordForm"
                                  onsubmit="return validateFormForgotPassword()"
                                  name="forgotForm">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i
                                                    class="glyphicon glyphicon-envelope color-blue"></i></span>
                                        <input id="email" name="email" placeholder="email address" class="form-control"
                                               type="email">
                                    </div>
                                    <br/>
                                    <p class="error" id="err_email_forgot">Email is required!</p>
                                </div>
                                <?php
                                if (isset($notify)) {
                                    echo "<p style='color: red; text-align: center'>" . $notify . "</p>";
                                }
                                ?>
                                <div class="form-group">
                                    <input name="recoverPassword" class="btn btn-lg btn-primary btn-block"
                                           value="Send" type="submit">
                                </div>

                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>