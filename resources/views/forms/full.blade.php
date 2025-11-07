@extends('layouts.app')

@section('content')

<div class="th-checkout-wrapper space-extra">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="alert alert-warning text-center my-5">
                    <h2>{{ $event }} Registration Closed</h2>
                    <p>We are sorry, but the registration for <strong>{{ $event }}</strong> has been closed.</p>
                    <p>Please contact our team if you have any questions.</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection