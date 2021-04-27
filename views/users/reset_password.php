<h3 style='text-align: center;'>Reset Password</h3>
<?php
if (isset($notify)) {
    echo "<p style='color:red; text-align: center'>" . $notify . "</p>";
}
$key = "";
$token = "";
if (isset($_GET['key'])) {
    $key = $_GET['key'];
}
if (isset($_GET['token'])) {
    $token = $_GET['token'];
}
?>
<form class="login-form" autocomplete="off"
      action="index.php?controller=users&action=resetPasswordForm&key=<?= $key ?>&token=<?= $token ?>"
      method="post"
      name="resetForm"
      onsubmit="return validateFormResetPassword()">

    <input type="password" name="password" placeholder="New Password"/>
    <p class="error" id="err_password_reset">password không được để trống!</p>
    <input type="password" name="passwordConfirm" placeholder="Confirm Password"/>
    <p class="error" id="err_password_reset_confirm">Phải giống password ở trên!</p>
    <button type="submit" name="reset">Reset Password</button>
</form>