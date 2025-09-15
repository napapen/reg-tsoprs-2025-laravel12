<?php

namespace App\Http\Controllers;

use App\Models\Registrations;
use Illuminate\Http\Request;

class RegistrationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home');
    }

    // ---------- Onsite ----------
    public function showOnsiteForm()
    {
        return view('forms.onsite');
    }

    public function storeOnsite(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'mobile'    => 'nullable|string|max:50',
            'photo'     => 'nullable|image|max:2048'
        ]);

        $path = $request->file('photo')?->store('photos', 'public');

        Registrations::create([
            'event_type' => 'onsite',
            'full_name'  => $request->full_name,
            'email'      => $request->email,
            'mobile'     => $request->mobile,
            'photo_path' => $path,
        ]);

        return redirect()->route('home')->with('success', 'ลงทะเบียน Onsite สำเร็จ');
    }

    // ---------- Online ----------
    public function showOnlineForm()
    {
        return view('forms.online');
    }

    public function storeOnline(Request $request)
    {
        $this->store($request, 'online');
        return redirect()->route('home')->with('success', 'ลงทะเบียน Online สำเร็จ');
    }

    // ---------- Workshop ----------
    public function showWorkshopForm()
    {
        return view('forms.workshop');
    }

    public function storeWorkshop(Request $request)
    {
        $this->store($request, 'workshop');
        return redirect()->route('home')->with('success', 'ลงทะเบียน Workshop สำเร็จ');
    }

    // ฟังก์ชันกลางสำหรับ save ข้อมูล
    private function store(Request $request, string $eventType)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'mobile'    => 'nullable|string|max:50',
            'photo'     => 'nullable|image|max:2048'
        ]);

        $path = $request->file('photo')?->store('photos', 'public');

        Registrations::create([
            'event_type' => $eventType,
            'full_name'  => $request->full_name,
            'email'      => $request->email,
            'mobile'     => $request->mobile,
            'photo_path' => $path,
        ]);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Registrations $registrations)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Registrations $registrations)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Registrations $registrations)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Registrations $registrations)
    // {
    //     //
    // }
}
