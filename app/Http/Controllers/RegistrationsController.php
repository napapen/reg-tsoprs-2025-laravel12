<?php

namespace App\Http\Controllers;

use App\Models\Registrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'mobile'    => 'nullable|string|max:50',
            'country'   => 'nullable|string|max:100',
            'specialty' => 'required|string',
            'cameratype'=> 'nullable|array',      // array ของ camera types
            'registration_type' => 'required|in:rcopt,nonrcopt,international',
            'photo'     => 'nullable|image|max:2048',
            'institution' => 'nullable|string|max:255',
            'camera_brand' => 'nullable|string|max:255',
            'photography_experience' => 'nullable|in:beginner,intermediate,advanced',
            'workshop_topics' => 'nullable|array',
            'other_topics' => 'nullable|string',
            'equipment_questions' => 'nullable|string',
        ]);
        

        $path = $request->file('photo')?->store('uploads', 'public');

        // แปลง cameratype array เป็น string เพื่อเก็บใน DB
        $cameratypeStr = isset($validated['cameratype']) ? implode(', ', $validated['cameratype']) : null;
        $workshopTopics = isset($validated['workshop_topics']) ? implode(', ', $validated['workshop_topics']) : null;

        $registration = Registrations::create([
            'transid'    => $this->generateTransId(),
            'event_type' => $eventType,
            'full_name'  => $validated['full_name'],
            'email'      => $validated['email'],
            'mobile'     => $validated['mobile'] ?? null,
            'country'    => $validated['country'] ?? null,
            'specialty'  => $validated['specialty'],
            'cameratype' => $cameratypeStr,
            'registration_type' => $validated['registration_type'],
            'photo_path' => $path,
            'institution' => $validated['institution'] ?? null,
            'camera_brand' => $validated['camera_brand'] ?? null,
            'photography_experience' => $validated['photography_experience'] ?? null,
            'workshop_topics' => $workshopTopics,
            'other_topics' => $validated['other_topics'] ?? null,
            'equipment_questions' => $validated['equipment_questions'] ?? null,
        ]);

        return redirect()->route('home')
            ->with('success', "ลงทะเบียน $eventType สำเร็จ รหัสของคุณคือ: $registration->transid");
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