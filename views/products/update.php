<div class="signup">
    <h1 class="signup-heading">Update Product</h1>
    <?php
    if (isset($notify)) {
        echo "<h3 class='sign-up-error'>" . $notify . "</h3>";
    }
    ?>
    <form action="index.php?controller=products&action=updateProductForm&old=<?= $product[0] ?>" class="signup-form"
          autocomplete="off"
          method="post"
          enctype="multipart/form-data" name="formUpdateProduct"
          onsubmit="return validateFormUpdateProduct()">

        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-input" id="name" placeholder="Eg: iphone 11" name="name"
                   value="<?= $product[0] ?>">
            <p class="error" id="err_name_product">Name is required!</p>
        </div>

        <div class="form-group">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-input" id="price" placeholder="Eg: 50000" name="price" step="0.01" min="0"
                   value="<?= $product[1] ?>">
            <p class="error" id="err_price_product">Price is required!</p>
        </div>

        <div class="form-group">
            <label for="username" class="form-label">Category</label>
            <select name="category" id="category" class="form-input">
                <?php
                foreach ($categories as $category) {
                    if ($product[2] == $category[0]) {
                        echo "<option value='$category[0]' selected>$category[1]</option>";
                    } else {
                        echo "<option value='$category[0]'>$category[1]</option>";
                    }
                }
                ?>
            </select>
            <p class="error" id="err_select_product">Category is required!</p>
        </div>

        <div class="form-group">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-input" id="image" name="image"
                   onchange="PreviewImage();">
            <p class="error" id="err_image_product">Image is required!</p>
        </div>
        <img id="uploadPreview" style="width: 100px; height: 100px;" src="<?= $product[3] ?>"/>
        <button type="submit" class="form-submit" name="updateProduct">ADD</button>
    </form>

</div>
<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("image").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

</script>
