<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

abstract class Controller
{
    public function index()
{
    $appointments = Appointment::with(['user', 'service'])->get();
    return view('appointments.index', compact('appointments'));
}

public function create()
{
    $services = Service::all();
    return view('appointments.create', compact('services'));
}

public function store(HttpRequest $request)
{
    $request->validate([
        'service_id' => 'required|exists:services,id',
        'appointment_time' => 'required|date|after:now',
    ]);

    Appointment::create([
        'user_id' => auth()->id(),
        'service_id' => $request->service_id,
        'appointment_time' => $request->appointment_time,
        'status' => 'pending',
    ]);

    return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully!');
}

}
