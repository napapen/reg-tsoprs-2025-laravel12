<?php

return [

    // Event type
    'event_types' => [
        'onsite'   => 'Onsite Lecture',
        'online'   => 'Online Lecture',
        'workshop' => 'Full-Day Workshop',
    ],

    // Registration types
    'registration_types' => [
        'rcopt'          => 'RCOPT Delegates',
        'nonrcopt'       => 'Non-RCOPT Thai Delegates',
        'international'  => 'International Delegates',
    ],

    // Payment channels
    'payment_channels' => [
        'rcopt'          => 'Direct Bank Transfer',
        'nonrcopt'       => 'Direct Bank Transfer',
        'international'  => 'Credit Card',
    ],

    // Pricing (nested array)
    'pricing' => [
        'onsite' => [
            'rcopt'         => 1000,
            'nonrcopt'      => 3000,
            'international' => 3000,
        ],
        'online' => [
            'rcopt'         => 0,
            'nonrcopt'      => 0,
            'international' => 1700,
        ],
        'workshop' => [
            'rcopt'         => 7500,
            'nonrcopt'      => 9000,
            'international' => 8500,
        ],
    ],
    
    'specialties' => [
        'specialty1'   => 'General practitioner',
        'specialty2'   => 'Ophthalmologist',
        'specialty3'   => 'Oculoplastic Surgeon',
        'specialty4'   => 'Plastic Surgeon',
        'specialty5'   => 'Resident/Fellow',
        'specialty99'  => 'Other',
    ],

    'cameras' => [
        'cameratype1' => 'DSLR camera',
        'cameratype2' => 'Mirrorless camera',
        'cameratype3' => 'Compact digital camera',
        'cameratype4' => 'Smartphone Android',
        'cameratype5' => 'Smartphone Apple',
        'cameratype99' => 'Other',
    ],

    'workshop_topics' => [
        'workshop_topics1' => 'Easy studio setup & lighting for clinical photography',
        'workshop_topics2' => 'Using a professional camera for clinical photography',
        'workshop_topics3' => 'Using a smartphone camera for clinical photography',
        'workshop_topics4' => 'DIY surgical video recording (smartphone or professional camera)',
        'workshop_topics5' => 'Creating and editing educational videos',
        'workshop_topics6' => 'Portrait photography for social media and professional websites',
        // 'workshop_topics7'   => 'How to choose affordable gear for clinical photography',
    ],

    'experiences' => [
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'advanced' => 'Advanced',
    ],

    'countries' => [
        "Afghanistan","Albania","Algeria","Andorra","Angola","Argentina","Armenia","Australia",
        "Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Belarus","Belgium","Belize","Benin",
        "Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Cambodia",
        "Cameroon","Canada","Chile","China","Colombia","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic",
        "Denmark","Dominican Republic","Ecuador","Egypt","El Salvador","Estonia","Ethiopia","Fiji","Finland",
        "France","Georgia","Germany","Ghana","Greece","Greenland","Guatemala","Honduras","Hong Kong","Hungary",
        "Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan",
        "Kazakhstan","Kenya","Kuwait","Laos","Latvia","Lebanon","Lithuania","Luxembourg","Macau","Madagascar",
        "Malaysia","Maldives","Malta","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro",
        "Morocco","Myanmar","Nepal","Netherlands","New Zealand","Nigeria","North Korea","Norway","Oman",
        "Pakistan","Panama","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia",
        "Rwanda","Saudi Arabia","Senegal","Serbia","Singapore","Slovakia","Slovenia","South Africa","South Korea",
        "Spain","Sri Lanka","Sudan","Sweden","Switzerland","Syria","Taiwan","Tanzania","Thailand","Tunisia",
        "Turkey","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan",
        "Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"
    ],
];
