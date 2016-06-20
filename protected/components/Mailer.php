<?php
class Mailer {

    /**
     * Send mail
     */
    public static function mail($to, $subject, $message, $from ,$SMTP = array() ,$attachment=NULL)
    {
        $mail_theme=Yii::app()->params['mailTheme'];
        $message=str_replace('{MessageBody}', $message, $mail_theme);
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail=new JPhpMailer;
        $mail->SetFrom($from, Yii::app()->name);
        if($SMTP && isset($SMTP['Host'])&& isset($SMTP['Secure'])&& isset($SMTP['Username'])&& isset($SMTP['Password'])&& isset($SMTP['Port']))
        {
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = $SMTP['Host'];
            $mail->SMTPSecure = $SMTP['Secure'];
            $mail->Username = $SMTP['Username'];
            $mail->Password = $SMTP['Password'];
            $mail->Port = (int)$SMTP['Port'];
        }
        $mail->Subject=$subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to);
        if($attachment)
            $mail->AddAttachment($attachment);
        return $mail->Send();
    }
}