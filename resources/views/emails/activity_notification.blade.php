<x-mail::message>
# Hello {{ $recipientName }},

{{ $messageText }}

<x-mail::button :url="url('/')">
Visit Plumbfix Portal
</x-mail::button>

If you have any questions or require support, please contact us at help@plumbfix.com.

Best regards,<br>
The {{ config('app.name', 'Plumbfix') }} Team
</x-mail::message>
