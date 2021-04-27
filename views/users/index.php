<div class="container">
    <h3>Xin chào <?= $fullName ?></h3>
    <div class="row">
        <div class="col">
            <img src="<?= $urlAvatar ?>" alt="" width="100px">
        </div>
        <div class="col">
            <p>Email: <?= $email ?></p>
            <p>Username: <?= $username ?></p>
            <p>Ngày sinh: <?= $birthDay ?></p>
            <?php
            if ($role == 1) {
                ?>
                <p><a href="index.php?controller=users&action=listUsers">list users</a></p>
                <?php
            }
            ?>
        </div>
    </div>
    <a href="index.php?controller=users&action=signOut">
        <button>LOG OUT</button>
    </a>
</div>
