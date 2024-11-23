<?php

namespace App\System;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailSystem
{

    public function __construct(string $email, string $serial)
    {
        try {
            $mailer = new PHPMailer(true);
            $mailer->isSMTP();
            $mailer->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mailer->Host       = getenv('TK_MAIL_HOST');
            $mailer->SMTPAuth   = true;
            $mailer->Username   = getenv('TK_MAIL_USER');
            $mailer->Password   = getenv('TK_MAIL_PASS');

            $mailer->setFrom(getenv('TK_MAIL_FROM'), 'GameSystem Spielstand');
            $mailer->addAddress($email);

            $mailer->isHTML();
            $mailer->Subject = 'Spielstand';
            $mailer->Body    = 'Serial des Spielstandes: <b>'.$serial.'</b>';
            $mailer->AltBody = 'Serial des Spielstandes: ' . $serial;

            $mailer->send();
            echo "E-Mail an $email gesendet.\n";
        } catch (Exception $e) {
            echo "E-Mail wurde NICHT an $email gesendet.\n";
            echo $e->getMessage() . PHP_EOL;
        }
    }

}