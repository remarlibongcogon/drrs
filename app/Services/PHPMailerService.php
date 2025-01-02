<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{
    public function sendMail($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';       
            $mail->SMTPAuth   = true;                  
            $mail->Username   = env('MAIL_USERNAME');  // your email address
            $mail->Password   = env('MAIL_PASSWORD');  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($to);

            // content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();

            return true;
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
