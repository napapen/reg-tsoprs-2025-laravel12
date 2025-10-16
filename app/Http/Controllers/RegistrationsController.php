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
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class RegistrationsController extends Controller
{
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

        return view('forms.onsite',[
        'countries' => config('mappings.countries') // ✅ ดึง countries จาก config
        ]);
    }

    public function storeOnsite(Request $request)
    {
        // check limit
        $count = Registrations::where('event_type', 'onsite')->count();
        if ($count >= $this->limits['onsite']) {
            return redirect()->route('onsite.form')
                ->withErrors(['limit' => 'Onsite registration is full.']);
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

        return view('forms.online', [
            'countries' => config('mappings.countries') // ✅ ดึง countries จาก config
        ]);
    }

    public function storeOnline(Request $request)
    {
        $count = Registrations::where('event_type', 'online')->count();
        if ($count >= $this->limits['online']) {
            return redirect()->route('online.form')
                ->withErrors(['limit' => 'Online registration is full.']);
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

        return view('forms.workshop', [
            'countries' => config('mappings.countries') // ✅ ดึง countries จาก config
        ]);
    }

    public function storeWorkshop(Request $request)
    {
        $count = Registrations::where('event_type', 'workshop')->count();
        if ($count >=  $this->limits['workshop']) {
            return redirect()->route('workshop.form')
                ->withErrors(['limit' => 'Workshop registration is full.']);
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
        // $eventTypeTextMap = [
        //     'onsite'   => 'Onsite Lecture',
        //     'online'   => 'Online Lecture',
        //     'workshop' => 'Full-Day Workshop',
        // ];
        $eventTypeTextMap = config('mappings.event_types');
        $mailData['event_type_text'] = $eventTypeTextMap[$mailData['event_type']] ?? '';

        //rcopt,nonrcopt,international
        // $registTypeTextMap = [
        //     'rcopt'   => 'RCOPT Delegates',
        //     'nonrcopt'   => 'Non-RCOPT Thai Delegates',
        //     'international' => 'International Delegates',
        // ];
        $registTypeTextMap = config('mappings.registration_types');
        $mailData['registration_type_text'] = $registTypeTextMap[$mailData['registration_type']] ?? '';

        //payment chanel
        // $paymentChanelTextMap = [
        //     'rcopt'   => 'Direct Bank Transfer',
        //     'nonrcopt'   => 'Direct Bank Transfer',
        //     'international' => 'Credit Card',
        // ];
        $paymentChanelTextMap = config('mappings.payment_channels');
        $mailData['payment_chanel_text'] = $paymentChanelTextMap[$mailData['registration_type']] ?? '';

        //session price
        // $pricing = [
        //     'onsite' => [
        //         'rcopt'         => 1000,
        //         'nonrcopt'      => 3000,
        //         'international' => 3000,
        //    ],
        //     'online' => [
        //         'rcopt'         => 0,
        //         'nonrcopt'      => 0,
        //         'international' => 1700,
        //     ],
        //     'workshop' => [
        //         'rcopt'         => 7500,
        //         'nonrcopt'      => 9000,
        //         'international' => 8500,
        //     ],
        // ];
        $pricing = config('mappings.pricing');
        $cstTotal = $pricing[$registration->event_type][$registration->registration_type] ?? 0;
        $mailData['payment_total'] = number_format($cstTotal, 0, '.', ',') . ' THB';

        //specialty radio
        // $specialtyTextMap = [
        //     'specialty1'   => 'General practitioner',
        //     'specialty2'   => 'Ophthalmologist',
        //     'specialty3' => 'Oculoplastic Surgeon',
        //     'specialty4' => 'Plastic Surgeon',
        //     'specialty5' => 'Resident/Fellow',
        //     'specialty99' => 'Other',
        // ];
        $specialtyTextMap = config('mappings.specialties');
        $mailData['specialty_text'] = $specialtyTextMap[$mailData['specialty']] ?? '';

        //cameratype checkbox
        $mailData['camera_type_text'] = '';
        // $cameratypeTextMap = [
        //     'cameratype1'   => 'DSLR camera',
        //     'cameratype2'   => 'Mirrorless camera',
        //     'cameratype3'   => 'Compact digital camera',
        //     'cameratype4'   => 'Smartphone Andriod',
        //     'cameratype5'   => 'Smartphone Apple',
        //     'cameratype99'   => 'Other',
        // ];
        $cameratypeTextMap = config('mappings.cameras');
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
        // $workshoptopicTextMap = [
        //     'workshop_topics1'   => 'Easy studio setup & lighting for clinical photography',
        //     'workshop_topics2'   => 'Using a professional camera for clinical photography',
        //     'workshop_topics3'   => 'Using a smartphone camera for clinical photography',
        //     'workshop_topics4'   => 'DIY surgical video recording (smartphone or professional camera)',
        //     'workshop_topics5'   => 'Creating and editing educational videos',
        //     'workshop_topics6'   => 'Portrait photography for social media and professional websites',
        //     // 'workshop_topics7'   => 'How to choose affordable gear for clinical photography',
        // ];
        $workshoptopicTextMap = config('mappings.workshop_topics');
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
        // $expTextMap = [
        //     'beginner'   => 'Beginner',
        //     'intermediate'   => 'Intermediate',
        //     'advanced'   => 'Advanced',
        // ];
        $expTextMap = config('mappings.experiences');
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
    
    public function dashboardByEventType($eventType)
    {
        $data = $this->buildDashboardData($eventType);

        // Map title สำหรับแต่ละ event
        // $titleMap = [
        //     'workshop' => 'Full-Day Workshop',
        //     'onsite'   => 'Onsite Lecture',
        //     'online'   => 'Online Lecture',
        // ];
        $titleMap = config('mappings.event_types');
        return view('admin.event-dashboard', $data + [
            'eventType' => $eventType,
            'pageTitle' => $titleMap[$eventType] ?? ucfirst($eventType), // fallback ถ้าไม่ match
        ]);
    }

    protected function buildDashboardData($eventType)
    {
        $data = Registrations::where('event_type', $eventType)
                            ->where('status', 'reviewed')
                            ->get();

        $specialtyMap   = config('mappings.specialties');
        $cameraMap      = config('mappings.cameras');
        $topicMap       = config('mappings.workshop_topics');
        $regTypeMap     = config('mappings.registration_types');
        $expMap         = config('mappings.experiences');

        // Map text สำหรับแต่ละ record
        $data->transform(function($item) use ($specialtyMap, $cameraMap, $topicMap, $regTypeMap, $expMap, $eventType){
            $item->specialty_text = $specialtyMap[$item->specialty] ?? $item->specialty;

            // Camera
            $cameraArr = array_map('trim', explode(',', (string) $item->camera_type));
            $item->camera_type_text = $cameraArr 
                ? '- ' . implode('<br/>- ', array_map(fn($c) => $cameraMap[$c] ?? $c, $cameraArr))
                : '';

            // Workshop topic (เฉพาะ workshop)
            if ($eventType === 'workshop') {
                $topicArr = array_map('trim', explode(',', (string) $item->workshop_topics));
                $item->workshop_topics_text = $topicArr
                    ? '- ' . implode('<br/>- ', array_map(fn($t) => $topicMap[$t] ?? $t, $topicArr))
                    : '';
            }

            $item->registration_type_text = $regTypeMap[$item->registration_type] ?? $item->registration_type;
            $item->photography_experience_text = $expMap[$item->photography_experience] ?? $item->photography_experience;

            return $item;
        });

        // Registration type
        $registrationTypes = $data->pluck('registration_type')
                                ->map(fn($t) => $regTypeMap[$t] ?? $t)
                                ->countBy()
                                ->sortDesc();

        // Specialty
        $specialties = $data->pluck('specialty')
                            ->map(fn($s) => $specialtyMap[$s] ?? $s)
                            ->countBy()
                            ->sortDesc();

        // Experience
        $photoExperiences = $data->pluck('photography_experience')
                                ->map(fn($e) => $expMap[$e] ?? $e)
                                ->countBy()
                                ->sortDesc();

        // Countries
        $countries = $data->pluck('country')->filter()->countBy()->sortDesc();

        // Camera Brands
        $cameraBrandData = $data->pluck('camera_brand')->filter()->map('trim')->countBy()->sortDesc();

        // ค่า default
        $topicCounts = collect([]);
        $cameraTypes = collect([]);

        if ($eventType === 'workshop') {
            // Topics
            $topics = $data->pluck('workshop_topics')
                        ->filter()
                        ->map(function($item) use ($topicMap){
                            $keys = explode(',', $item);
                            $texts = [];
                            foreach($keys as $key){
                                $key = trim($key);
                                if(isset($topicMap[$key])) $texts[] = $topicMap[$key];
                            }
                            return $texts;
                        })
                        ->flatten();
            $topicCounts = $topics->countBy()->sortDesc();

            // Camera Types
            $cameraTypes = $data->pluck('camera_type')
                                ->filter()
                                ->map(function($item) use ($cameraMap){
                                    $keys = explode(',', $item);
                                    $texts = [];
                                    foreach ($keys as $key) {
                                        $key = trim($key);
                                        if(isset($cameraMap[$key])) $texts[] = $cameraMap[$key];
                                    }
                                    return $texts;
                                })
                                ->flatten()
                                ->countBy()
                                ->sortDesc();
        }

        return [
            'workshops'          => $data,
            'registrationTypes'  => $registrationTypes,
            'specialties'        => $specialties,
            'photoExperiences'   => $photoExperiences,
            'countries'          => $countries,
            'topicCounts'        => $topicCounts,
            'cameraTypes'        => $cameraTypes,
            'cameraBrandData'    => $cameraBrandData,
        ];
    }

    public function exportCsv(Request $request)
    {
        $query = Registrations::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('transid', 'like', "%$search%")
                ->orWhere('full_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        // if ($status = $request->input('status')) {
        //     $query->where('status', $status);
        // }
        $query->where('status', 'reviewed');

        $registrations = $query->orderBy('created_at', 'desc')->get();

        $filename = 'registrations_' . now()->format('Ymd_His') . '.csv';

        $callback = function() use ($registrations) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header CSV
            fputcsv($file, [
                'TransID',
                'Name',
                'Email',
                'Mobile',
                'Institution / Organization', 
                'Country',
                'Masterclass',
                'Registration Type',
                'Payment',
                'Total',
                'Date Registered',
                'Status',
                // 'Cancel Reason',
                'Specialty',
                'Specialty Other',
                'Photography Experience',
                'Camera Type',
                'Camera / Phone Brand',
                'Workshop Topics'
            ]);

            $specialtyMap = config('mappings.specialties');
            $cameraMap = config('mappings.cameras');
            $topicMap = config('mappings.workshop_topics');
            $expMap = config('mappings.experiences');
            $regTypeMap = config('mappings.registration_types');
            $eventMap = config('mappings.event_types');

            $deadline = Carbon::create(2025, 10, 16, 14, 0, 0, 'Asia/Bangkok');

            foreach($registrations as $reg){
                $specialty = $specialtyMap[$reg->specialty] ?? $reg->specialty;
                $subspecialty = $reg->specialty_other ?? '';
                $experience = $expMap[$reg->photography_experience] ?? '';

                $cameraTypes = array_map('trim', explode(',', (string) $reg->camera_type));
                $cameraTypeText = $cameraTypes 
                    ? implode(' | ', array_map(fn($c) => $cameraMap[$c] ?? $c, $cameraTypes)) 
                    : '';

                $topics = array_map('trim', explode(',', (string) $reg->workshop_topics));
                $topicsText = $topics 
                    ? implode(' | ', array_map(fn($t) => $topicMap[$t] ?? $t, $topics)) 
                    : '';

                // 💰 ตรวจสอบ deadline แล้วเลือกแสดงราคาใหม่หรือเดิม
                $createdAt = Carbon::parse($reg->created_at)->timezone('Asia/Bangkok');
                if ($createdAt->greaterThan($deadline)) {
                    $paymentTotalText = $this->getLateFee($reg);
                } else {
                    $paymentTotalText = $reg->payment_total_text;
                }

                fputcsv($file, [
                    $reg->transid,
                    $reg->full_name,
                    $reg->email,
                    $reg->mobile,
                    $reg->institution ?? '',       
                    $reg->country ?? '',
                    $eventMap[$reg->event_type] ?? $reg->event_type,
                    $regTypeMap[$reg->registration_type] ?? $reg->registration_type,
                    $reg->registration_payment_text,
                    $paymentTotalText,
                    $reg->created_at->format('d/m/Y H:i'),
                    $reg->status,
                    // $reg->cancel_reason ?? '',
                    $specialty,
                    $subspecialty,
                    $experience,
                    $cameraTypeText,
                    $reg->camera_brand ?? '',
                    $topicsText
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ]);
    }

    private function getLateFee($reg)
    {
        $latePricing = [
            'onsite' => [
                'rcopt'         => '1,250 THB',
                'nonrcopt'      => '3,300 THB',
                'international' => '3,300 THB',
            ],
            'online' => [
                'rcopt'         => '0 THB',
                'nonrcopt'      => '0 THB',
                'international' => '1,900 THB',
            ],
            'workshop' => [
                'rcopt'         => '8,250 THB',
                'nonrcopt'      => '9,900 THB',
                'international' => '9,350 THB',
            ],
        ];

        return $latePricing[$reg->event_type][$reg->registration_type] 
            ?? $reg->payment_total_text;
    }


}

