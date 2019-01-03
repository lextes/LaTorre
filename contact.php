<?php 

//======================================================================
// Variables
//======================================================================


//E-mail para recibir mails
define("__TO__", "forza1708@gmail.com");

//Mensaje de envio correcto
define('__SUCCESS_MESSAGE__', "Tu mensaje se ha enviado correctamente. Pronto te responderemos. ¡Gracias!");

//Mensaje de envio incorrecto
define('__ERROR_MESSAGE__', "No se envió tu mensaje. Por favor intente de nuevo.");

//Mensaje de falta agregar datos a espacios vacios
define('__MESSAGE_EMPTY_FIELDS__', "Por favor llene los espacios indicados");


//======================================================================
// No tocar nada
//======================================================================

//E-mail validación
function check_email($email){
    if(!@eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
        return false;
    } else {
        return true;
    }
}

//Enviar mail
function send_mail($to,$subject,$message,$headers){
    if(@mail($to,$subject,$message,$headers)){
        echo json_encode(array('info' => 'success', 'msg' => __SUCCESS_MESSAGE__));
    } else {
        echo json_encode(array('info' => 'error', 'msg' => __ERROR_MESSAGE__));
    }
}

//Enviar informacion y enviar mail
if(isset($_POST['name']) and isset($_POST['emaild']) and isset($_POST['message'])){
	$name = $_POST['name'];
	$mail = $_POST['emaild'];
	$subjectForm = $_POST['subject'];
	$messageForm = $_POST['message'];

    if($name == '') {
        echo json_encode(array('info' => 'error', 'msg' => "Por favor inserte su nombre."));
        exit();
    } else if($mail == '' or check_email($mail) == false){
        echo json_encode(array('info' => 'error', 'msg' => "Por favor introduzca correctamente su e-mail."));
        exit();
    } else if($messageForm == ''){
        echo json_encode(array('info' => 'error', 'msg' => "Por favor anote su mensaje."));
        exit();
    } else {
        $to = __TO__;
        $subject = $subjectForm . ' ' . $name;
        $message = '
        <html>
        <head>
          <title>Mail from '. $name .'</title>
        </head>
        <body>
          <table style="width: 500px; font-family: arial; font-size: 14px;" border="1">
            <tr style="height: 32px;">
              <th align="right" style="width:150px; padding-right:5px;">Nombre:</th>
              <td align="left" style="padding-left:5px; line-height: 20px;">'. $name .'</td>
            </tr>
            <tr style="height: 32px;">
              <th align="right" style="width:150px; padding-right:5px;">E-mail:</th>
              <td align="left" style="padding-left:5px; line-height: 20px;">'. $mail .'</td>
            </tr>
            <tr style="height: 32px;">
              <th align="right" style="width:150px; padding-right:5px;">Asunto:</th>
              <td align="left" style="padding-left:5px; line-height: 20px;">'. $subjectForm .'</td>
            </tr>
            <tr style="height: 32px;">
              <th align="right" style="width:150px; padding-right:5px;">Mensaje:</th>
              <td align="left" style="padding-left:5px; line-height: 20px;">'. $messageForm  .'</td>
            </tr>
          </table>
        </body>
        </html>
        ';

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ' . $mail . "\r\n";

        send_mail($to,$subject,$message,$headers);
    }
} else {
    echo json_encode(array('info' => 'error', 'msg' => __MESSAGE_EMPTY_FIELDS__));
}
 ?>