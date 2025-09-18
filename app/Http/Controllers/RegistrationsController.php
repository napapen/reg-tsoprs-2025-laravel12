<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Registrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendRegistrationMail;

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

    public function index()
    {
        return view('home');
    }

    // ---------- Onsite ----------
    public function showOnsiteForm()
    {
        return view('forms.onsite', ['countries' => $this->countries]);
    }

    public function storeOnsite(Request $request)
    {
        return $this->store($request, 'onsite');
    }

    // ---------- Online ----------
    public function showOnlineForm()
    {
        return view('forms.online', ['countries' => $this->countries]);
    }

    public function storeOnline(Request $request)
    {
        return $this->store($request, 'online');
    }

    // ---------- Workshop ----------
    public function showWorkshopForm()
    {
        return view('forms.workshop', ['countries' => $this->countries]);
    }

    public function storeWorkshop(Request $request)
    {
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

        Log::info('ค่าที่ได้จาก request', $request->all());

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

            Log::info('ค่าที่ได้จาก validated', $validated);
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

        if (is_string($filePath)) {
            Log::info('ไฟล์เป็น string path เรียบร้อย', ['filePath' => $filePath]);
        } else {
            Log::warning('ไฟล์ไม่ใช่ string! อาจเป็น UploadedFile', ['filePath_type' => gettype($filePath)]);
        }

        // ตรวจสอบชนิดข้อมูลก่อนส่งเข้าคิว
        foreach ($mailData as $key => $value) {
            if (is_object($value)) {
                Log::warning("mailData contains object at key: $key", ['value' => $value]);
            }
        }

        // ส่ง Job แบบ Queue
        SendRegistrationMail::dispatch($mailData, $filePath);

        Log::info('Dispatched SendRegistrationMail job', [
            'email' => $mailData['email'],
            'file_path' => $filePath
        ]);

        // ✅ Redirect พร้อม flash message
        return redirect()->route('home')
            ->with('success', "ลงทะเบียน $eventType สำเร็จ 🎉 รหัสของคุณคือ: {$registration->transid}");
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
}