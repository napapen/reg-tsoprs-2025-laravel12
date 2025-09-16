@extends('layouts.app')

@section('title', 'Onsite Registration')

@section('content')
    <div class="th-checkout-wrapper space-extra">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <h4 class="mt-4 pt-lg-2"><i class="fa-solid fa-hashtag  fw-normal me-2 text-theme"></i> Onsite Lecture
                        Register</h4>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('onsite.store') }}"
                        class="woocommerce-form-login mb-3">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <h2 class="h4 d-lg-none mb-0 mb-lg-3">Choose Category</h2>
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
                        <div class="row">
                            <div class="col-12 form-group">
                                <label class="text-title">Full Name <span class="text-error">*</span></label>
                                <input type="text" name="full_name" class="form-control" placeholder="Full Name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="text-title">Email Address <span class="text-error">*</span></label>
                                <input type="text" name="email" class="form-control" placeholder="Email Address" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-title">Mobile Number/Whatsapp/LINE Number (Optional)</label>
                                <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="text-title">Institution/Practice Organization <span
                                        class="text-error">*</span></label>
                                <input name="institution" type="text" class="form-control" placeholder="Institution" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-title">Country of Practice <span class="text-error">*</span></label>
                                <select name="country">
                                    <option value="">-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="text-title">Specialty/Subspecialty</label>
                                <ul class="list-unstyled">
                                    <li>
                                        <input type="radio" id="general" name="specialty" value="General practitioner">
                                        <label for="general">General practitioner</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="ophthalmologist" name="specialty" value="Ophthalmologist"
                                            checked>
                                        <label for="ophthalmologist">Ophthalmologist</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="oculoplastic" name="specialty"
                                            value="Oculoplastic Surgeon">
                                        <label for="oculoplastic">Oculoplastic Surgeon</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="plastic" name="specialty" value="Plastic Surgeon">
                                        <label for="plastic">Plastic Surgeon</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="resident" name="specialty" value="Resident/Fellow">
                                        <label for="resident">Resident/Fellow</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="specialtyother" name="specialty" value="Other">
                                        <label for="specialtyother">Other</label>
                                    </li>
                                    <li id="specialtyOtherInputWrapper" style="display: none;">
                                        <input type="text" name="specialty_other_text" class="form-control w-50 mb-0 mt-0 ms-3" placeholder="Please specify" />
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-title">What type of camera will you be bringing during the
                                    workshop?</label>
                                <ul class="list-unstyled">
                                    <li>
                                        <input type="checkbox" id="cameratype1" name="cameratype[]" value="DSLR camera">
                                        <label for="cameratype1">DSLR camera</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype2" name="cameratype[]"
                                            value="Mirrorless camera">
                                        <label for="cameratype2">Mirrorless camera</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype3" name="cameratype[]"
                                            value="Compact digital camera">
                                        <label for="cameratype3">Compact digital camera</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype4" name="cameratype[]"
                                            value="Smartphone Andriod">
                                        <label for="cameratype4">Smartphone Andriod</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype5" name="cameratype[]"
                                            value="Smartphone Apple">
                                        <label for="cameratype5">Smartphone Apple</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype6" name="cameratype[]" value="Other">
                                        <label for="cameratype6">Other</label>
                                    </li>
                                    <li id="cameratypeOtherInputWrapper" style="display:none;">
                                        <input type="text" name="cameratype_other_text" class="form-control w-50 mb-0 mt-0 ms-3" placeholder="Please specify">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label class="text-title">Please specify the brand/model of your smartphone or camera
                                    (optional).<br />
                                    <span class="fw-light fst-italic">(e.g., iPhone, Android phone, Canon EOS R6, Sony
                                        A6400, Fujifilm X100V)</span></label>
                                <input type="text" name="camera_brand" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="text-title">What are you most interested in learning during the
                                    workshop?</label>
                                <ul class="list-unstyled">
                                    <li>
                                        <input type="checkbox" id="workshop_topics1" name="workshop_topics[]"
                                            value="workshop_topics1">
                                        <label for="workshop_topics1">How to take standardized clinical photos for
                                            eyelid/orbital conditions</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="workshop_topics2" name="workshop_topics[]"
                                            value="workshop_topics2">
                                        <label for="workshop_topics2">How to pose patients and control lighting for
                                            portraits</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="workshop_topics3" name="workshop_topics[]"
                                            value="workshop_topics3">
                                        <label for="workshop_topics3">How to take effective before/after photos using a
                                            smartphone</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="workshop_topics4" name="workshop_topics[]"
                                            value="workshop_topics4">
                                        <label for="workshop_topics4">How to create teaching videos in the OR</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="workshop_topics5" name="workshop_topics[]"
                                            value="workshop_topics5">
                                        <label for="workshop_topics5">How to edit and organize photo/video files</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="workshop_topics6" name="workshop_topics[]"
                                            value="workshop_topics6">
                                        <label for="workshop_topics6">How to present content professionally on social
                                            media</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="workshop_topics7" name="workshop_topics[]"
                                            value="workshop_topics7">
                                        <label for="workshop_topics7">How to choose affordable gear for clinical
                                            photography</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-title">How would you rate your photography experience?</label>
                                <ul class="list-unstyled">
                                    <li>
                                        <input type="radio" id="beginner" name="photography_experience"
                                            value="beginner" required checked>
                                        <label for="beginner">Beginner</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="intermediate" name="photography_experience"
                                            value="intermediate">
                                        <label for="intermediate">Intermediate</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="advanced" name="photography_experience"
                                            value="advanced">
                                        <label for="advanced">Advanced</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label class="text-title">Other topics you're hoping to learn or questions you'd like
                                    addressed?</label>
                                <textarea name="other_topics" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label class="text-title">Do you have any photo or video equipment you'd like to bring or
                                    ask about during the workshop?</label>
                                <textarea name="equipment_questions" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="bg-theme px-20 py-10">
                                    <h6 class="text-white mb-0"><i class="fa-solid fa-circle-info mr-10"></i> Make a
                                        Payment to Secure Your Spot ! <span class="fw-normal">- limited seats
                                            available</span></h6>
                                </div>
                            </div>
                        </div>
                        <div id="banktransferWindow" class="row">
                            <div class="col-12">
                                <table class="cart_table mb-20">
                                    <tbody class="checkout-ordertable">
                                        <tr>
                                            <th style="width:25%">Payment Method</th>
                                            <td data-title="Payment Method" class="text-start" colspan="4">
                                                <span class="h6 mb-0">Direct Bank Transfer</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Bank Account Detail</th>
                                            <td data-title="Bank Account" class="text-start" colspan="4">

                                                <div class="row my-10">
                                                    <div class="col-12">
                                                        <img src="{{ asset('frontend/img/icon/ktb1x1.png') }}"
                                                            width="30px" height="30px" class="rounded-circle mr-5" />
                                                        Krungthai Bank (KTB)
                                                    </div>
                                                    <div class="col-12 d-flex align-items-center ">
                                                        ราชวิทยาลัยจักษุแพทย์แห่งประเทศไทย
                                                    </div>
                                                    {{-- justify-content-center --}}
                                                    <div class="col-12 d-flex align-items-center ">
                                                        <span id="bankAccount" class="h6 mb-0">041-0-16252-3</span>
                                                        <button type="button" class="btn btn-sm btn-outline-primary ms-2"
                                                            onclick="copyBankAccount()">Copy</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td data-title="Total" class="text-start" colspan="4">
                                                <h6 class="mb-0">1,000 THB</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Payment Confirmation <span class="text-error">*</span></th>
                                            <td data-title="Total" class="text-start" colspan="4">
                                                <div class="row mt-10">
                                                    <div class="col-6">
                                                        <input type="file" name="photo" />
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
                        <div id="banktransferWindowNonRCOPT" class="row">
                            <div class="col-12">
                                <table class="cart_table mb-20">
                                    <tbody class="checkout-ordertable">
                                        <tr>
                                            <th style="width:25%">Payment Method</th>
                                            <td data-title="Payment Method" class="text-start" colspan="4">
                                                <span class="h6 mb-0">Direct Bank Transfer</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Bank Account Detail</th>
                                            <td data-title="Bank Account" class="text-start" colspan="4">

                                                <div class="row my-10">
                                                    <div class="col-12">
                                                        <img src="{{ asset('frontend/img/icon/ktb1x1.png') }}"
                                                            width="30px" height="30px" class="rounded-circle mr-5" />
                                                        Krungthai Bank (KTB)
                                                    </div>
                                                    <div class="col-12 d-flex align-items-center ">
                                                        ราชวิทยาลัยจักษุแพทย์แห่งประเทศไทย
                                                    </div>
                                                    {{-- justify-content-center --}}
                                                    <div class="col-12 d-flex align-items-center ">
                                                        <span id="bankAccount" class="h6 mb-0">041-0-16252-3</span>
                                                        <button type="button" class="btn btn-sm btn-outline-primary ms-2"
                                                            onclick="copyBankAccount()">Copy</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td data-title="Total" class="text-start" colspan="4">
                                                <h6 class="mb-0">3,000 THB</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Payment Confirmation <span class="text-error">*</span></th>
                                            <td data-title="Total" class="text-start" colspan="4">
                                                <div class="row mt-10">
                                                    <div class="col-6">
                                                        <input type="file" name="photo" />
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
                        <div id="creditcardWindow" class="row">
                            <div class="col-12">
                                <table class="cart_table mb-20">
                                    <tbody class="checkout-ordertable">
                                        <tr>
                                            <th style="width:25%">Payment Method</th>
                                            <td data-title="Payment Method" class="text-start" colspan="4">
                                                <div class="row">
                                                    {{-- justify-content-center --}}
                                                    <div class="col-12 d-flex align-items-center ">
                                                        <span class="h6 mb-0">Credit Card</span>
                                                        <span class="fw-normal text-mute ps-2 mt-1">secured by
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
                                            <th>Total</th>
                                            <td data-title="Total" class="text-start" colspan="4">
                                                <div class="row my-10">
                                                    <div class="col-12 d-flex align-items-center ">
                                                        <span class="h6 mb-0">3,000 THB</span>
                                                        <a href="#" target="_blank"
                                                            class="btn btn-sm btn-outline-success ms-2">Pay Now <i
                                                                class="fa-solid fa-up-right"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Payment Confirmation <span class="text-error">*</span></th>
                                            <td data-title="Total" class="text-start" colspan="4">
                                                <div class="row my-10">
                                                    <div class="col-lg-3 form-group my-0">
                                                        <label class="text-title mb-0 text-center">Pay Date <span class="text-error">*</span></label>
                                                        <input type="text" name="paydate" id="paydate" class="form-control mb-0" placeholder="DD/MM/YYYY" required>
                                                    </div>
                                                    <div class="col-lg-2 form-group my-0">
                                                        <label class="text-title mb-0 text-center">Hour <span class="text-error">*</span></label>
                                                        <select name="payhour" class="form-select mb-0" required>
                                                            @for ($h = 0; $h <= 23; $h++)
                                                                @php
                                                                    $hour = str_pad($h, 2, '0', STR_PAD_LEFT);
                                                                @endphp
                                                                <option value="{{ $hour }}">{{ $hour }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2 form-group my-0">
                                                        <label class="text-title mb-0 text-center">Min <span class="text-error">*</span></label>
                                                        <select name="paymin" class="form-select mb-0" required>
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
                        <div class="row">
                            <div class="col-12 form-btn">
                                <button type="submit" class="th-btn style4">Register Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

<script>
    function copyBankAccount() {
        const account = document.getElementById('bankAccount')?.innerText || '';
        if (!account) {
            alert('ไม่พบเลขบัญชีที่จะคัดลอก');
            return;
        }
        navigator.clipboard.writeText(account).then(() => {
            alert('Copied: ' + account);
        }).catch(err => {
            console.error('Failed to copy: ', err);
            alert('ไม่สามารถคัดลอกได้');
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        // --- Payment windows toggle ---
        const banktransferWindow = document.getElementById("banktransferWindow");
        const banktransferWindowNonRCOPT = document.getElementById("banktransferWindowNonRCOPT");
        const creditcardWindow = document.getElementById("creditcardWindow");
        const registrationTypeRadios = document.querySelectorAll("input[name='registration_type']");

        function togglePaymentWindow() {
            // ซ่อนทุก window ถ้า element มีตัวจริง
            if (banktransferWindow) banktransferWindow.style.display = "none";
            if (banktransferWindowNonRCOPT) banktransferWindowNonRCOPT.style.display = "none";
            if (creditcardWindow) creditcardWindow.style.display = "none";

            const checked = document.querySelector("input[name='registration_type']:checked");
            const selected = checked ? checked.value : null;

            if (selected === "rcopt" && banktransferWindow) {
                banktransferWindow.style.display = "block";
            } else if (selected === "nonrcopt" && banktransferWindowNonRCOPT) {
                banktransferWindowNonRCOPT.style.display = "block";
            } else if (selected === "international" && creditcardWindow) {
                creditcardWindow.style.display = "block";
            }
        }

        registrationTypeRadios.forEach(r => r.addEventListener("change", togglePaymentWindow));
        togglePaymentWindow(); // init

        // --- Specialty "Other" toggle (radio) ---
        const specialtyRadios = document.querySelectorAll("input[name='specialty']");
        const specialtyOtherWrapper = document.getElementById("specialtyOtherInputWrapper");

        function toggleSpecialtyOther() {
            if (!specialtyOtherWrapper) return;
            const checked = document.querySelector("input[name='specialty']:checked");
            specialtyOtherWrapper.style.display = (checked && checked.value === "Other") ? "block" : "none";
        }

        specialtyRadios.forEach(r => r.addEventListener("change", toggleSpecialtyOther));
        toggleSpecialtyOther(); // init

        // --- Cameratype "Other" toggle (checkbox) ---
        const cameraOtherCheckbox = document.getElementById("cameratype6");
        const cameraOtherWrapper = document.getElementById("cameratypeOtherInputWrapper");

        function toggleCameraOther() {
            if (!cameraOtherWrapper) return;
            if (!cameraOtherCheckbox) {
                cameraOtherWrapper.style.display = "none";
                return;
            }
            cameraOtherWrapper.style.display = cameraOtherCheckbox.checked ? "block" : "none";
        }

        if (cameraOtherCheckbox) {
            cameraOtherCheckbox.addEventListener("change", toggleCameraOther);
        }
        toggleCameraOther(); // init
    });

    $(document).ready(function(){
        $('#paydate').datetimepicker({
            timepicker: false,       // ปิดเลือกเวลา
            format: 'd/m/Y',         // ฟอร์แมต dd/mm/yyyy
            scrollInput: false,       // ป้องกัน scroll เปลี่ยนวัน
            maxDate: 0,                // จำกัดเลือกวันที่ไม่เกินวันนี้
            allowMonthChange: false,   // ปิดการเปลี่ยนเดือน
            allowYearChange: false     // ปิดการเปลี่ยนปี
        });
    });
</script>



@endsection
