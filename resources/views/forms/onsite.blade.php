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
                                                <input type="radio" id="rcopt" name="registration_type" value="rcopt" required checked>
                                                <label for="rcopt"> &nbsp;RCOPT Delegates</label>
                                            </td>
                                            <td data-title="Onsite Lecture"><strong class="fs-md">1,000 THB</strong></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>
                                               <input type="radio" id="nonrcopt" name="registration_type" value="nonrcopt">
                                                <label for="nonrcopt"> &nbsp;Non-RCOPT Thai Delegates</label>
                                            </td>
                                            <td data-title="Onsite Lecture"><strong class="fs-md">3,000 THB</strong></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>
                                                <input type="radio" id="international" name="registration_type" value="international">
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
                                <label>Full Name*</label>
                                <input type="text" name="full_name" class="form-control" placeholder="Full Name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label>Email Address*</label>
                                <input type="text" name="email" class="form-control" placeholder="Email Address" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label>Mobile Number/Whatsapp/LINE Number (Optional)</label>
                                <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label>Institution/Practice Organization*</label>
                                <input name="institution" type="text" class="form-control" placeholder="Institution" />
                            </div>
                            <div class="col-lg-6 form-group">
                                <label>Country of Practice</label>
                                <select name="country">
                                    <option value="">-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Specialty/Subspecialty</label>
                                <ul class="list-unstyled">
                                    <li>
                                        <input type="radio" id="general" name="specialty" value="General practitioner">
                                        <label for="general">General practitioner</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="ophthalmologist" name="specialty" value="Ophthalmologist" checked>
                                        <label for="ophthalmologist">Ophthalmologist</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="oculoplastic" name="specialty" value="Oculoplastic Surgeon">
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
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label>What type of camera will you be bringing during the workshop?</label>
                                <ul class="list-unstyled">
                                    <li>
                                        <input type="checkbox" id="cameratype1" name="cameratype[]" value="DSLR camera">
                                        <label for="cameratype1">DSLR camera</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype2" name="cameratype[]" value="Mirrorless camera">
                                        <label for="cameratype2">Mirrorless camera</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype3" name="cameratype[]" value="Compact digital camera">
                                        <label for="cameratype3">Compact digital camera</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype4" name="cameratype[]" value="Smartphone Andriod">
                                        <label for="cameratype4">Smartphone Andriod</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype5" name="cameratype[]" value="Smartphone Apple">
                                        <label for="cameratype5">Smartphone Apple</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cameratype6" name="cameratype[]" value="Other">
                                        <label for="cameratype6">Other</label>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Please specify the brand/model of your smartphone or camera (optional).<br/>
                                <span class="fw-light fst-italic">(e.g., iPhone, Android phone, Canon EOS R6, Sony A6400, Fujifilm X100V)</span></label>
                                <input type="text" name="camera_brand" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label>How would you rate your photography experience?</label>
                                <ul class="list-unstyled">
                                    <li>
                                        <input type="radio" id="beginner" name="photography_experience" value="beginner" required checked>
                                        <label for="beginner">Beginner</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="intermediate" name="photography_experience" value="intermediate">
                                        <label for="intermediate">Intermediate</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="advanced" name="photography_experience" value="advanced">
                                        <label for="advanced">Advanced</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label>What are you most interested in learning during the workshop?</label>
                                <ul class="list-unstyled">
                                    <li>
                                         <input type="checkbox" id="workshop_topics1" name="workshop_topics[]" value="workshop_topics1">
                                        <label for="workshop_topics1">How to take standardized clinical photos for eyelid/orbital conditions</label>
                                    </li>
                                    <li>
                                         <input type="checkbox" id="workshop_topics2" name="workshop_topics[]" value="workshop_topics2">
                                        <label for="workshop_topics2">How to pose patients and control lighting for portraits</label>
                                    </li>
                                    <li>
                                         <input type="checkbox" id="workshop_topics3" name="workshop_topics[]" value="workshop_topics3">
                                        <label for="workshop_topics3">How to take effective before/after photos using a smartphone</label>
                                    </li>
                                    <li>
                                         <input type="checkbox" id="workshop_topics4" name="workshop_topics[]" value="workshop_topics4">
                                        <label for="workshop_topics4">How to create teaching videos in the OR</label>
                                    </li>
                                    <li>
                                         <input type="checkbox" id="workshop_topics5" name="workshop_topics[]" value="workshop_topics5">
                                        <label for="workshop_topics5">How to edit and organize photo/video files</label>
                                    </li>
                                    <li>
                                         <input type="checkbox" id="workshop_topics6" name="workshop_topics[]" value="workshop_topics6">
                                        <label for="workshop_topics6">How to present content professionally on social media</label>
                                    </li>
                                    <li>
                                         <input type="checkbox" id="workshop_topics7" name="workshop_topics[]" value="workshop_topics7">
                                        <label for="workshop_topics7">How to choose affordable gear for clinical photography</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Other topics you're hoping to learn or questions you'd like addressed?</label>
                                <textarea name="other_topics" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Do you have any photo or video equipment you'd like to bring or ask about during the workshop?</label>
                                <textarea name="equipment_questions" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <h2>ลงทะเบียน Onsite</h2>
    <form method="POST" enctype="multipart/form-data" action="{{ route('onsite.store') }}">
        @csrf
        <label>Full Name*</label>
        <input type="text" name="full_name" required><br><br>

        <label>Email*</label>
        <input type="email" name="email" required><br><br>

        <label>Mobile/WhatsApp/LINE</label>
        <input type="text" name="mobile"><br><br>

        <label>Upload Photo</label>
        <input type="file" name="photo"><br><br>

        <button type="submit">Register</button>
    </form>
@endsection
