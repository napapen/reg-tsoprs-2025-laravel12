@extends('layouts.app')

@section('title', 'Onsite Registration')

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