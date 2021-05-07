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
    <title>PHP-MVC-FILE</title>
</head>
<body>
<div class="topnav" id="myTopnav">
    <?php
    function active($currect_page)
    {
        $url_array = explode('/', $_SERVER['REQUEST_URI']);
        $url = end($url_array);
        if (strpos($url, $currect_page) !== false) {
            echo 'active'; //class name in css
        }
    }

    if (!isset($_SESSION['user'])) {
        ?>
        <a href="index.php?controller=users&action=sign-in"
           class="<?php active("index.php?controller=users&action=sign-in"); ?>">
            <i class="fa fa-sign-in" aria-hidden="true"></i> Sign In
        </a>
        <a href="index.php?controller=users&action=sign-up"
           class="<?php active("index.php?controller=users&action=sign-up"); ?>">
            <i class="fa fa-user-plus" aria-hidden="true"></i> Sign Up
        </a>
        <?php
    } else {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
            ?>
            <a href="index.php?controller=users&action=list-users"
               class="<?php active("index.php?controller=users&action=list-users"); ?>">
                <i class="fa fa-users" aria-hidden="true"></i> Manage users
            </a>
            <a href="index.php?controller=products&action=manage-product"
               class="<?php active("index.php?controller=products&action=manage-product"); ?>">
                <i class="fa fa-product-hunt" aria-hidden="true"></i> Manage products
            </a>
            <?php
        }
        ?>
        <a href="index.php?controller=users&action=info"
           class="<?php active("index.php?controller=users&action=info"); ?>">
            <i class="fa fa-user" aria-hidden="true"></i> My Account
        </a>
        <a href="index.php?controller=users&action=sign-out">
            <i class="fa fa-sign-out" aria-hidden="true"></i> Sign Out
        </a>
        <?php
    }
    ?>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>


</div>
<?= @$content ?>
</body>
</html>