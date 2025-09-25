@component('mail::message')
# Registration Cancellation Notice

Hello **{{ $data['full_name'] }}**

We would like to inform you that your registration has been successfully cancelled.
The details of the cancelled registration are as follows:

@component('mail::panel')
Registration No.: **{{ $data['transid'] }}**<br/>
Sessions: **{{ $data['event_type'] }}**<br/>
Registration Type: **{{ $data['regist_type'] }}**<br/>
Amount Paid: **{{ $data['payment_total'] }}**<br/>
@endcomponent

For any questions or further assistance, please contact us at admin@rcopt.org

<br>
Thank you,<br>
APSOPRS - THAISOPRS 2025
@endcomponent