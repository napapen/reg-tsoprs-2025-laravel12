<div id="creditcardWindow" class="row">
    <div class="col-12">
        <table class="cart_table cart_totals mb-0 mb-lg-30">
            <tbody>
                <tr>
                    <td>Payment Method</td>
                    <td class="text-center text-lg-start" colspan="4">
                        <div class="row">
                            {{-- justify-content-center --}}
                            <div class="col-12 d-flex align-items-center justify-content-center  justify-content-lg-start">
                                <span class="h6 mb-0">Credit Card</span>
                                <span class="fw-normal text-mute ps-2 mt-0">secured by
                                    <a href="https://www.kasikornbank.com/" target="_blank"
                                        title="secured by Kbank"><img
                                            src="{{ asset('frontend/img/icon/kbank-logo.png') }}"
                                            width="70px" style="margin-top:-4px"
                                            class="" /></a></span>
                            </div>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-center text-lg-start" colspan="4">
                        <div class="row">
                            <div class="col-12 mb-2 d-flex align-items-center justify-content-center  justify-content-lg-start">
                                <span class="h6 mb-0">{{ $payment_total }}</span>
                                <a href="{{ $payment_link }}" target="_blank"
                                    class="btn btn-sm btn-outline-success ms-2">Pay Now <i
                                        class="fa-solid fa-up-right"></i></a>
                            </div>
                            <div class="col-12">
                                <p class="mb-0"><span class="text-muted">After clicking "Pay Now", you will be redirected to the secure payment gateway page to complete your transaction.</span><br/>
                                *Once you have completed the payment, please provide the date and time of your transaction to confirm your registration.</p>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Payment Confirmation <span class="text-error">*</span></td>
                    <td class="text-center text-lg-start" colspan="4">
                        <div class="row justify-content-center  justify-content-lg-start">
                            <div class="col-8 col-lg-3 form-group mb-lg-0">
                                <label class="text-title mb-0 text-center">Pay Date <span class="text-error">*</span></label>
                                <input type="text" name="pay_date" id="paydate" class="form-control mb-0 text-center text-lg-start" placeholder="DD/MM/YYYY">
                            </div>
                            <div class="col-6 col-lg-2 form-group mb-0">
                                <label class="text-title mb-0 text-center">Hour <span class="text-error">*</span></label>
                                <select name="pay_hour" class="form-select mb-0">
                                    @for ($h = 0; $h <= 23; $h++)
                                        @php
                                            $hour = str_pad($h, 2, '0', STR_PAD_LEFT);
                                        @endphp
                                        <option value="{{ $hour }}">{{ $hour }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-6 col-lg-2 form-group mb-0">
                                <label class="text-title mb-0 text-center">Min <span class="text-error">*</span></label>
                                <select name="pay_min" class="form-select mb-0">
                                    @for ($m = 0; $m <= 59; $m++)
                                        @php
                                            $min = str_pad($m, 2, '0', STR_PAD_LEFT);
                                        @endphp
                                        <option value="{{ $min }}">{{ $min }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>