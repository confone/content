<?php
class EmailUtil {

    const MAIL_FROM_NAME = 'Confone Notification';
    const MAIL_FROM_EMAIL = 'non-reply@confone.com';
    const MANDRILL_KEY = 'YJc3ok6MpNDY69ZCEGdhHw';
    const MANDRILL_URL = 'https://mandrillapp.com/api/1.0/';

    public static function sendActivationEmail($email, $name, $accountTokenDao) {
    	$to = array(array('email' => $email,'name' => $name));

    	$subject = 'Registration Confirmation - Activate Your Account';

    	$html = '';

    	self::send($to, $subject, $html);
    }

    public static function sendForgetPasswordEmail($email, $name, $accountTokenDao) {
		$to = array(array('email' => $email,'name' => $name));

    	$subject = 'Forget Password - Reset Your Password';

    	$html = '';

    	self::send($to, $subject, $html);
    }

    private static function send ( $to,
        					$subject,
        					$html,
        					$from=EmailUtil::MAIL_FROM_EMAIL,
        					$from_name=EmailUtil::MAIL_FROM_NAME ) {

		$params = array('key'=>EmailUtil::MANDRILL_KEY);

        $message = array(
            'api_key' => self::SENDGRID_PASS,
            'to' => json_encode($to),
            'subject' => $subject,
            'html' => $html,
            'from_email' => $from,
            'from_name' => $from_name
        );

        $params['message'] = $message;

        $request = self::MANDRILL_URL . 'messages/send.json';

        $session = curl_init($request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_HEADER, FALSE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($session);
        curl_close($session);

        $respArr = json_decode($response, true);
        if ($respArr['status']=='error') {
            if (is_array($to)) {
                $to = implode(', ', $to);
            }
            mail($to, $subject, $html, "From: {$from}\r\nContent-type: text/html\r\n");
        }

        Logger::info('Send email to '.json_encode($to).' ...');
        Logger::info('Mandrill response - '.$response);
    }
}
?>