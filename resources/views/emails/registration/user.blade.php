@component('mail::message')
# ขอบคุณที่ลงทะเบียน 🎉

เรียนคุณ {{ $data['full_name'] }},

ขอบคุณที่ลงทะเบียนเข้าร่วมงาน **APSOPRS - THAISOPRS 2025**  
หมายเลขลงทะเบียนของคุณคือ **{{ $data['transid'] }}**

@component('mail::panel')
📌 กรุณาเก็บหมายเลขนี้ไว้เพื่อติดต่อกับทีมงานในกรณีจำเป็น
@endcomponent

ขอบคุณ,<br>
APSOPRS - THAISOPRS 2025
@endcomponent
