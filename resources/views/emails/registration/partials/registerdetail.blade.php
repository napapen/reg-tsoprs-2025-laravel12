----------------------------------------<br>
**Register Details** <br>
-----------------------------------------<br>
**Full Name:** {{ $data['full_name'] }}<br>
**Email:** {{ $data['email'] }}<br>
**Mobile No./Whatsapp/LINE:** {{ $data['mobile'] ?? '-' }}<br>
**Institution / Organization:** {{ $data['institution'] }}<br>
**Country of Practice:** {{ $data['country'] }}<br>
**Specialty/Subspecialty:** {{ $data['specialty_text'] }}{{ !empty($data['specialty_other']) ? ' : '. $data['specialty_other'] : '' }}<br>
**Brand/model of smartphone/camera:** {{ $data['camera_brand'] ?? '-' }}<br>
**Photography experience:** {{ $data['photography_experience_text'] }} <br>
@if($data['event_type'] == 'workshop')
**Interested in learning during the workshop:**<br> {!! $data['workshop_topics_text'] ?? '-'!!}<br>
**Type of camera bringing:**<br>{!! $data['camera_type_text'] !!}<br>
@endif