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
                <input type="radio" id="specialty1" name="specialty" value="specialty1" checked>
                <label for="specialty1">General practitioner</label>
            </li>
            <li>
                <input type="radio" id="specialty2" name="specialty" value="specialty2">
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
    <div class="col-12 form-group mb-0">
        <label class="text-title mb-1">Please specify the brand/model of your smartphone or camera
            (optional).<br />
            <span class="fw-light fst-italic">(e.g., iPhone, Android phone, Canon EOS R6, Sony
                A6400, Fujifilm X100V)</span></label>
        <input type="text" name="camera_brand" class="form-control mb-0" />
    </div>
</div>
@if($event_type == 'workshop')
<div class="row mb-3">
    <div class="col-lg-6 form-group mb-3 mb-lg-0">
        <label class="text-title mb-2">Please select your top 3 topics you are most interested in learning during the workshop</label>
        <ul class="list-unstyled mb-0">
            <li>
                <input type="checkbox" id="workshop_topics1" name="workshop_topics[]"
                    value="workshop_topics1">
                <label for="workshop_topics1">Easy studio setup & lighting for clinical photography</label>
            </li>
            <li>
                <input type="checkbox" id="workshop_topics2" name="workshop_topics[]"
                    value="workshop_topics2">
                <label for="workshop_topics2">Using a professional camera for clinical photography</label>
            </li>
            <li>
                <input type="checkbox" id="workshop_topics3" name="workshop_topics[]"
                    value="workshop_topics3">
                <label for="workshop_topics3">Using a smartphone camera for clinical photography</label>
            </li>
            <li>
                <input type="checkbox" id="workshop_topics4" name="workshop_topics[]"
                    value="workshop_topics4">
                <label for="workshop_topics4">DIY surgical video recording (smartphone or professional camera)</label>
            </li>
            <li>
                <input type="checkbox" id="workshop_topics5" name="workshop_topics[]"
                    value="workshop_topics5">
                <label for="workshop_topics5">Creating and editing educational videos</label>
            </li>
            <li>
                <input type="checkbox" id="workshop_topics6" name="workshop_topics[]"
                    value="workshop_topics6">
                <label for="workshop_topics6">Portrait photography for social media and professional websites</label>
            </li>
            {{-- <li>
                <input type="checkbox" id="workshop_topics7" name="workshop_topics[]"
                    value="workshop_topics7">
                <label for="workshop_topics7">How to choose affordable gear for clinical
                    photography</label>
            </li> --}}
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
@endif
{{-- <div class="row mb-3">
    <div class="col-12 form-group">
        <label class="text-title mb-1">Other topics you're hoping to learn or questions you'd like
            addressed?</label>
        <textarea name="other_topics" class="form-control mb-0"></textarea>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12 form-group">
        <label class="text-title mb-1">Do you have any photo or video equipment you'd like to bring or ask about during the workshop?</label>
        <textarea name="equipment_questions" class="form-control mb-0"></textarea>
    </div>
</div> --}}
<div class="row">
    <div class="col-12">
        <div class="bg-theme px-20 py-10">
            <h6 class="text-center text-lg-start text-white mb-0"><i class="fa-solid fa-circle-info mr-10"></i> Make a
                Payment to Secure Your Spot ! <span class="d-block d-lg-inline fw-normal fw-normal">limited seats
                    available</span></h6>
        </div>
    </div>
</div>