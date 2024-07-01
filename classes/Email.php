<?php

namespace App;

use SendGrid;
use SendGrid\Mail\Mail;

class Email
{
    private $sendGrid;

    public function __construct()
    {
        $this->sendGrid = new SendGrid($_ENV['SENDGRID_TOKEN']);
    }

    public function sendEmail($to, $subject, $body)
    {
        $email = new Mail();
        $email->setFrom('info@mapamy.com', 'Mapamy');
        $email->setSubject($subject);
        $email->addTo($to);

        // Add header and footer to the body
        $styledBody = $this->addHeaderAndFooter($body);

        $email->addContent("text/html", $styledBody);

        try {
            $response = $this->sendGrid->send($email);
            return $response;
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    private function addHeaderAndFooter($body)
    {
        $header = '<html><head><style>body { font-family: Arial, sans-serif; }</style></head><body>
        <h1>Mapamy</h1>';
        $footer = '
        <hr>
        <p>mapamy.com</p></body></html>';

        return $header . $body . $footer;
    }
}