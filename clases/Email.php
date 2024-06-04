<?php

namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
        
    }

    public function enviarConfirmacion(){
        //Crear objeto de Email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'appsalon.com');
        $mail->Subject ='Confirma tu cuenta';

        //SET HTML

        $mail->isHTML(true);
        $mail->CharSet= 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre. "</strong> Has creado tu cuenta en App Salon, solo debes confirmarla presionando en el siguiente enlace </p>";
        $contenido .= "<p> Presiona aquí: <a href='" .  $_ENV['APP_URL'] ."/confirmar-cuenta?token=" . $this->token . "'Confirmar Cuenta</a> </p>";
        $contenido .= "<p> Si tu no solicitaste esta cuenta, puedes ignorar el mensaje </p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar Email
        $mail->send();

    }

    public function enviarInstrucciones(){

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'appsalon.com');
        $mail->Subject ='Restablece tu contraseña';

        //SET HTML

        $mail->isHTML(true);
        $mail->CharSet= 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre. "</strong> Para restablecer su contraseña solo debe presionar en el siguiente enlace </p>";
        $contenido .= "<p> Presiona aquí: <a href='" .  $_ENV['APP_URL'] ."/recuperar?token=" . $this->token . "'Restablecer contraseña</a> </p>";
        $contenido .= "<p> Si tu no solicitaste este cambio, puedes ignorar el mensaje </p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar Email
        $mail->send();
    }
 
}