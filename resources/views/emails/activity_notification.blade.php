<x-mail::message>
# Hello {{ $recipientName }},

{!! nl2br(e($messageText)) !!}

@if(!empty($contactDetails) && is_array($contactDetails))
<x-mail::panel>
### 📞 Contact Details / Maklumat Hubungan:
@foreach($contactDetails as $label => $value)
**{{ $label }}:** {{ $value }}<br>
@endforeach
</x-mail::panel>
@endif

<x-mail::button :url="url('/')">
Visit Plumbfix Portal
</x-mail::button>

If you have any questions or require support, please contact us at help@plumbfix.com.

Best regards,<br>
The {{ config('app.name', 'Plumbfix') }} Team
</x-mail::message>
