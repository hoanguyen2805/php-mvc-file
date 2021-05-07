<div class="signup">
    <h1 class="signup-heading">Sign up</h1>
    <?php
    if (isset($notify)) {
        echo "<h3 class='sign-up-error'>" . $notify . "</h3>";
    }
    ?>
    <form action="index.php?controller=users&action=sign-up-form" class="signup-form" autocomplete="off" method="post"
          enctype="multipart/form-data" name="myForm"
          onsubmit="return validateFormSignUp()">

        <div class="form-group">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-input" id="name" placeholder="Eg: John Doe" name="fullName">
            <p class="error" id="err_name">Full Name is required!</p>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-input" id="email" placeholder="Eg: johndoe@email.com" name="email">
            <p class="error" id="err_email">Email is required!</p>
        </div>

        <div class="form-group">
            <label for="username" class="form-label">User Name</label>
            <input type="text" class="form-input" id="username" placeholder="Eg: john" name="username">
            <p class="error" id="err_username">Username is required!</p>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-input" id="password" placeholder="******" name="password">
            <p class="error" id="err_password">Password is required!</p>
        </div>

        <div class="form-group">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-input" id="confirmPassword" placeholder="******" name="confirmPassword">
            <p class="error" id="err_password_confirm">password and confirm password must be match!</p>
        </div>

        <div class="form-group">
            <label for="birth" class="form-label">Birthday</label>
            <input type="date" class="form-input" id="birth" name="birth">
            <p class="error" id="err_birth">Birthday is required!</p>
        </div>

        <div class="form-group">
            <label for="avatar" class="form-label">Avatar</label>
            <input type="file" class="form-input" id="avatar" name="avatar">
            <p class="error" id="err_avatar">Avatar is required!</p>
        </div>
        <button type="submit" class="form-submit" name="signUp">Sign up</button>
    </form>
    <p class="signup-already">Already have an account ? <a href="index.php?controller=users&action=sign-in"
                                                           class="signup-already-link">Login</a></p>
</div>