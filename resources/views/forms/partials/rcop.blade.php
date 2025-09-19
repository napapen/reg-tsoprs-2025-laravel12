<div id="banktransferWindow" class="row">
    <div class="col-12">
        <table class="cart_table cart_totals mb-0 mb-lg-30">
            <tbody>
                <tr>
                    <td>Payment Method</td>
                    <td class="text-center text-lg-start" colspan="4">
                        <span class="h6 mb-0">Direct Bank Transfer</span>
                    </td>
                </tr>
                <tr>
                    <td class="fs-md">Bank Account Detail</td>
                    <td class="text-center text-lg-start" colspan="4">

                        <div class="row my-10">
                            <div class="col-12 d-flex align-items-center justify-content-center  justify-content-lg-start">
                                <img src="{{ asset('frontend/img/icon/ktb1x1.png') }}"
                                    width="30px" height="30px" class="rounded-circle mr-5" />
                                Krungthai Bank (KTB)
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-center  justify-content-lg-start">
                                ราชวิทยาลัยจักษุแพทย์แห่งประเทศไทย
                            </div>
                            {{-- justify-content-center --}}
                            <div class="col-12 d-flex align-items-center justify-content-center  justify-content-lg-start">
                                <span id="bankAccount" class="h6 mb-0">041-0-16252-3</span>
                                <button type="button" class="btn btn-sm btn-outline-primary ms-2"
                                    onclick="copyBankAccount()">Copy</button>
                            </div>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-center text-lg-start" colspan="4">
                        <h6 class="mb-0"> {{ $payment_total }}</h6>
                    </td>
                </tr>
                <tr>
                    <td>Payment Confirmation <span class="text-error">*</span></td>
                    <td class="text-center text-lg-start" colspan="4">
                        <div class="row mt-10">
                            <div class="col-lg-8">
                                <input type="file" name="pay_slip_rcopt" class="form-control mb-0" />
                            </div>
                        </div>
                        <div class="row mb-10">
                            <div class="col-12">
                                <span class="fw-normal">* Proof of payment (File size not over 10
                                    MB)</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>