<h2 style="text-align: center; margin-top: 30px; color: red">Manage Products</h2>
<a href="index.php?controller=products&action=add" class="add-product"><i class="fa fa-plus" aria-hidden="true"></i> Add
    Product</a>
<div class="divTable blueTable">
    <div class="divTableHeading">
        <div class="divTableRow">
            <div class="divTableHead">Image</div>
            <div class="divTableHead">Name</div>
            <div class="divTableHead">Price</div>
            <div class="divTableHead">Category</div>
            <div class="divTableHead">Action</div>
        </div>
    </div>
    <div class="divTableBody">
        <?php
        foreach ($products as $product) {
            ?>
            <div class="divTableRow">
                <div class="divTableCell">
                    <img src="<?= $product[3] ?>" alt="" width="60px">
                </div>
                <div class="divTableCell"><?= $product[0] ?></div>
                <div class="divTableCell"><?= $product[1] ?></div>
                <?php
                foreach ($categories as $category) {
                    if ($category[0] == $product[2]) {
                        ?>
                        <div class="divTableCell"><?= $category[1] ?></div>
                        <?php
                    }
                }
                ?>
                <div class="divTableCell">
                    <a href="index.php?controller=users&action=deleteUser&username=<?= $product[0] ?>"
                       onClick="return confirm('Are you sure you want to delete this user?');">DELETE</a>
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
                echo "&nbsp;<a href=\"index.php?controller=products&action=manageProduct&page=$i\">$i</a>";
            }
            ?>
            <!--            <a href="#">&raquo;</a>-->
        </div>
    </div>
</div>
