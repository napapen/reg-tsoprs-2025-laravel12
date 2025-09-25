<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Models\Registrations;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendUserConfirmRegistrationMail;
use App\Jobs\SendUserCancelRegistrationMail;

class AuthController extends Controller
{
    //
    public function index(): View
    {
        return view('auth.login');
    }

    public function registration(): View
    {
        return view('auth.registration');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("login")->withError('You have entered invalid credentials!');
    }

    public function postRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
   
        $data = $request->all();
        $check = $this->create($data);

        Auth::login($check);
        
        return redirect("login")->withSuccess('Great! You have Successfully loggedin');
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('admin.dashboard');
        }
        return redirect("login")->withError('You are not allowed to access');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();
  
        return redirect('login')->withSuccess('You have successfully logged out');
    }

    //After Login
    public function registerList(Request $request)
    {
        $query = Registrations::query();

        // เงื่อนไขค้นหา
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('transid', 'LIKE', "%{$search}%")
                ->orWhere('full_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // ดึงข้อมูลล่าสุดก่อน
        $registrations = $query->orderBy('created_at', 'desc')->paginate(30);
        //event_type_text, registration_type_text, status_text อยู่ใน Model
    
        return view('admin.register-list', compact('registrations'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:registrations,id',
            'status' => 'required|in:pending,reviewed,cancelled',
            'reason' => 'nullable|string|max:1000'
        ]);

        $registration = Registrations::findOrFail($request->id);
        $registration->status = $request->status;

        // ถ้าเลือก cancelled ให้บันทึกเหตุผล
        if ($request->status === 'cancelled') {
            $registration->cancel_reason = $request->reason;
        } else {
            $registration->cancel_reason = null;
        }

        $registration->save();

        // ✅ เพิ่มส่วนนี้สำหรับส่งอีเมลเมื่อสถานะเป็น reviewed
        if ($request->status === 'reviewed' || $request->status === 'cancelled') {
            $data = [
                'transid'       => $registration->transid,
                'full_name'     => $registration->full_name,
                'email'         => $registration->email,
                'event_type'    => $registration->event_type_text,
                'regist_type'   => $registration->registration_type_text,
                'payment_total' => $registration->payment_total_text,
                'pay_time'      => $registration->pay_time,
            ];

            if($request->status === 'reviewed'){
                // ส่งอีเมลยืนยันการลงทะเบียนไปยัง User
                SendUserConfirmRegistrationMail::dispatch($data);
            }

            if($request->status === 'cancelled'){
                // ส่งอีเมลแจ้งยกเลิกการลงทะเบียนไปยัง User
                SendUserCancelRegistrationMail::dispatch($data);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status_text' => $registration->status_text,
            'cancel_reason' => $registration->cancel_reason
        ]);
    }

    public function registerDetail($id)
    {
        $registration = Registrations::findOrFail($id);
        //print_r($registration->toArray());

        $specialtyTextMap = [
            'specialty1'   => 'General practitioner',
            'specialty2'   => 'Ophthalmologist',
            'specialty3'   => 'Oculoplastic Surgeon',
            'specialty4'   => 'Plastic Surgeon',
            'specialty5'   => 'Resident/Fellow',
            'specialty99'  => 'Other',
        ];

        $registration->specialty_text = $specialtyTextMap[$registration->specialty] ?? $registration->specialty;
        if($registration->specialty === 'specialty99' && $registration->specialty_other){
            $registration->specialty_text .= " ({$registration->specialty_other})";
        }

        //cameratype checkbox
        $cameratypeTextMap = [
            'cameratype1'   => 'DSLR camera',
            'cameratype2'   => 'Mirrorless camera',
            'cameratype3'   => 'Compact digital camera',
            'cameratype4'   => 'Smartphone Andriod',
            'cameratype5'   => 'Smartphone Apple',
            'cameratype99'   => 'Other',
        ];
        $cameraTypes = array_map('trim', explode(',', $registration->camera_type));
        $cameraTypeTexts = [];
        foreach ($cameraTypes as $type) {
            if ($type === 'cameratype99') {
                // ต่อข้อความ Other พร้อมค่าที่กรอก
                $cameraTypeTexts[] = "Other (" . ($registration->camera_type_other ?? '') . ")";
            } elseif (isset($cameratypeTextMap[$type])) {
                $cameraTypeTexts[] = $cameratypeTextMap[$type];
            }
        }
        $registration->camera_type_text_array = $cameraTypeTexts;  

        // workshop_topics checkbox
        $workshoptopicTextMap = [
            'workshop_topics1' => 'Easy studio setup & lighting for clinical photography',
            'workshop_topics2' => 'Using a professional camera for clinical photography',
            'workshop_topics3' => 'Using a smartphone camera for clinical photography',
            'workshop_topics4' => 'DIY surgical video recording (smartphone or professional camera)',
            'workshop_topics5' => 'Creating and editing educational videos',
            'workshop_topics6' => 'Portrait photography for social media and professional websites',
        ];
        
        $topics = array_map('trim', explode(',', $registration->workshop_topics));
        $result = [];
        foreach ($topics as $topic) {
            if (isset($workshoptopicTextMap[$topic])) {
                $result[] = $workshoptopicTextMap[$topic];
            }
        }
        $registration->workshop_topics_text_array = $result;

        //print_r($registration->toArray());
 
        return view('admin.register-detail', compact('registration'));
    }

}
