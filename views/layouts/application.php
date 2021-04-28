<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link
            rel="stylesheet"
            href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
            integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
            crossOrigin="anonymous"
    />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <script src="assets/js/validation.js"></script>
    <title>PHP-MVC</title>
</head>
<body>
<div class="topnav" id="myTopnav">
    <a href="index.php?controller=products" class="active">Home</a>
    <div class="dropdown">
        <button class="dropbtn">Categories <i class="fa fa-caret-down"></i></button>
        <div class="dropdown-content">
            <?php
            foreach ($categories as $category) {
                echo "  <a href=\"index.php\">$category[1]</a>";
            }
            ?>
        </div>
    </div>
    <?php
    if (!isset($_SESSION['user'])) {
        echo " <a href=\"index.php?controller=users&action=signIn\"><i class=\"fa fa-sign-in\" aria-hidden=\"true\"></i> Sign In</a>";
        echo "<a href=\"index.php?controller=users&action=signUp\"><i class=\"fa fa-user-plus\" aria-hidden=\"true\"></i> Sign Up</a>";
    } else {
        echo "<a href=\"index.php?controller=users\"><i class=\"fa fa-user\" aria-hidden=\"true\"></i> My Account</a>";
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == 1) {
                echo "<a href=\"index.php?controller=users&action=listUsers\">
                        <i class=\"fa fa-users\" aria-hidden=\"true\"></i> Manage users
                      </a>";
                echo "<a href=\"index.php?controller=products&action=manageProduct\">
                        <i class=\"fa fa-product-hunt\" aria-hidden=\"true\"></i> Manage products
                      </a>";
            }
        }
        echo "<a href=\"index.php?controller=users&action=signOut\"><i class=\"fa fa-sign-out\" aria-hidden=\"true\"></i> Sign Out</a>";
    }
    ?>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</div>
<?= @$content ?>
</body>
</html>