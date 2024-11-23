<?php

namespace App\System;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailSystem
{

    public function __construct(string $email, string $file)
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

            $mailer->addAttachment($file);

            $mailer->isHTML();
            $mailer->Subject = 'Spielstand';
            $mailer->Body    = 'Der Spielstand befindet sich im Anhang.';
            $mailer->AltBody = 'Der Spielstand befindet sich im Anhang.';

            $mailer->send();
            echo "E-Mail an $email gesendet.\n";
        } catch (Exception $e) {
            echo "E-Mail wurde NICHT an $email gesendet.\n";
            echo $e->getMessage() . PHP_EOL;
        }
    }

}