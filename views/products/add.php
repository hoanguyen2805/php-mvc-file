<div class="signup">
    <h1 class="signup-heading">Add Product</h1>
    <?php
    if (isset($notify)) {
        echo "<h3 class='sign-up-error'>" . $notify . "</h3>";
    }
    ?>
    <form action="index.php?controller=products&action=addProductForm" class="signup-form" autocomplete="off"
          method="post"
          enctype="multipart/form-data" name="formAddProduct"
          onsubmit="return validateFormAddProduct()">

        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-input" id="name" placeholder="Eg: iphone 11" name="name">
            <p class="error" id="err_name_product">Name is required!</p>
        </div>

        <div class="form-group">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-input" id="price" placeholder="Eg: 50000" name="price" step="0.01" min="0">
            <p class="error" id="err_price_product">Price is required!</p>
        </div>

        <div class="form-group">
            <label for="username" class="form-label">Category</label>
            <select name="category" id="category" class="form-input">
                <?php
                foreach ($categories as $category) {
                    ?>
                    <option value="<?= $category[0] ?>"><?= $category[1] ?></option>
                    <?php
                }
                ?>
            </select>
            <p class="error" id="err_select_product">Category is required!</p>
        </div>

        <div class="form-group">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-input" id="image" name="image">
            <p class="error" id="err_image_product">Image is required!</p>
        </div>
        <button type="submit" class="form-submit" name="addProduct">ADD</button>
    </form>
</div>