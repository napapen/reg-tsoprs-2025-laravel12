    <script>
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

        document.addEventListener("DOMContentLoaded", function () {
            //console.log("JS loaded");
            //##### VALIDATE
            const form = document.querySelector("form.needs-validation");

            //console.log("form found?", form);  // debug
            
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
