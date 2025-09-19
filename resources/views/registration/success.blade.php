@extends('layouts.app')

@section('content')
<div class="th-checkout-wrapper space-extra">
    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3><i class="fa-solid fa-hashtag  fw-normal me-2 text-theme"></i> Registration Successful</h3>
                <p class="lead">
                    Thank you, <strong>{{ $registration->full_name }}</strong>, for registering.
                </p>

                <p class="fs-5">
                    Your registration number is:  
                    <span class="fw-bold text-theme">{{ $registration->transid }}</span>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="bg-smoke px-20 py-10">
                    <h6 class="text-center text-lg-start text-theme mb-0"><i class="fa-solid fa-circle-info mr-10"></i> Please keep this number for future reference when contacting our team. <span class="d-block d-lg-inline fw-normal fw-normal">An email with your registration details has also been sent to your provided email address.</span></h6>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection