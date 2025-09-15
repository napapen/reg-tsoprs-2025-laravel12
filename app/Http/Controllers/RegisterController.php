<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $register = Register::all();
        return view('index',compact('register'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Register::create($request->only('title', 'content'));

        return redirect()->route('index')->with('success', 'Register created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Register $register)
    {
        return view('show', compact('register'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Register $register)
    {
        return view('edit', compact('register'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Register $register)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $register->update($request->only('title', 'content'));

        return redirect()->route('index')->with('success', 'Register updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Register $register)
    {
        $register->delete();
        return redirect()->route('index')->with('success', 'Register deleted successfully.');
    }
}
