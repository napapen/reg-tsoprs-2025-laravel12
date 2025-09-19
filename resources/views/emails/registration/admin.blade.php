@component('mail::message')
# 📝 A new registration has been submitted   

@include('emails.registration.partials.sessiondetail', ['data' => $data])

@isset($filePath)
@component('mail::panel')
📎 A payment slip has been attached.
@endcomponent
@endisset

@include('emails.registration.partials.registerdetail', ['data' => $data])

<br>
Thank you,<br>
APSOPRS - THAISOPRS 2025
@endcomponent
