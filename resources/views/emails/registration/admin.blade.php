@component('mail::message')
# A new registration has been submitted 📝  
----------------------------------------<br>
**Session Details:** <br>
-----------------------------------------<br>
**Regist No.:** #{{ $data['transid'] }} <br>
**Session:** {{ $data['event_type_text'] }}<br>
**Regist Type:** {{ $data['registration_type_text'] }}<br>
**Total:** {{ $data['payment_total'] }}<br>
**Regist Time:** {{ $data['created_at'] }}<br>

----------------------------------------<br>
**Form Details:** <br>
-----------------------------------------<br>
**Full Name:** {{ $data['full_name'] }}<br>
**Email:** {{ $data['email'] }}<br>
**Phone Number:** {{ $data['phone'] ?? '-' }}<br>
**Payment Type:** {{ $data['payment_type'] ?? '-' }}<br>

@if(!empty($data['institution']))
**Institution / Organization:** {{ $data['institution'] }}
@endif

@if(!empty($data['note']))
**Note:** {{ $data['note'] }}
@endif

@isset($filePath)
@component('mail::panel')
📎 A payment slip has been attached.
@endcomponent
@endisset

Thank you,<br>
APSOPRS - THAISOPRS 2025
@endcomponent
