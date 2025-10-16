@extends('layouts.app')

@section('title', 'Onsite Lecture Registration')

@section('content')
@php
    use Carbon\Carbon;

    // กำหนดเวลาที่ต้องการเปรียบเทียบ (16 ต.ค. 2025 เวลา 14:00)
    $deadline = Carbon::create(2025, 10, 16, 14, 0, 0, 'Asia/Bangkok');
    $priceRCOPT = "1,000 THB";
    $priceNonRCOPT = "3,000 THB";
    $priceInter = "3,000 THB";
    $paymentLink = "https://kpaymentgateway-services.kasikornbank.com/KPGW-Redirect-Webapi/Redirect/Link/plink_prod_14383e2d08d3b5310467ab469ede0811ae151";
    if (now()->greaterThan($deadline))
    {
        $priceRCOPT = "1,250 THB";
        $priceNonRCOPT = "3,300 THB";
        $priceInter = "3,300 THB";
        $paymentLink = "https://kpaymentgateway-services.kasikornbank.com/KPGW-Redirect-Webapi/Redirect/Link/plink_prod_143838632230dac8b4ec389e5f395500b5f42";
    }
@endphp

    <div class="th-checkout-wrapper space-extra">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3><i class="fa-solid fa-hashtag  fw-normal me-2 text-theme"></i> Onsite Lecture Register</h3>
                    <p class="mb-0">This rate for international delegates already includes processing fees.</p>
                    <p class="text-end"><a href="https://www.apsoprs-thaisoprs2025.com/sessions/lecture" target="_blank" class="stock in-stock text-theme"><i class="fa-solid fa-circle-info"></i> See our sessions &gt;&gt;</a></p>

                    @if($errors->has('limit'))
                        <div class="alert alert-danger">
                            {{ $errors->first('limit') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('onsite.store') }}" enctype="multipart/form-data" class="woocommerce-form-login mb-0 py-4 needs-validation" novalidate>
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
                                                <input type="radio" id="rcopt" name="registration_type" value="rcopt"
                                                    required checked>
                                                <label for="rcopt"> &nbsp;RCOPT Delegates</label>
                                            </td>
                                            <td data-title="Onsite Lecture"><strong class="fs-md">{{$priceRCOPT}}</strong></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>
                                                <input type="radio" id="nonrcopt" name="registration_type"
                                                    value="nonrcopt">
                                                <label for="nonrcopt"> &nbsp;Non-RCOPT Thai Delegates</label>
                                            </td>
                                            <td data-title="Onsite Lecture"><strong class="fs-md">{{$priceNonRCOPT}}</strong></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>
                                                <input type="radio" id="international" name="registration_type"
                                                    value="international">
                                                <label for="international"> &nbsp;International Delegates</label>
                                            </td>
                                            <td data-title="Onsite Lecture"><strong class="fs-md">{{$priceInter}}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @include('forms.partials.mainfield', ['event_type' => 'onsite'])
                        
                        @include('forms.partials.rcop', [
                            'payment_total' => "$priceRCOPT", 
                        ])
                         
                        @include('forms.partials.nonrcop', [
                            'payment_total' => "$priceNonRCOPT", 
                        ])

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