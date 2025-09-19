----------------------------------------<br>
**Session & Payment Details** <br>
-----------------------------------------<br>
**Reg. No.:** #{{ $data['transid'] }} <br>
**Session:** {{ $data['event_type_text'] }}<br>
**Reg. Type:** {{ $data['registration_type_text'] }}<br>
**Total:** {{ $data['payment_total'] }}<br>
 **Payment:** {{ $data['payment_chanel_text'] }}<br>
@if($data['registration_type']=="international")
 **Paid on:** {{ $data['pay_date'] }} {{ $data['pay_hour'] }}:{{ $data['pay_min'] }}<br>
@endif
**Register on:** {{ $data['created_at'] }}<br>