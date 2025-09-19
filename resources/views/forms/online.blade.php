@extends('layouts.app')

@section('title', 'Online Lecture Registration')

@section('content')
<div class="th-checkout-wrapper space-extra">
    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3><i class="fa-solid fa-hashtag  fw-normal me-2 text-theme"></i> Online Lecture Register</h3>  
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
                                        <td data-title="Online Lecture"><strong class="fs-md">1,700 THB</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>  

                    @include('forms.partials.mainfield')

                    @include('forms.partials.international', [
                        'payment_total' => "1,700 THB", 
                        'payment_link' => "https://kpaymentgateway-services.kasikornbank.com/KPGW-Redirect-Webapi/Redirect/Link/plink_prod_143831caec7afb9ae44b38a53343d1cd86e40"
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

@include('forms.partials.scriptvalidate')

@endsection
