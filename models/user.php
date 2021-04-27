<?php
include('libs/SendMail.php');
require_once('models/file.php');

class User
{
    public $fullName;
    public $email;
    public $username;
    public $password;
    public $birthDay;
    public $urlAvatar;
    public $role;

    /**
     * User constructor.
     * @param $fullName
     * @param $email
     * @param $username
     * @param $password
     * @param $birthDay
     * @param $urlAvatar
     * @param $role
     */

    public function __construct($fullName, $email, $username, $password, $birthDay, $urlAvatar, $role)
    {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->birthDay = $birthDay;
        $this->urlAvatar = $urlAvatar;
        $this->role = $role;
    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 8h30
     * sign up
     *
     */
    static function signUp($fullName, $email, $username, $password, $birthDay)
    {
        if (User::isUsernameExists($username)) {
            $_SESSION["signUpNotify"] = "Username đã tồn tại!";
            return false;
        }
        if (User::isEmailExists($email)) {
            $_SESSION["signUpNotify"] = "Email đã tồn tại!";
            return false;
        }
        $urlAvatar = User::uploadAvatar();
        if (!is_string($urlAvatar)) {
            return false;
        }
        File::writeFile("assets/files/users.txt", "$fullName,$email,$username,$password,$birthDay,$urlAvatar,0");
        $_SESSION["signUpNotify"] = "Đăng ký thành công! Hãy đăng nhập";
        return true;
    }

    /**
     *
     * Hoa
     * created at 22-04-2021 08h:40
     * checking username exists
     *
     */
    static function isUsernameExists($username)
    {
        if (file_exists('assets/files/users.txt')) {
            $fileUser = fopen("assets/files/users.txt", "r");
            while (!feof($fileUser)) {
                $arr = explode(",", fgets($fileUser));
                if ($arr[2] == $username) {
                    fclose($fileUser);
                    return true;
                }
            }
            fclose($fileUser);
            return false;
        } else {
            return false;
        }

    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 08h:50
     * checking email exists
     *
     */
    static function isEmailExists($email)
    {
        if (file_exists('assets/files/users.txt')) {
            $fileUser = fopen("assets/files/users.txt", "r");
            while (!feof($fileUser)) {
                $arr = explode(",", fgets($fileUser));
                if ($arr[1] == $email) {
                    fclose($fileUser);
                    return true;
                }
            }
            fclose($fileUser);
            return false;
        } else {
            return false;
        }

    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 9h:10
     * upload avatar to images folder
     *
     */
    static function uploadAvatar()
    {
        $target_dir = "assets/images/";
        //lấy đuôi file
        $temp = explode(".", $_FILES["avatar"]["name"]);
        //tạo tên file và đường dẫn
        $target_file = $target_dir . round(microtime(true)) . uniqid() . '.' . end($temp);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["avatar"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION["signUpNotify"] = "File không phải hình!";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $_SESSION["signUpNotify"] = "File đã tồn tại!";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["avatar"]["size"] > 500000) {
            $_SESSION["signUpNotify"] = "File quá lớn!";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $_SESSION["signUpNotify"] = "Chỉ cho phép File có đuôi JPG, JPEG, PNG & GIF!";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                echo "File " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " đã upload.";
                return $target_file;
            } else {
                $_SESSION["signUpNotify"] = "Lỗi upload không xác định được!";
            }
        }
    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 10h:40
     * check account to sign in
     *
     */
    static function signIn($username, $password)
    {
        if (trim($username) == "") {
            $_SESSION["signInNotify"] = "username không được bỏ trống!";
            return false;
        }
        if (trim($password) == "") {
            $_SESSION["signInNotify"] = "password không được bỏ trống!";
            return false;
        }
        if (file_exists('assets/files/users.txt')) {
            $fileUser = fopen("assets/files/users.txt", "r");
            while (!feof($fileUser)) {
                $arr = explode(",", fgets($fileUser));
                if ($arr[2] == $username) {
                    fclose($fileUser);
                    if ($arr[3] == $password) {
                        $_SESSION["user"] = $username;
                        $_SESSION["role"] = $arr[6];
                        return true;
                    } else {
                        $_SESSION["signInNotify"] = "Mật khẩu sai!";
                        return false;
                    }
                }
            }
            fclose($fileUser);
            $_SESSION["signInNotify"] = "Không tìm thấy username!";
            return false;
        } else {
            $_SESSION["signInNotify"] = "File users không tồn tại!";
            return false;
        }

    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 14h:30
     * check email for sending
     *
     */
    static function forgotPassword($email)
    {
        if (trim($email) == "") {
            $_SESSION['forgotPasswordNotify'] = "Hãy nhập email!";
            return false;
        } else {
            if (User::isEmailExists($email)) {
                User::sendEmail($email);
                return true;
            } else {
                $_SESSION['forgotPasswordNotify'] = "Không tìm thấy email!";
                return false;
            }
        }
    }

    /**
     *
     * Hoa
     * Created at 22-04-2021 14h50
     * get user by email
     *
     */
    static function getUserByEmail($email)
    {
        if (file_exists('assets/files/users.txt')) {
            $fileUser = fopen("assets/files/users.txt", "r");
            while (!feof($fileUser)) {
                $arr = explode(",", fgets($fileUser));
                if ($arr[1] == $email) {
                    fclose($fileUser);
                    return $arr;
                }
            }
            fclose($fileUser);
            return null;
        } else {
            return null;
        }
    }


    /**
     *
     * Hoa
     * Created at 21-04-2021 21h20
     * get user by username
     *
     */
    static function getUserByUsername($username)
    {
        if (file_exists('assets/files/users.txt')) {
            $fileUser = fopen("assets/files/users.txt", "r");
            while (!feof($fileUser)) {
                $arr = explode(",", fgets($fileUser));

                if ($arr[2] == $username) {
                    fclose($fileUser);
                    return $arr;
                }
            }
            fclose($fileUser);
            return null;
        } else {
            return null;
        }
    }


    /**
     *
     * Hoa
     * Created at 22-04-2021 15h:30
     * send email by phpmailer - save email and token into file forgotPassword.txt if sending email successfully
     *
     */
    static function sendEmail($email)
    {
        $arr = User::getUserByEmail($email);
        $token = md5($email) . rand(10, 9999) . uniqid();
        /**
         * $expFormat = mktime(
         * date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y")
         * );
         * $expDate = date("Y-m-d H:i:s", $expFormat);
         */
        $link = "<a href='http://localhost:8081/php-mvc-file/index.php?controller=users&action=resetPassword&key="
            . $email . "&token=" . $token . "'>cài lại mật khẩu!</a>";
        $title = 'Cài đặt lại mật khẩu!';     //chủ đề
        $content = "<h3> Chào " . $arr[0] . "</h3>";
        $content .= "<p>Gần đây, chúng tôi đã nhận được yêu cầu cấp lại mật khẩu của bạn.</p>";
        $content .= "<p></p>";
        $content .= "<p>Hãy click vào link bên dưới để đổi mật khẩu.</p>";
        $content .= "<b>$link</b>";
        $sendMai = SendMail::send($title, $content, $arr[0], $email);
        if ($sendMai) {
            File::writeFile("assets/files/forgotPassword.txt", "$email,$token");
            $_SESSION['forgotPasswordNotify'] = "Kiểm tra email của bạn để đổi mật khẩu!";
        } else {
            $_SESSION['forgotPasswordNotify'] = 'Xảy ra lỗi không xác định!';
        }
    }

    /**
     *
     * Hoa
     * Created at 23-04-2021 09h:20
     * reset password
     *
     */
    static function resetPassword($email, $token, $password)
    {
        if (User::isEmailAndTokenExist($email, $token)) {
            if (User::isEmailExists($email)) {
                $oldUser = User::getUserByEmail($email);
                $newUser = $oldUser;
                $newUser[3] = $password;
                File::updateLine("assets/files/users.txt", $oldUser, $newUser);
                return true;
            } else {
                $_SESSION['resetPasswordNotify'] = "Không tìm thấy user!";
                return false;
            }
        }
    }

    /**
     *
     * Hoa
     * Created at 23-04-2021 09h:40
     * checking Email and token exist - file forgotPassword
     *
     */
    static function isEmailAndTokenExist($email, $token)
    {
        if (file_exists('assets/files/forgotPassword.txt')) {
            $fileForgot = fopen("assets/files/forgotPassword.txt", "r");
            $index = 0;
            while (!feof($fileForgot)) {
                $arr = explode(",", fgets($fileForgot));
                if (trim($arr[0]) == trim($email) and trim($token) == trim($arr[1])) {
                    fclose($fileForgot);
                    $size = count(File::getList("assets/files/forgotPassword.txt"));
                    File::deleteLine("assets/files/forgotPassword.txt", $arr, $index, $size);
                    return true;
                }
                $index++;
            }
            fclose($fileForgot);
            $_SESSION['resetPasswordNotify'] = "Token sai!";
            return false;
        } else {
            $_SESSION['resetPasswordNotify'] = "File Forgot Password không tồn tại!";
            return false;
        }
    }


    /**
     *
     * Hoa
     * Created at 24-04-2021 09h30
     * get list users
     *
     */
    static function getListUsers()
    {
        return File::getList("assets/files/users.txt");
    }

    /**
     *
     * Hoa
     * Created at 24-04-2021 10h00
     * delete user by username
     *
     */
    static function deleteUserByUserName($username)
    {
        $user = User::getUserByUsername($username);
        if ($user != null) {
            $list = User::getListUsers(); //lay ra toan bo user
            $size = count($list);
            $index = 0;
            foreach ($list as $item) {
                if (trim($item[2]) == $username) {
                    break;
                }
                $index++;
            }
            File::deleteLine("assets/files/users.txt", $user, $index, $size);
        }
    }
}

?>