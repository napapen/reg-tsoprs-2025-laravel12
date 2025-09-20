@extends('layouts.app')

@section('content')
<div class="th-checkout-wrapper space-extra">
    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3><i class="fa-solid fa-hashtag  fw-normal me-2 text-theme"></i> Registration Successful</h3>
                <p>
                    Thank you, <strong>{{ $registration->full_name }}</strong> for registering for APSOPRS Masterclass in Oculofacial Photography and Videography.</p>

                <p class="fs-5">
                    Your registration number is:  
                    <span class="fw-bold text-theme">#{{ $registration->transid }}</span>
                </p>
                
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="bg-smoke px-30 py-30 mb-3">
                    <p class="text-center text-lg-start text-theme mb-0"><strong><i class="fa-solid fa-circle-info mr-10"></i> Please keep this registration number safe. You will need it for any future inquiries or communication with our team.</strong> <span class="d-block fw-normal fw-normal">A confirmation email with your registration details has also been sent to: {{ $registration->email }}.</span></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p >The event will be held at <strong>Centara Grand & Bangkok Convention Centre at CentralWorld, 23rd Floor</strong>.  
            This venue is conveniently located in the heart of Bangkok, directly connected to the BTS Skytrain and surrounded by shopping, dining, and cultural attractions.</p>
            <p class="mb-0">
            For more detailed information about the venue, please visit   
            <a href="https://www.apsoprs-thaisoprs2025.com/venue" target="_blank" class="stock in-stock text-theme"><i class="fa-solid fa-circle-info ms-3"></i> Venue Page &gt;&gt;</a></p>
                
            </div>
        </div>

    </div>
</div>
@endsection