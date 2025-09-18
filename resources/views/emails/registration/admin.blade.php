@component('mail::message')
# มีผู้ลงทะเบียนใหม่เข้ามา 📝

รายละเอียดผู้ลงทะเบียน:

- **ชื่อ-นามสกุล:** {{ $data['full_name'] }}
- **อีเมล:** {{ $data['email'] }}
- **เบอร์โทรศัพท์:** {{ $data['phone'] ?? '-' }}
- **หมายเลขลงทะเบียน:** {{ $data['transid'] }}
- **ประเภทการชำระเงิน:** {{ $data['payment_type'] ?? '-' }}

@if(!empty($data['institution']))
- **สังกัด / หน่วยงาน:** {{ $data['institution'] }}
@endif

@if(!empty($data['note']))
- **หมายเหตุ:** {{ $data['note'] }}
@endif

@isset($filePath)
@component('mail::panel')
📎 มีไฟล์แนบมาด้วย (slip ชำระเงิน)
@endcomponent
@endisset

ขอบคุณ,<br>
{{ config('app.name') }}
@endcomponent
