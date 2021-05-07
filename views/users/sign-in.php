<h1 class="login">Login Form</h1>
<?php
if (isset($notify)) {
    echo "<h3 style='text-align: center; color:red;'>" . $notify . "</h3>";
}
?>
<form class="login-form" autocomplete="off" action="index.php?controller=users&action=sign-in-form" method="post"
      name="loginForm"
      onsubmit="return validateFormLogin()">
    <input type="text" name="username" placeholder="Username"/>
    <p class="error" id="err_username">username is required!</p>
    <input type="password" name="password" placeholder="Password"/>
    <p class="error" id="err_password">password is required!</p>
    <div class="nav">
        <a href="index.php?controller=users&action=forgot-password" class="forgot">Forgot password?</a>
        <a href="index.php?controller=users&action=sign-up" class="forgot">Sign up!</a>
    </div>

    <button type="submit" name="login" class="btn btn-sign-in">Sign in</button>
</form>