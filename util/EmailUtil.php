<?php
class EmailUtil {

    const MAIL_FROM_NAME = 'Indochino Payment';
    const MAIL_FROM_EMAIL = 'payment@indochino.com';
    const SPAM_USER = 'indochino_spam';
    const IMPORTANT_USER = 'indochino_important';
    const SENDGRID_PASS = 'indochino99123!';
    const SENDGRID_URL = 'http://sendgrid.com/';

    static function send(
        $to,
        $subject,
        $data,
        $files='',
        $content='',
        $category='Indochino Payment',
        $from=NULL,
        $from_name=NULL,
        $isSpam=FALSE,
        $dont_use_sendgrid=FALSE
    ) {
        if (!$from) {
            $from = self::MAIL_FROM_EMAIL;
            $from_name = self::MAIL_FROM_NAME;
        }

        if ($dont_use_sendgrid) {
            if (is_array($to)) {
                $to = implode(', ', $to);
            }
            mail($to, $subject, $data, "From: {$from}\r\nContent-type: text/html\r\n");
            return;
        }

        // All Emails that are considered "spammy" like marketing deals will
        // be sent through an user bound to an IP with less reputation than
        // the important user
        $api_user = $isSpam ? self::SPAM_USER : self::IMPORTANT_USER;

        $params = array(
            'api_user' => $api_user,
            'api_key' => self::SENDGRID_PASS,
            'to' => is_array($to) ? self::MAIL_FROM_EMAIL : $to,
            'subject' => $subject,
            'files[signature]' => $files,
            'content[signature]' => $content,
            'html' => $data,
            'from' => $from,
            'fromname' => $from_name
        );

        $params['x-smtpapi'] = json_encode(array(
            'to' => is_array($to) ? $to : array($to),
            'category' => $category
        ));

        $request = self::SENDGRID_URL . 'api/mail.send.json';

        $session = curl_init($request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_HEADER, FALSE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($session);
        curl_close($session);

        Logger::info('Send email to <'.$to.'> ...');
        Logger::info('SendGrid response - '.$response);
    }
}
?>