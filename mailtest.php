<?php

include('Mail.php');

$recipients = 'cmendez007@gmail.com';

$headers['From'] = 'contacto@cincoletras.mx';
$headers['To'] = 'cmendez007@gmail.com';
$headers['Subject'] = 'Test message';

$body = 'Test message';

// Create the mail object using the Mail::factory method
$mail = & Mail::factory("smtp", array(
            'host' => 'mail.cincoletras.mx',
            'port' => '26',
            'auth' => "PLAIN",
            'socket_options' => array('ssl' => array('verify_peer_name' => false)),
            'username' => 'contacto@cincoletras.mx',
            'password' => 'Contacto5letras'));

$r = $mail->send($recipients, $headers, $body);

echo "response: " . $r;
?>