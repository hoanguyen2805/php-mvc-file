/**
 *
 * Hoa
 * Created at 21-04-2021 08h:40
 * Validate for Form Sign Up
 *
 */
function validateFormSignUp() {
    let fullName = document.forms["myForm"]["fullName"].value;
    let email = document.forms["myForm"]["email"].value;
    let username = document.forms["myForm"]["username"].value;
    let password = document.forms["myForm"]["password"].value;
    let confirmPassword = document.forms["myForm"]["confirmPassword"].value;
    let birth = document.forms["myForm"]["birth"].value;
    let avatar = document.forms["myForm"]["avatar"].value;
    let regex = /^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/;
    let check = true;
    if (fullName == "" || fullName == null) {
        document.getElementById("err_name").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_name").style.display = "none";
    }
    if (email == "" || email == null) {
        document.getElementById("err_email").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_email").style.display = "none";
    }
    if (username == "" || username == null) {
        document.getElementById("err_username").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_username").style.display = "none";
    }
    if (password == "" || password == null) {
        document.getElementById("err_password").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_password").style.display = "none";
    }
    if (birth == "" || birth == null) {
        document.getElementById("err_birth").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_birth").style.display = "none";
    }
    if (avatar == "" || avatar == null) {
        document.getElementById("err_avatar").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_avatar").style.display = "none";
    }
    if (password != confirmPassword) {
        document.getElementById("err_password_confirm").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_password_confirm").style.display = "none";
    }
    if (check == false) {
        return check;
    }

    if (check) {
        if (!regex.test(fullName)) {
            alert("Please do not enter following special characters in the Full Name field");
            check = false;
            return check;
        }
        if (!regex.test(username)) {
            alert("Please do not enter following special characters in the Username field");
            check = false;
            return check;
        }
    }
}

/**
 *
 * Hoa
 * Created at 21-04-2021 17h:05
 * Validate for Form Sign in
 *
 */
function validateFormLogin() {
    let username = document.forms["loginForm"]["username"].value;
    let password = document.forms["loginForm"]["password"].value;
    let check = true;
    if (username.trim() == "" || username == null) {
        document.getElementById("err_username").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_username").style.display = "none";
    }
    if (password == "" || username == null) {
        document.getElementById("err_password").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_password").style.display = "none";
    }
    if (check == false) {
        return false;
    }


}


/**
 *
 * Hoa
 * Created at 22-04-2021 14h:10
 * Validate for Form Forgot Password - send email
 *
 */
function validateFormForgotPassword() {
    let email = document.forms["forgotForm"]["email"].value;
    let check = true;
    if (email == "" || email == null) {
        document.getElementById("err_email_forgot").style.display = "block";
        check = false;
    }
    if (check == false) {
        return check;
    }
}

/**
 *
 * Hoa
 * Created at 23-04-2021 10h:05
 * Validate for Form Reset Password
 *
 */
function validateFormResetPassword() {
    let password = document.forms["resetForm"]["password"].value;
    let confirmPassword = document.forms["resetForm"]["passwordConfirm"].value;
    let check = true;
    if (password !== confirmPassword) {
        document.getElementById("err_password_reset_confirm").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_password_reset_confirm").style.display = "none";
    }
    if (password == "" || password == null) {
        document.getElementById("err_password_reset").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_password_reset").style.display = "none";
    }
    if (check == false) {
        return check;
    }
}

/**
 *
 * Hoa
 * Created at 27-04-2021 08h:50
 * click open menu on mobi
 *
 */
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

/**
 *
 * Hoa
 * Created at 26-04-2021 10h00
 * validate for form add product
 *
 */
function validateFormAddProduct() {
    let name = document.forms["formAddProduct"]["name"].value;
    let price = document.forms["formAddProduct"]["price"].value;
    let category = document.forms["formAddProduct"]["category"].value;
    let img = document.forms["formAddProduct"]["image"].value;
    let regex = /^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/;
    let check = true;
    if (name == "" || name == null) {
        document.getElementById("err_name_product").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_name_product").style.display = "none";
    }
    if (price == "" || price == null || isNaN(price)) {
        document.getElementById("err_price_product").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_price_product").style.display = "none";
    }
    if (category == "" || category == null) {
        document.getElementById("err_select_product").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_select_product").style.display = "none";
    }

    if (img == "" || img == null) {
        document.getElementById("err_image_product").style.display = "block";
        check = false;
    } else {
        document.getElementById("err_image_product").style.display = "none";
    }

    if (check == false) {
        return check;
    }
    if (check) {
        if (!regex.test(name)) {
            alert("Please do not enter following special characters in the name field");
            check = false;
            return check;
        }
    }
}