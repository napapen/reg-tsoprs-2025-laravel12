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
    </script>