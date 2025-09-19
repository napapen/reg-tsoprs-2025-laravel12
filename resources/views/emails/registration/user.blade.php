@component('mail::message')
# Thank you for registering 🎉

Dear {{ $data['full_name'] }},

Thank you for registering for APSOPRS Masterclass in Oculofacial Photography and Videography,
your registration number is **#{{ $data['transid'] }}**  <br>

@component('mail::panel')
📌 Please keep this number for future reference when contacting our team.
@endcomponent

@include('emails.registration.partials.sessiondetail', ['data' => $data])
<br>
@include('emails.registration.partials.registerdetail', ['data' => $data])
<br>

Best regards,<br>
APSOPRS - THAISOPRS 2025
@endcomponent