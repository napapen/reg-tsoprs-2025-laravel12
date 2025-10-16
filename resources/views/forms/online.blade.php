@extends('layouts.app')

@section('title', 'Online Lecture Registration')

@section('content')
@php
    use Carbon\Carbon;

    // กำหนดเวลาที่ต้องการเปรียบเทียบ (16 ต.ค. 2025 เวลา 14:00)
    $deadline = Carbon::create(2025, 10, 16, 14, 0, 0, 'Asia/Bangkok');
    $priceInter = "1,700 THB";
    $paymentLink = "https://kpaymentgateway-services.kasikornbank.com/KPGW-Redirect-Webapi/Redirect/Link/plink_prod_143831caec7afb9ae44b38a53343d1cd86e40";
    if (now()->greaterThan($deadline))
    {
        $priceInter = "1,900 THB";
        $paymentLink = "https://kpaymentgateway-services.kasikornbank.com/KPGW-Redirect-Webapi/Redirect/Link/plink_prod_143839566f5c75389490fa4825a43de4e9b5a";
    }
@endphp
<div class="th-checkout-wrapper space-extra">
    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3><i class="fa-solid fa-hashtag  fw-normal me-2 text-theme"></i> Online Lecture Register</h3>  
                    <p class="mb-0">This rate for international delegates already includes processing fees.</p>
                    <p class="text-end"><a href="https://www.apsoprs-thaisoprs2025.com/sessions/lecture" target="_blank" class="stock in-stock text-theme"><i class="fa-solid fa-circle-info"></i> See our sessions &gt;&gt;</a></p>

                    @if($errors->has('limit'))
                        <div class="alert alert-danger">
                            {{ $errors->first('limit') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('online.store') }}" enctype="multipart/form-data" class="woocommerce-form-login mb-0 py-4 needs-validation" novalidate>
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <table class="cart_table cart_totals prices mb-30">
                                <thead>
                                    <tr class="bg-gray text-center">
                                        <th>Choose Category</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>
                                            <input type="radio" id="international" name="registration_type"
                                                value="international" checked>
                                            <label for="international"> &nbsp;International Delegates</label>
                                        </td>
                                        <td data-title="Online Lecture"><strong class="fs-md">{{$priceInter}}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>  

                    @include('forms.partials.mainfield', ['event_type' => 'online'])

                    @include('forms.partials.international', [
                        'payment_total' => "$priceInter", 
                        'payment_link' => "$paymentLink"
                    ])

                    <div class="row">
                        <div class="d-grid gap-2 d-lg-block">
                            <button type="submit" class="th-btn style4 mt-3">Register Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@include('forms.partials.scriptmain')
@include('forms.partials.scriptvalidate')

@endsection
