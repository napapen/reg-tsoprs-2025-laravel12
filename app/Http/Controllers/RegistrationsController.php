<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Registrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendRegistrationMail;
use App\Jobs\SendUserRegistrationMail;

class RegistrationsController extends Controller
{
    private array $countries = [
        "Afghanistan","Albania","Algeria","Andorra","Angola","Argentina","Armenia","Australia",
        "Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Belarus","Belgium","Belize","Benin",
        "Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Cambodia",
        "Cameroon","Canada","Chile","China","Colombia","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic",
        "Denmark","Dominican Republic","Ecuador","Egypt","El Salvador","Estonia","Ethiopia","Fiji","Finland",
        "France","Georgia","Germany","Ghana","Greece","Greenland","Guatemala","Honduras","Hong Kong","Hungary",
        "Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan",
        "Kazakhstan","Kenya","Kuwait","Laos","Latvia","Lebanon","Lithuania","Luxembourg","Macau","Madagascar",
        "Malaysia","Maldives","Malta","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro",
        "Morocco","Myanmar","Nepal","Netherlands","New Zealand","Nigeria","North Korea","Norway","Oman",
        "Pakistan","Panama","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia",
        "Rwanda","Saudi Arabia","Senegal","Serbia","Singapore","Slovakia","Slovenia","South Africa","South Korea",
        "Spain","Sri Lanka","Sudan","Sweden","Switzerland","Syria","Taiwan","Tanzania","Thailand","Tunisia",
        "Turkey","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan",
        "Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"
    ];

    protected $limits = [
        'onsite'   => 140,
        'online'   => 200,
        'workshop' => 55, #60
    ];

    public function index()
    {
        //return view('home');
        return redirect()->route('onsite.form');
    }

    // ---------- Onsite ----------
    public function showOnsiteForm()
    {
        $count = Registrations::where('event_type', 'onsite')->count();
        if ($count >= $this->limits['onsite']) {
            return view('forms.full', [
                'event' => 'Onsite Lecture',
                'limit' => $this->limits['onsite'],
            ]);
        }

        return view('forms.onsite', ['countries' => $this->countries]);
    }

    public function storeOnsite(Request $request)
    {
        // check limit
        $count = Registrations::where('event_type', 'onsite')->count();
        if ($count >= $this->limits['onsite']) {
            return redirect()->route('onsite.form')
                ->withErrors(['limit' => 'Onsite registration is full ('.$this->limits['onsite'].' participants).']);
        }

        return $this->store($request, 'onsite');
    }

    // ---------- Online ----------
    public function showOnlineForm()
    {
        $count = Registrations::where('event_type', 'online')->count();
        if ($count >= $this->limits['online']) {
            return view('forms.full', [
                'event' => 'Online Lecture',
                'limit' => $this->limits['online'],
            ]);
        }

        return view('forms.online', ['countries' => $this->countries]);
    }

    public function storeOnline(Request $request)
    {
        $count = Registrations::where('event_type', 'online')->count();
        if ($count >= $this->limits['online']) {
            return redirect()->route('online.form')
                ->withErrors(['limit' => 'Online registration is full ('.$this->limits['online'].' participants).']);
        }

        return $this->store($request, 'online');
    }

    // ---------- Workshop ----------
    public function showWorkshopForm()
    {
        $count = Registrations::where('event_type', 'workshop')->count();
        if ($count >= $this->limits['workshop']) {
            return view('forms.full', [
                'event' => 'Full-Day Workshop',
                'limit' => $this->limits['workshop'],
            ]);
        }

        return view('forms.workshop', ['countries' => $this->countries]);
    }

    public function storeWorkshop(Request $request)
    {
        $count = Registrations::where('event_type', 'workshop')->count();
        if ($count >=  $this->limits['workshop']) {
            return redirect()->route('workshop.form')
                ->withErrors(['limit' => 'Workshop registration is full ('.$this->limits['workshop'].' participants).']);
        }

        return $this->store($request, 'workshop');
    }

    // ---------- ฟังก์ชันกลางสำหรับบันทึกข้อมูล ----------
    private function store(Request $request, string $eventType)
    {
        //dd($request->all()); // แสดงข้อมูลที่ถูกส่งมาทั้งหมดแล้วหยุด execution
        // dd([
        //     'inputs' => $request->except('pay_slip'),
        //     'rcopt_hasFile' => $request->hasFile('pay_slip_rcopt'),
        //     'rcopt_isValid' => $request->file('pay_slip_rcopt')?->isValid(),
        //     'rcopt_file'    => $request->file('pay_slip_rcopt'),
        //     'nonrcopt_hasFile' => $request->hasFile('pay_slip_nonrcopt'),
        //     'nonrcopt_isValid' => $request->file('pay_slip_nonrcopt')?->isValid(),
        //     'nonrcopt_file'    => $request->file('pay_slip_nonrcopt'),
        // ]);

        //Log::info('ค่าที่ได้จาก request', $request->all());

        try {
            $validated = $request->validate([
                //'event_type'         => 'required|in:onsite,online,workshop',
                'registration_type'  => 'required|in:rcopt,nonrcopt,international',

                'pay_date'           => 'required_if:registration_type,international|string|max:10',
                'pay_hour'           => 'nullable|string|max:10',
                'pay_min'            => 'nullable|string|max:10',

                // ใช้ชื่อ field ตามที่เจอใน dd()
                'pay_slip_rcopt'     => 'required_if:registration_type,rcopt|file|max:2048',
                'pay_slip_nonrcopt'  => 'required_if:registration_type,nonrcopt|file|max:2048',

                'full_name'          => 'required|string|max:255',
                'email'              => 'required|email',
                'mobile'             => 'nullable|string|max:50',
                'institution'        => 'nullable|string|max:255',
                'country'            => 'nullable|string|max:100',

                'specialty'          => 'required|string',
                'specialty_other'    => 'nullable|string|max:255',

                'camera_type'        => 'nullable|array',
                'camera_type_other'  => 'nullable|string|max:255',
                'camera_brand'       => 'nullable|string|max:255',

                'workshop_topics'    => 'nullable|array',
                'photography_experience' => 'nullable|in:beginner,intermediate,advanced',
                'other_topics'       => 'nullable|string',
                'equipment_questions'=> 'nullable|string',
            ]);

            //Log::info('ค่าที่ได้จาก validated', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', $e->errors());
        }

        // ✅ จัดการอัพโหลดไฟล์ ตาม registration_type
        $filePath = null;

        if ($validated['registration_type'] === 'rcopt' && $request->hasFile('pay_slip_rcopt')) {
            $filePath = $request->file('pay_slip_rcopt')->store('uploads', 'public');
        }

        if ($validated['registration_type'] === 'nonrcopt' && $request->hasFile('pay_slip_nonrcopt')) {
            $filePath = $request->file('pay_slip_nonrcopt')->store('uploads', 'public');
        }

        if ($validated['registration_type'] === 'international' && $request->hasFile('capture_international')) {
            $filePath = $request->file('capture_international')->store('uploads', 'public');
        }
        
        // ✅ แปลง array เป็น string เก็บใน DB
        $cameratypeStr   = isset($validated['camera_type']) ? implode(', ', $validated['camera_type']) : null;
        $workshopTopics  = isset($validated['workshop_topics']) ? implode(', ', $validated['workshop_topics']) : null;

        // ✅ Insert DB
        $registration = Registrations::create([
            'transid'    => $this->generateTransId(),
            'event_type' => $eventType,
            'registration_type' => $validated['registration_type'],

            'pay_date'   => $validated['pay_date'] ?? null,
            'pay_hour'   => $validated['pay_hour'] ?? null,
            'pay_min'    => $validated['pay_min'] ?? null,
            'pay_slip'   => $filePath,

            'full_name'  => $validated['full_name'],
            'email'      => $validated['email'],
            'mobile'     => $validated['mobile'] ?? null,
            'institution'=> $validated['institution'] ?? null,
            'country'    => $validated['country'] ?? null,

            'specialty'       => $validated['specialty'],
            'specialty_other' => $validated['specialty_other'] ?? null,

            'camera_type'        => $cameratypeStr,
            'camera_type_other'  => $validated['camera_type_other'] ?? null,
            'camera_brand'       => $validated['camera_brand'] ?? null,

            'workshop_topics'       => $workshopTopics,
            'photography_experience'=> $validated['photography_experience'] ?? null,
            'other_topics'          => $validated['other_topics'] ?? null,
            'equipment_questions'   => $validated['equipment_questions'] ?? null,
        ]);

        // ส่ง Mail แบบ Queue
        // เตรียมข้อมูลสำหรับ Mail (ไม่เอา UploadedFile ตรง ๆ)
        $mailData = $validated;
        unset($mailData['pay_slip_rcopt'], $mailData['pay_slip_nonrcopt']); // ลบ UploadedFile
        
        //push other data use in mail template
        $mailData['transid'] = $registration->transid;
        $mailData['event_type'] = $registration->event_type;
        $mailData['created_at'] = $registration->created_at;

        //onsite,online,workshop
        $eventTypeTextMap = [
            'onsite'   => 'Onsite Lecture',
            'online'   => 'Online Lecture',
            'workshop' => 'Full-Day Workshop',
        ];
        $mailData['event_type_text'] = $eventTypeTextMap[$mailData['event_type']] ?? '';
        
        //rcopt,nonrcopt,international
        $registTypeTextMap = [
            'rcopt'   => 'RCOPT Delegates',
            'nonrcopt'   => 'Non-RCOPT Thai Delegates',
            'international' => 'International Delegates',
        ];
        $mailData['registration_type_text'] = $registTypeTextMap[$mailData['registration_type']] ?? '';

        //payment chanel
        $paymentChanelTextMap = [
            'rcopt'   => 'Direct Bank Transfer',
            'nonrcopt'   => 'Direct Bank Transfer',
            'international' => 'Credit Card',
        ];
        $mailData['payment_chanel_text'] = $paymentChanelTextMap[$mailData['registration_type']] ?? '';

        //session price
        $pricing = [
            'onsite' => [
                'rcopt'         => 1000,
                'nonrcopt'      => 3000,
                'international' => 3000,
           ],
            'online' => [
                'rcopt'         => 0,
                'nonrcopt'      => 0,
                'international' => 1700,
            ],
            'workshop' => [
                'rcopt'         => 7500,
                'nonrcopt'      => 9000,
                'international' => 8500,
            ],
        ];
        $cstTotal = $pricing[$registration->event_type][$registration->registration_type] ?? 0;
        $mailData['payment_total'] = number_format($cstTotal, 0, '.', ',') . ' THB';

        //specialty radio
        $specialtyTextMap = [
            'specialty1'   => 'General practitioner',
            'specialty2'   => 'Ophthalmologist',
            'specialty3' => 'Oculoplastic Surgeon',
            'specialty4' => 'Plastic Surgeon',
            'specialty5' => 'Resident/Fellow',
            'specialty99' => 'Other',
        ];
        $mailData['specialty_text'] = $specialtyTextMap[$mailData['specialty']] ?? '';

        //cameratype checkbox
        $mailData['camera_type_text'] = '';
        $cameratypeTextMap = [
            'cameratype1'   => 'DSLR camera',
            'cameratype2'   => 'Mirrorless camera',
            'cameratype3'   => 'Compact digital camera',
            'cameratype4'   => 'Smartphone Andriod',
            'cameratype5'   => 'Smartphone Apple',
            'cameratype99'   => 'Other',
        ];
        $cameraTypes = $mailData['camera_type'] ?? []; // isArray
        if (is_array($cameraTypes) && !empty($cameraTypes)) {
            $lines = [];
            foreach ($cameraTypes as $type) {
                if ($type === 'cameratype99') {
                    $other = $mailData['camera_type_other'] ?? '';
                    $lines[] = ' > ' . $cameratypeTextMap[$type] . ($other ? ": {$other}" : '');
                } else {
                    $lines[] = ' > ' . ($cameratypeTextMap[$type] ?? $type);
                }
            }
            $mailData['camera_type_text'] = implode("<br>", $lines);

        }

        //workshop topic checkbox
        $workshoptopicTextMap = [
            'workshop_topics1'   => 'Easy studio setup & lighting for clinical photography',
            'workshop_topics2'   => 'Using a professional camera for clinical photography',
            'workshop_topics3'   => 'Using a smartphone camera for clinical photography',
            'workshop_topics4'   => 'DIY surgical video recording (smartphone or professional camera)',
            'workshop_topics5'   => 'Creating and editing educational videos',
            'workshop_topics6'   => 'Portrait photography for social media and professional websites',
            // 'workshop_topics7'   => 'How to choose affordable gear for clinical photography',
        ];
        $workshoptopciTypes = $mailData['workshop_topics'] ?? [];
        $mailData['workshop_topics_text'] = '';
        if (is_array($workshoptopciTypes) && !empty($workshoptopciTypes)) {
            $lines = [];
            foreach ($workshoptopciTypes as $type) {
                $lines[] = ' > ' . ($workshoptopicTextMap[$type] ?? $type);
            }
            $mailData['workshop_topics_text'] = implode("<br>", $lines);

        }

        //photography experience
        $expTextMap = [
            'beginner'   => 'Beginner',
            'intermediate'   => 'Intermediate',
            'advanced'   => 'Advanced',
        ];
        $mailData['photography_experience_text'] = $expTextMap[$mailData['photography_experience']] ?? '';

        // ส่ง Job แบบ Queue
        SendRegistrationMail::dispatch($mailData, $filePath);
        SendUserRegistrationMail::dispatch($mailData, $filePath);

        // ✅ Redirect พร้อม flash message
        // return redirect()->route('home')
        //     ->with('success', "ลงทะเบียน $eventType สำเร็จ 🎉 รหัสของคุณคือ: {$registration->transid}");
        return redirect()->route('registration.success', ['transid' => $registration->transid]);
    }

    // ---------- ฟังก์ชัน generate transid ----------
    private function generateTransId(): string
    {
        $date = now()->format('Ymd');

        return DB::transaction(function () use ($date) {
            // ตรวจสอบ sequence ของวันนี้
            $seq = DB::table('transid_sequences')->where('date', $date)->lockForUpdate()->first();

            if ($seq) {
                $next = $seq->last_no + 1;
                DB::table('transid_sequences')->where('date', $date)->update([
                    'last_no'    => $next,
                    'updated_at' => now(),
                ]);
            } else {
                $next = 1;
                DB::table('transid_sequences')->insert([
                    'date'       => $date,
                    'last_no'    => $next,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // คืนค่า transid แบบ YYYYMMDD + running number 2 หลัก
            return $date . str_pad($next, 2, '0', STR_PAD_LEFT);
        });
    }

    public function success($transid)
    {
        // ดึงข้อมูลจาก DB ถ้าต้องการแสดงรายละเอียด
        $registration = Registrations::where('transid', $transid)->firstOrFail();

        return view('registration.success', compact('registration'));
    }

    // Workshop Dashboard (Admin)
    public function workshopDashboard()
{
    $workshops = Registrations::where('event_type','workshop')
                               ->where('status','reviewed')
                               ->get();

    // Mapping Text
    $specialtyTextMap = [
        'specialty1'   => 'General practitioner',
        'specialty2'   => 'Ophthalmologist',
        'specialty3'   => 'Oculoplastic Surgeon',
        'specialty4'   => 'Plastic Surgeon',
        'specialty5'   => 'Resident/Fellow',
        'specialty99'  => 'Other',
    ];

    $cameraTextMap = [
        'cameratype1' => 'DSLR camera',
        'cameratype2' => 'Mirrorless camera',
        'cameratype3' => 'Compact digital camera',
        'cameratype4' => 'Smartphone Android',
        'cameratype5' => 'Smartphone Apple',
        'cameratype99' => 'Other',
    ];

    $workshoptopicTextMap = [
        'workshop_topics1' => 'Easy studio setup & lighting for clinical photography',
        'workshop_topics2' => 'Using a professional camera for clinical photography',
        'workshop_topics3' => 'Using a smartphone camera for clinical photography',
        'workshop_topics4' => 'DIY surgical video recording (smartphone or professional camera)',
        'workshop_topics5' => 'Creating and editing educational videos',
        'workshop_topics6' => 'Portrait photography for social media and professional websites',
    ];

    $registTypeTextMap = [
        'rcopt' => 'RCOPT Delegates',
        'nonrcopt' => 'Non-RCOPT Thai Delegates',
        'international' => 'International Delegates',
    ];

    $expTextMap = [
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'advanced' => 'Advanced',
    ];


    // Map text สำหรับแต่ละ record
    $workshops->transform(function($item) use ($specialtyTextMap, $cameraTextMap, $workshoptopicTextMap, $registTypeTextMap, $expTextMap){
        // Specialty
        $item->specialty_text = $specialtyTextMap[$item->specialty] ?? $item->specialty;

        // Camera type
        $cameraArr = array_map('trim', explode(',', $item->camera_type));
        $cameraTextArr = [];
        foreach ($cameraArr as $c) {
            if (isset($cameraTextMap[$c])) {
                $cameraTextArr[] = $cameraTextMap[$c];
            }
        }
        $item->camera_type_text = '- ' . implode('<br/>- ', $cameraTextArr);

        // Workshop topics
        $topicArr = array_map('trim', explode(',', $item->workshop_topics));
        $topicTextArr = [];
        foreach ($topicArr as $t) {
            if (isset($workshoptopicTextMap[$t])) {
                $topicTextArr[] = $workshoptopicTextMap[$t];
            }
        }
        $item->workshop_topics_text = '- ' . implode('<br/>- ', $topicTextArr);

        // Registration type
        $item->registration_type_text = $registTypeTextMap[$item->registration_type] ?? $item->registration_type;

        // Photography Experience
        $item->photography_experience_text = $expTextMap[$item->photography_experience] ?? $item->photography_experience;

        return $item;
    });



    $registrationTypes = $workshops->pluck('registration_type')
                                    ->map(fn($type) => $registTypeTextMap[$type] ?? $type)
                                    ->countBy()
                                    ->sortDesc();

    // Specialty Count
    $specialties = $workshops->pluck('specialty')
                             ->map(fn($s) => $specialtyTextMap[$s] ?? $s)
                             ->countBy()
                             ->sortDesc();

    // Photography Experience
    $photoExperiences = $workshops->pluck('photography_experience')
                                  ->filter()
                                  ->map(fn($e) => $expTextMap[$e] ?? $e)
                                  ->countBy()
                                  ->sortDesc();

    // Workshop Topics Count
    $topics = $workshops->pluck('workshop_topics')
                        ->filter()
                        ->map(function($item) use ($workshoptopicTextMap){
                            $keys = explode(',', $item);
                            $texts = [];
                            foreach($keys as $key){
                                $key = trim($key);
                                if(isset($workshoptopicTextMap[$key])) $texts[] = $workshoptopicTextMap[$key];
                            }
                            return $texts;
                        })
                        ->flatten();
    $topicCounts = $topics->countBy()->sortDesc();

    // Camera Types Count
    $cameraTypes = $workshops->pluck('camera_type')
                             ->filter()
                             ->map(function($item) use ($cameraTextMap){
                                 $keys = explode(',', $item);
                                 $texts = [];
                                 foreach($keys as $key){
                                     $key = trim($key);
                                     if(isset($cameraTextMap[$key])) $texts[] = $cameraTextMap[$key];
                                 }
                                 return $texts;
                             })
                             ->flatten()
                             ->countBy()
                             ->sortDesc();

    // Countries
    $countriesData = $workshops->pluck('country')->filter();
    $countries = $countriesData->countBy()->sortDesc();

    return view('admin.workshop-dashboard', compact(
        'workshops','registrationTypes','specialties','photoExperiences','topicCounts','cameraTypes','countries'
    ));
}


 

}