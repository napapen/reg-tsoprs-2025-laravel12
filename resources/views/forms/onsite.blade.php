@extends('layouts.app')

@section('title', 'Onsite Registration')

@section('content')
    <div class="th-checkout-wrapper space-extra">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <h4><i class="fa-solid fa-hashtag  fw-normal me-2 text-theme"></i> Onsite Lecture
                        Register</h4>
                        <form method="POST" action="{{ route('onsite.store') }}" enctype="multipart/form-data"
                        class="woocommerce-form-login mb-0 py-4 needs-validation" novalidate>
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
                        <div class="row mb-3">
                            <div class="col-12 form-group mb-0">
                                <label class="text-title mb-1">Full Name <span class="text-error">*</span></label>
                                <input type="text" name="full_name" class="form-control mb-0" placeholder="Full Name" required/>
                                <div class="invalid-feedback ps-3">Please enter your full name.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 form-group mb-3 mb-lg-0">
                                <label class="text-title mb-1">Email Address <span class="text-error">*</span></label>
                                <input type="email" name="email" class="form-control mb-0" placeholder="Email Address" required/>
                                <div class="invalid-feedback ps-3">Please enter a valid email address.</div>
                            </div>
                            <div class="col-lg-6 form-group mb-0">
                                <label class="text-title mb-1">Mobile Number/Whatsapp/LINE Number (Optional)</label>
                                <input type="text" name="mobile" class="form-control  mb-0" placeholder="Mobile Number" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 form-group mb-3 mb-lg-0">
                                <label class="text-title mb-1">Institution/Practice Organization <span
                                        class="text-error">*</span></label>
                                <input name="institution" type="text" class="form-control  mb-0" placeholder="Institution" required/>
                                <div class="invalid-feedback ps-3">Please enter your Institution/Practice Organization</div>
                            </div>
                            <div class="col-lg-6 form-group mb-0">
                                <label class="text-title mb-1">Country of Practice <span class="text-error">*</span></label>
                                <select name="country" class="mb-0" required>
                                    <option value="">-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback ps-3">Please select your Country of Practice</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 form-group mb-3 mb-lg-0">
                                <label class="text-title mb-2">Specialty/Subspecialty</label>
                                <ul class="list-unstyled mb-0">
                                    <li>
                                        <input type="radio" id="specialty1" name="specialty" value="specialty1">
                                        <label for="specialty1">General practitioner</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="specialty2" name="specialty" value="specialty2"
                                            checked>
                                        <label for="specialty2">Ophthalmologist</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="specialty3" name="specialty" value="specialty3">
                                        <label for="specialty3">Oculoplastic Surgeon</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="specialty4" name="specialty" value="specialty4">
                                        <label for="specialty4">Plastic Surgeon</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="specialty5" name="specialty" value="specialty5">
                                        <label for="specialty5">Resident/Fellow</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="specialty99" name="specialty" value="specialty99">
                                        <label for="specialty99">Other</label>
                                    </li>
                                    <li id="specialtyOtherInputWrapper" style="display: none;">
                                        <input type="text" name="specialty_other" class="form-control w-50 mb-0 mt-0 ms-3" placeholder="Please specify" />
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6 form-group mb-0">
                                <label class="text-title mb-2">What type of camera will you be bringing during the
                                    workshop?</label>
                                <ul class="list-unstyled  mb-0">
                                    <li>
                                        <input type="checkbox" id="cameratype1" name="camera_type[]" value="cameratype1">
                                        <label for="cameratype1">DSLR camera</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype2" name="camera_type[]"
                                            value="cameratype2">
                                        <label for="cameratype2">Mirrorless camera</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype3" name="camera_type[]"
                                            value="cameratype3">
                                        <label for="cameratype3">Compact digital camera</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype4" name="camera_type[]"
                                            value="cameratype4">
                                        <label for="cameratype4">Smartphone Andriod</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype5" name="camera_type[]" value="cameratype5">
                                        <label for="cameratype5">Smartphone Apple</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype99" name="camera_type[]" value="cameratype99">
                                        <label for="cameratype99">Other</label>
                                    </li>
                                    <li id="cameratypeOtherInputWrapper" style="display:none;">
                                        <input type="text" name="camera_type_other" class="form-control w-50 mb-0 mt-0 ms-3" placeholder="Please specify">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 form-group mb-0">
                                <label class="text-title mb-1">Please specify the brand/model of your smartphone or camera
                                    (optional).<br />
                                    <span class="fw-light fst-italic">(e.g., iPhone, Android phone, Canon EOS R6, Sony
                                        A6400, Fujifilm X100V)</span></label>
                                <input type="text" name="camera_brand" class="form-control mb-0" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 form-group mb-3 mb-lg-0">
                                <label class="text-title mb-2">What are you most interested in learning during the
                                    workshop?</label>
                                <ul class="list-unstyled mb-0">
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
                            <div class="col-lg-6 form-group mb-0">
                                <label class="text-title mb-2">How would you rate your photography experience?</label>
                                <ul class="list-unstyled mb-0">
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
                        <div class="row mb-3">
                            <div class="col-12 form-group">
                                <label class="text-title mb-1">Other topics you're hoping to learn or questions you'd like
                                    addressed?</label>
                                <textarea name="other_topics" class="form-control mb-0"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 form-group">
                                <label class="text-title mb-1">Do you have any photo or video equipment you'd like to bring or
                                    ask about during the workshop?</label>
                                <textarea name="equipment_questions" class="form-control mb-0"></textarea>
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
                                                <h6 class="mb-0">1,000 THB</h6>
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
                        <div id="banktransferWindowNonRCOPT" class="row">
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
                                            <td>Bank Account Detail</td>
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
                                                <h6 class="mb-0">3,000 THB</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Payment Confirmation <span class="text-error">*</span></td>
                                            <td class="text-center text-lg-start" colspan="4">
                                                <div class="row mt-10">
                                                    <div class="col-lg-8">
                                                        <input type="file" name="pay_slip_nonrcopt" class="form-control mb-0" />
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
                                                <div class="row my-10">
                                                    <div class="col-12 d-flex align-items-center justify-content-center  justify-content-lg-start">
                                                        <span class="h6 mb-0">3,000 THB</span>
                                                        <a href="https://kpaymentgateway-services.kasikornbank.com/KPGW-Redirect-Webapi/Redirect/Link/plink_prod_14383e2d08d3b5310467ab469ede0811ae151" target="_blank"
                                                            class="btn btn-sm btn-outline-success ms-2">Pay Now <i
                                                                class="fa-solid fa-up-right"></i></a>
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
        console.log("JS loaded");
        //##### VALIDATE
        const form = document.querySelector("form.needs-validation");

        console.log("form found?", form);  // debug
        
        form.addEventListener("submit", function (event) {
            // alert("submit");
            let valid = true;
            let firstInvalid = null;

            form.querySelectorAll("[required]").forEach(function (input) {
                let inputValid = true;

                // --- เช็คประเภท element ---
                if (input.tagName.toLowerCase() === "select") {
                    // ถ้าเป็น select ต้องเลือก option ที่ไม่ใช่ "" 
                    if (!input.value || input.value.trim() === "") {
                        inputValid = false;
                    }
                } else {
                    // input, textarea
                    if (!input.value.trim()) {
                        inputValid = false;
                    }

                    // validate email format
                    if (inputValid && input.type === "email") {
                        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailPattern.test(input.value.trim())) {
                            inputValid = false;
                        }
                    }
                }

                // --- จัดการ class error ---
                if (!inputValid) {
                    input.classList.add("is-invalid");
                    valid = false;
                    if (!firstInvalid) {
                        firstInvalid = input;
                    }
                } else {
                    input.classList.remove("is-invalid");
                }
            });

            if (!valid) {
                console.log("form invalid");
                event.preventDefault();
                event.stopPropagation();

                // focus + scroll ไปยังช่องที่ error ตัวแรก
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
                }
            }else{
                 console.log("form valid → submit ไป backend");
                 form.submit(); // ให้มันไปจริง
            }
        }); 
        //##### END - VALIDATE

        //##### Payment windows toggle
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
        //##### END - Payment windows toggle

        //##### PAY SLIP REQUIRED BY REGISTRATION TYPE
        const registrationRadios = document.querySelectorAll("input[name='registration_type']");

        const bankSlipRCOPT   = document.querySelector("#banktransferWindow input[name='pay_slip_rcopt']");
        const bankSlipNonRCOPT = document.querySelector("#banktransferWindowNonRCOPT input[name='pay_slip_nonrcopt']");
        const payDateIntl     = document.querySelector("#creditcardWindow input[name='pay_date']");

        function updatePaymentRequired() {
            const checked = document.querySelector("input[name='registration_type']:checked");
            if (!checked) return;

            //alert(checked.value);
            // reset required ก่อนทุกครั้ง
            if (bankSlipRCOPT)   { bankSlipRCOPT.removeAttribute("required");   bankSlipRCOPT.classList.remove("is-invalid"); }
            if (bankSlipNonRCOPT){ bankSlipNonRCOPT.removeAttribute("required");bankSlipNonRCOPT.classList.remove("is-invalid"); }
            if (payDateIntl)     { payDateIntl.removeAttribute("required");     payDateIntl.classList.remove("is-invalid"); }

            // ใส่ required ตามเงื่อนไข
            if (checked.value === "rcopt" && bankSlipRCOPT) {
                bankSlipRCOPT.setAttribute("required", "required");
            } 
            else if (checked.value === "nonrcopt" && bankSlipNonRCOPT) {
                bankSlipNonRCOPT.setAttribute("required", "required");
            } 
            else if (checked.value === "international" && payDateIntl) {
                payDateIntl.setAttribute("required", "required");
            }
        }

        // bind event
        registrationRadios.forEach(r => r.addEventListener("change", updatePaymentRequired));

        // run on load
        updatePaymentRequired();
        //##### END - PAY SLIP REQUIRED


        //##### PAYDATE FOR CREDITCARD
        const paydate = document.getElementById("paydate");
        const nonrcoptRadio = document.querySelector("input[name='registration_type'][value='nonrcopt']");

        function togglePaydateRequired() {
            if (nonrcoptRadio.checked) {
                paydate.setAttribute("required", "required");
            } else {
                paydate.removeAttribute("required");
                paydate.classList.remove("is-invalid"); // reset error
            }
        }

        // ตอนเปลี่ยน radio
        document.querySelectorAll("input[name='registration_type']").forEach(radio => {
            radio.addEventListener("change", togglePaydateRequired);
        });

        // เช็คตอนโหลด
        togglePaydateRequired();
        //##### END - PAYDATE FOR CREDITCARD

        //##### Specialty&Camera Logic
        const specialtyRadios = document.querySelectorAll("input[name='specialty']");
        const specialtyOtherWrapper = document.getElementById("specialtyOtherInputWrapper");
        const specialtyOtherInput = document.querySelector("input[name='specialty_other']");

        const cameraOtherCheckbox = document.getElementById("cameratype99");
        const cameraOtherWrapper = document.getElementById("cameratypeOtherInputWrapper");
        const cameraOtherInput = document.querySelector("input[name='cameratype_other']");

        // Safety: helper to set display
        function showEl(el, show) {
            if (!el) return;
            el.style.display = show ? "block" : "none";
        }

        // --- Specialty: show/hide wrapper and required ---
        function updateSpecialtyUI() {
            const checked = document.querySelector("input[name='specialty']:checked");
            const isOther = !!(checked && checked.value === "specialty99"); //Other

            showEl(specialtyOtherWrapper, isOther);

            if (specialtyOtherInput) {
                if (isOther) {
                    specialtyOtherInput.setAttribute("required", "required");
                } else {
                    specialtyOtherInput.removeAttribute("required");
                    specialtyOtherInput.classList.remove("is-invalid");
                }
            }
        }

        // Bind specialty radios (if any)
        if (specialtyRadios && specialtyRadios.length) {
            specialtyRadios.forEach(r => r.addEventListener("change", updateSpecialtyUI));
            updateSpecialtyUI(); // init
        }

        // --- Cameratype: show/hide wrapper and required ---
        function updateCameraUI() {
            const isChecked = cameraOtherCheckbox ? cameraOtherCheckbox.checked : false;
            showEl(cameraOtherWrapper, isChecked);

            if (cameraOtherInput) {
                if (isChecked) {
                    cameraOtherInput.setAttribute("required", "required");
                } else {
                    cameraOtherInput.removeAttribute("required");
                    cameraOtherInput.classList.remove("is-invalid");
                }
            }
        }

        if (cameraOtherCheckbox) {
            cameraOtherCheckbox.addEventListener("change", updateCameraUI);
            updateCameraUI(); // init
        }
        //##### END - Specialty&Camera Logic

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
        $('#paydate').datetimepicker('setOptions', { value: new Date() });
    });
</script>



@endsection
