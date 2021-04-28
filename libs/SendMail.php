<?php
require_once __DIR__ . "/PHPMailer/src/PHPMailer.php";
require_once __DIR__ . "/PHPMailer/src/Exception.php";
require_once __DIR__ . "/PHPMailer/src/OAuth.php";
require_once __DIR__ . "/PHPMailer/src/POP3.php";
require_once __DIR__ . "/PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendMail
{
    public function send($title, $content, $nameTo, $mailTo)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2;                           // Enable verbose debug output    // Set mail sử dụng SMTP
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->CharSet = "utf-8";
            $mail->IsSMTP();
            $mail->SMTPAuth = true;                         // Kích hoạt xác thực SMTP
            $mail->Username = 'nodejsangular02@gmail.com';  //mail gửi
            $mail->Password = 'Hoanguyen123';               //pass gửi
            $mail->SMTPSecure = "ssl";
            $mail->Host = "smtp.gmail.com";                 // Chỉ định máy chủ SMTP chính và dự phòng
            $mail->Port = "465";                            // set the SMTP port for the GMAIL server
            $mail->From = 'nodejsangular02@gmail.com';        //mail gửi
            $mail->FromName = 'Admin Website';                //tên người gửi
            $mail->addAddress($mailTo, $nameTo);            // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "=?utf-8?b?" . base64_encode($title) . "?=";
            $mail->Body = $content;
            $mail->AltBody = '';
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
}