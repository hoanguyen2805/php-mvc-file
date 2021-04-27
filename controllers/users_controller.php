<?php
session_start();
require_once('controllers/base_controller.php');
require_once('models/user.php');

class UsersController extends BaseController
{
    function __construct()
    {
        $this->folder = 'users';
    }

    /**
     *
     * Hoa
     * Created at 21-04-2021 21h00
     * go to page index
     *
     */
    public function index()
    {
        if (isset($_SESSION["user"])) {
            $username = $_SESSION["user"];
            $user = User::getUserByUsername($username);
            if ($user == null) {
                header("location:index.php?controller=users&action=signIn");
            } else {
                $data = array(
                    'fullName' => $user[0],
                    'email' => $user[1],
                    'username' => $user[2],
                    'password' => $user[3],
                    'birthDay' => $user[4],
                    'urlAvatar' => $user[5],
                    'role' => $user[6]
                );
                $this->render('index', $data);
            }
        } else {
            header("location:index.php?controller=users&action=signIn");
        }
    }

    /**
     *
     * Hoa
     * Created at 21-04-2021 21h50
     * go to page error when user entered wrong path
     *
     */
    public function error()
    {
        $this->render('error');
    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 08h00
     * go to page sign up
     *
     */
    public function signUp()
    {
        if (isset($_SESSION["user"])) {
            header("location:index.php?controller=users");
        } else {
            if (isset($_GET['notify'])) {
                $data = array(
                    'notify' => $_GET['notify'],
                );
                $this->render('sign_up', $data);
            }
            $this->render('sign_up');
        }
    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 08h20
     * handling form sign up
     *
     */
    public function signUpForm()
    {
        if (isset($_POST['signUp'])) {
            $fullName = $_POST['fullName'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $birthDay = $_POST['birth'];
            User::signUp($fullName, $email, $username, $password, $birthDay);
            $notify = "";
            if (isset($_SESSION["signUpNotify"])) {
                $notify = $_SESSION["signUpNotify"];
                unset($_SESSION["signUpNotify"]);
            }
            header("location:index.php?controller=users&action=signUp&notify=$notify");
        } else {
            header("location:index.php?controller=user&action=signUp");
        }
    }


    /**
     *
     * Hoa
     * Created at 22-04-2021 10h00
     * go to page sign in
     *
     */
    public function signIn()
    {
        if (isset($_SESSION["user"])) {
            header("location:index.php?controller=users");
        } else {
            if (isset($_GET['notify'])) {
                $data = array(
                    'notify' => $_GET['notify'],
                );
                $this->render('sign_in', $data);
            }
            $this->render('sign_in');
        }

    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 10h20
     * handling form sign in
     *
     */
    public function signInForm()
    {
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $user = User::signIn($username, $password);
            if ($user) {
                header("location:index.php?controller=users");
            } else {
                $notify = "";
                if (isset($_SESSION["signInNotify"])) {
                    $notify = $_SESSION["signInNotify"];
                    unset($_SESSION["signInNotify"]);
                }
                header("location:index.php?controller=users&action=signIn&notify=$notify");
            }
        } else {
            header("location:index.php?controller=users&action=signIn");
        }
    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 11h50
     * sign out then go to page sign in
     *
     */
    public function signOut()
    {
        session_destroy();
        header("location:index.php?controller=users&action=signIn");
    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 13h40
     * go to page forgot password
     *
     */
    public function forgotPassword()
    {
        if (isset($_SESSION["user"])) {
            header("location:index.php?controller=users");
        } else {
            if (isset($_GET['notify'])) {
                $data = array(
                    'notify' => $_GET['notify'],
                );
                $this->render('forgot_password', $data);
            }
            $this->render('forgot_password');
        }
    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 14h00
     * handling form forgot password - send email
     *
     */
    public function forgotPasswordForm()
    {
        if (isset($_POST['recoverPassword'])) {
            $email = $_POST["email"];
            User::forgotPassword($email);
            $notify = "";
            if (isset($_SESSION['forgotPasswordNotify'])) {
                $notify = $_SESSION['forgotPasswordNotify'];
                unset($_SESSION['forgotPasswordNotify']);
            }
            header("location:index.php?controller=users&action=forgotPassword&notify=$notify");
        } else {
            header("location:index.php?controller=users&action=forgotPassword");
        }
    }


    /**
     *
     * Hoa
     * Created at 23-04-2021 08h20
     * go to page reset password
     *
     */
    public function resetPassword()
    {
        if (isset($_SESSION["user"])) {
            echo "<script>
                          alert('Hãy đăng xuất khỏi tài khoản trước!');
                          window.location.href='index.php?controller=users';
                  </script>";
        } else {
            if (isset($_GET['notify'])) {
                $data = array(
                    'notify' => $_GET['notify'],
                );
                $this->render('reset_password', $data);
            }
            $this->render('reset_password');
        }
    }

    /**
     *
     * Hoa
     * Created at 23-04-2021 08h50
     * handling form reset password
     *
     */
    public function resetPasswordForm()
    {
        if (empty($_GET['key']) || empty($_GET['token'])) {
            $notify = "token và email không tồn tại!";
            header("location:index.php?controller=users&action=resetPassword&notify=$notify");
        } else {
            $email = $_GET['key'];
            $token = $_GET['token'];
            if (isset($_POST['reset'])) {
                $newPassword = md5($_POST['password']);
                $newPassword = User::resetPassword($email, $token, $newPassword);
                $notify = "";
                if (isset($_SESSION['resetPasswordNotify'])) {
                    $notify = $_SESSION['resetPasswordNotify'];
                    unset($_SESSION['resetPasswordNotify']);
                }
                if ($newPassword) {
                    echo "<script>
                            alert('Thành công! Hãy đăng nhập lại');
                            window.location.href='index.php?controller=users&action=signIn';
                          </script>";
                } else {
                    header("location:index.php?controller=users&action=resetPassword&key=$email&token=$token&notify=$notify");
                }
            } else {
                header("location:index.php?controller=users&action=resetPassword&key=$email&token=$token");
            }
        }

    }


    /**
     *
     * Hoa
     * Created at 24-04-2021 09h00
     * just admin can go to listUsers page
     *
     */
    public function listUsers()
    {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION["role"];
            if ($role == 1) {
                $listUsers = User::getListUsers();
                $data = array('listUsers' => $listUsers);
                $this->render("list", $data);
            } else {
                echo "<script>
                            alert('Không có quyền truy cập!');
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
     * Created at 24-04-2021 09h50
     * just admin can delete user
     *
     */
    public function deleteUser()
    {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION["role"];
            if ($role == 1) {
                if (isset($_GET['username'])) {
                    $username = $_GET['username'];
                    User::deleteUserByUserName($username);
                }
                header("location:index.php?controller=users&action=listUsers");
            } else {
                echo "<script>
                            alert('Không có quyền truy xóa user!');
                            window.location.href='index.php?controller=users';
                      </script>";
            }
        } else {
            header("location:index.php?controller=users&action=signIn");
        }
    }

}

?>