@extends('layouts.app')

@section('title', 'Onsite Lecture Registration')

@section('content')
    <div class="th-checkout-wrapper space-extra">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <h3><i class="fa-solid fa-hashtag  fw-normal me-2 text-theme"></i> Onsite Lecture Register</h3>
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
                                            <td data-title="Onsite Lecture"><strong class="fs-md">1,000 THB</strong></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>
                                                <input type="radio" id="nonrcopt" name="registration_type"
                                                    value="nonrcopt">
                                                <label for="nonrcopt"> &nbsp;Non-RCOPT Thai Delegates</label>
                                            </td>
                                            <td data-title="Onsite Lecture"><strong class="fs-md">3,000 THB</strong></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>
                                                <input type="radio" id="international" name="registration_type"
                                                    value="international">
                                                <label for="international"> &nbsp;International Delegates</label>
                                            </td>
                                            <td data-title="Onsite Lecture"><strong class="fs-md">3,000 THB</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @include('forms.partials.mainfield')
                        
                        @include('forms.partials.rcop', [
                            'payment_total' => "1,000 THB", 
                        ])
                         
                        @include('forms.partials.nonrcop', [
                            'payment_total' => "3,000 THB", 
                        ])

                        @include('forms.partials.international', [
                            'payment_total' => "3,000 THB", 
                            'payment_link' => "https://kpaymentgateway-services.kasikornbank.com/KPGW-Redirect-Webapi/Redirect/Link/plink_prod_14383e2d08d3b5310467ab469ede0811ae151"
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