<h2 style="text-align: center; margin-top: 30px; color: red">Manage Users</h2>

<form action="index.php?controller=users&action=formSearch" method="post" class="example"
      style="margin:auto;max-width:400px">
    <input type="text" placeholder="Enter username or email" name="key">
    <button type="submit" name="search"><i class="fa fa-search"></i></button>
</form>

<div class="divTable blueTable">
    <div class="divTableHeading">
        <div class="divTableRow">
            <div class="divTableHead">Avatar</div>
            <div class="divTableHead">Full Name</div>
            <div class="divTableHead">Email</div>
            <div class="divTableHead">Username</div>
            <div class="divTableHead">Birthday</div>
            <div class="divTableHead">Action</div>
        </div>
    </div>
    <div class="divTableBody">
        <?php
        foreach ($listUsers as $user) {
            ?>
            <div class="divTableRow">
                <div class="divTableCell">
                    <img src="<?= $user[5] ?>" alt="" width="30px">
                </div>
                <div class="divTableCell"><?= $user[0] ?></div>
                <div class="divTableCell"><?= $user[1] ?></div>
                <div class="divTableCell"><?= $user[2] ?></div>
                <div class="divTableCell"><?= $user[4] ?></div>
                <div class="divTableCell">
                    <?php
                    if ($user[6] != 1) {
                        ?>
                        <a href="index.php?controller=users&action=deleteUser&username=<?= $user[2] ?>"
                           onClick="return confirm('Are you sure you want to delete this user?');">DELETE</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<div class="blueTable outerTableFooter">
    <div class="tableFootStyle">
        <div class="links">
            <!--            <a href="">&laquo;</a>-->
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "&nbsp;<a href=\"index.php?controller=users&action=listUsers&page=$i\">$i</a>";
            }
            ?>
            <!--            <a href="#">&raquo;</a>-->
        </div>
    </div>
</div>
