<?php

// configure
$from = 'seejay33@wp.pl'; 
$sendTo = 'kontakt@indexor.pl';
$subject = "=?UTF-8?B?".base64_encode("Temat z ogonkami ęóąśłżźćń")."?=";
$fields = array('name' => 'Imię', 'surname' => 'Nazwisko', 'phone' => 'Numer Telefonu', 'email' => 'Email', 'message' => 'Treść'); // array variable name => Text to appear in email
$okMessage = 'Twoja wiadomość została wysłana!';
$errorMessage = 'Wystąpił błąd, spróbuj ponownie później';
// let's do the sending

try
{
    $emailText = " ";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    mail($sendTo, $subject, $emailText);

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    
    header('Content-Type: application/json');
    
    echo $encoded;
}
else {
    echo $responseArray['message'];
}
