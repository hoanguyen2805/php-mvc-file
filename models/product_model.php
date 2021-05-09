<?php
require_once('models/file.php');

class ProductModel
{

    /**
     *
     * Hoa
     * Created at 26-04-2021 09h30
     * validate for form add product
     *
     */
    public function validateProduct($name, $price, $category)
    {
        $check = true;
        $err = "";
        if ($name == "") {
            $err = $err . "Name is required. ";
            $check = false;
        }
        $regex = preg_match('/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/', $name);
        if (!$regex) {
            $err = $err . "The name cannot contain special characters. ";
            $check = false;
        }
        if ($price == "" || !is_numeric($price)) {
            $err = $err . "Price is required. ";
            $check = false;
        }
        if ($price < 0) {
            $err = $err . "Price must be greater than or equal to 0. ";
            $check = false;
        }
        if ($category == "") {
            $err = $err . "Category is required. ";
            $check = false;
        }
        if ($check == false) {
            $_SESSION["addProductNotify"] = $err;
            return false;
        }
        return true;
    }

    /**
     *
     * Hoa
     * Created at 26-04-2021 09h40
     * save product
     *
     */
    public function saveProduct($name, $price, $category)
    {
        if ($this->isNameExists($name)) {
            $_SESSION["addProductNotify"] = "Name is already taken!";
            return false;
        }
        $urlImage = $this->uploadImage();
        if (!is_string($urlImage)) {
            return false;
        }
        File::writeFile("assets/files/products.txt", "$name,$price,$category,$urlImage");
        $_SESSION["addProductNotify"] = "Added successfully!";
        return true;
    }

    /**
     *
     * Hoa
     * Created at 26-04-2021 10h00
     * checking name exists
     *
     */
    public function isNameExists($name)
    {
        if (file_exists('assets/files/products.txt')) {
            $file = fopen("assets/files/products.txt", "r");
            while (!feof($file)) {
                $arr = explode(",", fgets($file));
                if ($arr[0] == $name) {
                    fclose($file);
                    return true;
                }
            }
            fclose($file);
            return false;
        } else {
            return false;
        }
    }

    /**
     *
     * Hoa
     * Created at 26-04-2021 09h:10
     * upload image to images/products folder
     *
     */
    public function uploadImage()
    {
        $target_dir = "assets/images/products/";
        //lấy đuôi file
        $temp = explode(".", $_FILES["image"]["name"]);
        //tạo tên file và đường dẫn
        $target_file = $target_dir . round(microtime(true)) . uniqid() . '.' . end($temp);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION["addProductNotify"] = "File is not an image!";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $_SESSION["addProductNotify"] = "File already exists!";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $_SESSION["addProductNotify"] = "Sorry, your file is too large!";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $_SESSION["addProductNotify"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed!";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The File " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
                return $target_file;
            } else {
                $_SESSION["addProductNotify"] = "Sorry, there was an error uploading your file.";
            }
        }
    }


    /**
     *
     * Hoa
     * Created at 26-04-2021 13h30
     * get categories
     *
     */
    public function getCategories()
    {
        return File::getList('assets/files/categories.txt');
    }

    /**
     *
     * Hoa
     * Created at 26-04-2021 14h00
     * get list product
     *
     */
    public function getProducts()
    {
        return File::getList('assets/files/products.txt');
    }

    /**
     *
     * Hoa
     * Created at 26-04-2021 15h00
     * paginate product
     *
     */
    public function paginate($page)
    {
        if ((int)$page == 0) {
            $page = 1;
        }
        $index = ($page - 1) * 5;
        $products = $this->getProducts();
        if ($products == null) {
            return null;
        } else {
            return array_slice($products, $index, 5);
        }
    }

    /**
     *
     * Hoa
     * Created at 27-04-2021 08h30
     * delete product by name
     *
     */
    public function deleteProductByName($name)
    {
        $product = $this->getProductByName($name);
        if ($product != null) {
            $list = $this->getProducts();
            $size = count($list);
            $index = 0;
            foreach ($list as $item) {
                if (trim($item[0]) == $name) {
                    break;
                }
                $index++;
            }
            File::deleteLine('assets/files/products.txt', $product, $index, $size);
            File::deleteImage(trim($product[3]));
        }
    }

    /**
     *
     * Hoa
     * Created at 27-04-2021 08h40
     * get product by name
     *
     */
    public function getProductByName($name)
    {
        if (file_exists('assets/files/products.txt')) {
            $file = fopen("assets/files/products.txt", "r");
            while (!feof($file)) {
                $arr = explode(",", fgets($file));
                if ($arr[0] == $name) {
                    fclose($file);
                    return $arr;
                }
            }
            fclose($file);
            return null;
        } else {
            return null;
        }
    }

    /**
     *
     * Hoa
     * Created at 27-04-2021 15h10
     * validate for form update
     *
     */
    public function validateUpdateProduct($name, $price, $category)
    {
        $check = true;
        $err = "";
        if ($name == "") {
            $err = $err . "Name is required. ";
            $check = false;
        }
        $regex = preg_match('/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/', $name);
        if (!$regex) {
            $err = $err . "The name cannot contain special characters. ";
            $check = false;
        }
        if ($price == "" || !is_numeric($price)) {
            $err = $err . "Price is required. ";
            $check = false;
        }
        if ($price < 0) {
            $err = $err . "Price must be greater than or equal to 0. ";
            $check = false;
        }
        if ($category == "") {
            $err = $err . "Category is required. ";
            $check = false;
        }
        if ($check == false) {
            $_SESSION["updateProductNotify"] = $err;
            return false;
        }
        return true;
    }

    /**
     *
     * Hoa
     * Created at 27-04-2021 15h20
     * update product
     *
     */
    public function updateProduct($name, $price, $category, $oldNameProduct)
    {
        $oldProduct = $this->getProductByName($oldNameProduct);
        $newProduct = $oldProduct;
        $newProduct[0] = $name;
        $newProduct[1] = $price;
        $newProduct[2] = $category;
        if ($this->isNewNameExists($name, $oldNameProduct)) {
            $_SESSION["updateProductNotify"] = "New Name is already taken!";
            return false;
        }
        if ($_FILES['image']['name'] == "") {
            //not delete img
            File::updateLine("assets/files/products.txt", $oldProduct, $newProduct);
        } else {
            //đelete img and update img
            $urlImage = $this->updateImage();
            if (!is_string($urlImage)) {
                return false;
            }
            $newProduct[3] = $urlImage;
            File::updateLine("assets/files/products.txt", $oldProduct, $newProduct);
            File::deleteImage(trim($oldProduct[3]));
        }
        $_SESSION["updateProductNotify"] = "updated successfully";
        return true;
    }


    /**
     *
     * Hoa
     * Created at 27-04-2021 16h:00
     * update image
     *
     */
    public function updateImage()
    {
        $target_dir = "assets/images/products/";
        //lấy đuôi file
        $temp = explode(".", $_FILES["image"]["name"]);
        //tạo tên file và đường dẫn
        $target_file = $target_dir . round(microtime(true)) . uniqid() . '.' . end($temp);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION["updateProductNotify"] = "File is not an image!";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $_SESSION["updateProductNotify"] = "File already exists!";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $_SESSION["updateProductNotify"] = "Sorry, your file is too large!";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $_SESSION["updateProductNotify"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed!";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The File " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
                return $target_file;
            } else {
                $_SESSION["updateProductNotify"] = "Sorry, there was an error uploading your file.";
            }
        }
    }

    /**
     *
     * Hoa
     * Created at 27-04-2021 16h20
     * checking new name exists
     *
     */
    public function isNewNameExists($newName, $oldName)
    {
        if (file_exists('assets/files/products.txt')) {
            $file = fopen("assets/files/products.txt", "r");
            while (!feof($file)) {
                $arr = explode(",", fgets($file));
                if ($arr[0] == $oldName) {
                    continue;
                }
                if ($arr[0] == $newName) {
                    fclose($file);
                    return true;
                }
            }
            fclose($file);
            return false;
        } else {
            return false;
        }
    }
}