<?php

namespace App\Mail;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

class BrevoApiTransport extends AbstractTransport
{
    protected $apiKey;

    public function __construct($apiKey)
    {
        parent::__construct();
        $this->apiKey = $apiKey;
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        
        $sender = $email->getFrom()[0] ?? null;
        $senderEmail = $sender ? $sender->getAddress() : env('MAIL_FROM_ADDRESS');
        $senderName = $sender ? ($sender->getName() ?: env('MAIL_FROM_NAME', 'PlumbFix')) : env('MAIL_FROM_NAME', 'PlumbFix');

        $tos = [];
        foreach ($email->getTo() as $to) {
            $tos[] = [
                'email' => $to->getAddress(),
                'name' => $to->getName() ?: explode('@', $to->getAddress())[0],
            ];
        }

        $attachments = [];
        foreach ($email->getAttachments() as $attachment) {
            $attachments[] = [
                'name' => $attachment->getFilename() ?: 'attachment.pdf',
                'content' => base64_encode($attachment->getBody()),
            ];
        }

        $payload = [
            'sender' => [
                'name' => $senderName,
                'email' => $senderEmail,
            ],
            'to' => $tos,
            'subject' => $email->getSubject(),
        ];

        if ($email->getHtmlBody()) {
            $payload['htmlContent'] = $email->getHtmlBody();
        } else {
            $payload['textContent'] = $email->getTextBody() ?: 'No content';
        }

        if (count($attachments) > 0) {
            $payload['attachment'] = $attachments;
        }

        $ch = curl_init('https://api.brevo.com/v3/smtp/email');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'api-key: ' . $this->apiKey,
            'content-type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 400) {
            \Illuminate\Support\Facades\Log::error("Brevo API send failed with HTTP code $httpCode: " . $response);
            if (app()->environment('local')) {
                return;
            }
            throw new \Exception("Brevo API send failed with HTTP code $httpCode: " . $response);
        }
    }

    public function __toString(): string
    {
        return 'brevo-api';
    }
}
