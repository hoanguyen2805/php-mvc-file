<?php
require_once('models/file.php');

class Product
{
    public $name;
    public $price;
    public $category;
    public $urlImage;

    /**
     * Product constructor.
     * @param $name
     * @param $price
     * @param $category
     * @param $urlImage
     */
    public function __construct($name, $price, $category, $urlImage)
    {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $this->urlImage = $urlImage;
    }

    /**
     *
     * Hoa
     * Created at 26-04-2021 09h30
     * validate for form add product
     *
     */
    static function validateProduct($name, $price, $category)
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
    static function saveProduct($name, $price, $category)
    {
        if (Product::isNameExists($name)) {
            $_SESSION["addProductNotify"] = "Name is already taken!";
            return false;
        }
        $urlImage = Product::uploadImage();
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
    static function isNameExists($name)
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
    static function uploadImage()
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
    static function getCategories()
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
    static function getProducts()
    {
        return File::getList('assets/files/products.txt');
    }

    static function paginate($page)
    {
        $index = ($page - 1) * 5;
        $products = Product::getProducts();
        return array_slice($products, $index, 5);
    }
}