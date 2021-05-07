<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<h2 style="text-align: center; margin-top: 30px; color: red">Manage Products</h2>
<a href="index.php?controller=products&action=add" class="add-product"><i class="fa fa-plus" aria-hidden="true"></i> Add
    Product</a>
<?php
if (isset($notify)) {
//    echo "<h3 class='sign-up-error'>" . $notify . "</h3>";
    echo '<script type="text/javascript">alert("' . $notify . '")</script>';
}
?>
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
        if ($products != null) {
            foreach ($products as $product) {
                ?>
                <div class="divTableRow">
                    <div class="divTableCell">
                        <img src="<?= $product[3] ?>" alt="" width="60px">
                    </div>
                    <div class="divTableCell"><?= $product[0] ?></div>
                    <div class="divTableCell">
                        <?= number_format("$product[1]", 0, ",", " ") ?> đ
                    </div>
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
                        <a href="index.php?controller=products&action=delete&name=<?= $product[0] ?>"
                           onClick="return confirm('Are you sure you want to delete this product?');"
                           class="btn btn-danger">
                            <i class="fa fa-trash"
                               aria-hidden="true"></i> DELETE
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <!--                        <a href="index.php?controller=products&action=update&name=-->
                        <?//= $product[0]?><!--">UPDATE</a>-->
                        <button class="btn btn-warning" data-toggle="modal" type="button"
                                data-target="#update_modal_<?php
                                $arrName = explode(" ", $product[0]);
                                echo implode("", $arrName);
                                ?>"><span
                                    class="glyphicon glyphicon-edit"></span> Edit
                        </button>
                    </div>
                </div>
                <?php
                include 'views/products/update.php';
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
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($page == $i) {
                    echo "&nbsp;<a href=\"index.php?controller=products&action=manage-product&page=$i\" class='page-active'>$i</a>";
                } else {
                    echo "&nbsp;<a href=\"index.php?controller=products&action=manage-product&page=$i\">$i</a>";
                }
            }
            ?>
            <!--            <a href="#">&raquo;</a>-->
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>