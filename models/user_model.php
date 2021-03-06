<?php
include('libs/SendMail.php');
require_once('models/file.php');

class UserModel
{
    /**
     *
     * Hoa
     * Created at 22-04-2021 09h40
     * validate for form sign up
     *
     */
    public function validateSignUp($fullName, $email, $username, $password, $birthDay)
    {
        $check = true;
        $err = "";
        if ($fullName == "") {
            $err = $err . "Full Name is required. ";
            $check = false;
        }
        $regex = preg_match('/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/', $fullName);
        if (!$regex) {
            $err = $err . "The Full Name cannot contain special characters. ";
            $check = false;
        }
        if ($username == "") {
            $err = $err . "Username is required. ";
            $check = false;
        }
        $regex = preg_match('/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/', $username);
        if (!$regex) {
            $err = $err . "The Username cannot contain special characters. ";
            $check = false;
        }
        if ($email == "") {
            $err = $err . "Email is required.\n ";
            $check = false;
        }
        if ($password == "") {
            $err = $err . "Password is required.\n ";
            $check = false;
        }
        if ($birthDay == "") {
            $err = $err . "BirthDay is required.\n ";
            $check = false;
        }
        if ($check == false) {
            $_SESSION["signUpNotify"] = $err;
            return false;
        }
        return true;
    }


    /**
     *
     * Hoa
     * Created at 22-04-2021 8h30
     * sign up
     *
     */
    public function signUp($fullName, $email, $username, $password, $birthDay)
    {
        if ($this->isUsernameExists($username)) {
            $_SESSION["signUpNotify"] = "Username is already taken!";
            return false;
        }
        if ($this->isEmailExists($email)) {
            $_SESSION["signUpNotify"] = "Email is already taken!";
            return false;
        }
        $urlAvatar = $this->uploadAvatar();
        if (!is_string($urlAvatar)) {
            return false;
        }
        File::writeFile("assets/files/users.txt", "$fullName,$email,$username,$password,$birthDay,$urlAvatar,0");
        $_SESSION["signUpNotify"] = "Registered successfully, please login!";
        return true;
    }

    /**
     *
     * Hoa
     * created at 22-04-2021 08h:40
     * checking username exists
     *
     */
    public function isUsernameExists($username)
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
    public function isEmailExists($email)
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
     * Created at 22-04-2021 09h:10
     * upload avatar to images folder
     *
     */
    public function uploadAvatar()
    {
        $target_dir = "assets/images/users/";
        //l???y ??u??i file
        $temp = explode(".", $_FILES["avatar"]["name"]);
        //t???o t??n file v?? ???????ng d???n
        $target_file = $target_dir . round(microtime(true)) . uniqid() . '.' . end($temp);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["avatar"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION["signUpNotify"] = "File is not an image!";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $_SESSION["signUpNotify"] = "File already exists!";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["avatar"]["size"] > 500000) {
            $_SESSION["signUpNotify"] = "Sorry, your file is too large!";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $_SESSION["signUpNotify"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed!";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                echo "The File " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.";
                return $target_file;
            } else {
                $_SESSION["signUpNotify"] = "Sorry, there was an error uploading your file.";
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
    public function signIn($username, $password)
    {
        if (trim($username) == "") {
            $_SESSION["signInNotify"] = "The username field is required!";
            return false;
        }
        if (trim($password) == "") {
            $_SESSION["signInNotify"] = "The password field is required!";
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
                        $_SESSION["signInNotify"] = "Password is incorrect!";
                        return false;
                    }
                }
            }
            fclose($fileUser);
            $_SESSION["signInNotify"] = "Username not found!";
            return false;
        } else {
            $_SESSION["signInNotify"] = "Users File does not exist!";
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
    public function forgotPassword($email)
    {
        if (trim($email) == "") {
            $_SESSION['forgotPasswordNotify'] = "Please enter your email!";
            return false;
        } else {
            if ($this->isEmailExists($email)) {
                $this->sendEmail($email);
                return true;
            } else {
                $_SESSION['forgotPasswordNotify'] = "Email not found!";
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
    public function getUserByEmail($email)
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
    public function getUserByUsername($username)
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
    public function sendEmail($email)
    {
        $arr = $this->getUserByEmail($email);
        $token = md5($email) . rand(10, 9999) . uniqid();
        /**
         * $expFormat = mktime(
         * date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y")
         * );
         * $expDate = date("Y-m-d H:i:s", $expFormat);
         */
        $link = "<a href='http://localhost:8081/php-mvc-file/index.php?controller=users&action=reset-password&key="
            . $email . "&token=" . $token . "'>Click To Reset Your Password!</a>";
        $title = 'Reset Your Password!';     //ch??? ?????
        $content = "<h3> Dear " . $arr[0] . "</h3>";
        $content .= "<p>We have received a request to re-issue your password recently.</p>";
        $content .= "<p>Please click on the following link to reset your password.</p>";
        $content .= "<b>$link</b>";
        $send = new SendMail();
        $sendMai = $send->send($title, $content, $arr[0], $email);
        if ($sendMai) {
            File::writeFile("assets/files/forgotPassword.txt", "$email,$token");
            $_SESSION['forgotPasswordNotify'] = "Check your email to reset password!";
        } else {
            $_SESSION['forgotPasswordNotify'] = 'An error has occurred unable to retrieve the password!';
        }
    }

    /**
     *
     * Hoa
     * Created at 23-04-2021 09h:20
     * reset password
     *
     */
    public function resetPassword($email, $token, $password)
    {
        if ($this->isEmailAndTokenExist($email, $token)) {
            if ($this->isEmailExists($email)) {
                $oldUser = $this->getUserByEmail($email);
                $newUser = $oldUser;
                $newUser[3] = $password;
                File::updateLine("assets/files/users.txt", $oldUser, $newUser);
                return true;
            } else {
                $_SESSION['resetPasswordNotify'] = "User not found!";
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
    public function isEmailAndTokenExist($email, $token)
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
            $_SESSION['resetPasswordNotify'] = "Token or email is incorrect!";
            return false;
        } else {
            $_SESSION['resetPasswordNotify'] = "File Forgot Password does not exist!";
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
    public function getListUsers()
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
    public function deleteUserByUserName($username)
    {
        $user = $this->getUserByUsername($username);
        if ($user != null) {
            $list = $this->getListUsers(); //lay ra toan bo user
            $size = count($list);
            $index = 0;
            foreach ($list as $item) {
                if (trim($item[2]) == $username) {
                    break;
                }
                $index++;
            }
            File::deleteLine("assets/files/users.txt", $user, $index, $size);
            File::deleteImage(trim($user[5]));
        }
    }

    /**
     *
     * Hoa
     * Created at 24-04-2021 14h30
     * get list users by comparing key with email or username
     *
     */
    public function getUsersByString($key)
    {
        if ($key != "") {
            if (file_exists("assets/files/users.txt")) {
                if (filesize("assets/files/users.txt") < 16 && empty(trim(file_get_contents("assets/files/users.txt")))) {
                    return null;
                } else {
                    $file = fopen("assets/files/users.txt", "r");
                    $list = array();
                    while (!feof($file)) {
                        $arr = explode(",", fgets($file));
                        //kh??ng set != false ???????c v?? n???u t??m th???y chu???i ??? v??? tr?? 0 th?? n?? tr??? v??? 0, m?? false = 0 n??n ch???y sai
                        //d??ng !== ????? so s??nh ki???u d??? li???u
                        if (strpos($arr[1], $key) !== false || strpos($arr[2], $key) !== false) {
                            array_push($list, $arr);
                        }
                    }
                    fclose($file);
                    return $list;
                }
            } else {
                return null;
            }
        } else {
            return $this->getListUsers();
        }
    }

    /**
     *
     * Hoa
     * Created at 24-04-2021 16h20
     * paginate with email | username
     *
     */
    public function paginate($page, $key)
    {
        if ((int)$page == 0) {
            $page = 1;
        }
        $index = ($page - 1) * 5;
        $listUsers = $this->getUsersByString($key);
        if ($listUsers == null) {
            return null;
        } else {
            return array_slice($listUsers, $index, 5);
        }
    }

}