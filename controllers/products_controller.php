<?php
session_start();
require_once('controllers/base_controller.php');
require_once('models/product.php');

class ProductsController extends BaseController
{
    function __construct()
    {
        $this->folder = 'products';
    }

    /**
     *
     * Hoa
     * Created at 26-04-2021 08h:30
     * go to page home
     *
     */
    public function index()
    {
        $this->render('index');
    }


    /**
     *
     * Hoa
     * Created at 26-04-2021 08h30
     * go to page manage product
     *
     */
    public function manageProduct()
    {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION["role"];
            if ($role == 1) {
                $page = 1;
                if (!empty($_GET['page'])) {
                    $page = $_GET['page'];
                }
                $products = Product::paginate($page);
                $size = count(Product::getProducts());
                $categories = Product::getCategories();
                $totalPages = ceil($size / 5);
                $data = array(
                    'products' => $products,
                    'totalPages' => $totalPages,
                    'categories' => $categories
                );
                $this->render('manage-product', $data);
            } else {
                echo "<script>
                            alert('You are not permitted to use this feature!');
                            window.location.href='index.php?controller=users';
                      </script>";
            }
        } else {
            header("location:index.php?controller=users&action=signIn");
        }

    }

    /**
     *
     * Hoa
     * Created at 26-04-2021 08h40
     * go to page add product
     *
     */
    public function add()
    {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION["role"];
            if ($role == 1) {
                $categories = Product::getCategories();
                $data = array(
                    'categories' => $categories
                );
                if (isset($_GET['notify'])) {
                    $data['notify'] = $_GET['notify'];
                }
                $this->render('add', $data);
            } else {
                echo "<script>
                            alert('You are not permitted to use this feature!');
                            window.location.href='index.php?controller=users';
                      </script>";
            }
        } else {
            header("location:index.php?controller=users&action=signIn");
        }
    }

    /**
     *
     * Hoa
     * Created at 26-04-2021 09h00
     * handling form add product
     *
     */
    public function addProductForm()
    {
        if (isset($_POST['addProduct'])) {
            $name = trim($_POST['name']);
            $price = trim($_POST['price']);
            $category = trim($_POST['category']);
            $notify = "";
            if (Product::validateProduct($name, $price, $category)) {
                Product::saveProduct($name, $price, $category);
            }
            if (isset($_SESSION["addProductNotify"])) {
                $notify = $_SESSION["addProductNotify"];
                unset($_SESSION["addProductNotify"]);
            }
            header("location: index.php?controller=products&action=add&notify=$notify");
        } else {
            header("location: index.php?controller=products&action=add");
        }
    }
}