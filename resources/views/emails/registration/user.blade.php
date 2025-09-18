@component('mail::message')
# Thank you for registering 🎉

Dear {{ $data['full_name'] }},

Thank you for registering for **APSOPRS - THAISOPRS 2025**.  
Your registration number is **{{ $data['transid'] }}**  

@component('mail::panel')
📌 Please keep this number for future reference when contacting our team.
@endcomponent

Best regards,<br>
APSOPRS - THAISOPRS 2025
@endcomponent
