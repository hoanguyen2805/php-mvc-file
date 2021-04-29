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
                $size = 0;
                if (Product::getProducts() != null) {
                    $size = count(Product::getProducts());
                }
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

    /**
     *
     * Hoa
     * Created at 27-04-2021 08h20
     * just admin can delete product
     *
     */
    public function delete()
    {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION["role"];
            if ($role == 1) {
                if (isset($_GET['name'])) {
                    $name = trim($_GET['name']);
                    Product::deleteProductByName($name);
                }
                header("location:index.php?controller=products&action=manageProduct");
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
     * Created at 27-04-2021 13h40
     * go to page update product
     *
     */
    public function update()
    {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION["role"];
            if ($role == 1) {
                if (isset($_GET['name'])) {
                    $name = trim($_GET['name']);
                    $product = Product::getProductByName($name);
                    if ($product == null) {
                        echo "<script>
                            alert('Product not found!');
                            window.location.href='index.php?controller=products&action=manageProduct';
                      </script>";
                    } else {
                        $categories = Product::getCategories();
                        $data = array(
                            'product' => $product,
                            'categories' => $categories
                        );
                        if (isset($_GET['notify'])) {
                            $data['notify'] = $_GET['notify'];
                        }
                        $this->render('update', $data);
                    }
                } else {
                    header("location:index.php?controller=products&action=manageProduct");
                }
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
     * Created at 27-04-2021 14h40
     * handling form update product
     *
     */
    public function updateProductForm()
    {
        if (isset($_POST['updateProduct']) && isset($_GET['old'])) {
            $name = trim($_POST['name']);
            $price = trim($_POST['price']);
            $category = trim($_POST['category']);
            $oldNameProduct = trim($_GET['old']);
            $notify = "";
            if (Product::validateUpdateProduct($name, $price, $category)) {
                $product = Product::updateProduct($name, $price, $category, $oldNameProduct);
                if (isset($_SESSION["updateProductNotify"])) {
                    $notify = $_SESSION["updateProductNotify"];
                    unset($_SESSION["updateProductNotify"]);
                }
                if ($product) {
                    echo "<script>
                            alert('Update successful!');
                            window.location.href='index.php?controller=products&action=manageProduct';
                      </script>";
                } else {
                    header("location: index.php?controller=products&action=update&name=$oldNameProduct&notify=$notify");
                }
            }
            header("");
        } else {
            header("location: index.php?controller=products&action=add");
        }
    }
}