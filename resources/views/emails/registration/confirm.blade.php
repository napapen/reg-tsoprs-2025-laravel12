@component('mail::message')
# Registration Confirmation ✅

Hello **{{ $data['full_name'] }}**

We are pleased to confirm that your registration has been successfully completed
Here are the details of your registration:

@component('mail::panel')
Registration No.: **{{ $data['transid'] }}**<br/>
Sessions: **{{ $data['event_type'] }}**<br/>
Registration Type: **{{ $data['regist_type'] }}**<br/>
Amount Paid: **{{ $data['payment_total'] }}**<br/>
@endcomponent


Please keep this information as your proof of registration and present it to the staff on the event day (if required).

Thank you for joining us, and we look forward to seeing you on 14 November 2025 🎉

<br>
Thank you,<br>
APSOPRS - THAISOPRS 2025
@endcomponent