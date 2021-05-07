<h2 style="text-align: center; margin-top: 30px; color: red; font-size: 30px; font-weight: normal">Manage Users</h2>

<form action="index.php?controller=users&action=form-search" method="post" class="example"
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
        if ($listUsers != null) {
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
                            <a href="index.php?controller=users&action=delete-user&username=<?= $user[2] ?>"
                               onClick="return confirm('Are you sure you want to delete this user?');">DELETE</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>
<div class="blueTable outerTableFooter">
    <div class="tableFootStyle">
        <div class="links">
            <!--            <a href="">&laquo;</a>-->
            <?php
            $page = 1;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if ((int)$page == 0) {
                    $page = 1;
                }
            }
            $key = "";
            if(isset($_GET['key'])){
                $key = $_GET['key'];
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($page == $i) {
                    echo "&nbsp;<a href=\"index.php?controller=users&action=list-users&page=$i&key=$key\" class='page-active'>$i</a>";
                } else {
                    echo "&nbsp;<a href=\"index.php?controller=users&action=list-users&page=$i&key=$key\">$i</a>";
                }

            }
            ?>
            <!--            <a href="#">&raquo;</a>-->
        </div>
    </div>
</div>
